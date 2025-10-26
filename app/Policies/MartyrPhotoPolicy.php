<?php

namespace App\Policies;

use App\Models\MartyrPhoto;
use App\Models\User;

class MartyrPhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MartyrPhoto $martyrPhoto): bool
    {
        // Admin xem tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ xem ảnh của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $martyrPhoto->cemetery && $martyrPhoto->cemetery->commune === $user->commune;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin và cán bộ xã/phường được upload ảnh
        return $user->isAdmin() || $user->isCommuneStaff();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MartyrPhoto $martyrPhoto): bool
    {
        // Admin sửa tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ sửa ảnh của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $martyrPhoto->cemetery && $martyrPhoto->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MartyrPhoto $martyrPhoto): bool
    {
        // Admin xóa tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ xóa ảnh của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $martyrPhoto->cemetery && $martyrPhoto->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MartyrPhoto $martyrPhoto): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MartyrPhoto $martyrPhoto): bool
    {
        return $user->isAdmin();
    }
}
