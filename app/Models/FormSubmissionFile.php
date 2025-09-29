<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormSubmissionFile extends Model
{
    use HasFactory;
    protected $table = 'form_submission_files';

    protected $fillable = ['submission_id','field_id','field_name','file_path','type','mime'];

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }

    // convenience accessor for full URL
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
