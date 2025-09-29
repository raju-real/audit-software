<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\FormSubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormController extends Controller
{
    // show the form to the user
    public function show($id)
    {
        $form = Form::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $form->load('fields');
        $route = route('admin.submit-form', $id);
        return view('forms.builder.show_form', compact('form', 'route'));
    }

    // handle submission
    public function submit(Request $request, $id)
    {
        $form = Form::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $form->load('fields');

        // Build validation rules dynamically
        $rules = [];
        foreach ($form->fields as $field) {
            $key = "field_{$field->id}";
            if (in_array($field->type, ['file'])) {
                // for file fields use array of files
                if ($field->multiple) {
                    $rules["{$key}"] = [$field->required ? 'required' : 'nullable', 'array'];
                    $rules["{$key}.*"] = ['file', 'max:5120']; // 5MB default
                } else {
                    $rules[$key] = [$field->required ? 'required' : 'nullable', 'file', 'max:5120'];
                }
            } elseif ($field->type === 'signature') {
                // signature comes as base64 string in field_{id}_signature
                $sigKey = "{$key}_signature";
                $rules[$sigKey] = [$field->required ? 'required' : 'nullable', 'string'];
            } else {
                $rules[$key] = [$field->required ? 'required' : 'nullable', 'sometimes'];
            }
        }

        $validated = $request->validate($rules);

        // Create submission
        $submission = FormSubmission::create([
            'form_id' => $form->id,
            'audit_step_id' => 1,
            'question_id' => 1,
            'user_id' => auth()->id(),
            'data' => [], // we'll fill below
        ]);

        $data = [];

        // Process each field
        foreach ($form->fields as $field) {
            $key = "field_{$field->id}";

            if ($field->type === 'file') {
                // store files
                $files = $request->file($key);
                if ($files) {
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    foreach ($files as $f) {
                        $path = uploadFile($f, "forms");
                        $submission->files()->create([
                            'field_id' => $field->id,
                            'field_name' => $field->label,
                            'file_path' => $path,
                            'type' => fileMimeType($f),
                            'mime' => isImage($f),
                        ]);
                    }
                    // in data store stored file_paths for reference (array)
                    $data[$field->id] = $submission->files()->where('field_id', $field->id)->pluck('file_path')->toArray();
                } else {
                    $data[$field->id] = [];
                }
            } elseif ($field->type === 'signature') {
                $sigKey = "field_{$field->id}_signature";
                $b64 = $request->input($sigKey);
                if ($b64) {
                    if (preg_match('/^data:(image\/\w+);base64,/', $b64, $type)) {
                        $dataStr = substr($b64, strpos($b64, ',') + 1);
                        $dataStr = base64_decode($dataStr);
                        $ext = explode('/', $type[1])[1] ?? 'png';
                        $filename = Str::uuid() . '.' . $ext;
                        // Path directly under public folder
                        $file_path = "assets/files/forms/signatures/{$filename}";
                        // Make sure directory exists
                        if (!file_exists(dirname($file_path))) {
                            mkdir(dirname($file_path), 0755, true);
                        }
                        // Save file
                        file_put_contents($file_path, $dataStr);

                        // Save record in submission files
                        $submission->files()->create([
                            'field_id'   => $field->id,
                            'field_name' => $field->label,
                            'file_path'  => $file_path, // relative path
                            'type'       => 'signature',
                            'mime'       => $type[1],
                        ]);

                        // Save path in submission data
                        $data[$field->id] = $file_path;
                    }
                } else {
                    $data[$field->id] = null;
                }
            } else {
                // other fields: text, textarea, select, checkbox -> store raw input
                $val = $request->input($key);
                $data[$field->id] = $val;
            }
        }

        // Save submission data
        $submission->data = $data;
        $submission->save();

        return redirect()->back()->with('success', 'Submission saved for this audit.');
    }
}
