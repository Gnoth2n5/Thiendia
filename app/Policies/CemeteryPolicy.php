<?php

namespace App\Policies;

use App\Models\Cemetery;
use App\Models\User;

class CemeteryPolicy
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
    public function view(User $user, Cemetery $cemetery): bool
    {
        // Admin có thể xem tất cả
        if ($user->isAdmin()) {
            return true;
        }

        // Cán bộ xã/phường chỉ xem được nghĩa trang của xã/phường mình
        if ($user->isCommuneStaff()) {
            return $cemetery->commune === $user->commune;
        }

        return true; // Viewer có thể xem tất cả
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Chỉ admin mới được tạo nghĩa trang
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cemetery $cemetery): bool
    {
        // Chỉ admin mới được sửa nghĩa trang
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cemetery $cemetery): bool
    {
        // Chỉ admin mới được xóa nghĩa trang
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Cemetery $cemetery): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Cemetery $cemetery): bool
    {
        return $user->isAdmin();
    }
}
