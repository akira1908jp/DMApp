<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\States\PendingAdmin;
use APP\States\PendingHeadquarters;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }

    public function approveAsAdmin(User $user, Document $document)
    {
        // 1. ユーザーが「管理部門」ロールを持っているか
        // 2. かつ、書類が今「管理部門承認待ち」状態か
        return $user->hasRole('admin_dept') 
            && $document->status->is(PendingAdmin::class);
    }

    public function approveAsHq(User $user, Document $document)
    {
        // 本部担当者かつ、本部承認待ち状態か
        return $user->hasRole('hq_dept') 
            && $document->status->is(PendingHeadquarters::class);
    }
}
