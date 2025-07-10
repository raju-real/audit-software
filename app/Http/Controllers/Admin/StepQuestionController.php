<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditStep;
use App\Models\AuditStepQuestion;
use Illuminate\Http\Request;

class StepQuestionController extends Controller
{
    public function questionList($step_slug = Null)
    {
        $audit_step = AuditStep::whereSlug($step_slug)->firstOrFail();
        $step_id = $audit_step->id;
        $questions = AuditStepQuestion::where('audit_step_id',$step_id)->get();
        return view('admin.step-questions.question_list',compact('audit_step','questions'));
    }

    public function addQuestion($step_slug) {
        $audit_step = AuditStep::whereSlug($step_slug)->firstOrFail();
        return view('admin.step-questions.question_add_edit',compact('audit_step'));
    }
}
