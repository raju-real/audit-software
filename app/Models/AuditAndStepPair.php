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

    public function audit_info() {
        return $this->belongsTo(Audit::class,'audit_id','id');
    }

    public function audit_step_info() {
        return $this->belongsTo(AuditStep::class,'audit_step_id','id');
    }

    public function audit_user() {
        return $this->belongsTo(User::class,'audit_by','id');
    }

    public function supervisor_user() {
        return $this->belongsTo(User::class,'reviewed_by','id');
    }
}
