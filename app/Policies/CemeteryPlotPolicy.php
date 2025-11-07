<?php

namespace App\Policies;

use App\Models\CemeteryPlot;
use App\Models\User;

class CemeteryPlotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isCommuneStaff();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CemeteryPlot $cemeteryPlot): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCommuneStaff()) {
            return $cemeteryPlot->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Admin và cán bộ xã/phường có thể tạo plots.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCommuneStaff();
    }

    /**
     * Determine whether the user can update the model.
     * Admin và cán bộ xã/phường có thể cập nhật plots của nghĩa trang họ quản lý.
     */
    public function update(User $user, CemeteryPlot $cemeteryPlot): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCommuneStaff()) {
            return $cemeteryPlot->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Admin và cán bộ xã/phường có thể xóa plots của nghĩa trang họ quản lý.
     */
    public function delete(User $user, CemeteryPlot $cemeteryPlot): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCommuneStaff()) {
            return $cemeteryPlot->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CemeteryPlot $cemeteryPlot): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCommuneStaff()) {
            return $cemeteryPlot->cemetery->commune === $user->commune;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CemeteryPlot $cemeteryPlot): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCommuneStaff()) {
            return $cemeteryPlot->cemetery->commune === $user->commune;
        }

        return false;
    }
}
