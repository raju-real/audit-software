<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;
    protected $table = 'form_submissions';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    public function files()
    {
        return $this->hasMany(FormSubmissionFile::class, 'submission_id');
    }
}
