<?php

namespace App\Policies;

use App\Models\AssetMutation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssetMutationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'staf_operasional']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AssetMutation $assetMutation): bool
    {
        return $user->hasAnyRole(['administrator', 'staf_operasional']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['administrator', 'staf_operasional']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AssetMutation $assetMutation): bool
    {
        return $user->hasAnyRole(['administrator', 'staf_operasional']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AssetMutation $assetMutation): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AssetMutation $assetMutation): bool
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AssetMutation $assetMutation): bool
    {
        return $user->hasRole('administrator');
    }
}
