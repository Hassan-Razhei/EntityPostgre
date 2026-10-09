---
description: دليل تشغيل وهندسة إضافة المحتوى في الاستوديو (Studio Content Pipeline Guide) 🧱
---

# 🧱 دليل تشغيل وهندسة إضافة المحتوى في الاستوديو (Studio Content Pipeline Guide)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library

---

> [!NOTE]
> هذا المستند يوثق المسار الهندسي والتشغيلي المكتمل لإضافة وهيكلة العقد (`ContentNodes`) وتنسيق التحرير بين محرر Tiptap ومشغل الوسائط وقواعد بيانات PostgreSQL.

---

## 🏛️ دستور العمل وقواعد الانسجام الهيكلي (The Structural Harmony Contract)

يعتمد استوديو المنظومة على منظومة العقد الهيكلية الموحدة (`ContentNode`) لتنظيم كافة أشكال المحتوى العميق دون تكرار أو ازدواجية برمجية:

### 1. تصنيف العقد حسب طبيعة الأصل (`App\Enums\ContentNodeType`)
- **الكتب (Books):**
  - **العقد الحاوية (Container Structure Nodes):**  
    `SUB_BOOK` (H1), `PART` (H2), `BAB` (H3), `CHAPTER` (H4), `MASALAH` (H5), `SECTION` (H6).
  - **العقد العلامية (Markers):** `PAGE` (H4 marker).
- **المخطوطات (Manuscripts - الهجين الفائق):**
  - ترث كافة هياكل الكتب (أجزاء، أبواب، فصول) مع إضافة علامات اللوحات والورقات:
  - `FOLIO` (H4 marker مع سمة `data-folio`).
- **الصوتيات (Audio - الزمن والمسارات):**
  - `SEGMENT` (H4 marker مع سمة `data-start-time`), `TRACK` (H4), `MARKER` (H5).
- **المرئيات (Video - المشاهد واللقطات):**
  - `SCENE` (H4 marker مع سمة `data-start-time`), `SHOT` (H5), `SEGMENT` (H4).

---

## 🎼 المنسق الشامل لاستوديو المحتوى (`useStudioContentProcess.js`)

يمثل Composable [`resources/js/Technologies/Studio/Composables/useStudioContentProcess.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Technologies/Studio/Composables/useStudioContentProcess.js) نقطة الالتقاء المركزية لكافة عمليات الإضافة:

### دورة حياة إضافة العقدة:
1. **اكتشاف العقدة الأب الحالية (`findParentIdFromEditor`):**  
   فحص موضع مؤشر الماوس داخل محرر Tiptap صعوداً في شجرة الـ DOM للعثور على أقرب وسم يحمل السمة `data-id`.
2. **تحديث رصيد الميديا (`mediaStore`):**  
   في حال كان الأصل صوتاً أو مرئياً وتوفر توقيت زمني، يتم تحديث الخط الزمني للمشغل تلقائياً دون تفعيل إجباري للقطاع.
3. **الإرسال والحفظ في الخادم (Server Persistence):**  
   إرسال طلب POST فوري للمسار المعتمد:
   ```http
   POST /studio/{type}/{slug}/nodes
   Payload: { type, title, time, parent_id }
   ```
4. **تحديث البيانات دون فقدان السياق (Context-Preserving Reload):**  
   إعادة تنشيط بيانات الشجرة والمحتوى عبر `router.reload({ only: ['entity', 'editorContent', 'fullContent', 'hierarchy'] })` ليبقى المستخدم في نفس موضع القراءة والتحرير.

---

## 🖱️ زر الإضافة السياقي الذكي (`StudioAddButton.vue`)

المكون [`resources/js/Technologies/Studio/Components/StudioAddButton.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Technologies/Studio/Components/StudioAddButton.vue):
- **الموقع:** يظهر مباشرة بعد عنوان الأصل داخل ترويسة الاستوديو.
- **التكيف الذكي:**
  - يعرض فقط الأنواع المسموحة للأصل الحالي استناداً إلى `ContentNodeType.allowedFor(type)`.
  - يقترح التوقيت التلقائي الحالي للمشغل للصوتيات والمرئيات.
  - يقترح رقم الورقة التالي للمخطوطات.
- **التشغيل:** يستدعي دالة `insertNode` من `useStudioContentProcess`.

---

## 🎮 وحدة التحكم والخدمات الحاكمة (Backend & Service Layer)

### 1. وحدة التحكم (`App\Http\Controllers\ContentNodeController`)
- حراسة المسارات والتحقق الصارم من الحقول (`type`, `title`, `time`, `parent_id`).
- التحقق من عدم تجاوز التوقيت الزمني لمدة ملف الوسائط الفعلي (`duration`).
- تفويض الحفظ إلى `EntityContentService::addNode`.

### 2. الخدمة السيادية (`App\Services\EntityContentService`)
- استخراج الترتيب الأقصى (`order`) وتوليد الـ Slug الفريد.
- التحقق من توافق النوع مع نوع الأصل (`allowedTypes`).
- إدارة التجزئة الجراحية والتجميع الذكي (`Smart Splitter & Aggregator`):
  - التجميع: دمج العقد مع حقن العلامات `data-segment-link="true" data-id="UUID" data-type="TYPE"`.
  - التقسيم والحفظ: استخدام التعبير النمطي `/<h4 class="structure-marker".*?>.*?<\/h4>/` لإعادة كل مقطع لعقدته في جدول `content_nodes` في PostgreSQL.

---

## 🛡️ شبكة الاختبارات المؤتمتة الحامية للاستوديو

تخضع هذه المنظومة لحماية صارمة عبر الاختبارات الآتية:
- `tests/Browser/Studio/StudioContentStructureTest.php`: اختبار التناغم الهيكلي لـ `ContentNodeType`.
- `tests/Browser/Studio/StudioContentProcessTest.php`: اختبار تكامل المحرر والمشغل والمنسق الشامل.
- `tests/Feature/ContentNodes/ContentNodeArchitectureTest.php`: اختبار حفظ الـ AST كـ JSONB والعقد الهيكلية في PostgreSQL.
- `tests/Feature/ContentNodes/UnifiedContentTest.php`: اختبار إنشاء العقد الموحدة لكافة الأصول.
- `tests/Feature/Studio/ComprehensiveStudioSaveAndReloadTest.php`: اختبار الحفظ والاسترجاع الشامل وتجنب فقدان البيانات.
- `tests/Feature/Studio/SmartSplitterTest.php`: اختبار التجزئة والتجميع الذكي.
