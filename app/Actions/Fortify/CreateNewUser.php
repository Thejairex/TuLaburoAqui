<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\User;
use App\Models\WorkerProfile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    public function create(array $input): User
    {
        $role = $input['role'] ?? 'candidate';

        $rules = [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'role' => ['required', 'in:candidate,employer'],
        ];

        if ($role === 'employer') {
            $rules['company_legal_name'] = ['required', 'string', 'max:255'];
            $rules['company_display_name'] = ['nullable', 'string', 'max:255'];
            $rules['company_industry'] = ['nullable', 'string', 'max:100'];
            $rules['company_size'] = ['nullable', 'string', 'max:50'];
        }

        Validator::make($input, $rules)->validate();

        return DB::transaction(function () use ($input, $role) {
            $user = User::create([
                'name'     => $input['name'],
                'email'    => $input['email'],
                'password' => $input['password'],
                'role'     => $role,
            ]);

            if ($role === 'candidate') {
                WorkerProfile::create(['user_id' => $user->id]);
            }

            if ($role === 'employer') {
                $displayName = $input['company_display_name'] ?? $input['company_legal_name'];
                $company = Company::create([
                    'legal_name'   => $input['company_legal_name'],
                    'display_name' => $input['company_display_name'] ?? null,
                    'slug'         => Company::generateUniqueSlug($displayName),
                    'industry'     => $input['company_industry'] ?? null,
                    'company_size' => $input['company_size'] ?? null,
                    'email'        => $input['email'],
                ]);

                CompanyMember::create([
                    'company_id' => $company->id,
                    'user_id'    => $user->id,
                    'role'       => 'admin',
                    'is_owner'   => true,
                ]);
            }

            return $user;
        });
    }
}
