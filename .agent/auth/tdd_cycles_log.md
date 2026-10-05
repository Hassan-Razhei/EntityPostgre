# 📋 سجل ومسار دورات التطوير الموجه بالاختبارات (TDD Cycles Execution Log)
## منظومة الهوية والصلاحيات — Entity Digital Library

---

## 📊 لوحة المؤشرات الإجمالية (Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور | ملفات الاختبار المنشأة | نتيجة الـ RED 🔴 | نتيجة الـ GREEN 🟢 | فحص عدم الانكسار 🛡️ | الحالة |
|:---:|---|---|:---:|:---:|:---:|:---:|
| **1** | **طبقة البيانات والموديلات (Data & Models)** | `tests/Unit/Auth/UserRoleAndModelTest.php` | 4 Failed, 1 Passed | 5 Passed (70 Assertions) | **328 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **2** | **استنبات الحسابات وأمر المدير العام (Provisioning & CLI)** | `tests/Feature/Auth/UserProvisioningTest.php` | 4 Failed | 4 Passed (70 Assertions) | **332 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **3** | **حواجز المسارات (Route Middlewares: EnsureUserHasRole & EnsureUserIsActive)** | `tests/Feature/Auth/RoleAndActiveMiddlewareTest.php` | 6 Failed | 6 Passed (13 Assertions) | **338 Passed** (100% نجاح) | ✅ مكتملة وموثقة |

---

## 🔹 الدورة 1: طبقة البيانات والموديلات (Data, Enum & Model Guardrails)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  تأسيس حجر الزاوية البرمجي لمنظومة الهوية؛ عبر بناء التعداد الهرمي للأدوار الـ 12 (`UserRole`)، وتطعيم موديل `User` بالكاستينغ التلقائي والدوال المساعدة، وحصانة التعيين الكتلي، ودمج الحقول في ملف ترحيل جدول المستخدمين التأسيسي.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Unit/Auth/UserRoleAndModelTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Unit/Auth/UserRoleAndModelTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_has_all_twelve_roles_with_correct_backed_values`: فحص وجود الأدوار الـ 12 بقيمها النصية المعتمدة.
  2. `it_has_correct_hierarchy_weights_and_capabilities`: فحص الأوزان الهرمية (من 100 إلى 0)، والتدرج (`isAtLeast`)، وأهليات (`canAccessStudio`, `canCurateMetadata`, `canPublish`).
  3. `it_enforces_mass_assignment_guardrail`: التحقق من الحصانة 3 (استبعاد `role` و `is_active` من `$fillable`).
  4. `it_casts_role_and_is_active_correctly`: فحص كاستينغ الحقول تلقائياً لنوع Enum و Boolean.
  5. `it_provides_helper_methods_on_user_model`: فحص دوال التحقق بالموديل (`isSuperAdmin`, `hasRole`, `isAtLeast`, `canAccessStudio`).
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  Tests\Unit\Auth\UserRoleAndModelTest
  ⨯ it has all twelve roles with correct backed values
  ⨯ it has correct hierarchy weights and capabilities
  ✓ it enforces mass assignment guardrail
  ⨯ it casts role and is active correctly
  ⨯ it provides helper methods on user model
  
  Error: Class "App\Enums\UserRole" not found
  Tests: 4 failed, 1 passed (2 assertions)
  ```
  *(نجح اختبار الحصانة تلقائياً وفشلت بقية الاختبارات الأربعة بالسبب المنطقي السليم لعدم وجود الكلاسات بعد)*.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **إنشاء الـ Enum:** [`app/Enums/UserRole.php`](file:///home/a/Project-test/EntityPostgre/app/Enums/UserRole.php)
     - صياغة الأدوار الـ 12 موزعة على القطاعات الأربعة.
     - تضمين توابع: `label()`, `weight()`, `sector()`, `badgeColor()`, `isAtLeast()`, `canAccessStudio()`, `canCurateMetadata()`, `canPublish()`.
  2. **تحديث موديل المستخدم:** [`app/Models/User.php`](file:///home/a/Project-test/EntityPostgre/app/Models/User.php)
     - إضافة `$attributes` الافتراضية (`role = researcher`, `is_active = true`).
     - إضافة كاستينغ `role` إلى `UserRole::class` و `is_active` إلى `boolean`.
     - إضافة توابع التحقق البرمجية المساعدة.
  3. **تحديث الترحيل التأسيسي:** [`database/migrations/0001_01_01_000000_create_users_table.php`](file:///home/a/Project-test/EntityPostgre/database/migrations/0001_01_01_000000_create_users_table.php)
     - إضافة الحقلين مفهرسين:
       ```php
       $table->string('role', 50)->default('researcher')->index();
       $table->boolean('is_active')->default(true)->index();
       ```
  4. **تحديث مصنع المستخدمين:** [`database/factories/UserFactory.php`](file:///home/a/Project-test/EntityPostgre/database/factories/UserFactory.php)
     - تزويد الـ Factory بالحقول الافتراضية وحالات التخصيص (`withRole`, `superAdmin`, `inactive`).
- **الأوامر المنفذة:**
  - ترحيل نظيف: `php artisan migrate:fresh` (دون إدخال بيانات وهمية seed لتفادي التشويش).
- **نتيجة تشغيل اختبار الوحدة بعد كتابة الكود (GREEN):**
  ```text
  PASS  Tests\Unit\Auth\UserRoleAndModelTest
  ✓ it has all twelve roles with correct backed values                   0.13s  
  ✓ it has correct hierarchy weights and capabilities                    0.02s  
  ✓ it enforces mass assignment guardrail                                0.02s  
  ✓ it casts role and is active correctly                                0.02s  
  ✓ it provides helper methods on user model                             0.02s  

  Tests: 5 passed (70 assertions)
  Duration: 0.27s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test`
- **النتيجة الرسمية:**
  ```text
  Tests: 1 incomplete, 328 passed (1886 assertions)
  Duration: 41.40s
  ```
  *(جميع الاختبارات السابقة البالغ عددها 323 اختباراً استمرت بالعمل بنجاح تام 100% دون كسر أي وظيفة في استوديو المخطوطات والوسائط والكتب)*.

---

### 4. القرارات المعمارية الموثقة في الدورة (Architectural Decisions):
1. **رفض ترحيلات الترقيع (No Patch Migrations in Dev):**
   - بتوجيه حكيم من المستخدم، تم تعديل ملف الترحيل التأسيسي الأصلي مباشرة لجدول `users` وتطبيق `migrate:fresh` للحفاظ على نظافة الـ Schema ومنع تراكم الديون التقنية.
2. **اعتماد الـ Backed Enum (PHP 8.4):**
   - استخدام نوع String للـ Enum مع دوال مباشرة للتحقق، مما يضمن أداءً فائقاً وخفة في استعلامات المصادقة اليومية.
3. **الحصانة 3 (استبعاد التعيين الكتلي):**
   - التأكيد على عدم وجود `role` و `is_active` داخل `$fillable` لردع أي محاولة تعديل غير مصرح بها عبر طلبات النماذج العامة.

---

## 🔹 الدورة 2: استنبات الحسابات وأمر المدير العام (Provisioning & CLI Admin Creation)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  استكمال البند الرابع والأخير من الخطوة 1 في المرجع المعماري؛ بتوفير آلية استنبات حسابات نموذجية للأدوار الـ 12 لبيئة التطوير والاختبار عبر `UserSeeder`، وبناء أمر طرفية تفاعلي آمن `php artisan user:create-admin` لإنشاء حساب المدير العام الأول في بيئة الإنتاج دون كشف كلمات المرور في مستودع Git.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Feature/Auth/UserProvisioningTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Feature/Auth/UserProvisioningTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_seeds_default_users_for_all_twelve_roles`: فحص استنبات حساب نشط لكل دور من الأدوار الـ 12 والتأكد من صحة الرتبة والحالة.
  2. `it_creates_super_admin_via_artisan_command`: فحص أمر `user:create-admin` التفاعلي وتوليد حساب مدير عام `super_admin`.
  3. `it_rejects_duplicate_email_in_create_admin_command`: التحقق من رفض إنشاء مدير ببريد إلكتروني مسجل مسبقاً.
  4. `it_rejects_password_mismatch_in_create_admin_command`: التحقق من رفض العملية عند عدم تطابق كلمتي المرور.
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  Tests\Feature\Auth\UserProvisioningTest
  ⨯ it seeds default users for all twelve roles
  ⨯ it creates super admin via artisan command
  ⨯ it rejects duplicate email in create admin command
  ⨯ it rejects password mismatch in create admin command

  Errors:
  1. Target class [Database\Seeders\UserSeeder] does not exist.
  2. The command "user:create-admin" does not exist.
  Tests: 4 failed (13 assertions)
  ```

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة:**
  1. **ملف الـ Seeder:** [`database/seeders/UserSeeder.php`](file:///home/a/Project-test/EntityPostgre/database/seeders/UserSeeder.php)  
     - استنبات الحسابات الـ 12 بنمط `firstOrNew` لمنع التكرار وضبط الرتبة والحالة النشطة لكل حساب.
  2. **أمر الطرفية التفاعلي:** [`app/Console/Commands/CreateAdminCommand.php`](file:///home/a/Project-test/EntityPostgre/app/Console/Commands/CreateAdminCommand.php)  
     - تنفيذ أمر `user:create-admin` بالتحقق من صحة الاسم والبريد وتفرده، وقوة كلمة المرور وتطابقها، وإنشاء المدير العام بحصانة تامة.
- **نتيجة تشغيل اختبار الميزة بعد كتابة الكود (GREEN):**
  ```text
  PASS  Tests\Feature\Auth\UserProvisioningTest
  ✓ it seeds default users for all twelve roles                          1.11s  
  ✓ it creates super admin via artisan command                           0.08s  
  ✓ it rejects duplicate email in create admin command                   0.16s  
  ✓ it rejects password mismatch in create admin command                 0.07s  

  Tests: 4 passed (70 assertions)
  Duration: 1.49s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test`
- **النتيجة الرسمية:**
  ```text
  Tests: 1 incomplete, 332 passed (1974 assertions)
  Duration: 34.35s
  ```
  *(تم الحفاظ التام على سلامة الـ 323 اختباراً السابقة، وارتفع إجمالي الاختبارات الناجحة إلى 332 اختباراً بنسبة نجاح 100%)*.

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **الأمان في بيئة الإنتاج:** حظر وضع كلمات مرور المشرفين في الكود المصدري أو ملفات الترحيل، واستبدال ذلك بأمر تفاعلي مشفر (`secret()`) يُشغل مباشرة على الخادم.
2. **عزل حسابات الأدوار الـ 12:** تخصيص بريد إلكتروني واضح لكل دور (`{role}@archive.org`) لتسهيل عمليات الاختبارات الوظيفية وأتمتة الـ QA.

---

## 🔹 الدورة 3: حواجز المسارات (Route Middlewares: EnsureUserHasRole & EnsureUserIsActive)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  بناء المستوى الأول من خط الدفاع الثلاثي؛ بتطوير حراس المداخل في المنظومة:
  1. `EnsureUserIsActive`: فحص نشاط الحساب ومصادرة الجلسة الحية للحسابات المجمدة فورياً.
  2. `EnsureUserHasRole`: فحص الرتب المفردة والمتعددة مع دعم الفصل بالفواصل (`role:editor,chief_editor,super_admin`) وتوجيه الزوار لصفحة الدخول.
  3. تسجيل الأسماء المستعارة (`active` و `role`) رسمياً في `bootstrap/app.php`.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Feature/Auth/RoleAndActiveMiddlewareTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Feature/Auth/RoleAndActiveMiddlewareTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_allows_active_authenticated_users`: نفاذ المستخدم النشط المصرح له بنجاح (HTTP 200).
  2. `it_blocks_inactive_users_and_invalidates_session`: طرد الحساب المجمد ومصادرة جلسته فوراً ورفضه بـ (HTTP 403).
  3. `it_allows_user_with_exact_required_role`: نفاذ المستخدم المطابق للرتبة المفردة (`role:editor`).
  4. `it_denies_user_without_required_role_with_informative_403`: حظر المستخدم الذي لا يملك الرتبة المطلوبة برمز 403 ورسالة عربية مفسرة.
  5. `it_allows_any_matching_role_in_multiple_role_middleware`: دعم الرتب المتعددة والسماح لأي رتبة مطابقة وحجب غيرها.
  6. `it_redirects_unauthenticated_guests_to_login`: إعادة توجيه الزائر غير المسجل لصفحة `/login` برمز (302).
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  Tests\Feature\Auth\RoleAndActiveMiddlewareTest
  ⨯ it allows active authenticated users
  ⨯ it blocks inactive users and invalidates session
  ⨯ it allows user with exact required role
  ⨯ it denies user without required role with informative 403
  ⨯ it allows any matching role in multiple role middleware
  ⨯ it redirects unauthenticated guests to login

  Error: Target class [active] does not exist.
  Tests: 6 failed (0 assertions)
  Duration: 2.89s
  ```

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **ميدلوير النشاط وإبطال الجلسات:** [`app/Http/Middleware/EnsureUserIsActive.php`](file:///home/a/Project-test/EntityPostgre/app/Http/Middleware/EnsureUserIsActive.php)  
     - طرد الجلسة فورياً عبر `Auth::logout()` و `$request->session()->invalidate()` و `$request->session()->regenerateToken()`.
  2. **ميدلوير فحص الرتب:** [`app/Http/Middleware/EnsureUserHasRole.php`](file:///home/a/Project-test/EntityPostgre/app/Http/Middleware/EnsureUserHasRole.php)  
     - دعم مرن للرتب المفردة والمتعددة والفصل بالفواصل.
  3. **تسجيل الـ Aliases:** [`bootstrap/app.php`](file:///home/a/Project-test/EntityPostgre/bootstrap/app.php)  
     - تسجيل `active` و `role` تحت `$middleware->alias(...)`.
- **نتيجة تشغيل اختبار الميزة بعد كتابة الكود (GREEN):**
  ```text
  PASS  Tests\Feature\Auth\RoleAndActiveMiddlewareTest
  ✓ it allows active authenticated users                                 0.78s  
  ✓ it blocks inactive users and invalidates session                     0.07s  
  ✓ it allows user with exact required role                              0.04s  
  ✓ it denies user without required role with informative 403            0.05s  
  ✓ it allows any matching role in multiple role middleware              0.06s  
  ✓ it redirects unauthenticated guests to login                         0.04s  

  Tests: 6 passed (13 assertions)
  Duration: 1.10s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test`
- **النتيجة الرسمية:**
  ```text
  Tests: 1 incomplete, 338 passed (1981 assertions)
  Duration: 37.06s
  ```
  *(نجاح كامل بنسبة 100% لجميع اختبارات المشروع السابقة والجديدة، وارتفاع إجمالي الاختبارات الناجحة إلى 338 اختباراً)*.

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **الردع التفسيري (Informative Denial):** إرجاع رسائل رفض عربية واضحة ومحددة عند الـ 403 لتمكين الواجهة ومستخدميها من معرفة سبب الحظر.
2. **الفصل الصارم للجلسات الحية (Session Invalidation):** عدم الاكتفاء بالرفض البرمجي عند تجميد الحساب، بل إلغاء التوكن وإبطال الجلسة الأمنية فوراً لمنع أي استغلال للجلسة المفتوحة مسبقاً.


