<?php

namespace App\Http\Controllers\Admin;

use App\Models\Audit;
use Illuminate\Http\Request;
use App\Models\AuditAndStepPair;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupervisorActivityController extends Controller
{
    public function auditList()
    {
        $data = Audit::query();
        $data->whereHas('supervisors', function ($q) {
            $q->where('user_id', Auth::id());
        });
        // Filtered section
        if (request()->filled('status')) {
            $data->whereHas('audit_steps', function ($q) {
                $q->where('status', request()->status);
            });
        }
        // Manage relational data
        $data->withAuditSteps();

        $audits = $data->latest()->paginate(20);
        return view('admin.audits.supervisor_audit_list', compact('audits'));
    }

    public function auditSteps($audit_id = null)
    {
        $audit = Audit::findOrFail(encrypt_decrypt($audit_id, 'decrypt'));
        $steps = AuditAndStepPair::with([
            'audit_step_info' => function ($audit_step) {
                $audit_step->select('id', 'step_no', 'title', 'slug', 'isa_reference');
            },
            'audit_user' => function($user) {
                $user->select('id','name','mobile','email');
            }
        ])->where("audit_id", $audit->id)->select('id', 'audit_id', 'audit_step_id', 'step_no', 'status', 'audit_by', 'reviewed_by')->orderBy('step_no')->get();
        return view('admin.audits.supervisor_audit_steps', compact('audit', 'steps'));
    }

    public function reviewStepAnswer($step_id = null)
    {
        $step_info = AuditAndStepPair::with([
            'audit_info' => function ($audit_info) {
                $audit_info->select('id', 'audit_number', 'financial_year_id', 'organization_id', 'title');
                $audit_info->with([
                    'financial_year' => function ($financial_year) {
                        $financial_year->select('id', 'financial_year');
                    },
                    'organization' => function ($organization) {
                        $organization->select('id', 'name');
                    }
                ]);
            },
            'audit_step_info' => function ($audit_step) {
                $audit_step->select('id', 'step_no', 'title', 'slug', 'isa_reference');
            },
            'audit_step_questions' => function ($step_question) {
                $step_question->select('id', 'audit_step_pair_id', 'audit_step_id', 'audit_id', 'question_id', 'sorting_serial', 'closed_ended_answer', 'text_answer', 'documents');
                $step_question->with([
                    'question' => function ($question) {
                        $question->select('id', 'question', 'is_closed_ended', 'is_boolean_answer_required', 'has_text_answer', 'is_text_answer_required', 'has_document', 'is_document_required', 'sorting_serial');
                    }
                ]);
                $step_question->sort();
            }
        ])->findOrFail(encrypt_decrypt($step_id, 'decrypt'));

        return view('admin.audits.supervisor_audit_step_questions', compact('step_info'));
    }

    public function changeStatus() {
        $step = AuditAndStepPair::findOrFail(encrypt_decrypt(request()->get('step_id'),'decrypt'));
        $step->status = request()->get('status');
        $step->reviewed_by = Auth::id();
        $step->save();
        return redirect()->route('admin.supervisor-audit-steps',encrypt_decrypt($step->audit_id,'encrypt'))->with(infoMessage());
    }
}
