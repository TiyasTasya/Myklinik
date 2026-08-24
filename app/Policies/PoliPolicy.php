<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Poli;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoliPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Poli');
    }

    public function view(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('View:Poli');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Poli');
    }

    public function update(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('Update:Poli');
    }

    public function delete(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('Delete:Poli');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Poli');
    }

    public function restore(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('Restore:Poli');
    }

    public function forceDelete(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('ForceDelete:Poli');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Poli');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Poli');
    }

    public function replicate(AuthUser $authUser, Poli $poli): bool
    {
        return $authUser->can('Replicate:Poli');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Poli');
    }

}