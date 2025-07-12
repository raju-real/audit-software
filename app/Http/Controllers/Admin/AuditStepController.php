<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuditStepController extends Controller
{
    public function index()
    {
        $steps = AuditStep::orderBy('step_no')->get();
        return view('admin.audit-steps.audit_step_list', compact('steps'));
    }

    public function create()
    {
        $route = route('admin.audit-steps.store');
        return view('admin.audit-steps.audit_step_add_edit', compact('route'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('audit_steps', 'title')->whereNull('deleted_at')
            ],
            'isa_reference' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|sometimes|max:5000'
        ]);
        $step = new AuditStep();
        $step->step_no = AuditStep::max('step_no') + 1;
        $step->title = $request->title;
        $step->slug = time().'-'.Str::slug($request->title);
        $step->isa_reference = $request->isa_reference;
        $step->description = $request->description;
        $step->status = $request->status;
        $step->created_by = Auth::id();
        $step->save();
        return redirect()->route('admin.audit-steps.index')->with(successMessage());
    }


    public function edit($slug)
    {
        $step = AuditStep::whereSlug($slug)->first();
        $route = route('admin.audit-steps.update', $step->id);
        return view('admin.audit-steps.audit_step_add_edit', compact('step', 'route'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('audit_steps', 'title')->whereNull('deleted_at')->ignore($id)
            ],
            'isa_reference' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|sometimes|max:5000'
        ]);
        $step = AuditStep::findOrFail($id);
        $step->title = $request->title;
        $step->isa_reference = $request->isa_reference;
        $step->description = $request->description;
        $step->status = $request->status;
        $step->created_by = Auth::id();
        $step->save();
        return redirect()->route('admin.audit-steps.index')->with(infoMessage());
    }

    public function destroy($id)
    {
        $auditStep = AuditStep::findOrFail($id);
        $auditStep->update(['deleted_by' => Auth::id()]);
        $auditStep->delete();
        return redirect()->route('admin.audit-steps.index')->with(deleteMessage());
    }

    public function updateStepStatus($id): \Illuminate\Http\JsonResponse
    {
        $step = AuditStep::findOrFail($id);
        $step->status = $step->status === 'active' ? 'inactive' : 'active';
        if ($step->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Audit step status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update step status.',
        ], 500);
    }

    public function sortSteps(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $row = AuditStep::find($id);
                $row->step_no = $sortOrder + 1;
                $row->save();
            }
            return ['success' => true, 'message' => 'Updated'];
        }
    }
}
