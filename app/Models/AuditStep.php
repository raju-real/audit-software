<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditStep extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "audit_steps";
    protected $guarded = [];
    protected $appends = ['short_title'];

    public function getShortTitleAttribute(): string
    {
        return 'Step '.$this->step_no;
    }

    public function questions() {
        return $this->hasMany(AuditStepQuestion::class,'audit_step_id','id');
    }
}
