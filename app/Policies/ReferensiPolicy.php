<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Referensi;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReferensiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Referensi');
    }

    public function view(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('View:Referensi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Referensi');
    }

    public function update(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('Update:Referensi');
    }

    public function delete(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('Delete:Referensi');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Referensi');
    }

    public function restore(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('Restore:Referensi');
    }

    public function forceDelete(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('ForceDelete:Referensi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Referensi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Referensi');
    }

    public function replicate(AuthUser $authUser, Referensi $referensi): bool
    {
        return $authUser->can('Replicate:Referensi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Referensi');
    }

}