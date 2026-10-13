# 📋 سجل ومسار دورات التنظيف وإعادة الهيكلة المعمارية (Refactor Cycles Log)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library
**الفرع المخصص:** `EntityRefactor` | **المرجع الدستوري:** [`.agent/refactor/refactor_rules.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/refactor/refactor_rules.md)

---

## 📊 لوحة المؤشرات الإجمالية لدورات التنظيف (Refactor Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور المعماري | الملفات المستهدفة (حذف / تعديل) | أمر الفحص المنفذ بواسطة المستخدم | فحص درع المناعة 🛡️ | معرف الكوميت | الحالة |
|:---:|---|---|---|:---:|:---:|:---:|
| **1** | **إنقاذ دوال العلاقات وتطهير خدمة الكود الميت (`EntityRelationService`)** | `app/Services/EntityRelationService.php` (حذف)<br>`app/Traits/HasPolymorphicRelations.php` (إضافة)<br>`tests/Unit/Services/EntityRelationServiceTest.php` (حذف)<br>`tests/Unit/Traits/HasPolymorphicRelationsTest.php` (تحديث) | `php artisan test tests/Unit/Traits/HasPolymorphicRelationsTest.php` | **7 Passed (17 Assertions)**<br>100% نجاح | `79f87bd` | ✅ مكتملة وموثقة |

---

## 🔹 الدورة 1: إنقاذ دوال العلاقات وتطهير خدمة الكود الميت (`EntityRelationService`)

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الأول (الكود الميت والطبقات المهجورة)
- **الهدف المعماري:**  
  فحص خدمة العلاقات المهجورة [`app/Services/EntityRelationService.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Services/EntityRelationService.php) والتنقيب بداخلها عن أي قيمة برمجية قبل حذفها. تم إنقاذ دوال إدارة الوسوم والتصنيفات الذكية ونقلها كطرق أصيلة في سمة العلاقات العامة [`HasPolymorphicRelations`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasPolymorphicRelations.php)، ثم حذف الخدمة الميتة بالكامل وتغطية الطرق المنقولة باختبارات وحدة موثوقة.

---

### 1. الكود المستخرج والمنقول إلى [`app/Traits/HasPolymorphicRelations.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasPolymorphicRelations.php):
* **`attachTagsByName(array $names): array`**: البحث عن الوسوم بالاسم وإنشاؤها تلقائياً (`firstOrCreate`) وتوليد slugs لها ثم ربطها بالكيان الحالي مع منع التكرار.
* **`attachCategoriesByName(array $names): array`**: البحث عن التصنيفات بالاسم وإنشاؤها تلقائياً مع توليد slugs وربطها بالكيان.
* **`copyTagsFrom($source, bool $replace = false): void`**: نسخ كامل وسوم كيان مصدر إلى الكيان الحالي (مع خيار الاستبدال أو الإلحاق دون حذف).
* **`getCommonTagsWith($other): EloquentCollection`**: استخراج مجموعة الوسوم المشتركة بين كيانين متطابقين أو مختلفين.

---

### 2. الملفات المحذوفة والمعدلة:
1. **محذوف 🗑️:** [`app/Services/EntityRelationService.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Services/EntityRelationService.php) (285 سطراً من الكود الميت غير المستخدم في أي Controller أو Service).
2. **محذوف 🗑️:** [`tests/Unit/Services/EntityRelationServiceTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Services/EntityRelationServiceTest.php) (اختبار وحدة كان يعزل الخدمة الميتة).
3. **معدل ✏️:** [`app/Traits/HasPolymorphicRelations.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasPolymorphicRelations.php) (إضافة الدوال الأربع أعلاه).
4. **معدل ✏️:** [`tests/Unit/Traits/HasPolymorphicRelationsTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Traits/HasPolymorphicRelationsTest.php) (إضافة 4 اختبارات جديدة تغطي السلوك المنقول بالكامل).

---

### 3. نتائج فحص الحماية وعدم الانكسار 🛡️ (Verification by User):
* **الأمر المنفذ:**
  ```bash
  php artisan test tests/Unit/Traits/HasPolymorphicRelationsTest.php
  ```
* **النتيجة المسجلة:**
  ```text
  PASS  Tests\Unit\Traits\HasPolymorphicRelationsTest
  ✓ trait adds polymorphic methods
  ✓ tags relationship works
  ✓ morph map works for tags
  ✓ it attaches tags by name and creates missing ones
  ✓ it attaches categories by name and creates missing ones
  ✓ it copies tags from another entity
  ✓ it finds common tags with another entity

  Tests:    7 passed (17 assertions)
  Duration: 0.89s
  ```

---

### 4. الأثر المعماري:
* التخلص من طبقة وسيطة ميتة كاملة في مجلد `app/Services`.
* ترقية قدرات نماذج الكيانات (`Book`, `Audio`, `Video`, `Manuscript`, `Author`, إلخ) عبر إتاحة معالجة الوسوم بالاسم أو بالنسخ مباشرة من الـ Model دون الحاجة لحقن خدمات خارجية.

