<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditAndStepPair extends Model
{
    use HasFactory;
    protected $table = "audit_and_step_pairs";

    public function audit_step_questions()
    {
        return $this->hasMany(AuditAndStepQuestionPair::class, 'audit_step_pair_id', 'id');
    }

    public function audit_step_info() {
        return $this->belongsTo(AuditStep::class,'audit_step_id','id');
    }
}
