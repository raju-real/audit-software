<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditStepQuestion extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = "audit_step_questions";
    protected $guarded = [];
}
