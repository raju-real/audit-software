<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\AuditAndStepPair;
use App\Models\AuditAndStepQuestionPair;
use App\Models\AuditStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorActivityController extends Controller
{
    public function auditList()
    {
        $data = Audit::query();
        $data->whereHas('auditors', function ($q) {
            $q->where('user_id', Auth::id());
        });

        $data->with([
            'audit_steps' => function ($audit_step) {
                $audit_step->select('id', 'audit_id', 'audit_step_id', 'step_no', 'reviewed_by')
                    ->with([
                        'audit_step_questions' => function ($question) {
                            $question->select('id', 'audit_step_pair_id', 'audit_step_id', 'audit_id', 'question_id', 'sorting_serial');
                        },
                        'audit_step_info' => function ($audit_step) {
                            $audit_step->select('id', 'step_no', 'title', 'slug', 'isa_reference');
                        }
                    ]);
                $audit_step->orderBy('step_no');
            }
        ]);

        $data->when(request()->get('status'), function ($query) {
            $query->where('status', request()->get('status'));
        });

        $audits = $data->latest()->paginate(20);
        //return $audits;

        return view('admin.audits.auditor_audit_list', compact('audits'));
    }

    public function auditSteps($audit_id = null)
    {
        $audit = Audit::findOrFail(encrypt_decrypt($audit_id, 'decrypt'));
        $steps = AuditAndStepPair::with([
            'audit_step_info' => function ($audit_step) {
                $audit_step->select('id', 'step_no', 'title', 'slug', 'isa_reference');
            }
        ])->where("audit_id", $audit->id)->select('id', 'audit_id', 'audit_step_id', 'step_no', 'status', 'reviewed_by')->orderBy('step_no')->get();
        return view('admin.audits.auditor_audit_steps', compact('audit', 'steps'));
    }

    public function stepQuestions($step_id = null)
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
            },
        ])->findOrFail(encrypt_decrypt($step_id, 'decrypt'));

        return view('admin.audits.auditor_audit_step_questions', compact('step_info'));
    }

    public function submitAnswer(Request $request, $step_id)
    {
        $this->validate($request, [
            'documents'   => 'nullable|array|max:5', // Max 5 files total
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,xlsx,xls,csv|max:51200', // Max 50MB per file
        ]);
        // return $request;
        $step_info = AuditAndStepPair::findOrFail(encrypt_decrypt($step_id,'decrypt'));
        if ($request->step_question_id) {
            foreach ($request->step_question_id as $key => $step_question_id) {
                $step_answer = AuditAndStepQuestionPair::find($step_question_id);
                if (isset($step_answer)) {
                    $step_answer->closed_ended_answer = $request->closed_ended_answer[$key] ?? null;
                    $step_answer->text_answer = $request->text_answer[$key] ?? null;

                    // Handle documents
                    $document_paths = [];

                    if ($request->hasFile("documents")) {
                        foreach ($request->file("documents") as $file_key => $file) {
                            if (isImage($request->file("documents.{$file_key}"))) {
                                $document_path = uploadImage($request->file("documents.{$file_key}"), 'documents');
                            } else {
                                $document_path = uploadFile($request->file("documents.{$file_key}"), 'documents');
                            }
                            array_push($document_paths, $document_path);
                        }

                        $step_answer->documents = implode(',', $document_paths);
                    }

                    if($step_answer->save()) {
                        $step_info->status = 'ongoing';
                        $step_info->save();
                    }
                }
            }
            return redirect()->route('admin.auditor-audit-steps', encrypt_decrypt($step_info->audit_id,'encrypt'))->with(infoMessage());
        }
    }
}
