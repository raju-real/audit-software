<?php

namespace App\Models;

use App\Traits\ModelHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;
    protected $table = 'audits';
    protected $guarded = [];

    public function financial_year() {
        return $this->belongsTo(FinancialYear::class,'financial_year_id','id');
    }

    public function organization() {
        return $this->belongsTo(Organization::class,'organization_id','id');
    }

    public function scopeDraft($query) {
        return $query->where('workflow_status', 'draft');
    }

    public function scopeOngoing($query) {
        return $query->where('workflow_status', 'ongoing');
    }

    public function scopeReviewed($query) {
        return $query->where('workflow_status', 'reviewed');
    }

    public function scopeApproved($query) {
        return $query->where('workflow_status', 'approved');
    }

    public function scopeRejected($query) {
        return $query->where('workflow_status', 'rejected');
    }

    public function scopeComplete($query) {
        return $query->where('workflow_status', 'complete');
    }

    public function scopeClosed($query) {
        return $query->where('workflow_status', 'closed');
    }

    public static function getAuditNumber(): string
    {
        $latestAuditNo = Audit::latest('id')->first();
        $newAuditNo = str_pad(1, 4, "0", STR_PAD_LEFT);
        if ($latestAuditNo) {
            $lastAuditNo = $latestAuditNo->audit_number;
            if ($lastAuditNo != null) {
                $newSerialNumber = $lastAuditNo + 1;
                $newAuditNo = str_pad($newSerialNumber, 4, "0", STR_PAD_LEFT);;
            } else {
                $newAuditNo = str_pad(1, 4, "0", STR_PAD_LEFT);
            }
        }
        if (Audit::where('audit_number', $newAuditNo)->exists()) {
            Audit::getAuditNo();
        }
        return $newAuditNo;
    }
}
