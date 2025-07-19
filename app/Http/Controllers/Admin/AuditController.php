<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Audit;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Models\AuditAuditor;
use Illuminate\Http\Request;
use App\Models\AuditSupervisor;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AuditValidationRequest;
use App\Models\AuditAndStepPair;
use App\Models\AuditAndStepQuestionPair;
use App\Models\AuditStep;
use App\Models\AuditStepQuestion;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Audit::query();
        $audits = $data->latest()->paginate(20);
        return view('admin.audits.audit_list', compact('audits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = route('admin.audits.store');
        return view('admin.audits.add_edit_audit', compact('route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuditValidationRequest $request)
    {
        $audit = new Audit();
        $audit_number = Audit::getAuditNumber();
        $audit->audit_number = $audit_number;
        $audit->title = $request->title;
        $audit->slug = $audit_number.'-'.Str::slug($request->title);
        $audit->financial_year_id = $request->financial_year;
        $audit->organization_id = $request->organization;
        $audit->start_date = dateFormat($request->start_date);
        $audit->end_date = dateFormat($request->end_date);
        $audit->priority = $request->priority;
        $audit->workflow_status = $request->workflow_status;

        if ($request->file('reference_document')) {
            $audit->reference_document = uploadFile($request->file('reference_document'), 'audits');
        }
        $audit->status = $request->status;
        $audit->description = $request->description;
        $audit->created_by = Auth::id();
        if ($audit->save()) {
            // Save audit auditors
            if ($request->auditors && count($request->auditors) > 0) {
                foreach ($request->auditors as $auditor) {
                    $audit_auditor = new AuditAuditor();
                    $audit_auditor->audit_id = $audit->id;
                    $audit_auditor->user_id = $auditor;
                    $audit_auditor->save();
                }
            }

            // Save audit auditors
            if ($request->supervisors && count($request->supervisors) > 0) {
                foreach ($request->supervisors as $supervisor) {
                    $audit_supervisor = new AuditSupervisor();
                    $audit_supervisor->audit_id = $audit->id;
                    $audit_supervisor->user_id = $supervisor;
                    $audit_supervisor->save();
                }
            }

            // Save audit and step pairs
            $audit_steps = AuditStep::active()->oldest('step_no')->select('id','step_no')->get();
            foreach($audit_steps as $step) {
                $audit_step_pair = new AuditAndStepPair();
                $audit_step_pair->audit_id = $audit->id;
                $audit_step_pair->audit_step_id = $step->id;
                $audit_step_pair->step_no = $step->step_no;
                $audit_step_pair->save();
                // Save audit and step and questions pairs
                $step_questions = AuditStepQuestion::where('audit_step_id', $step->id)->active()->sort()->select('id','audit_step_id','sorting_serial')->get();
                foreach($step_questions as $question) {
                    $step_question_pair = new AuditAndStepQuestionPair();
                    $step_question_pair->audit_id = $audit->id;
                    $step_question_pair->audit_step_id = $step->id;
                    $step_question_pair->audit_step_pair_id = $audit_step_pair->id;
                    $step_question_pair->question_id = $question->id;
                    $step_question_pair->sorting_serial = $question->sorting_serial;
                    $step_question_pair->save();
                }
            }

            return redirect()->route('admin.audits.index')->with(successMessage('success','New Audit has been created successfully!'));
        } else {
            return redirect()->route('admin.audits.index')->with(warningMessage('warning', 'Data not saved. Something went wrong!'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $audit = Audit::draft()->whereSlug($slug)->firstOrFail();
        $route = route('admin.audits.update',encrypt_decrypt($audit->id,'encrypt'));
        return view('admin.audits.add_edit_audit',compact('audit','route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuditValidationRequest $request, $id)
    {
        $audit = Audit::findOrFail(encrypt_decrypt($id,'decrypt'));
        $audit->title = $request->title;
        $audit->slug = $audit->audit_number.'-'.Str::slug($request->title);
        $audit->financial_year_id = $request->financial_year;
        $audit->organization_id = $request->organization;
        $audit->start_date = dateFormat($request->start_date);
        $audit->end_date = dateFormat($request->end_date);
        $audit->priority = $request->priority;
        $audit->workflow_status = $request->workflow_status;

        if ($request->file('reference_document')) {
            $audit->reference_document = uploadFile($request->file('reference_document'), 'audits');
        }

        $audit->status = $request->status;
        $audit->description = $request->description;
        $audit->created_by = Auth::id();

        if ($audit->save()) {
            // Save audit auditors
            if ($request->auditors && count($request->auditors) > 0) {
                AuditAuditor::whereIn('audit_id', array($audit->id))->delete();
                foreach ($request->auditors as $auditor) {
                    $audit_auditor = new AuditAuditor();
                    $audit_auditor->audit_id = $audit->id;
                    $audit_auditor->user_id = $auditor;
                    $audit_auditor->save();
                }
            }

            // Save audit auditors
            if ($request->supervisors && count($request->supervisors) > 0) {
                AuditSupervisor::whereIn('audit_id', array($audit->id))->delete();
                foreach ($request->supervisors as $supervisor) {
                    $audit_supervisor = new AuditSupervisor();
                    $audit_supervisor->audit_id = $audit->id;
                    $audit_supervisor->user_id = $supervisor;
                    $audit_supervisor->save();
                }
            }

            // Save audit and step pairs
            AuditAndStepPair::whereIn('audit_id', array($audit->id))->delete();
            AuditAndStepQuestionPair::whereIn('audit_id', array($audit->id))->delete();

            $audit_steps = AuditStep::active()->oldest('step_no')->select('id','step_no')->get();
            foreach($audit_steps as $step) {
                $audit_step_pair = new AuditAndStepPair();
                $audit_step_pair->audit_id = $audit->id;
                $audit_step_pair->audit_step_id = $step->id;
                $audit_step_pair->step_no = $step->step_no;
                $audit_step_pair->save();
                // Save audit and step and questions pairs
                $step_questions = AuditStepQuestion::where('audit_step_id', $step->id)->active()->sort()->select('id','audit_step_id','sorting_serial')->get();
                foreach($step_questions as $question) {
                    $step_question_pair = new AuditAndStepQuestionPair();
                    $step_question_pair->audit_id = $audit->id;
                    $step_question_pair->audit_step_id = $step->id;
                    $step_question_pair->audit_step_pair_id = $audit_step_pair->id;
                    $step_question_pair->question_id = $question->id;
                    $step_question_pair->sorting_serial = $question->sorting_serial;
                    $step_question_pair->save();
                }
            }

            return redirect()->route('admin.audits.index')->with(successMessage('success','New Audit has been created successfully!'));
        } else {
            return redirect()->route('admin.audits.index')->with(warningMessage('warning', 'Data not saved. Something went wrong!'));
        }
    }


    public function updateAuditStatus($id): \Illuminate\Http\JsonResponse
    {
        $audit = Audit::findOrFail($id);
        $audit->status = $audit->status === 'active' ? 'inactive' : 'active';
        if ($audit->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Audit status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update Audit status.',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
