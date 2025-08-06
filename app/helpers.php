<?php

use Dom\Comment;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Audit;
use Illuminate\Support\Str;
use App\Models\AuditAuditor;
use App\Models\Organization;
use App\Models\FinancialYear;
use App\Models\AuditSupervisor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

if (!function_exists('successMessage')) {
    function successMessage(string $type = 'success', string $message = "Information has been saved successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('infoMessage')) {
    function infoMessage(string $type = 'info', string $message = "Information has been updated successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('deleteMessage')) {
    function deleteMessage(string $type = 'primary', string $message = "Information has been deleted successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}


if (!function_exists('dangerMessage')) {
    function dangerMessage(string $type = 'danger', string $message = "Information has been deleted successfully!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('warningMessage')) {
    function warningMessage(string $type = 'warning', string $message = "Something is wrong!"): array
    {
        return [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('starSign')) {
    function starSign(): string
    {
        return " <span class='text-danger'>" . " *" . "</span>";
    }
}

if (!function_exists('displayError')) {
    function displayError(string $error = "Something went wrong!"): string
    {
        return "<span class='text-danger font-weight-500'>" . $error . "</span>";
    }
}

if (!function_exists('devLogo')) {
    function devLogo(): string
    {
        return "assets/dev/ex_logo.jpg";
    }
}

if (!function_exists('hasError')) {
    function hasError(string $fieldName): string
    {
        $errors = session()->get('errors');
        return $errors && $errors->has($fieldName) ? 'border-danger is-invalid' : '';
    }
}

if (!function_exists('commonSpinner')) {
    function commonSpinner(): string
    {
        return "<i class='fa fa-spinner fa-spin me-2 spinner d-none'></i>";
    }
}

if (!function_exists('getStatus')) {
    function getStatus(): array
    {
        return [
            (object)['value' => 'active', 'title' => 'Active'],
            (object)['value' => 'inactive', 'title' => 'In Active']
        ];
    }
}

if (!function_exists('getSureStatus')) {
    function getSureStatus(): array
    {
        return [
            (object)['value' => 'yes', 'title' => 'Yes'],
            (object)['value' => 'no', 'title' => 'No']
        ];
    }
}

if (!function_exists('getClosedEnded')) {
    function getClosedEnded(): array
    {
        return [
            (object)['value' => 'n/a', 'title' => 'N/A'],
            (object)['value' => 'yes', 'title' => 'Yes'],
            (object)['value' => 'no', 'title' => 'No']
        ];
    }
}

if (!function_exists('isActive')) {
    function isActive($status): bool
    {
        return $status == 'active';
    }
}

if (!function_exists('showStatus')) {
    function showStatus($status): string
    {
        $status_badge = $status == 'active' ? 'primary' : 'danger';
        $status_text = firstUpper($status);
        return "<span class='badge badge-pill badge-soft-{$status_badge} font-size-11'>" . $status_text . "</span>";
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'Y-m-d'): string
    {
        return Carbon::parse($date)->format($format);
    }
}

if (!function_exists('imageInfo')) {
    function imageInfo($image): array
    {
        return [
            'is_image' => isImage($image),
            'extension' => fileExtension($image),
            'width' => imageWidthHeight($image)['width'],
            'height' => imageWidthHeight($image)['height'],
            'size' => $image->getSize(),
            'mb_size' => fileSizeInMB($image->getSize())
        ];
    }
}

if (!function_exists('isImage')) {
    function isImage($file): bool
    {
        return $fileType = $file->getClientMimeType();
        $text = explode('/', $fileType)[0];
        return $text == "image";
    }
}

if (!function_exists('fileExtension')) {
    function fileExtension($file): mixed
    {
        if (isset($file)) {
            return $file->getClientOriginalExtension();
        } else {
            return "Invalid file";
        }
    }
}

if (!function_exists('imageWidthHeight')) {
    function imageWidthHeight($image): array
    {
        $imageSize = getimagesize($image);
        $width = $imageSize[0];
        $height = $imageSize[1];
        return array('width' => $width, 'height' => $height);
    }
}

if (!function_exists('fileSizeInMB')) {
    function fileSizeInMB($size): mixed
    {
        if ($size > 0) {
            return number_format($size / 1048576, 2);
        }
        return $size;
    }
}


if (!function_exists('userAvatar')) {
    function userAvatar(): string
    {
        return 'assets/common/images/avatar.png';
    }
}


if (!function_exists('firstUpper')) {
    function firstUpper($text): string
    {
        return ucfirst($text);
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($file, string $folderName = "partial/", $size = "", $width = "", $height = ""): string
    {
        $folderPath = "assets/files/images/" . $folderName;
        File::isDirectory($folderPath) || File::makeDirectory($folderPath, 0777, true, true);
        $imageName = time() . '-' . $file->getClientOriginalName();
        $image = Image::make($file->getRealPath());
        if ((isset($height)) && (isset($width))) {
            $image->resize($width, $height);
        }
        if (isset($size)) {
            $image->filesize($size);
        }
        $image->save($folderPath . "/" . $imageName);
        return $folderPath . "/" . $imageName;
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, string $folderName = "partial/")
    {
        try {
            $folderPath = "assets/files/" . trim($folderName, '/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = time() . '_' . Str::slug($originalName) . '.' . $extension;

            if ($file->move($folderPath, $uniqueFileName)) {
                return $folderPath . "/" . $uniqueFileName;
            }
        } catch (\Throwable $e) {
            // Log the error or silently fail
            Log::error("File upload failed: " . $e->getMessage());
        }

        return null;
    }
}


if (!function_exists('segmentOne')) {
    function segmentOne(): ?string
    {
        return request()->segment(1);
    }
}

if (!function_exists('encrypt_partial')) {
    function encrypt_partial($value, int $length = 15): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        // Convert to string (safe for int or float)
        $stringValue = (string)$value;
        // Split
        $prefix = substr($stringValue, 0, $length);
        $suffix = substr($stringValue, $length);
        // Encrypt the prefix
        $encryptedPrefix = \Illuminate\Support\Facades\Crypt::encrypt($prefix);
        // Optional: Add a separator for easier parsing during decryption
        return $encryptedPrefix . '|PART|' . $suffix;
    }
}

if (!function_exists('decrypt_partial')) {
    function decrypt_partial($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        // Split encrypted and plain part
        [$encryptedPrefix, $suffix] = explode('|PART|', $value, 2);
        // Decrypt prefix
        $decryptedPrefix = \Illuminate\Support\Facades\Crypt::decrypt($encryptedPrefix);
        return $decryptedPrefix . $suffix;
    }
}

if (! function_exists('encrypt_decrypt')) {
    function encrypt_decrypt($key, $type)
    {
        # type = encrypt/decrypt
        $str_rand = "XxOx*4e!hQqG5b~9a";

        if (!$key) {
            return false;
        }
        if ($type == 'decrypt') {
            $en_slash_added1 = trim(str_replace(array('audit'), '/', $key));
            $en_slash_added = trim(str_replace(array('dcaudit'), '%', $en_slash_added1));
            $key_value = $return = openssl_decrypt($en_slash_added, "AES-128-ECB", $str_rand);
            return $key_value;
        } elseif ($type == 'encrypt') {
            $key_value = openssl_encrypt($key, "AES-128-ECB", $str_rand);
            $en_slash_remove1 = trim(str_replace(array('/'), 'audit', $key_value));
            $en_slash_remove = trim(str_replace(array('%'), 'dcaudit', $en_slash_remove1));
            return $en_slash_remove;
        }
        return FALSE;    # if function is not used properly
    }
}


if (!function_exists('isMainMenuActive')) {
    function isMainMenuActive(string $fieldName): string
    {
        $main_menus = explode(',', $fieldName);
        return in_array(segmentOne(), $main_menus) ? 'active mm-active' : '';
    }
}

if (!function_exists('isSubMenuActive')) {
    function isSubMenuActive(string $fieldName): string
    {
        $sub_menus = explode(',', $fieldName);
        return in_array(segmentOne(), $sub_menus) ? 'active' : '';
        // return request()->segment(1) == $fieldName ? 'active' : '';
    }
}

if (!function_exists('isActive')) {
    function isActive(string $segment): string
    {
        return request()->segment(1) === $segment ? 'active' : '';
    }
}

if (!function_exists('textLimit')) {
    function textLimit($text = "", $limit = 20)
    {
        return Str::limit($text, $limit, '...');
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($number, $format = 2): mixed
    {
        return number_format($number, $format);
    }
}

if (!function_exists('ucFirst')) {
    function ucFirst($string = Null): string
    {
        return Str::ucfirst($string);
    }
}

if (!function_exists('siteSettings')) {
    function siteSettings()
    {
        $jsonString = file_get_contents('assets/common/json/site_setting.json');
        return json_decode($jsonString, true);
    }
}

if (!function_exists('authUser')) {
    function authUser()
    {
        return Auth::check() ? Auth::user() : null;
    }
}

// Project related

if (!function_exists('authUserRole')) {
    function authUserRole()
    {
        return Auth::check() ? Auth::user()->role : null;
    }
}

if (!function_exists('getPriorityStatus')) {
    function getPriorityStatus(): array
    {
        return [
            (object)['value' => 'low', 'title' => 'Low'],
            (object)['value' => 'medium', 'title' => 'Medium'],
            (object)['value' => 'high', 'title' => 'High'],
            (object)['value' => 'critical', 'title' => 'Critical']
        ];
    }
}

if (!function_exists('getWorkFlowStatus')) {
    function getWorkFlowStatus(): array
    {
        return [
            (object)['value' => 'draft',    'title' => 'Draft'],
            // (object)['value' => 'ongoing',  'title' => 'Ongoing'],
            // (object)['value' => 'reviewed', 'title' => 'Reviewed'],
            // (object)['value' => 'approved', 'title' => 'Approved'],
            (object)['value' => 'rejected', 'title' => 'Rejected'],
            (object)['value' => 'complete', 'title' => 'Complete'],
            (object)['value' => 'reopened', 'title' => 'Reopened']
        ];
    }
}

if (!function_exists('getAuditStepStatus')) {
    function getAuditStepStatus(): array
    {
        return [
            (object)['value' => 'draft',    'title' => 'Draft'],
            (object)['value' => 'ongoing',  'title' => 'Ongoing'],
            (object)['value' => 'returned',  'title' => 'Returned'],
            // (object)['value' => 'reviewed', 'title' => 'Reviewed'],
            (object)['value' => 'approved', 'title' => 'Approved'],
            (object)['value' => 'rejected', 'title' => 'Rejected']
        ];
    }
}

if (!function_exists('stepSlugById')) {

    function stepSlugById($step_id = null) // Changed Null to null (lowercase)
    {
        return \App\Models\AuditStep::where('id', $step_id)->pluck('slug')->first();
    }
}

if (!function_exists('activeOrganizations')) {
    function activeOrganizations()
    {
        return Organization::active()->oldest('name')->select('id', 'name', 'slug')->get();
    }
}

if (!function_exists('financialYears')) {
    function financialYears()
    {
        return FinancialYear::latest('financial_year')->select('id', 'financial_year')->get();
    }
}

if (!function_exists('getActiveAdmins')) {
    function getActiveAdmins()
    {
        return User::active()->admin()->select('id', 'name')->get();
    }
}

if (!function_exists('auditAuditorsToArray')) {
    function auditAuditorsToArray($audit_id = null)
    {
        return AuditAuditor::where('audit_id', $audit_id)->pluck('user_id')->toArray() ?? [];
    }
}

if (!function_exists('auditSupervisorsToArray')) {
    function auditSupervisorsToArray($audit_id = null)
    {
        return AuditSupervisor::where('audit_id', $audit_id)->pluck('user_id')->toArray() ?? [];
    }
}

if (!function_exists('isStepActive')) {
    /**
     * Determine if a step should be active based on step number and previous step's status
     *
     * @param \Illuminate\Support\Collection $steps
     * @param int $index
     * @return bool
     */
    function isStepActive($steps, $index)
    {
        if ($index === 0) {
            return true; // First step is always active
        }

        $previousStep = $steps[$index - 1] ?? null;

        //return $previousStep && $previousStep->status === 'reviewed';
        return $previousStep && $previousStep->status === 'approved';
    }
}

if(! function_exists('auditWiseAuditors')) {
    function auditWiseAuditors($audit_id = null) {
        $auditors = AuditAuditor::where('audit_id',$audit_id)->pluck('user_id');
        $users = User::whereIn('id',$auditors)->pluck('name')->toArray();
        return implode(', ',$users);
    }
}

if(! function_exists('auditWiseSupervisors')) {
    function auditWiseSupervisors($audit_id = null) {
        $auditors = AuditSupervisor::where('audit_id',$audit_id)->pluck('user_id');
        $users = User::whereIn('id',$auditors)->pluck('name')->toArray();
        return implode(', ',$users);
    }
}

if (! function_exists('auditStepStatusWiseCount')) {
    function auditStepStatusWiseCount($status = null)
    {
        return Audit::whereHas('audit_steps', function ($q) use ($status) {
            $q->where('status', $status);
        })
        ->count();
    }
}

if (! function_exists('supervisorStepStatusWiseCount')) {
    function supervisorStepStatusWiseCount($status = null, $supervisor_id = null)
    {
        $supervisorId = $supervisor_id ?? Auth::id();
        return Audit::whereHas('supervisors', function ($q) use ($supervisorId) {
            $q->where('user_id', $supervisorId);
        })
        ->whereHas('audit_steps', function ($q) use ($status) {
            $q->where('status', $status);
        })
        ->count();
    }
}

if (! function_exists('auditorStepStatusWiseCount')) {
    function auditorStepStatusWiseCount( $auditor_id = null, $status = null)
    {
        $auditorId = $auditor_id ?? Auth::id();
        return Audit::whereHas('auditors', function ($q) use ($auditorId) {
            $q->where('user_id', $auditorId);
        })
        ->whereHas('audit_steps', function ($q) use ($status) {
            $q->where('status', $status);
        })
        ->count();
    }
}


