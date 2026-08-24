<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Penyedia;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenyediaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Penyedia');
    }

    public function view(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('View:Penyedia');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Penyedia');
    }

    public function update(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('Update:Penyedia');
    }

    public function delete(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('Delete:Penyedia');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Penyedia');
    }

    public function restore(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('Restore:Penyedia');
    }

    public function forceDelete(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('ForceDelete:Penyedia');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Penyedia');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Penyedia');
    }

    public function replicate(AuthUser $authUser, Penyedia $penyedia): bool
    {
        return $authUser->can('Replicate:Penyedia');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Penyedia');
    }

}