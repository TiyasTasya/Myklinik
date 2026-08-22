<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Tindakan;
use Illuminate\Auth\Access\HandlesAuthorization;

class TindakanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Tindakan');
    }

    public function view(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('View:Tindakan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Tindakan');
    }

    public function update(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('Update:Tindakan');
    }

    public function delete(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('Delete:Tindakan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Tindakan');
    }

    public function restore(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('Restore:Tindakan');
    }

    public function forceDelete(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('ForceDelete:Tindakan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Tindakan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Tindakan');
    }

    public function replicate(AuthUser $authUser, Tindakan $tindakan): bool
    {
        return $authUser->can('Replicate:Tindakan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Tindakan');
    }

}