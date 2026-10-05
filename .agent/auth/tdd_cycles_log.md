# 📋 سجل ومسار دورات التطوير الموجه بالاختبارات (TDD Cycles Execution Log)
## منظومة الهوية والصلاحيات — Entity Digital Library

---

## 📊 لوحة المؤشرات الإجمالية (Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور | ملفات الاختبار المنشأة | نتيجة الـ RED 🔴 | نتيجة الـ GREEN 🟢 | فحص عدم الانكسار 🛡️ | الحالة |
|:---:|---|---|:---:|:---:|:---:|:---:|
| **1** | **طبقة البيانات والموديلات (Data & Models)** | `tests/Unit/Auth/UserRoleAndModelTest.php` | 4 Failed, 1 Passed | 5 Passed (70 Assertions) | **328 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **2** | **استنبات الحسابات وأمر المدير العام (Provisioning & CLI)** | `tests/Feature/Auth/UserProvisioningTest.php` | 4 Failed | 4 Passed (70 Assertions) | **332 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **3** | **حواجز المسارات (Route Middlewares: EnsureUserHasRole & EnsureUserIsActive)** | `tests/Feature/Auth/RoleAndActiveMiddlewareTest.php` | 6 Failed | 6 Passed (13 Assertions) | **338 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **4** | **سياسات الكيانات وبوابة العبور (EntityPolicy & Gate::before)** | `tests/Feature/Auth/EntityPolicyTest.php` | 5 Failed, 1 Passed | 6 Passed (26 Assertions) | **344 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **5** | **ترسيم الأحياز الجغرافية للمسارات (Routing & Zones Separation)** | `tests/Feature/Auth/RoutingZonesTest.php` | 3 Failed | 3 Passed (10 Assertions) | **347 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **6** | **تكامل الواجهة وحقن الهوية (Frontend & Inertia: HandleInertiaRequests & useAuth)** | `tests/Feature/Auth/InertiaAuthSharingTest.php`<br>`resources/js/__tests__/useAuth.test.js` | 13 Failed (PHP)<br>1 Failed (JS) | 14 Passed (340 Assertions)<br>3 Passed (JS) | **361 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **7** | **التكيف البصري والملاحة المكانية (Adaptive UI & Spatial Navigation)** | `resources/js/__tests__/adaptiveUI.test.js` | 3 Failed (JS) | 6 Passed (JS) | **361 Passed (PHP) + 11 Passed (JS)** (100% نجاح) | ✅ مكتملة وموثقة |

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

---

## 🔹 الدورة 4: سياسات الكيانات وبوابة العبور (EntityPolicy & Gate::before)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  بناء المستوى الثاني من خط الدفاع الثلاثي؛ بتشريع الضوابط الصارمة لسياسة الكيانات والمصنفات الرقمية [`EntityPolicy.php`](file:///home/a/Project-test/EntityPostgre/app/Policies/EntityPolicy.php) وتفعيل بوابة العبور المركزي السيادية للمدير العام (`Gate::before`) مع استثناء وحصانة سجلات التدقيق الرقمية (Immutability).

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Feature/Auth/EntityPolicyTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Feature/Auth/EntityPolicyTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_allows_viewing_public_entities_for_all`: إتاحة قراءة المصنفات العامة لكافة الزوار والمستخدمين.
  2. `it_restricts_restricted_entities_to_verified_researchers_and_staff`: حظر المصنفات المقيدة عن الباحثين العاديين، وإتاحتها حصراً للباحث الموثق (`verified_researcher`) وطاقم التحرير والمدير العام.
  3. `it_restricts_studio_access_to_transcriber_editor_chief_and_super_admin`: حصر دخول الاستوديو بالنساخ والمحررين ورؤساء التحرير والمدير العام.
  4. `it_restricts_publishing_to_chief_editor_and_super_admin`: حظر النشر على المحررين والفهارس وحصره برئيس التحرير والمدير العام.
  5. `it_restricts_soft_delete_to_chief_editor_and_super_admin`: حظر الحذف على المحررين وحصره برئيس التحرير والمدير العام.
  6. `it_restricts_force_delete_strictly_to_super_admin`: قصر الحذف النهائي الجذري على المدير العام وحده دون سواه.
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  Tests\Feature\Auth\EntityPolicyTest
  ✓ it allows viewing public entities for all
  ⨯ it restricts restricted entities to verified researchers and staff (Failed asserting that true is false)
  ⨯ it restricts studio access to transcriber editor chief and super admin (Failed asserting that false is true)
  ⨯ it restricts publishing to chief editor and super admin (Failed asserting that false is true)
  ⨯ it restricts soft delete to chief editor and super admin (Failed asserting that true is false)
  ⨯ it restricts force delete strictly to super admin (Failed asserting that true is false)

  Tests: 5 failed, 1 passed (10 assertions)
  Duration: 1.30s
  ```

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **تحديث سياسة الكيانات:** [`app/Policies/EntityPolicy.php`](file:///home/a/Project-test/EntityPostgre/app/Policies/EntityPolicy.php)  
     - استبدال `return true` الصامت بكامل الضوابط الهندسية للأدوار الـ 12.
  2. **تفعيل بوابة العبور المركزي للمدير العام:** [`app/Providers/AppServiceProvider.php`](file:///home/a/Project-test/EntityPostgre/app/Providers/AppServiceProvider.php)  
     - تفعيل `Gate::before` لعبور `super_admin` مع استثناء صريح لحصانة سجلات التدقيق (منع حذف أو تعديل سجلات التدقيق حتى للمدير العام).
  3. **تطبيق قرار المستخدم المعماري (Strict Realism):**
     - ضبط الرتبة الافتراضية في قاعدة البيانات (`0001_01_01_000000_create_users_table.php`) والموديل (`User.php`) والـ Factory (`UserFactory.php`) لتكون `guest` أصيلة.
     - تحديث أسطر إنشاء المستخدم في الاختبارات الوظيفية السابقة للإعلان الصريح عن هوية منفذ العمليات الإدارية (`superAdmin()`).
- **نتيجة تشغيل اختبار سياسة الكيانات بعد كتابة الكود (GREEN):**
  ```text
  PASS  Tests\Feature\Auth\EntityPolicyTest
  ✓ it allows viewing public entities for all                            1.08s  
  ✓ it restricts restricted entities to verified researchers and staff   0.08s  
  ✓ it restricts studio access to transcriber editor chief and super ad… 0.12s  
  ✓ it restricts publishing to chief editor and super admin              0.14s  
  ✓ it restricts soft delete to chief editor and super admin             0.08s  
  ✓ it restricts force delete strictly to super admin                    0.12s  

  Tests: 6 passed (26 assertions)
  Duration: 1.70s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test`
- **النتيجة الرسمية:**
  ```text
  Tests: 1 incomplete, 344 passed (2010 assertions)
  Duration: 37.12s
  ```
  *(تم بنجاح كاسح استعادة كامل اللون الأخضر بنسبة 100% لكافة الاختبارات السابقة والجديدة، وارتفع إجمالي الاختبارات الناجحة إلى 344 اختباراً)*.

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **الواقعية الصارمة (Strict Realism):** اعتماد `guest` كخيار افتراضي جذري في المنظومة، وإلزام الاختبارات الوظيفية بالتصريح الصريح عن الرتبة الإدارية المنفذة للاختبار.
2. **استثناء حصانة التدقيق من عبور المدير العام (Audit Immutability):** منع تجاوز المدير العام عند فحص عمليات حذف أو تعديل سجلات التدقيق لضمان النزاهة الرقمية المطلقة.

---

## 🔹 الدورة 5: ترسيم الأحياز الجغرافية وحراسة المسارات (Routing & Zones Separation)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  تفعيل المستوى الأول من خط الدفاع الثلاثي (Route Guarding) بعزل الأحياز الحساسة للمنظومة في [`routes/web.php`](file:///home/a/Project-test/EntityPostgre/routes/web.php)؛ حيث يُحظر المستخدم المجمد على كافة الأصعدة بـ `active`، ويُعزل استوديو التحرير الرقمي الموحد ومسارات حفظ الأجزاء بحاجز رتب الاستوديو (`role:transcriber,editor,chief_editor,super_admin`)، وتُقفل لوحة أوامر النظام وأوامر التنفيذ الجذرية حصراً للمدير العام (`role:super_admin`).

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Feature/Auth/RoutingZonesTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Feature/Auth/RoutingZonesTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_restricts_studio_routes_to_studio_staff_only`: التحقق من أن الباحث العادي يُحظر من دخول مسار استوديو التحرير (`/studio/resume`) بـ 403، بينما طاقم الاستوديو المعتمد والمدير العام مصرح لهم بالدخول.
  2. `it_restricts_system_commands_strictly_to_super_admin`: التحقق من حظر المحرر ورئيس التحرير والباحث من دخول لوحة أوامر النظام (`/system/commands`) بـ 403، والسماح للمدير العام فقط بعبورها (200 OK).
  3. `it_blocks_inactive_users_across_zones`: التحقق من طرد المستخدم المجمد وحظره بـ 403 عبر مختلف مناطق التطبيق حتى لو كان يحمل رتبة مدير عام.
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  Tests\Feature\Auth\RoutingZonesTest
  ⨯ it restricts studio routes to studio staff only (Expected response status code [403] but received 302)
  ⨯ it restricts system commands strictly to super admin (Expected response status code [403] but received 200)
  ⨯ it blocks inactive users across zones (Expected response status code [403] but received 200)

  Tests: 3 failed (3 assertions)
  Duration: 1.25s
  ```

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **تحديث مسارات الويب:** [`routes/web.php`](file:///home/a/Project-test/EntityPostgre/routes/web.php)
     - إضافة وسيط `active` لمجموعة المسارات الموثقة: `Route::middleware(['auth', 'active'])->group(...)`.
     - حراسة مسارات استوديو التحرير الموحد ومسارات الأجزاء المتصلة:
       `Route::middleware(['role:transcriber,editor,chief_editor,super_admin'])->group(...)`.
     - قصر مسارات أوامر النظام ولوحة الأوامر حصراً على المدير العام:
       `Route::middleware(['role:super_admin'])->group(...)`.
     - حراسة مسارات تقنية القارئ (`reader`) بوسيط `active`.
- **نتيجة تشغيل اختبار ترسيم الأحياز بعد كتابة الكود (GREEN):**
  ```text
  PASS  Tests\Feature\Auth\RoutingZonesTest
  ✓ it restricts studio routes to studio staff only                      1.01s  
  ✓ it restricts system commands strictly to super admin                 0.07s  
  ✓ it blocks inactive users across zones                                0.06s  

  Tests: 3 passed (10 assertions)
  Duration: 1.20s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test`
- **النتيجة الرسمية:**
  ```text
  Tests: 1 incomplete, 347 passed (2014 assertions)
  Duration: 36.43s
  ```
  *(جميع اختبارات الأرشيف والاستوديو والوسائط السابقة البالغ عددها 344 اختباراً بقيت خضراء بنسبة 100% دون أدنى انكسار، وارتفع إجمالي الاختبارات الناجحة إلى 347 اختباراً)*.

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **العزل الهيكلي للمناطق (Zonal Isolation):** تجميع المسارات في كتل `Route::middleware` واضحة الصلاحيات بدلاً من تطبيق الحراسة الفردية المتفرقة لكل مسار، لتفادي تسرب أي مسارات جديدة مستقبلاً دون حماية.
2. **الحظر الاستباقي الشامل (Universal Active Filter):** اشتراط وسيط `active` بجانب `auth` في قمة هرم المجموعات الموثقة لضمان عدم وصول أي حساب مجمد إلى أي مورد داخل المنصة.

---

## 🔹 الدورة 6: تكامل الواجهة وحقن الهوية (Frontend & Inertia Integration: HandleInertiaRequests & useAuth)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  بناء المستوى الثالث من خط الدفاع الأمني (Adaptive Rendering & State Hydration)؛ بتزويد الواجهة مسبقاً عبر `HandleInertiaRequests.php` بكائن المستخدم الموثوق وشارة رتبته ومصفوفة الصلاحيات المجهزة مسبقاً `auth.user.can` لجميع الأدوار الـ 12 دون تسريب أي بيانات اعتماد حساسة، وتوفير الـ Composable العام `resources/js/Composables/useAuth.js` في Vue 3 لتمكين المكونات وشاشات العرض من فحص الأذونات بسلاسة فائقة.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار المنشأة:**  
  1. [`tests/Feature/Auth/InertiaAuthSharingTest.php`](file:///home/a/Project-test/EntityPostgre/tests/Feature/Auth/InertiaAuthSharingTest.php) (PHP Feature Test).
  2. [`resources/js/__tests__/useAuth.test.js`](file:///home/a/Project-test/EntityPostgre/resources/js/__tests__/useAuth.test.js) (Vitest Frontend Test).
- **الحالات التي تم اختبارها:**
  1. `it_shares_null_user_for_unauthenticated_guests`: التحقق من أن الزائر غير المسجل يحصل على `auth.user = null` دون أي أخطاء.
  2. `it_shares_user_without_sensitive_credentials`: التحقق من حجب الحقول الحساسة (`password`, `remember_token`) وتزويد الواجهة ببيانات الهوية والرتبة والشارة.
  3. `it_shares_exact_permission_matrix_for_each_of_the_twelve_roles`: **فحص دقيق وصارم لمصفوفة الصلاحيات الـ 7 لكل دور من الأدوار الـ 12 فرداً فرداً** عبر DataProvider مخصص:
     - `access_studio`: مقصور على طاقم الاستوديو والمدير العام.
     - `curate_metadata`: مقصور على الفهارس والمحررين ورؤساء التحرير والمدير العام.
     - `publish`: مقصور على رئيس التحرير والمدير العام.
     - `system_commands`: مقصور حصراً على المدير العام.
     - `manage_backups`: مقصور على مشغل النسخ الاحتياطي والمدير العام.
     - `view_audit_logs`: مقصور على مدقق النظام والمدير العام.
     - `view_restricted`: مقصور على الرتب المؤهلة والباحثين الموثقين (`weight >= 25`).
  4. فحص حالات دوال `useAuth` في Vue 3 (`user`, `can`, `hasRole`, `isAtLeast`, `isGuest`, `isSuperAdmin`, `canAccessStudio`).
- **نتيجة التشغيل الأولى (RED):**
  - **PHP:** `Tests: 13 failed, 1 passed (175 assertions)` — فشلت لاختفاء خاصية `auth.user.can.access_studio` وعدم حقن المصفوفة بعد.
  - **Vitest:** `FAIL resources/js/__tests__/useAuth.test.js` — فشل لعدم وجود ملف الـ Composable بعد.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **تحديث التعداد الهرمي للأدوار:** [`app/Enums/UserRole.php`](file:///home/a/Project-test/EntityPostgre/app/Enums/UserRole.php)
     - إضافة توابع الفحص المعمارية الصريحة: `canManageSystem()`, `canManageBackups()`, `canViewAuditLogs()`, `canViewRestricted()`.
  2. **تحديث وسيط Inertia:** [`app/Http/Middleware/HandleInertiaRequests.php`](file:///home/a/Project-test/EntityPostgre/app/Http/Middleware/HandleInertiaRequests.php)
     - تهيئة وتطهير كائن `auth.user` وحقن المصفوفة الكاملة `auth.user.can` لجميع الأدوار الـ 12 بدقة كاملة.
  3. **إنشاء Composable الواجهة:** [`resources/js/Composables/useAuth.js`](file:///home/a/Project-test/EntityPostgre/resources/js/Composables/useAuth.js)
     - برمجة دوال تفاعلية سريعة تعتمد على كاش Inertia Props المجهزة دون أي استعلام شبكة إضافي.
- **نتيجة تشغيل الاختبارين بعد كتابة الكود (GREEN):**
  - **PHP:**
    ```text
    PASS  Tests\Feature\Auth\InertiaAuthSharingTest
    ✓ it shares null user for unauthenticated guests                       1.02s  
    ✓ it shares user without sensitive credentials                         0.09s  
    ✓ it shares exact permission matrix for each of the twelve roles (12 tests) ...
    
    Tests: 14 passed (340 assertions)
    Duration: 2.74s
    ```
  - **Vitest:**
    ```text
    PASS  resources/js/__tests__/useAuth.test.js
    ✓ useAuth Composable (3 tests) 12ms
    
    Tests: 3 passed (3)
    Duration: 1.21s
    ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test` + `npm run test:run`
- **النتيجة الرسمية:**
  - **PHP:** `Tests: 1 incomplete, 361 passed (2363 assertions)` — ارتفاع إجمالي الاختبارات الناجحة من 347 إلى **361 اختباراً** بنسبة نجاح 100%.
  - **JavaScript:** `Tests: 5 passed (5)` في ملفي اختبار بنسبة نجاح 100%.
  *(ثبات تام لجميع مكونات النظام والأرشيف والوسائط دون تسجيل أي انكسار).*

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **التزويد الشامل للمصفوفة السباعية (Universal 12-Role Hydration):** حقن مصفوفة الأذونات الـ 7 لكل دور خادمياً في الـ Root Props، مما يحصن الفرونت إند من ارتكاب أخطاء فحص الحسابات أو استنتاج الصلاحيات محلياً.
2. **تطهير كائن المستخدم (Credential Sanitization):** إعادة تشكيل مصفوفة `auth.user` صراحة لاستبعاد أي حقول أمنية داخلية (`password`, `remember_token`, إلخ) لحماية الأمان الرقمي.
3. **تغليف دوال الصلاحيات داخل Enum (Rich Backed Enum):** ترقية `UserRole` ليصبح المصدر المرجعي الموحد (Single Source of Truth) لحساب الأهلية لكل دور، مما يمنع تكرار الشروط البرمجية في أماكن متفرقة.

---

## 🔹 الدورة 7: التكيّف البصري والملاحة المكانية (Adaptive UI & Spatial Navigation)

- **تاريخ الإنجاز:** 2026-10-05
- **الهدف المعماري:**  
  تفعيل المستوى الثالث من خط الدفاع الأمني (Adaptive UI Rendering) في واجهات ومكونات Vue 3؛ بحيث تتحور القوائم العلوية والجانبية وشاشات العرض تلقائياً بحسب رتبة وصلاحيات المستخدم، مع توفير تجربة تصفح هادئة وخالية من الأخطاء للزوار غير المسجلين وحجب الروابط والأزرار السيادية عمن لا يملك أهليتها.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`resources/js/__tests__/adaptiveUI.test.js`](file:///home/a/Project-test/EntityPostgre/resources/js/__tests__/adaptiveUI.test.js) (Vitest Component Test).
- **الحالات التي تم اختبارها:**
  1. `renders the dynamic Arabic role label instead of hardcoded text for chief editor`: فحص القائمة العلوية لعرض شارة الرتبة العربية الحقيقية للمستخدم (`role_label`) بدلاً من النص الثابت.
  2. `renders guest login and register actions when user is not authenticated`: فحص معالجة حالة الزائر غير المسجل (`guest`) وإظهار زري "تسجيل الدخول" و"إنشاء حساب" دون انهيار المكون.
  3. `shows system commands navigation item only for users with system_commands permission`: فحص القائمة الجانبية لإظهار رابط "أوامر النظام" حصراً للمدير العام.
  4. `hides system commands from regular staff or researchers lacking permission`: التحقق من اختفاء أوامر النظام تماماً عن النساخ والباحثين.
  5. `shows studio editor button for users with studio capabilities`: فحص ظهور زر "محرر المحتوى" في صفحات العرض لطاقم الاستوديو.
  6. `hides studio editor button for researchers or guest users lacking studio permission`: فحص حجب أزرار الاستوديو عن الباحثين والزوار.
- **نتيجة التشغيل الأولى (RED):**
  ```text
  FAIL  resources/js/__tests__/adaptiveUI.test.js
  × renders the dynamic Arabic role label instead of hardcoded text for chief editor (Found "مسؤول النظام")
  × renders guest login and register actions when user is not authenticated (Cannot read properties of null)
  × shows system commands navigation item only for users with system_commands permission (Expected "أوامر النظام")
  
  Tests: 3 failed, 1 passed (4)
  Duration: 1.86s
  ```

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. **تحديث القائمة العلوية:** [`resources/js/Layouts/Partials/Navbar.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Layouts/Partials/Navbar.vue)
     - استدعاء `useAuth()` وعرض اسم المستخدم وشارة رتبته الملونة (`user.role_label`, `user.badge_color`).
     - إظهار زري "تسجيل الدخول" و"إنشاء حساب" عند غياب الجلسة (`isGuest`).
  2. **تحديث القائمة الجانبية:** [`resources/js/Layouts/Partials/Sidebar.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Layouts/Partials/Sidebar.vue)
     - إضافة مسار "أوامر النظام" (`system.commands`) في قسم "النظام" محكوماً بالصلاحية `system_commands`.
     - تطبيق فلترة القائمة عبر `v-if="!item.permission || can(item.permission)"`.
  3. **تحديث صفحات العرض الأربعة (Adaptive Action Buttons):**
     - [`resources/js/Pages/Books/Show.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Pages/Books/Show.vue): حماية أزرار الاستوديو والتعديل بـ `can('access_studio')` و `can('curate_metadata')`.
     - [`resources/js/Pages/Manuscripts/Show.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Pages/Manuscripts/Show.vue): حماية أزرار الاستوديو وتعديل المخطوط بـ `can('access_studio')` و `can('curate_metadata')`.
     - [`resources/js/Pages/Audios/Show.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Pages/Audios/Show.vue): حماية أزرار محرر الاستوديو والتعديل الصوتي.
     - [`resources/js/Pages/Videos/Show.vue`](file:///home/a/Project-test/EntityPostgre/resources/js/Pages/Videos/Show.vue): حماية أزرار محرر الاستوديو وتعديل المرئية.
- **نتيجة تشغيل الاختبار بعد كتابة الكود (GREEN):**
  ```text
  PASS  resources/js/__tests__/adaptiveUI.test.js
  ✓ renders the dynamic Arabic role label instead of hardcoded text for chief editor    57ms
  ✓ renders guest login and register actions when user is not authenticated              8ms
  ✓ shows system commands navigation item only for users with system_commands permission 33ms
  ✓ hides system commands from regular staff or researchers lacking permission          21ms
  ✓ shows studio editor button for users with studio capabilities                       19ms
  ✓ hides studio editor button for researchers or guest users lacking studio permission 10ms

  Tests: 6 passed (6)
  Duration: 2.09s
  ```

---

### 3. تطبيق فحص عدم الانكسار 🛡️ (Zero Regression Immunity - القاعدة 3):
- **الأمر المنفذ:** `php artisan test` + `npm run test:run`
- **النتيجة الرسمية:**
  - **PHP:** `Tests: 1 incomplete, 361 passed (2342 assertions)` (نجاح 100% لكامل المنظومة).
  - **JavaScript:** `Tests: 11 passed (11)` عبر 3 ملفات اختبار كاملة (نجاح 100%).

---

### 4. القرارات المعمارية الموثقة في الدورة:
1. **التحوّر البصري التلقائي (Proactive Adaptive UI):** إخفاء الأدوات والأزرار غير المأذونة استباقياً من الواجهة، لمنع تجربة الاستخدام المحبطة عند الضغط على زر ثم تلقي ردع 403.
2. **الهبوط الآمن لحالة الزوار (Graceful Degradation):** معالجة غياب الجلسة برقي في المكونات المشتركة، مع استبدال أدوات العمل بأبواب الدخول والاشتراك.






