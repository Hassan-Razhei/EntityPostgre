<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * استنبات حسابات نموذجية للأدوار الـ 12 لبيئة التطوير والاختبار
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password123');

        foreach (UserRole::cases() as $role) {
            $user = User::firstOrNew(['email' => "{$role->value}@archive.org"]);
            $user->name = $role->label();
            $user->password = $defaultPassword;
            $user->role = $role;
            $user->is_active = true;
            $user->save();
        }
    }
}
