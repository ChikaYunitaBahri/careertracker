<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * User dapat melihat daftar perusahaan miliknya.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * User dapat melihat perusahaan miliknya sendiri.
     */
    public function view(User $user, Company $company): bool
    {
        return $company->user_id === $user->id;
    }

    /**
     * Semua user login boleh membuat perusahaan.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Hanya pemilik perusahaan yang boleh mengubah.
     */
    public function update(User $user, Company $company): bool
    {
        return $company->user_id === $user->id;
    }

    /**
     * Hanya pemilik perusahaan yang boleh menghapus.
     */
    public function delete(User $user, Company $company): bool
    {
        return $company->user_id === $user->id;
    }

    public function restore(User $user, Company $company): bool
    {
        return $company->user_id === $user->id;
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $company->user_id === $user->id;
    }
}