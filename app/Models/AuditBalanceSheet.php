<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditBalanceSheet extends Model
{
    use HasFactory;
    protected $table = 'audit_balance_sheets';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
