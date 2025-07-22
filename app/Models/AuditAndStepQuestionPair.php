<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditAndStepQuestionPair extends Model
{
    use HasFactory, ModelHelper;
    protected $table = "audit_and_step_question_pairs";

    public function question() {
        return $this->belongsTo(AuditStepQuestion::class,'question_id','id');
    }
}
