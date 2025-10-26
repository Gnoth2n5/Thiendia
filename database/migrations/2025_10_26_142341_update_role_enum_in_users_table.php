<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Sử dụng raw SQL để update ENUM vì Laravel không hỗ trợ trực tiếp
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'super_admin', 'commune_staff', 'viewer', 'user') DEFAULT 'user' COMMENT 'Vai trò người dùng'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') DEFAULT 'user' COMMENT 'Vai trò người dùng'");
    }
};
