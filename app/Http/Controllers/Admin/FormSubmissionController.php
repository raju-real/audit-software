<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // secure this route
    }

    // list submissions for a form
    public function index(Form $form)
    {
        $submissions = $form->submissions()->with('files')->latest()->paginate(20);
        return view('forms.submissions.index', compact('form', 'submissions'));
    }

    public function show($id)
    {
        // Fetch submission
        $submission = FormSubmission::with('files')->findOrFail($id);

        // Load the related form and its fields
        $form = Form::with('fields')->findOrFail($submission->form_id);

        return view('forms.builder.show_submission', compact('form', 'submission'));
    }
}
