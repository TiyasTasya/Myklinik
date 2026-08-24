<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UnitEksternal;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnitEksternalPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UnitEksternal');
    }

    public function view(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('View:UnitEksternal');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UnitEksternal');
    }

    public function update(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('Update:UnitEksternal');
    }

    public function delete(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('Delete:UnitEksternal');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:UnitEksternal');
    }

    public function restore(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('Restore:UnitEksternal');
    }

    public function forceDelete(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('ForceDelete:UnitEksternal');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UnitEksternal');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UnitEksternal');
    }

    public function replicate(AuthUser $authUser, UnitEksternal $unitEksternal): bool
    {
        return $authUser->can('Replicate:UnitEksternal');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UnitEksternal');
    }

}