<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditAndStepPair extends Model
{
    use HasFactory, ModelHelper;
    protected $table = "audit_and_step_pairs";

    public function audit_step_questions()
    {
        return $this->hasMany(AuditAndStepQuestionPair::class, 'audit_step_pair_id', 'id');
    }

    public function audit_info()
    {
        return $this->belongsTo(Audit::class, 'audit_id', 'id');
    }

    public function audit_step_info()
    {
        return $this->belongsTo(AuditStep::class, 'audit_step_id', 'id');
    }

    public function audit_user()
    {
        return $this->belongsTo(User::class, 'audit_by', 'id');
    }

    public function supervisor_user()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public static function getStepInfo($step_id = null)
    {
        return AuditAndStepPair::with([
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
    }
}
