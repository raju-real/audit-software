<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;

    protected $fillable = ['form_id', 'user_id', 'response_json'];

    public function form() {
        return $this->belongsTo(DynamicForm::class, 'form_id');
    }
}
