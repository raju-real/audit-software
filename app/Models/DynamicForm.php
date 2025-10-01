<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;
    protected $table = "dynamic_forms";
    protected $guarded = [];

    public function audit_step() {
        return $this->belongsTo(AuditStep::class, 'audit_step_id', 'id');
    }

    public function question() {
        return $this->belongsTo(AuditStepQuestion::class, 'question_id', 'id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function responses() {
        return $this->hasMany(FormResponse::class, 'form_id');
    }
}
