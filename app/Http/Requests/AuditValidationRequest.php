<?php

namespace App\Http\Requests;

use App\Rules\AdminUserArray;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuditValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'financial_year' => ['required', 'exists:financial_years,id'],
            'organization' => ['required', 'exists:organizations,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'workflow_status' => ['required', Rule::in(['draft', 'ongoing', 'reviewed', 'approved', 'rejected', 'closed'])],
            'reference_document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'description' => ['nullable', 'string', 'max:5000'],

            'auditors' => ['required', 'array', 'min:1', new AdminUserArray('auditors')],
            'auditors.*' => ['required', 'integer'],

            'supervisors' => ['required', 'array', 'min:1', new AdminUserArray('supervisors')],
            'supervisors.*' => ['required', 'integer'],
        ];
    }
}
