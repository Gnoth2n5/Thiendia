<?php

namespace App\Policies;

use App\Models\Grave;
use App\Models\User;

class GravePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone can view list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Grave $grave): bool
    {
        // Admin có thể xem tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ xem được lăng mộ của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $grave->cemetery->commune === $user->commune;
        }

        return true; // Viewer có thể xem tất cả
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin và cán bộ xã/phường được tạo lăng mộ
        return $user->isAdmin() || $user->isCommuneStaff();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Grave $grave): bool
    {
        // Admin có thể sửa tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ sửa được lăng mộ của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $grave->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Grave $grave): bool
    {
        // Admin có thể xóa tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ xóa được lăng mộ của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $grave->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Grave $grave): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Grave $grave): bool
    {
        return $user->isAdmin();
    }
}
