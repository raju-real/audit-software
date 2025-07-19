<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
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
                    'audit_step_info' => function($audit_step) {
                        $audit_step->select('id','step_no','title','slug','isa_reference');
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
}
