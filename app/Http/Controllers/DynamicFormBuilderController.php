<?php

// app/Http/Controllers/DynamicFormBuilderController.php
namespace App\Http\Controllers;

use App\Models\AuditStep;
use App\Models\DynamicForm;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class DynamicFormBuilderController extends Controller
{
    public function index()
    {
        $forms = DynamicForm::all();
        return view('admin.forms.form_list', compact('forms'));
    }

    public function create()
    {
        $audit_steps = AuditStep::active()->oldest('step_no')->select('id', 'title', 'step_no')->get();
        $route = route('admin.dynamic-forms.store');
        return view('admin.forms.form_add_edit', ['form' => null, 'route' => $route, 'audit_steps' => $audit_steps]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'form_json' => 'required|string',
        ]);

        DynamicForm::create([
            'title' => $request->title,
            'audit_step_id' => $request->audit_step ?? null,
            'question_id' => $request->question ?? null,
            'form_json' => $request->form_json,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.dynamic-forms.index')->with(successMessage());
    }

    public function show($id)
    {
        $form = DynamicForm::findOrFail($id);
        // Get latest response (or all responses if you want multiple)
        $formResponse = $form->responses()
            ->where('audit_step_id', $form->audit_step_id)
            ->where('question_id', $form->question_id)
            ->latest()
            ->first();
        $responses = json_decode($formResponse->response_json ?? '{}', true);
        $formStructure = json_decode($form->form_json ?? '[]');
        return view('admin.forms.show_form', compact('form', 'responses', 'formStructure'));
    }

    public function edit($id)
    {
        $form = DynamicForm::findOrFail($id);
        $route = route('admin.dynamic-forms.update', $form->id);
        $audit_steps = AuditStep::active()->oldest('step_no')->select('id', 'title', 'step_no')->get();
        return view('admin.forms.form_add_edit', compact('form', 'route', 'audit_steps'));
    }

    public function update(Request $request, $id)
    {
        $form = DynamicForm::findOrFail($id);
        $form->update([
            'title' => $request->title,
            'form_json' => $request->form_json,
        ]);

        return redirect()->route('admin.dynamic-forms.index')->with(infoMessage());
    }

    public function destroy($id)
    {
        $form = DynamicForm::findOrFail($id);
        $form->delete();
        return redirect()->route('admin.dynamic-forms.index')->with(deleteMessage());
    }

    // Render form for submission
    public function submitForm($id)
    {
        $form = DynamicForm::findOrFail($id);
        return view('admin.forms.submit_render', compact('form'));
    }

    public function submit(Request $request, $id)
    {
        $form = DynamicForm::findOrFail($id);
        $formStructure = json_decode($form->form_json, true);

        $validated = [];

        foreach ($formStructure as $field) {
            $name = $field['name'] ?? null;
            if (!$name) continue;

            $rules = !empty($field['required']) ? 'required' : 'nullable';

            // Handle file inputs separately
            if ($field['type'] === 'file') {
                if (!empty($field['multiple']) && $request->hasFile($name)) {
                    $paths = [];
                    foreach ($request->file($name) as $file) {
                        $paths[] = uploadFile($file, "forms");
                    }
                    $validated[$name] = $paths;
                } elseif ($request->hasFile($name)) {
                    $validated[$name] = uploadFile($request->file($name), 'forms');
                } else {
                    $validated[$name] = null;
                }
            }

            // Handle signature fields (canvas image from signature pad)
            elseif ($field['type'] === 'signature') {
                //$sigInputName = 'field_' . ($field['id'] ?? $name) . '_signature'; // From helper function
                $sigInputName = $field['id'] ?? $name;
                $signatureData = $request->input($sigInputName);
                if (!empty($signatureData)) {
                    $image = str_replace('data:image/png;base64,', '', $signatureData);
                    $image = str_replace(' ', '+', $image);
                    $fileName = uniqid() . '.png';
                    $filePath = "assets/files/forms/signatures/{$fileName}";
                    if (!file_exists(dirname($filePath))) {
                        mkdir(dirname($filePath), 0755, true);
                    }
                    file_put_contents($filePath, base64_decode($image));
                    $validated[$name] = $filePath;
                } else {
                    // Keep old signature if exists
                    $existingResponse = FormResponse::where('form_id', $form->id)
                        ->where('audit_step_id', $form->audit_step_id)
                        ->where('question_id', $form->question_id)
                        ->first();

                    $oldResponses = $existingResponse ? json_decode($existingResponse->response_json, true) : [];
                    $validated[$name] = $oldResponses[$name] ?? null;
                }
            }

            // Handle text, number, etc.
            else {
                $validated[$name] = $request->validate([$name => $rules])[$name] ?? null;
            }
        }

        // Save response
        FormResponse::updateOrInsert(
            [
                'form_id' => $form->id,
                'audit_step_id' => $form->audit_step_id,
                'question_id' => $form->question_id
            ],
            [
                'form_id' => $form->id,
                'audit_step_id' => $form->audit_step_id,
                'question_id' => $form->question_id,
                'response_json' => json_encode($validated),
                'submitted_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()
            ->route('admin.dynamic-forms.index')
            ->with(successMessage('success', 'Form submitted successfully.'));
    }



    // View submitted form
    public function viewForm($id)
    {
        $form = DynamicForm::findOrFail($id);
        $response = $form->responses()->latest()->first(); // latest response
        return view('forms.view_form', compact('form', 'response'));
    }

    // Download PDF
    public function downloadPdf($id)
    {
        $form = DynamicForm::findOrFail($id);
        // Get latest response
        $formResponse = $form->responses()
            ->where('audit_step_id', $form->audit_step_id)
            ->where('question_id', $form->question_id)
            ->latest()
            ->first();
        // Decode submitted responses
        $responses = json_decode($formResponse->response_json ?? '{}', true);
        // Decode form structure
        $formStructure = json_decode($form->form_json ?? '[]');
        // Pass both to the Blade for PDF generation
        //return view('admin.forms.download_form', compact('formStructure', 'responses', 'form'));
        $pdf = Pdf::loadView('admin.forms.download_form', compact('formStructure', 'responses', 'form'));
        // Stream the PDF
        return $pdf->stream($form->title . '.pdf');
    }
}
