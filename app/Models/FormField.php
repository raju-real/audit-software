<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;
    protected $table = 'form_fields';

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'multiple' => 'boolean',
        'paragraph' => 'string',
    ];
    
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
