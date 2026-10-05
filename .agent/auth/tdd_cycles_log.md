# 📋 سجل ومسار دورات التطوير الموجه بالاختبارات (TDD Cycles Execution Log)
## منظومة الهوية والصلاحيات — Entity Digital Library

---

## 📊 لوحة المؤشرات الإجمالية (Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور | ملفات الاختبار المنشأة | نتيجة الـ RED 🔴 | نتيجة الـ GREEN 🟢 | فحص عدم الانكسار 🛡️ | الحالة |
|:---:|---|---|:---:|:---:|:---:|:---:|
| **1** | **طبقة البيانات والموديلات (Data & Models)** | `tests/Unit/Auth/UserRoleAndModelTest.php` | 4 Failed, 1 Passed | 5 Passed (70 Assertions) | **328 Passed** (100% نجاح) | ✅ مكتملة وموثقة |

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
