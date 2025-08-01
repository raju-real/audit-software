<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = 'audits';
    protected $guarded = [];

    public function financial_year()
    {
        return $this->belongsTo(FinancialYear::class, 'financial_year_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function audit_steps()
    {
        return $this->hasMany(AuditAndStepPair::class, 'audit_id', 'id');
    }

    public function auditors()
    {
        return $this->hasMany(AuditAuditor::class, 'audit_id', 'id');
    }

    public function supervisors()
    {
        return $this->hasMany(AuditSupervisor::class, 'audit_id', 'id');
    }

    public function scopeDraft($query)
    {
        return $query->where('workflow_status', 'draft');
    }

    public function scopeOngoing($query)
    {
        return $query->where('workflow_status', 'ongoing');
    }

    public function scopeReviewed($query)
    {
        return $query->where('workflow_status', 'reviewed');
    }

    public function scopeApproved($query)
    {
        return $query->where('workflow_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('workflow_status', 'rejected');
    }

    public function scopeComplete($query)
    {
        return $query->where('workflow_status', 'complete');
    }

    public function scopeClosed($query)
    {
        return $query->where('workflow_status', 'closed');
    }

    public static function getAuditNumber(): string
    {
        $latestAuditNo = Audit::latest('id')->first();
        $newAuditNo = str_pad(1, 4, "0", STR_PAD_LEFT);
        if ($latestAuditNo) {
            $lastAuditNo = $latestAuditNo->audit_number;
            if ($lastAuditNo != null) {
                $newSerialNumber = $lastAuditNo + 1;
                $newAuditNo = str_pad($newSerialNumber, 4, "0", STR_PAD_LEFT);;
            } else {
                $newAuditNo = str_pad(1, 4, "0", STR_PAD_LEFT);
            }
        }
        if (Audit::where('audit_number', $newAuditNo)->exists()) {
            Audit::getAuditNo();
        }
        return $newAuditNo;
    }

    // In App\Models\Audit.php

    public function scopeWithAuditSteps($query)
    {
        return $query->with([
            'audit_steps' => function ($audit_step) {
                $audit_step->select('id', 'audit_id', 'audit_step_id', 'step_no', 'audit_by', 'reviewed_by', 'status', 'returned_for', 'rejected_for')
                    ->with([
                        'audit_step_questions' => function ($step_question) {
                            $step_question->select('id', 'audit_step_pair_id', 'audit_step_id', 'audit_id', 'question_id', 'sorting_serial', 'closed_ended_answer', 'text_answer', 'documents');
                            $step_question->with([
                                'question' => function ($question) {
                                    $question->select('id', 'question', 'is_closed_ended', 'is_boolean_answer_required', 'has_text_answer', 'is_text_answer_required', 'has_document', 'is_document_required', 'sorting_serial');
                                }
                            ]);
                            $step_question->sort();
                        },
                        'audit_step_info' => function ($step_info) {
                            $step_info->select('id', 'step_no', 'title', 'slug', 'isa_reference');
                        }
                    ]);

                if (request()->has('status')) {
                    $audit_step->where('status', request()->has('status'));
                }

                $audit_step->orderBy('step_no');
            }
        ]);
    }
}
