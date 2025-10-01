<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->paginate(20);
        return view('forms.builder.index', compact('forms'));
    }

    public function create()
    {
        $route = route('admin.form-builders.store');
        return view('forms.builder.form_add_edit', compact('route'));
    }

    // store newly created form with its fields
    public function store(Request $request)
    {
        $form = Form::create([
            'audit_step_id' => 1,
            'question_id' => 1,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'settings' => $request->input('settings', []),
        ]);

        $fields = json_decode($request->input('fields'), true);

        if (is_array($fields)) {
            foreach ($fields as $index => $f) {
                $form->fields()->create([
                    'label'       => $f['label'] ?? ($f['type'] === 'paragraph' ? $f['label'] : 'Note'),
                    'type'        => $f['type'] ?? 'text',
                    'options'     => isset($f['options']) && is_array($f['options']) ? $f['options'] : null,
                    'order'       => $index,
                    'required'    => $f['required'] ?? false,
                    'multiple'    => $f['multiple'] ?? false,
                    'placeholder' => $f['placeholder'] ?? null,
                    'paragraph'   => $f['paragraph'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.form-builders.index')->with(successMessage());
    }


    public function edit($id)
    {
        $form = Form::findOrFail(encrypt_decrypt($id, 'decrypt'));
        $form->load('fields');
        $route = route('admin.form-builders.update', $form->id);
        return view('forms.builder.form_add_edit', compact('form', 'route'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'fields' => 'required', // validate presence, not array (since it's JSON string)
        ]);

        $form = Form::findOrFail($id);
        $form->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'settings' => $request->input('settings', []),
        ]);
        // Remove old fields
        $form->fields()->delete();
        // Decode JSON string into array
        $fields = json_decode($request->input('fields'), true);
        if (is_array($fields)) {
            foreach ($fields as $index => $f) {
                $form->fields()->create([
                    'label'       => $f['label'] ?? ($f['type'] === 'paragraph' ? $f['label'] : 'Note'),
                    'type'        => $f['type'] ?? 'text',
                    'options'     => isset($f['options']) && is_array($f['options']) ? $f['options'] : null,
                    'order'       => $index,
                    'required'    => $f['required'] ?? false,
                    'multiple'    => $f['multiple'] ?? false,
                    'placeholder' => $f['placeholder'] ?? null,
                    'paragraph'   => $f['paragraph'] ?? null,
                ]);
            }
        }
        return redirect()->route('admin.form-builders.index')->with(infoMessage());
    }


    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->fields()->delete();
        $form->delete();
        return redirect()->route('admin.form-builders.index')->with(deleteMessage());
    }
}
