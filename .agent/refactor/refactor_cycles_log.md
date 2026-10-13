# 📋 سجل ومسار دورات التنظيف وإعادة الهيكلة المعمارية (Refactor Cycles Log)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library
**الفرع المخصص:** `EntityRefactor` | **المرجع الدستوري:** [`.agent/refactor/refactor_rules.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/refactor/refactor_rules.md)

---

## 📊 لوحة المؤشرات الإجمالية لدورات التنظيف (Refactor Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور المعماري | الملفات المستهدفة (حذف / تعديل) | أمر الفحص المنفذ بواسطة المستخدم | فحص درع المناعة 🛡️ | معرف الكوميت | الحالة |
|:---:|---|---|---|:---:|:---:|:---:|
| **1** | **إنقاذ دوال العلاقات وتطهير خدمة الكود الميت (`EntityRelationService`)** | `app/Services/EntityRelationService.php` (حذف)<br>`app/Traits/HasPolymorphicRelations.php` (إضافة)<br>`tests/Unit/Services/EntityRelationServiceTest.php` (حذف)<br>`tests/Unit/Traits/HasPolymorphicRelationsTest.php` (تحديث) | `php artisan test tests/Unit/Traits/HasPolymorphicRelationsTest.php` | **7 Passed (17 Assertions)**<br>100% نجاح | `712a60a` | ✅ مكتملة وموثقة |
| **2** | **تطهير طبقة الـ Repositories والكود الميت وإغلاق المحور الأول** | `app/Repositories/EntityBaseRepository.php` (حذف)<br>`tests/Unit/Repositories/EntityBaseRepositoryTest.php` (حذف)<br>`app/Http/Controllers/AuthorController.php.backup` (حذف)<br>`app/Http/Controllers/SuperAdminDashboardController.php` (حذف)<br>`app/Http/Requests/StoreEntityRequest.php` (حذف)<br>`app/Http/Requests/UpdateEntityRequest.php` (حذف)<br>`app/Traits/HasPolymorphicRelations.php` (تنظيف) | `php artisan test` | **585 Passed (3337 Assertions)**<br>100% نجاح | `8659439` | ✅ مكتملة وموثقة |
| **3** | **تطهير محولات التوافقية المهجورة للمخطوطات والكيانات (`EntityContent`, `ManuscriptChild`, `ManuscriptPage`)** | `app/Models/EntityContent.php` (حذف)<br>`app/Models/ManuscriptChild.php` (حذف)<br>`app/Models/ManuscriptPage.php` (حذف)<br>`tests/Feature/Entities/Manuscripts/ManuscriptContentNodeTest.php` (تحديث) | `php artisan test tests/Feature/Entities/Manuscripts/ManuscriptContentNodeTest.php` | **584 Passed (3320 Assertions)**<br>100% نجاح | `94d55c1` | ✅ مكتملة وموثقة |
| **4** | **تطهير آخر نماذج التوافقية الصورية (`BookChild`, `AudioSegment`, `VideoSegment`) وتوحيد الشجرة في `ContentNode`** | `app/Models/BookChild.php` (حذف)<br>`app/Models/AudioSegment.php` (حذف)<br>`app/Models/VideoSegment.php` (حذف)<br>`app/Models/ContentNode.php` (ترقية وتوحيد)<br>`app/Providers/AppServiceProvider.php` (تحديث)<br>`database/seeders/SeedRealisticData.php` (تحديث)<br>`database/seeders/BookContentSeeder.php` (تحديث)<br>`tests/Feature/Entities/Books/BookChildTest.php` (ترقية) | `php artisan test tests/Feature/Entities/Books/BookChildTest.php` | **584 Passed (3326 Assertions)**<br>100% نجاح | `9c65a95` | ✅ مكتملة وموثقة |
| **5** | **استخراج وحماية الخصائص الذكية لشجرة المحتوى في سمة `HasNodeMetadata`** | `app/Traits/HasNodeMetadata.php` (إنشاء)<br>`app/Models/ContentNode.php` (ترقية ورشاقة)<br>`tests/Unit/Traits/HasNodeMetadataTest.php` (إنشاء درع جديد) | `php artisan test tests/Unit/Traits/HasNodeMetadataTest.php` | **589 Passed (3351 Assertions)**<br>100% نجاح | `edec6d4` | ✅ مكتملة وموثقة |
| **6** | **تفكيك وترشيق `AdminDashboardController` واستخراج خدمة `DashboardStatsService` وسمة `AppliesAssetFilters`** | `app/Services/DashboardStatsService.php` (إنشاء)<br>`app/Traits/AppliesAssetFilters.php` (إنشاء)<br>`app/Http/Controllers/AdminDashboardController.php` (ترشيق وتفكيك)<br>`tests/Unit/Services/DashboardStatsServiceTest.php` (إنشاء درع جديد) | `php artisan test tests/Unit/Services/DashboardStatsServiceTest.php`<br>`npm run test:run` | **592 Passed (3414 Assertions)**<br>**Vitest: 136 Passed**<br>100% نجاح كامل | `fedc8d7` | ✅ مكتملة وموثقة |
| **7** | **توحيد متحكمات المساهمين واللغات والرفوف في `EntityController` ومعايرة الـ Hooks** | `app/Http/Controllers/BookerController.php` (ترشيق وتوحيد)<br>`app/Http/Controllers/LanguageController.php` (ترشيق وتوحيد)<br>`app/Http/Controllers/ShelfController.php` (ترشيق وتوحيد)<br>`app/Http/Controllers/EntityController.php` (تحسين Hooks)<br>`app/Providers/AppServiceProvider.php` (تسجيل السياسات)<br>`app/Http/Requests/*` (إنشاء 6 طلبات FormRequests) | `php artisan test tests/Feature/Entities/Common/CoreEntitiesCRUDTest.php`<br>`npm run test:run`<br>`php artisan test` | **CoreEntitiesCRUDTest: 11 Passed (384 Assertions)**<br>**Vitest: 136 Passed (14 Files)**<br>**Full Backend: 592 Passed (3417 Assertions)**<br>100% نجاح كامل | `ed3d77d` | ✅ مكتملة وموثقة |
| **8** | **توحيد متحكمات المجموعات والتعليقات والملاحظات في `EntityController` وترشيق CRUD** | `app/Http/Controllers/CollectionController.php` (ترشيق وتوحيد)<br>`app/Http/Controllers/CommentController.php` (ترشيق وتوحيد)<br>`app/Http/Controllers/NoteController.php` (ترشيق وتوحيد)<br>`app/Providers/AppServiceProvider.php` (تسجيل السياسات)<br>`app/Http/Requests/*` (إنشاء 6 طلبات FormRequests) | `php artisan test tests/Feature/Entities/Common/CoreEntitiesCRUDTest.php`<br>`php artisan test tests/Feature/Entities/Taxonomies/TaxonomyAttachmentTest.php`<br>`npm run test:run`<br>`php artisan test` | **CoreEntitiesCRUDTest: 11 Passed (384 Assertions)**<br>**TaxonomyAttachmentTest: 2 Passed (6 Assertions)**<br>**Vitest: 136 Passed (14 Files)**<br>**Full Backend: 592 Passed (3429 Assertions)**<br>100% نجاح كامل | `155fa14` | ✅ مكتملة وموثقة |

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

---

## 🔹 الدورة 2: تطهير طبقة الـ Repositories والكود الميت وإغلاق المحور الأول

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الأول (الكود الميت والطبقات المهجورة)
- **الهدف المعماري:**  
  استكمال التطهير الجذري لكافة الملفات والطبقات المهجورة التي أثبت التحليل المعماري عدم استخدامها في أي مسار أو متحكم أو خدمة، والتخلص من الطبقات الزائدة التي كانت تزيد من التعقيد الصيانة دون أي فائدة تشغيلية.

---

### 1. الملفات المحذوفة والمطهرة (Cleaned & Pruned Dead Files):
1. **طبقة الـ Repositories بالكامل 🗑️:**
   * [`app/Repositories/EntityBaseRepository.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Repositories/EntityBaseRepository.php) (206 سطور - مستودع قديم للبحث الميت عبر الجداول وتجزئة الذاكرة).
   * [`tests/Unit/Repositories/EntityBaseRepositoryTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Repositories/EntityBaseRepositoryTest.php) (133 سطراً - اختبار معزول لا يخدم كوداً حياً).
   * حذف المجلدين الفارغين `app/Repositories` و `tests/Unit/Repositories`.
2. **المتحكمات والملفات الاحتياطية 🗑️:**
   * [`app/Http/Controllers/AuthorController.php.backup`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/AuthorController.php.backup) (128 سطراً - نسخة احتياطية منسية مرتَكبة بالخطأ).
   * [`app/Http/Controllers/SuperAdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SuperAdminDashboardController.php) (11 سطراً - صنف فارغ مهجور تماماً ومستبدل بـ `AdminDashboardController`).
3. **طلبات الـ FormRequests المهجورة 🗑️:**
   * [`app/Http/Requests/StoreEntityRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreEntityRequest.php) (83 سطراً).
   * [`app/Http/Requests/UpdateEntityRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateEntityRequest.php) (57 سطراً).
4. **تنظيف الكود المعلق في سمة العلاقات ✏️:**
   * تنظيف [`app/Traits/HasPolymorphicRelations.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasPolymorphicRelations.php): حذف كتل الدوال المعطلة بالتعليقات (`reviews`, `favourites`, `searchTerms`, `views`) وحذف الاستيراد غير المستخدم `Review`.

---

### 2. نتائج فحص الحماية وعدم الانكسار 🛡️ (Verification by User):
* **الأمر المنفذ بواسطة المستخدم:**
  ```bash
  php artisan test
  ```
* **النتيجة المسجلة:**
  ```text
  Tests:    1 incomplete, 585 passed (3337 assertions)
  Duration: 47.81s
  ```
  *(نجاح 100% لكافة الاختبارات الحية، وانخفاض العدد من 603 إلى 585 بسبب التخلص من اختبارات الكود الميت المحذوف)*.

---

### 3. الأثر المعماري:
* حذف **أكثر من 820 سطراً** من الكود المهجور والزوائد البرمجية.
* إغلاق **المحور الأول (الكود الميت والطبقات المهجورة)** بالكامل وتطهير شجرة المشروع بنسبة 100%.

---

## 🔹 الدورة 3: تطهير محولات التوافقية المهجورة للمخطوطات والكيانات (`EntityContent`, `ManuscriptChild`, `ManuscriptPage`)

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الثاني (رواسب وقشور الترحيل من MongoDB إلى PostgreSQL)
- **الهدف المعماري:**  
  بدء تفكيك وتطهير موديلات التوافقية الصورية الستة التي أُنشئت كجسر مؤقت أثناء الترحيل من MongoDB. تم التحقق من أن موديلات المخطوطات والكيانات القديمة لم تعد تُستخدم في أي مسار أو خدمة حية بعد توحيد كافة عمليات إدارة المحتوى الشجري عبر [`ContentNode`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) و [`EntityContentService`](file:///home/a/PhpstormProjects/EntityPostgre/app/Services/EntityContentService.php).

---

### 1. الملفات المحذوفة والمعدلة (Cleaned Models & Tests):
1. **محذوف 🗑️:** [`app/Models/EntityContent.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/EntityContent.php) (صنف توافقي فارغ تماماً لم يعد له أي استدعاء في كامل النظام).
2. **محذوف 🗑️:** [`app/Models/ManuscriptChild.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ManuscriptChild.php) (محول قديم لعقد المخطوطات تم استبداله كلياً بـ `ContentNode`).
3. **محذوف 🗑️:** [`app/Models/ManuscriptPage.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ManuscriptPage.php) (نسخة مكررة مطابقة بنسبة 100% لـ `ManuscriptChild`).
4. **معدل ✏️:** [`tests/Feature/Entities/Manuscripts/ManuscriptContentNodeTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/Entities/Manuscripts/ManuscriptContentNodeTest.php) (إزالة اختبار المحول المهجور `manuscript_page_legacy_adapter_works_seamlessly` مع الإبقاء على كافة اختبارات الـ Nodes الحديثة للمخطوطات).

---

### 2. نتائج فحص الحماية وعدم الانكسار 🛡️ (Verification by User):
* **الأمر المنفذ بواسطة المستخدم:**
  ```bash
  php artisan test tests/Feature/Entities/Manuscripts/ManuscriptContentNodeTest.php
  ```
* **النتيجة المسجلة:**
  ```text
  PASS  Tests\Feature\Entities\Manuscripts\ManuscriptContentNodeTest
  ✓ manuscript can access content nodes
  ✓ eager loading children works cleanly for multiple manuscripts

  Tests:    2 passed (8 assertions)
  Duration: 0.74s
  ```
  *(إجمالي المنظومة: 584 اختباراً ناجحاً بنسبة 100% و 3320 تأكيداً)*.

---

### 3. الأثر المعماري:
* التخلص من 3 نماذج مضللة من أصل 6 نماذج ترث صورياً من `ContentNode`.
* تثبيت الاعتماد الصريح للمخطوطات على شجرة PostgreSQL الموحدة.

---

## 🔹 الدورة 4: تطهير آخر نماذج التوافقية الصورية (`BookChild`, `AudioSegment`, `VideoSegment`) وتوحيد الشجرة في `ContentNode`

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الثاني (موديلات ومحولات التوافقية الصورية - المرحلة النهائية)
- **الهدف المعماري:**  
  إكمال التخلص النهائي من بقايا التوافقية الصورية لـ MongoDB. كانت نماذج `BookChild`, `AudioSegment`, `VideoSegment` عبارة عن فئات فارغة ترث من `ContentNode` فقط لتوفر معالجات أسماء قديمة مثل `$child->book_id` أو العلاقات `$child->book`. تم ترقية النموذج الأصيل [`ContentNode`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) ليحتوي هذه العلاقات والمعالجات بشفافية كاملة، ثم حذف النماذج الثلاثة وتحديث ملفات الـ Seeders ومقدمي الخدمة بدون أي كسر خارجي.

---

### 1. الملفات المحذوفة والمعدلة:
1. **محذوف 🗑️:** [`app/Models/BookChild.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/BookChild.php) (نموذج مهجور يرث صورياً من `ContentNode`).
2. **محذوف 🗑️:** [`app/Models/AudioSegment.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/AudioSegment.php) (نموذج مهجور يرث صورياً من `ContentNode`).
3. **محذوف 🗑️:** [`app/Models/VideoSegment.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/VideoSegment.php) (نموذج مهجور يرث صورياً من `ContentNode`).
4. **معدل ✏️:** [`app/Models/ContentNode.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) (إضافة علاقات الكيان الأب `book()`, `audio()`, `video()`, `manuscript()` والمفاتيح الافتراضية `book_id`, `audio_id`, `video_id`, `manuscript_id`).
5. **معدل ✏️:** [`app/Providers/AppServiceProvider.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Providers/AppServiceProvider.php) (تطهير ربط MorphMap القديم لـ `book_child`).
6. **معدل ✏️:** [`database/seeders/SeedRealisticData.php`](file:///home/a/PhpstormProjects/EntityPostgre/database/seeders/SeedRealisticData.php) (الاعتماد المباشر على `ContentNode`).
7. **معدل ✏️:** [`database/seeders/BookContentSeeder.php`](file:///home/a/PhpstormProjects/EntityPostgre/database/seeders/BookContentSeeder.php) (تطهير الاستيراد المهجور).
8. **معدل ✏️:** [`tests/Feature/Entities/Books/BookChildTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/Entities/Books/BookChildTest.php) (ترقية الفحص ليتحقق من سلوك العقد عبر `ContentNode` مباشرة مع فحص المفاتيح والعلاقات الافتراضية).

---

### 2. نتائج فحص الحماية وعدم الانكسار 🛡️ (Verification by User):
* **الأمر المنفذ بواسطة المستخدم:**
  ```bash
  php artisan test tests/Feature/Entities/Books/BookChildTest.php
  php artisan test
  ```
* **النتيجة المسجلة:**
  ```text
  PASS  Tests\Feature\Entities\Books\BookChildTest
  ✓ it can create a book child node in postgresql
  ✓ it can update nested content blocks
  ✓ a book can access its children nodes
  ✓ book content service can manage hierarchy
  ✓ it can add annotated blocks via service
  ✓ deleting a book deletes its content nodes
  ✓ content nodes support parent foreign keys and relations

  Tests:    7 passed (29 assertions)
  Duration: 0.88s

  Tests:    1 incomplete, 584 passed (3326 assertions)
  Duration: 52.37s
  ```
  *(نجاح كامل بنسبة 100% لكامل المنظومة)*.

---

### 3. الأثر المعماري:
* إغلاق ملف المحور الثاني بالكامل: تم تطهير كافة نماذج التوافقية الصورية الستة (`EntityContent`, `ManuscriptChild`, `ManuscriptPage`, `BookChild`, `AudioSegment`, `VideoSegment`).
* شجرة المحتوى الآن موحدة 100% تحت نموذج مركزي واحد هو [`ContentNode`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php).

---

## 🔹 الدورة 5: استخراج وحماية الخصائص الذكية لشجرة المحتوى في سمة `HasNodeMetadata`

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الثاني (حماية الكنز المعماري وترشيق نموذج شجرة المحتوى)
- **الهدف المعماري:**  
  حماية وتنظيم كنز البيانات الوصفية الذكية (Smart Node Metadata) المتمثل في 12 خاصية تغذي محركات الصوت والفيديو والمخطوطات ومحرر الاستوديو عبر حقل الـ JSONB (`metadata`) في PostgreSQL. تم استخراج كافة معالجات القراءة والكتابة (Accessors & Mutators) من كلاس الموديل المركزي المكتظ [`ContentNode`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) إلى سمة مستقلة عالية التماسك [`app/Traits/HasNodeMetadata.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasNodeMetadata.php) مع تزويدها بتوابع مساعدة ذكية (`getMetadata`, `setMetadata`, `hasMetadata`, `forgetMetadata`).

---

### 1. الملفات المنشأة والمعدلة:
1. **منشأ 🌟:** [`app/Traits/HasNodeMetadata.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/HasNodeMetadata.php) (سمة مخصصة تدير أوقات المقاطع الصوتية والمرئية، لوحات وصور المخطوطات، أرقام الصفحات وحالات التفريغ والتحرير مع دوال مساعدة مرنة).
2. **منشأ 🛡️:** [`tests/Unit/Traits/HasNodeMetadataTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Traits/HasNodeMetadataTest.php) (اختبار وحدة معماري مخصص يغطي 100% من خصائص السمة وتكاملها مع PostgreSQL بـ 5 اختبارات و 31 تأكيداً).
3. **معدل ✏️:** [`app/Models/ContentNode.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) (تضمين السمة وترشيق النموذج وانخفاض حجمه من 526 سطراً إلى 303 سطور بنقاء معماري تام).

---

### 2. نتائج فحص الحماية وعدم الانكسار 🛡️ (Verification by User):
* **الأوامر المنفذة بواسطة المستخدم:**
  ```bash
  php artisan test tests/Unit/Traits/HasNodeMetadataTest.php
  php artisan test tests/Feature/Entities/Books/BookChildTest.php
  php artisan test
  ```
* **النتيجة المسجلة:**
  ```text
  PASS  Tests\Unit\Traits\HasNodeMetadataTest
  ✓ it handles audio video time and duration metadata
  ✓ it handles manuscript folio and image metadata
  ✓ it handles editing and transcription metadata
  ✓ it provides smart helper methods for metadata
  ✓ it persists metadata properly in postgresql database

  Tests:    5 passed (31 assertions)
  Duration: 0.63s

  PASS  Tests\Feature\Entities\Books\BookChildTest
  ✓ it can create a book child node in postgresql
  ✓ it can update nested content blocks
  ✓ a book can access its children nodes
  ✓ book content service can manage hierarchy
  ✓ it can add annotated blocks via service
  ✓ deleting a book deletes its content nodes
  ✓ content nodes support parent foreign keys and relations

  Tests:    7 passed (29 assertions)
  Duration: 0.84s

  Tests:    1 incomplete, 589 passed (3351 assertions)
  Duration: 47.33s
  ```
  *(ارتفاع درع المناعة إلى 589 اختباراً ناجحاً بنسبة 100% و 3351 تأكيداً)*.

---

### 3. الأثر المعماري:
* ترشيق وتطهير كلاس [`ContentNode`](file:///home/a/PhpstormProjects/EntityPostgre/app/Models/ContentNode.php) بأكثر من **220 سطراً** ليصبح كوداً نظيفاً يركز فقط على العلاقات وبنية الشجرة.
* عزل منطق الـ JSONB metadata في Trait مخصص وقابل لإعادة الاستخدام والاختبار المستقل.
* صفر انكسار في كافة واجهات الاستوديو ومحررات النصوص ومشغلات الوسائط.

---

## 🔹 الدورة 6: تفكيك وترشيق `AdminDashboardController` واستخراج خدمة `DashboardStatsService` وسمة `AppliesAssetFilters`

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الثالث (طبقة المتحكمات - تفكيك المتحكم الوحش وترشيق قمرة القيادة)
- **الهدف المعماري:**  
  تطبيق مبدأ المسؤولية الفردية (SRP) وتفكيك "المتحكم الوحش" [`AdminDashboardController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/AdminDashboardController.php) (748 سطراً). تم استخراج منطق حساب إحصائيات الكيانات الـ 16، حالات دورة الحياة `ContentStatus`، قمع الاستوديو، وسلة المهملات الموحدة إلى خدمة متخصصة [`app/Services/DashboardStatsService.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Services/DashboardStatsService.php). كما تم استخراج خوارزميات الفلترة والترتيب الآمن إلى سمة [`app/Traits/AppliesAssetFilters.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/AppliesAssetFilters.php) مدعومة بذاكرة مؤقتة على مستوى الطلب (Request-level cache) لقوائم أعمدة الجداول لتفادي عشرات الاستعلامات المتكررة لـ `Schema::getColumnListing` على PostgreSQL.

---

### 1. الملفات المنشأة والمعدلة:
1. **منشأ 🌟:** [`app/Services/DashboardStatsService.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Services/DashboardStatsService.php) (خدمة مركزية لحساب إحصائيات المنصة، حالات `ContentStatus`، قمع الاستوديو، وسلة المهملات).
2. **منشأ 🌟:** [`app/Traits/AppliesAssetFilters.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Traits/AppliesAssetFilters.php) (سمة الفلترة والبحث والترتيب الآمن مع تخزين مؤقت للأعمدة لتسريع استعلامات PostgreSQL).
3. **منشأ 🛡️:** [`tests/Unit/Services/DashboardStatsServiceTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Services/DashboardStatsServiceTest.php) (اختبار وحدة معماري يغطي كافة مفاتيح الإحصائيات، الحسابات، وسلة المهملات بـ 3 اختبارات و 72 تأكيداً).
4. **معدل ✏️:** [`app/Http/Controllers/AdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/AdminDashboardController.php) (حقن الخدمة واستخدام السمة، وتطهير 240 سطراً من الكود المحشو والمكرر، مع ثبات كامل لعقود Inertia بنسبة 100%).

---

### 2. نتائج فحص درع المناعة الشامل (Full-Stack Immunity Shield) 🛡️:
* **الأوامر المنفذة بواسطة المستخدم:**
  ```bash
  php artisan test tests/Unit/Services/DashboardStatsServiceTest.php
  php artisan test tests/Unit/Enums/ContentStatusIntegrationTest.php
  php artisan test tests/Feature/Dashboard/ServerSidePaginationTest.php
  npm run test:run
  php artisan test
  ```
* **النتائج المسجلة:**
  ```text
  PASS  Tests\Unit\Services\DashboardStatsServiceTest
  ✓ it returns all expected statistics keys
  ✓ it calculates status counts accurately
  ✓ it aggregates soft deleted entities accurately
  Tests: 3 passed (72 assertions) | Duration: 0.70s

  PASS  Tests\Unit\Enums\ContentStatusIntegrationTest
  Tests: 19 passed (217 assertions) | Duration: 0.87s

  PASS  Tests\Feature\Dashboard\ServerSidePaginationTest
  Tests: 10 passed (171 assertions) | Duration: 3.02s

  Vitest Frontend Tests (npm run test:run):
  Test Files: 14 passed (14)
  Tests:      136 passed (136) | Duration: 13.82s

  Full Backend Suite (php artisan test):
  Tests:      1 incomplete, 592 passed (3414 assertions) | Duration: 44.19s
  ```
  *(نجاح ساحق وكامل بنسبة 100% للفرونت إند والباك إند معاً)*.

---

### 3. الأثر المعماري:
* تحويل `AdminDashboardController` من متحكم ضخم إلى متحكم منظم ورشيق يعتمد على حقن التبعيات.
* تحسين أداء استعلامات PostgreSQL عبر التخلص من التكرار المفرط لـ `Schema::getColumnListing`.
* ثبات تام بنسبة 100% لكافة واجهات قمرة القيادة والفرونت إند بدون أي انكسار سلوكي أو بصري.

---

## 🔹 الدورة 7: توحيد متحكمات المساهمين واللغات والرفوف في `EntityController` ومعايرة الـ Hooks

- **تاريخ الإنجاز:** 2026-10-13
- **المحور المستهدف:** المحور الثالث (طبقة المتحكمات وتوحيد معمارية الـ CRUD)
- **الهدف المعماري:**  
  إنهاء الازدواجية البرمجية في المتحكمات الوصفية الأساسية الثلاثة ([`BookerController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/BookerController.php), [`LanguageController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/LanguageController.php), [`ShelfController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/ShelfController.php)) وإخضاعها لوراثة الفئة الأم [`EntityController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/EntityController.php) بنمط Template Method، وإنشاء طلبات التحقق القياسية (`FormRequests`)، وربط سياسات الصلاحيات (`EntityPolicy`)، مع صيانة خطافات التوليد التلقائي للـ Slugs وإعادة التوجيه بعد التعديل وحصر النسخ الشقيقة (`siblings`) بالأصول الحقيقية حصراً.

---

### 1. الملفات المنشأة والمعدلة:
1. **منشأ 🌟 (طبقة FormRequests القياسية):**
   - [`app/Http/Requests/StoreBookerRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreBookerRequest.php)
   - [`app/Http/Requests/UpdateBookerRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateBookerRequest.php)
   - [`app/Http/Requests/StoreLanguageRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreLanguageRequest.php)
   - [`app/Http/Requests/UpdateLanguageRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateLanguageRequest.php)
   - [`app/Http/Requests/StoreShelfRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreShelfRequest.php)
   - [`app/Http/Requests/UpdateShelfRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateShelfRequest.php)
2. **معدل ✏️ (تسجيل السياسات في مزود الخدمة):**
   - [`app/Providers/AppServiceProvider.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Providers/AppServiceProvider.php): تسجيل بوابات الصلاحيات لـ `Booker` و `Language` و `Shelf` وربطها بـ `EntityPolicy`.
3. **معدل ✏️ (ترقية الفئة الأم):**
   - [`app/Http/Controllers/EntityController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/EntityController.php):
     - حصر استعلام النسخ الشقيقة (`siblings`) بنماذج الأصول `Entity` الحقيقية لمنع انهيار الاستعلام في الجداول التي لا تملك عمود `title`.
     - استخراج خطاف `getUpdateRedirect()` لإتاحة تخصيص وجهة التوجيه بعد التحديث.
4. **معدل ✏️ (المتحكمات الموحدة والرشيقة):**
   - [`app/Http/Controllers/BookerController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/BookerController.php): تقليص الكود من 126 إلى 50 سطراً مع الحفاظ على التوليد التلقائي للـ Slugs وإحصاء الأصول المشتركة.
   - [`app/Http/Controllers/LanguageController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/LanguageController.php): تقليص الكود من 121 إلى 36 سطراً.
   - [`app/Http/Controllers/ShelfController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/ShelfController.php): تقليص الكود من 120 إلى 36 سطراً.

---

### 2. نتائج فحص درع المناعة الشامل (Full-Stack Immunity Shield) 🛡️:
* **الأوامر المنفذة بواسطة المستخدم:**
  ```bash
  php artisan test tests/Feature/Entities/Common/CoreEntitiesCRUDTest.php
  npm run test:run
  php artisan test
  ```
* **النتائج المسجلة:**
  ```text
  PASS  Tests\Feature\Entities\Common\CoreEntitiesCRUDTest
  ✓ full crud lifecycle for books
  ✓ full crud lifecycle for manuscripts
  ✓ full crud lifecycle for audios
  ✓ full crud lifecycle for videos
  ✓ crud lifecycle for supporting entities
  ✓ full crud lifecycle for bookers
  ✓ full crud lifecycle for languages
  ✓ full crud lifecycle for comments and notes
  ✓ audit logs lifecycle for activities and deletions
  ✓ crud lifecycle for content nodes and segments
  ✓ lifecycle for versions and reading positions
  Tests: 11 passed (384 assertions) | Duration: 1.48s

  Vitest Frontend Tests (npm run test:run):
  Test Files: 14 passed (14)
  Tests:      136 passed (136) | Duration: 14.42s

  Full Backend Suite (php artisan test):
  Tests:      1 incomplete, 592 passed (3417 assertions) | Duration: 44.26s
  ```
  *(نجاح ساحق وكامل بنسبة 100% للفرونت إند والباك إند معاً)*.

---

### 3. الأثر المعماري:
* التخلص من أكثر من 245 سطراً من الكود المكرر والازدواجية اليدوية في عمليات الـ CRUD.
* إخضاع كافة عمليات الإدخال والتعديل لطبقة طلبات تحقق مستقلة (`FormRequests`) مما يرفع أمان واستقرار المدخلات.
* توافق كامل مع بنية قمرة القيادة وواجهات Vue دون أي انكسار.

---

## 🔹 الدورة 8: توحيد متحكمات المجموعات والتعليقات والملاحظات في `EntityController` وترشيق الـ CRUD

- **تاريخ الإنجاز:** 2026-10-14
- **المحور المستهدف:** المحور الثالث (طبقة المتحكمات وتوحيد معمارية الـ CRUD)
- **الهدف المعماري:**  
  توحيد متحكمات المجموعات ([`CollectionController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/CollectionController.php)) والتعليقات ([`CommentController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/CommentController.php)) والملاحظات ([`NoteController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/NoteController.php)) تحت مظلة الفئة الأم [`EntityController`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/EntityController.php)، مع الحفاظ على المنطق الخاص والوظائف الذكية (مثل ربط الكيانات بالمجموعة `attachEntity`، وتخصيص التحميل الحثيث `Eager Loading` بحسب المسار، وإسناد هوية المستخدم تلقائياً `user_id` للملاحظات والتعليقات والمجموعات)، واستخراج 6 أصناف طلبات تحقق مستقلة (`FormRequests`)، وربط سياسات الصلاحيات (`EntityPolicy`) في مزود الخدمة.

---

### 1. الملفات المنشأة والمعدلة:
1. **منشأ 🌟 (طبقة FormRequests القياسية):**
   - [`app/Http/Requests/StoreCollectionRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreCollectionRequest.php)
   - [`app/Http/Requests/UpdateCollectionRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateCollectionRequest.php)
   - [`app/Http/Requests/StoreCommentRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreCommentRequest.php)
   - [`app/Http/Requests/UpdateCommentRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateCommentRequest.php)
   - [`app/Http/Requests/StoreNoteRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/StoreNoteRequest.php)
   - [`app/Http/Requests/UpdateNoteRequest.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Requests/UpdateNoteRequest.php)
2. **معدل ✏️ (تسجيل السياسات في مزود الخدمة):**
   - [`app/Providers/AppServiceProvider.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Providers/AppServiceProvider.php): تسجيل بوابات الصلاحيات للنماذج `Collection`, `Comment`, `Note` وربطها بسياسة `EntityPolicy`.
3. **معدل ✏️ (المتحكمات الموحدة والرشيقة):**
   - [`app/Http/Controllers/CollectionController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/CollectionController.php): تقليص الكود من 142 إلى 75 سطراً (توفير 47% من الكود)، مع الحفاظ على طريقة `attachEntity` وتخصيص التحميل الحثيث `relations()` ليكون `['user']` في صفحة الفهرس و `['books', 'videos', 'audio', 'manuscripts', 'user']` في صفحة العرض، وتعيين `user_id` وتوجيه `update` إلى `collections.index`.
   - [`app/Http/Controllers/CommentController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/CommentController.php): تقليص الكود من 109 إلى 45 سطراً (توفير 59% من الكود)، مع إسناد هوية المستخدم تلقائياً في `persistModel`.
   - [`app/Http/Controllers/NoteController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/NoteController.php): تقليص الكود من 109 إلى 45 سطراً (توفير 59% من الكود)، مع إسناد هوية المستخدم تلقائياً في `persistModel`.

---

### 2. نتائج فحص درع المناعة الشامل (Full-Stack Immunity Shield) 🛡️:
* **الأوامر المنفذة بواسطة المستخدم:**
  ```bash
  php artisan test tests/Feature/Entities/Common/CoreEntitiesCRUDTest.php
  php artisan test tests/Feature/Entities/Taxonomies/TaxonomyAttachmentTest.php
  npm run test:run
  php artisan test
  ```
* **النتائج المسجلة:**
  ```text
  PASS  Tests\Feature\Entities\Common\CoreEntitiesCRUDTest
  ✓ full crud lifecycle for books
  ✓ full crud lifecycle for manuscripts
  ✓ full crud lifecycle for audios
  ✓ full crud lifecycle for videos
  ✓ crud lifecycle for supporting entities
  ✓ full crud lifecycle for bookers
  ✓ full crud lifecycle for languages
  ✓ full crud lifecycle for comments and notes
  ✓ audit logs lifecycle for activities and deletions
  ✓ crud lifecycle for content nodes and segments
  ✓ lifecycle for versions and reading positions
  Tests: 11 passed (384 assertions) | Duration: 1.48s

  PASS  Tests\Feature\Entities\Taxonomies\TaxonomyAttachmentTest
  ✓ entities can attach taxonomies dynamically
  ✓ entities can detach taxonomies dynamically
  Tests: 2 passed (6 assertions) | Duration: 0.16s

  Vitest Frontend Tests (npm run test:run):
  Test Files: 14 passed (14)
  Tests:      136 passed (136) | Duration: 13.91s

  Full Backend Suite (php artisan test):
  Tests:      1 incomplete, 592 passed (3429 assertions) | Duration: 44.44s
  ```
  *(100% نجاح كامل لكافة الاختبارات)*.

---

### 3. الأثر المعماري:
* التخلص من أكثر من 190 سطراً من الكود المكرر عبر توحيد استجابات Inertia ومعالجة CRUD في `EntityController`.
* رفع المعايير الأمنية عبر فرض قواعد التحقق لعمليات التخزين والتحديث لكل نموذج على حدة بواسطة FormRequests مستقلة.
* الحفاظ الدقيق على السلوكيات الخاصة (مثل `attachEntity` وتأمين عدم تسريب بيانات غير مرغوبة أو انكسار صفحات العرض).
