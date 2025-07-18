<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminUserArray implements Rule
{
    protected string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_array($value) || empty($value)) {
            return false;
        }

        $userCount = DB::table('users')
            ->whereIn('id', $value)
            ->where('role', 'admin')
            ->count();

        return $userCount === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "All selected {$this->field} must be valid users with the 'admin' role.";
    }
}
