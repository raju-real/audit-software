<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\AuditAndStepPair;
use App\Models\AuditAndStepQuestionPair;
use App\Models\AuditBalanceSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AuditorActivityController extends Controller
{
    public function auditList()
    {
        $data = Audit::query();

        $data->whereHas('auditors', function ($q) {
            $q->where('user_id', Auth::id());
        });

        if (request()->filled('status')) {
            $data->whereHas('audit_steps', function ($q) {
                $q->where('status', request()->status);
            });
        }
        // Manage relational data
        $data->withAuditSteps();

        $audits = $data->latest()->paginate(20);
        return view('admin.audits.auditor_audit_list', compact('audits'));
    }


    public function auditSteps($audit_id = null)
    {
        $audit = Audit::findOrFail(encrypt_decrypt($audit_id, 'decrypt'));
        $steps = AuditAndStepPair::with([
            'audit_step_info' => function ($audit_step) {
                $audit_step->select('id', 'step_no', 'title', 'slug', 'isa_reference');
            },
            'audit_user' => function ($user) {
                $user->select('id', 'name', 'mobile', 'email');
            }
        ])->where("audit_id", $audit->id)->select('id', 'audit_id', 'audit_step_id', 'step_no', 'status', 'audit_by', 'reviewed_by')->orderBy('step_no')->get();
        return view('admin.audits.auditor_audit_steps', compact('audit', 'steps'));
    }

    public function stepQuestions($step_id = null)
    {
        $step_info = AuditAndStepPair::getStepInfo($step_id);
        $submit_type = 'save';
        return view('admin.audits.auditor_audit_step_questions', compact('step_info', 'submit_type'));
    }

    public function previewQuestions($step_id = null)
    {
        $step_info = AuditAndStepPair::getStepInfo($step_id);
        $submit_type = 'submit';
        return view('admin.audits.auditor_audit_step_questions', compact('step_info', 'submit_type'));
    }

    public function submitAnswer(Request $request, $step_id)
    {
        $this->validate($request, [
            // Multiple documents handle
            // 'documents'   => 'nullable|array|max:5', 
            'documents.*' => 'nullable|sometimes|mimes:jpg,jpeg,png,pdf,xlsx,xls,csv|max:51200',
            //'documents' => 'nullable|sometimes|mimes:jpg,jpeg,png,pdf,xlsx,xls,csv|max:51200',
        ]);
        // return $request;
        $step_info = AuditAndStepPair::findOrFail(encrypt_decrypt($step_id, 'decrypt'));
        if ($request->step_question_id) {
            foreach ($request->step_question_id as $key => $step_question_id) {
                $step_answer = AuditAndStepQuestionPair::find($step_question_id);
                if (isset($step_answer)) {
                    $step_answer->closed_ended_answer = $request->closed_ended_answer[$key] ?? null;
                    $step_answer->text_answer = $request->text_answer[$key] ?? null;

                    // Handle multiple documents
                    // $document_paths = [];

                    // if ($request->hasFile("documents")) {
                    //     foreach ($request->file("documents") as $file_key => $file) {
                    //         if (isImage($request->file("documents.{$file_key}"))) {
                    //             $document_path = uploadImage($request->file("documents.{$file_key}"), 'documents');
                    //         } else {
                    //             $document_path = uploadFile($request->file("documents.{$file_key}"), 'documents');
                    //         }
                    //         array_push($document_paths, $document_path);
                    //     }

                    //     $step_answer->documents = implode(',', $document_paths);
                    // }

                    if ($request->hasFile("documents.{$key}")) {
                        $base_folder = 'documents/audit/';
                        $sub_folder = $step_info->audit_info->financial_year->financial_year . '/' . $step_info->audit_info->organization->slug;
                        $audit_folder = $base_folder . $sub_folder;
                        $step_answer->documents = uploadFile($request->file("documents.{$key}"), $audit_folder);
                    }

                    if ($step_answer->save()) {
                        $step_info->status = $request->submit_type === 'submit' ? 'ongoing' : 'draft';
                        $step_info->audit_by = Auth::id();
                        $step_info->save();
                        Audit::where('id', $step_info->audit_id)->update(['workflow_status' => 'ongoing']);
                    }
                }
            }
            return redirect()->route('admin.auditor-audit-steps', encrypt_decrypt($step_info->audit_id, 'encrypt'))->with(infoMessage());
        }
    }

    public function stepDetails($step_id)
    {
        $step_info = AuditAndStepPair::getStepInfo($step_id);
        return view('admin.audits.auditor_audit_step_details', compact('step_info'));
    }

    public function balanceSheet($audit_id = null)
    {
        $audit = Audit::with('balance_sheet')->where('id', encrypt_decrypt($audit_id, 'decrypt'))->firstOrFail();
        return view('admin.audits.auditor_balance_sheet_with_client_side_preview', compact('audit'));
        //return view('admin.audits.auditor_balance_sheet', compact('audit'));
    }

    public function uploadBalanceSheet(Request $request, $audit_id = null)
    {
        $request->validate([
            'balance_sheet' => 'required|file|mimes:xls,xlsx',
        ]);

        $file = $request->file('balance_sheet'); // <- fixed

        $spreadsheet = IOFactory::load($file->getPathname());

        $writer = IOFactory::createWriter($spreadsheet, 'Html');

        ob_start();
        $writer->save('php://output');
        $htmlContent = ob_get_clean();

        // Remove old entry
        AuditBalanceSheet::where('audit_id', $audit_id)->update([
            'deleted_by' => Auth::id()
        ]);
        AuditBalanceSheet::where('audit_id', $audit_id)->delete();

        $balance_sheet = new AuditBalanceSheet();
        $balance_sheet->audit_id = $audit_id;
        $balance_sheet->balance_sheet = $htmlContent;
        $balance_sheet->created_by = Auth::id();
        $balance_sheet->save();

        return redirect()->route('admin.audit-wise-auditor-balance-sheet', encrypt_decrypt($audit_id, 'encrypt'))->with(infoMessage());
    }
}
