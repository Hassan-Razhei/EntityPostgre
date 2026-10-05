<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * أمر طرفية تفاعلي آمن لإنشاء حساب المدير العام الأول
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md
 */
class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إنشاء حساب مدير عام جديد ذو سيادة تقنية للنظام';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('أدخل اسم المدير العام');
        if (empty($name)) {
            $this->error('اسم المدير العام مطلوب ولا يمكن أن يكون فارغاً!');
            return self::FAILURE;
        }

        $email = $this->ask('أدخل البريد الإلكتروني');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('البريد الإلكتروني غير صالح أو فارغ!');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error("البريد الإلكتروني [{$email}] مسجل مسبقاً في المنظومة!");
            return self::FAILURE;
        }

        $password = $this->secret('أدخل كلمة المرور');
        $confirmPassword = $this->secret('تأكيد كلمة المرور');

        if (empty($password) || strlen($password) < 8) {
            $this->error('يجب ألا تقل كلمة المرور عن 8 خانات!');
            return self::FAILURE;
        }

        if ($password !== $confirmPassword) {
            $this->error('كلمة المرور وتأكيدها غير متطابقة!');
            return self::FAILURE;
        }

        $admin = new User();
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = Hash::make($password);
        $admin->role = UserRole::SUPER_ADMIN;
        $admin->is_active = true;
        $admin->save();

        $this->info("تم إنشاء حساب المدير العام بنجاح للمستخدم: {$admin->name} ({$admin->email})");

        return self::SUCCESS;
    }
}
