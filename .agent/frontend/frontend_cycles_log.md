# 📋 سجل ومسار دورات تطوير واجهة قمرة القيادة (Frontend TDD Cycles Log)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library

---

## 📊 لوحة المؤشرات الإجمالية (Executive Dashboard)

| رقم الدورة | اسم الدورة والمحور | ملفات الاختبار المنشأة | نتيجة الـ RED 🔴 | نتيجة الـ GREEN 🟢 | فحص عدم الانكسار 🛡️ | الحالة |
|:---:|---|---|:---:|:---:|:---:|:---:|
| **1** | **النواة التشغيلية وقمرة القيادة الحية (POC & AdminDashboard)** | `tests/Feature/SuperAdminDashboardTest.php` | 3 Failed (404) | 3 Passed (14 Assertions) | **340 Passed** (100% نجاح) | ✅ مكتملة وموثقة |
| **2** | **السايدبار الموحد وأكوردion المجموعات الخمس (Unified Sidebar & Accordion)** | `resources/js/__tests__/Sidebar.test.js` | 6 Failed | 6 Passed (19 Vitest Tests) | **19 Vitest + 3 PHP Passed** | ✅ مكتملة وموثقة |
| **3** | **النافبار الموحد ومسار التتبع ثلاثي المستويات وقائمة المستخدم (Unified Navbar & Breadcrumbs)** | `resources/js/__tests__/Navbar.test.js` | 4 Failed | 4 Passed (23 Vitest Tests) | **23 Vitest + 3 PHP Passed** | ✅ مكتملة وموثقة |
| **4** | **تغذية قمرة القيادة بالبيانات الحية من PostgreSQL (Live Stats & Dynamic Props)** | `tests/Feature/SuperAdminDashboardTest.php` | 1 Failed (Property [stats] missing) | 4 Passed (38 Assertions) | **23 Vitest + 4 PHP Passed** | ✅ مكتملة وموثقة |
| **5** | **نظام الجداول عالي الكثافة وقائمة اختيار الأعمدة (ColumnsDropdown & High-Density Primitive)** | `resources/js/__tests__/ColumnsDropdown.test.js` | 1 Failed (Missing import) | 6 Passed (29 Vitest Tests) | **29 Vitest + 4 PHP Passed** | ✅ مكتملة وموثقة |
| **6** | **دمج نظام الجداول عالي الكثافة وقائمة الأعمدة في فهرس الكتب (Books Index High-Density Integration)** | `resources/js/__tests__/BooksIndex.test.js` | 4 Failed | 4 Passed (33 Vitest Tests) | **33 Vitest + 10 PHP Passed** | ✅ مكتملة وموثقة |

---

## 🔹 الدورة 1: النواة التشغيلية الأولى وقمرة القيادة الحية (POC Bootstrap & AdminDashboard)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  تأسيس المسار السيادي لقمرة قيادة السوبر أدمن `/superadmin/dashboard`، وحمايته بمصفوفة صلاحيات السوبر أدمن (`role:super_admin`)، ونقل النموذج الأولي الحاكم من `super_admin_dashboard_preview.html` ككتلة واحدة في مكون Vue 3 (`AdminDashboard.vue`) لتجربته ومعاينته حياً داخل بيئة `Laravel + Inertia + Vite` قبل البدء في تفكيكه المعماري.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`tests/Feature/SuperAdminDashboardTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SuperAdminDashboardTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_redirects_unauthenticated_guests_to_login`: التحقق من إعادة توجيه الزوار غير المسجلين لصفحة الدخول.
  2. `it_forbids_non_super_admin_users_from_accessing_dashboard`: منع المستخدمين غير الحاملين لرتبة `super_admin` برمز الحظر `403 Forbidden`.
  3. `it_allows_super_admin_to_access_and_renders_admin_dashboard_component`: تمكين السوبر أدمن فقط واستدعاء مكون `AdminDashboard` بنجاح (`200 OK`).
- **نتيجة التشغيل الأولى (RED):**
  * فشل 3 اختبارات بنجاح لعدم وجود المسار والمكون (`3 Failed - 404 Not Found`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. [`routes/web.php`](file:///home/a/PhpstormProjects/EntityPostgre/routes/web.php): تسجيل المسار المحمي بحراسة `['auth', 'active', 'role:super_admin']`.
  2. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue): إنشاء مكوّن Vue 3 التفاعلي الشامل ونقل الهيكل والأنماط والدوال الـ 18.
  3. [`public/super_admin_dashboard_preview.html`](file:///home/a/PhpstormProjects/EntityPostgre/public/super_admin_dashboard_preview.html): دمج السمات المكررة وضبط التوافق الصارم مع محرك قوالب Vue 3.
- **نتيجة التشغيل (GREEN):**
  * `Tests: 3 passed (14 assertions)` بنجاح 100%.
  * نجاح بناء حزم الإنتاج عبر Vite: `AdminDashboard-CK5GJIwC.js (210.72 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- فحص اختبارات التوجيه الجغرافي وحقن الهوية: `17 Passed (350 assertions)` بنجاح تام.
- المعاينة الحية: تأكيد عمل الصفحة واستجابة السايدبار والثيم والجداول في المتصفح على `http://localhost:8000/superadmin/dashboard`.

---

## 🔹 الدورة 2: السايدبار الموحد وأكوردion المجموعات الخمس (Unified Sidebar & Accordion)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  ترقية السايدبار الأصلي المعتمد في المشروع [`resources/js/Layouts/Partials/Sidebar.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Layouts/Partials/Sidebar.vue) ليعكس بدقة 100% المجموعات الخمس الواردة في المرجع الحاكم `super_admin_dashboard_preview.html` (المكتبة، الأشخاص، التنظيم، الاستوديو، النظام)، مع إضافة شريط تحكم الأكوردion (توسيع وطي الكل)، وبادجات العدادات، وتمييز المجموعة السيادية، وحراسة المسارات بصلاحيات الأدوار عبر `useAuth()`.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`resources/js/__tests__/Sidebar.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/Sidebar.test.js)
- **الحالات التي تم اختبارها:**
  1. `renders all five canonical groups matching super_admin_dashboard_preview.html`: فحص وجود المجموعات الخمس الأساسية.
  2. `renders the accordion micro-toolbar with expand and collapse buttons`: فحص وجود شريط الأكوردion وزري التوسيع والطي.
  3. `toggles collapse state of a navigation group when header is clicked`: فحص سلوك طي وفرد المجموعة عند النقر.
  4. `collapses all groups when collapse-all button is clicked`: فحص طي كافة المجموعات دفعة واحدة.
  5. `expands all groups when expand-all button is clicked`: فحص توسيع كافة المجموعات دفعة واحدة.
  6. `renders the sovereign group with sovereign-group class and crown icon`: فحص تمييز المجموعة السيادية برتبة السوبر أدمن.
- **نتيجة التشغيل الأولى (RED):**
  * فشل كافة الاختبارات الستة بنجاح (`6 Failed`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملف البرمجي المحدث:**  
  [`resources/js/Layouts/Partials/Sidebar.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Layouts/Partials/Sidebar.vue)
  * بناء مصفوفة `navigationGroups` المطابقة 1:1 للمرجع الحاكم مع الرموز التعبيرية والبادجات.
  * إضافة كائن الحالة التفاعلية `collapsedGroups = ref(new Set())` ودوال `toggleNavGroup` و `expandAllGroups` و `collapseAllGroups`.
  * حراسة مجموعة الاستوديو بصلاحية `access_studio` ومجموعة النظام بصلاحية `system_commands`.
- **نتيجة التشغيل (GREEN):**
  * `Sidebar.test.js`: **6 Passed (100% نجاح)**.
  * نجاح بناء حزم الـ Assets عبر Vite: `AuthenticatedLayout-BYoXluRk.js (17.58 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- اختبارات الواجهة الحالية: `adaptiveUI.test.js` (6 Passed).
- إجمالي اختبارات جافاسكريبت: **19 Tests Passed في Vitest بنجاح 100%**.
- اختبارات الباك إند: `SuperAdminDashboardTest` (3 Passed).

---

## 🔹 الدورة 3: النافبار الموحد ومسار التتبع ثلاثي المستويات وقائمة المستخدم (Unified Navbar & Breadcrumbs)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  ترقية شريط الملاحة العلوي الأصلي [`resources/js/Layouts/Partials/Navbar.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Layouts/Partials/Navbar.vue) لمطابقة المرجع الحاكم: إدراج مسار التتبع ثلاثي المستويات (`الرئيسية ‹ المجموعة ‹ الصفحة`)، حقل البحث السريع مع أيقونة العدسة، زر التنبيهات، وقائمة المستخدم المنسدلة الدائرية مع تفاصيل الحساب والبريد الإلكتروني وخيارات لوحة التحكم وتسجيل الخروج.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`resources/js/__tests__/Navbar.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/Navbar.test.js)
- **الحالات التي تم اختبارها:**
  1. `renders 3-tier breadcrumbs (الرئيسية ‹ المجموعة ‹ الصفحة) matching super_admin_dashboard_preview.html`: فحص مستويات التتبع الثلاثية.
  2. `renders the system notifications button with alert trigger`: فحص زر التنبيهات.
  3. `renders user email and profile details inside the user dropdown header`: فحص قائمة المستخدم وبيانات الحساب والبريد.
  4. `toggles theme when theme button is clicked`: فحص زر تبديل الثيم وأيقونتي الشمس والقمر.
- **نتيجة التشغيل الأولى (RED):**
  * فشل 4 اختبارات بنجاح (`4 Failed`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملف البرمجي المحدث:**  
  [`resources/js/Layouts/Partials/Navbar.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Layouts/Partials/Navbar.vue)
  * إضافة خاصية `group` لتمكين مسار التتبع ثلاثي المستويات.
  * تصميم زر الأفاتار الدائري مع الحرف الأول، والقائمة المنسدلة الزجاجية ذات الظلال الفاخرة (`userDropdownMenu`).
  * تضمين بيانات الحساب: الاسم والبريد الإلكتروني والرتبة المؤسسية.
  * زر التنبيهات السريعة ومبدل الثيم بالشمس والقمر.
- **نتيجة التشغيل (GREEN):**
  * `Navbar.test.js`: **4 Passed (100% نجاح)**.
  * إجمالي اختبارات Vitest: **23 Passed (100% نجاح)**.
  * نجاح بناء حزم الـ Assets عبر Vite: `AuthenticatedLayout-CdRlxx6T.js (21.14 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- اختبارات الواجهة: `adaptiveUI.test.js` (6 Passed), `Sidebar.test.js` (6 Passed), `useAuth.test.js` (3 Passed).
- اختبارات الباك إند: `SuperAdminDashboardTest` (3 Passed).

---

## 🔹 الدورة 4: تغذية قمرة القيادة بالبيانات الحية من PostgreSQL (Live Stats & Dynamic Props)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  فصل المنطق البرمجي لقمرة قيادة السوبر أدمن عبر متحكم مستقل [`SuperAdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SuperAdminDashboardController.php)، واستخراج أعداد الكيانات الحية من قاعدة البيانات وتمريرها عبر Inertia Props، وتغذية بطاقات الـ KPI وقوائم النشاطات في [`AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue) ببيانات حقيقية حية بدلاً من الأرقام الثابتة.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار:**  
  [`tests/Feature/SuperAdminDashboardTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SuperAdminDashboardTest.php)
- **الحالات التي تم اختبارها:**
  * `it_shares_live_database_statistics_and_recent_activities_to_admin_dashboard`: فحص تمرير إحصائيات دقيقة ومطابقة لأعداد قاعدة البيانات للكتب (5) والمخطوطات (3) والصوتيات (4) والمرئيات (2) والمؤلفين (6) وقائمة النشاطات.
- **نتيجة التشغيل الأولى (RED):**
  * فشل الاختبار بنجاح: `Property [stats] does not exist` (`1 Failed`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. [`app/Http/Controllers/SuperAdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SuperAdminDashboardController.php): بناء المتحكم وحساب أعداد الموديلات واسترجاع آخر النشاطات وتمريرها لـ Inertia.
  2. [`routes/web.php`](file:///home/a/PhpstormProjects/EntityPostgre/routes/web.php): ربط مسار `/superadmin/dashboard` بالكونترولر الجديد.
  3. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue): استقبال خصائص `props.stats` و `props.recentActivities` وتطعيم بطاقات الـ KPI بالأرقام الحية المنسقة (`toLocaleString`).
- **نتيجة التشغيل (GREEN):**
  * `SuperAdminDashboardTest`: **4 Passed (38 Assertions) بنجاح 100%**.
  * نجاح بناء حزم Vite للإنتاج: `AdminDashboard-BJ9GJhY-.js (211.04 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- اختبارات الواجهة: كافة اختبارات Vitest الـ **23 اختباراً ناجحة بنسبة 100%**.
- اختبارات الباك إند: كافة اختبارات `SuperAdminDashboardTest` ناجحة بنسبة 100%.

---

## 🔹 الدورة 5: نظام الجداول عالي الكثافة وقائمة تحديد الأعمدة (ColumnsDropdown & High-Density Table Primitive)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  بناء المكوّن الأساسي القابل لإعادة الاستخدام لإدارة رؤية أعمدة الجداول الكثيفة [`resources/js/Components/Table/ColumnsDropdown.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/ColumnsDropdown.vue) وفقاً لمواصفات وتصميم النموذج الحاكم `super_admin_dashboard_preview.html`. يتيح للمشرف إظهار وإخفاء الأعمدة ديناميكياً مع حماية الأعمدة السيادية الأساسية (مثل العنوان) من الإخفاء، وتوفير زر استعادة إظهار الكل، مع دعم كامل للثيمين الداكن والفاتح وقوائم التمرير المخصصة.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`resources/js/__tests__/ColumnsDropdown.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/ColumnsDropdown.test.js)
- **الحالات التي تم اختبارها:**
  1. `renders the columns dropdown toggle button with label الأعمدة`: التأكد من وجود زر تفعيل القائمة مع الأيقونة وعنوان "الأعمدة".
  2. `toggles dropdown visibility when button is clicked`: اختبار فتح وإغلاق القائمة المنسدلة عند النقر على الزر.
  3. `renders a checkbox item for each column in the menu`: التحقق من توليد خيارات الأعمدة كاملة داخل القائمة.
  4. `disables checkbox for required primary columns`: التحقق من تعطيل إمكانية إلغاء تحديد الأعمدة الأساسية الإلزامية (`required: true`).
  5. `emits toggle event with column key and visibility when a checkbox is toggled`: التحقق من إطلاق حدث `toggle-column` بالقيمة الجديدة ومعرف الحقل.
  6. `emits reset-all event when إظهار الكل button is clicked`: التحقق من إطلاق حدث `reset-all` عند طلب إعادة ضبط الأعمدة.
- **نتيجة التشغيل الأولى (RED):**
  * فشل الاختبار بنجاح لعدم وجود المكوّن (`Failed to resolve import ColumnsDropdown.vue`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملف البرمجي المنشأ:**  
  [`resources/js/Components/Table/ColumnsDropdown.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/ColumnsDropdown.vue)
  * هيكلة زر التبديل بالأبعاد القياسية `h-[27px]` وتدرجات البوردر والتأثيرات الزجاجية.
  * قائمة منسدلة بأقصى ارتفاع `max-h-[260px]` وشريط تمرير مخصص فائق النعومة (`custom-scrollbar`).
  * دعم الإغلاق التلقائي عند النقر خارج القائمة عبر مستمع الأحداث العام للوثيقة `document.addEventListener('click')`.
  * دعم الوضعين الداكن والفاتح بوضوح عالٍ وتباين بصري مثالي.
- **نتيجة التشغيل (GREEN):**
  * `ColumnsDropdown.test.js`: **6 Passed (100% نجاح)**.
  * نجاح بناء حزم Vite للإنتاج دون أي أخطاء.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **29 Passed (100% نجاح عبر 7 ملفات اختبار)**.
- **اختبارات الباك إند (PHPUnit):** **4 Passed (38 Assertions)** بنجاح تام.

---

## 🔹 الدورة 6: دمج نظام الجداول عالي الكثافة وقائمة الأعمدة في فهرس الكتب (Books Index High-Density Integration)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  ترقية صفحة فهرس الكتب الأصلية المعتمدة في النظام [`resources/js/Pages/Books/Index.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/Books/Index.vue) لدمج مكون اختيار الأعمدة `<ColumnsDropdown />`، وتطبيق مصفوفة الأعمدة المتوافقة 1:1 مع جداول المايجريشن في PostgreSQL ومواصفات النموذج الحاكم `super_admin_dashboard_preview.html`. تتيح ترقية الصفحة التحكم الحي في إظهار وإخفاء الأعمدة مثل (`isbn`، `slug`، `description`، `created_at`) مع تثبيت الأعمدة الإلزامية (`title`، `actions`)، وضمان عمل البحث السريع والفلترة والترقيم والوضع الليلي دون أي انكسار.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**  
  [`resources/js/__tests__/BooksIndex.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/BooksIndex.test.js)
- **الحالات التي تم اختبارها:**
  1. `renders the ColumnsDropdown component in the toolbar`: التأكد من وجود مكون قائمة الأعمدة داخل شريط الفلترة والأدوات.
  2. `provides columns configuration with required title column`: فحص تمرير مصفوفة الأعمدة كاملة وتثبيت عمود `title` كحقل إلزامي أساسي.
  3. `hides column header and cells when column visibility is toggled off`: فحص إخفاء ترويسة الجدول والخلايا المطابقة ديناميكياً عند إلغاء تفعيل عمود `isbn`.
  4. `restores all columns when reset-all event is emitted`: فحص استعادة رؤية كافة الأعمدة عند استدعاء حدث `reset-all`.
- **نتيجة التشغيل الأولى (RED):**
  * فشل كافة الاختبارات الأربعة بنجاح (`4 Failed`).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملف البرمجي المحدث:**  
  [`resources/js/Pages/Books/Index.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/Books/Index.vue)
  * استيراد ودمج `<ColumnsDropdown />` داخل بطاقة شريط البحث والفلترة.
  * تعريف مصفوفة الأعمدة التفاعلية `columns` التسعة (الرقم التسلسلي، العنوان، المعرف، المؤلف، الرقم الدولي، الوصف، الأوسمة، تاريخ الإضافة، الإجراءات).
  * ربط دالتي `isColumnVisible` و `toggleColumn` و `resetAllColumns` مع ترويسة الجدول وخلايا الصفوف.
- **نتيجة التشغيل (GREEN):**
  * `BooksIndex.test.js`: **4 Passed (100% نجاح)**.
  * نجاح بناء حزم الإنتاج عبر Vite: `Index-BVavF0BW.js (12.47 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **33 Passed (100% نجاح عبر 8 ملفات اختبار)**.
- **اختبارات الباك إند (PHPUnit):** نجاح كافة اختبارات الكتب [`BookTest`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Unit/Models/BookTest.php) و [`BookControllerTest`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/BookControllerTest.php) بواقع **10 Passed (66 Assertions)**.


---

## 🔹 الدورة 7: إتمام قمرة القيادة السيادية (AdminDashboard) وربط البيانات الحية للمستخدمين والنشاطات والمهملات والتنقل السلس

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  إتمام قمرة القيادة السيادية [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue) وإغلاق كافة وظائفها بنسبة 100% تطابقاً مع المرجع الحاكم `super_admin_dashboard_preview.html`:
  1. ضبط الواجهة الافتراضية لقمرة القيادة لتفتح على لوحة المؤشرات المركزية (`stats`) الحاوية على شارات الكفاءة وصحة قاعدة البيانات والـ KPI ومسار تدفق النشر وسجل النشاطات بدلاً من فتح جدول الكتب قسرياً.
  2. دعم التوجيه المتناغم عبر الهاش (`#stats`، `#books`، `#users`، `#activities`، `#commands`، إلخ) لحفظ موقع المشرف وتسهيل التنقل والتحديث.
  3. ربط كافة شارات السايدبار الـ 19 بالأعداد الحية الدقيقة لجميع الكيانات من قاعدة بيانات PostgreSQL عبر `props.stats`.
  4. حساب عدد المحذوفات مؤقتاً (سلة المهملات `stats.deletions`) برمجياً عبر `onlyTrashed()->count()` لجميع الموديلات التي تدعم الحذف الرخو.
  5. ربط تبويب المستخدمين (`users`) وسجل النشاطات الحية (`activities`) بقوائم PostgreSQL الفعلية مع تهيئة الأفاتار والرتب الملونة وتواريخ الإضافة التفاعلية.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار:**  
  - باوند إند: [`tests/Feature/SuperAdminDashboardTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SuperAdminDashboardTest.php) (`it_shares_recent_users_and_accurate_deletions_count_to_admin_dashboard`).
  - فرونت إند: [`resources/js/__tests__/AdminDashboard.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/AdminDashboard.test.js).
- **الحالات التي تم اختبارها:**
  1. `renders live statistics badges in sidebar navigation items`: فحص ربط أرقام السايدبار ديناميكياً بـ `props.stats`.
  2. `initializes with stats overview view by default`: فحص فتح الداشبورد على شاشة `stats` افتراضياً أو بناءً على الهاش في الرابط.
  3. `renders real users list in users view when selected`: فحص توليد بطاقات المستخدمين الحقيقيين في تبويب `المستخدمون`.
  4. `renders live activities timeline in activities view`: فحص رسم الخط الزمني للنشاطات الفعلية في تبويب `النشاطات`.
- **نتيجة التشغيل الأولى (RED):**
  * فشل اختبار الباك إند: `Failed asserting that 0 matches expected 3` (كانت المهملات صفراً والمستخدمون غير ممررين).
  * فشل اختبار الفرونت إند: لعدم وجود ملف الاختبار وبقاء الشارات ثابتة وفتح واجهة الكتب افتراضياً.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة:**  
  1. [`app/Http/Controllers/SuperAdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SuperAdminDashboardController.php):
     - حساب المحذوفات مؤقتاً (`deletions`) ديناميكياً عبر `Book`, `Manuscript`, `Audio`, `Video`, `Author`.
     - استخراج أحدث المستخدمين `recentUsers` مع تجهيز الحرف الأول للأفاتار وشرائح الرتب الزمنية.
     - تمرير إحصائيات الـ 15 موديلاً كاملاً مع المستخدمين والمهملات والنشاطات.
  2. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue):
     - ربط شارات السايدبار ديناميكياً بـ `props.stats` واستخدام `.toLocaleString()`.
     - ضبط الواجهة الابتدائية إلى `stats` والاستماع لأحداث `hashchange` في نافذة المتصفح.
     - تحديث قوالب `users` و `activities` و `deletions` لعرض البيانات الحية المستلمة من Inertia Props.
- **نتيجة التشغيل (GREEN):**
  * `SuperAdminDashboardTest`: **5 Passed (52 Assertions) بنسبة 100%**.
  * `AdminDashboard.test.js`: **4 Passed (100% نجاح)**.
  * نجاح بناء الحزم للإنتاج عبر Vite: `AdminDashboard-Bn9evrBZ.js (211.51 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **37 Passed (100% نجاح عبر 9 ملفات اختبار)**.
- **اختبارات الباك إند (PHPUnit):** **5 Passed (52 Assertions)** بنجاح تام.


---

## 🔹 الدورة 8: ربط الطرفية التفاعلية وأدوات الصيانة الفورية بالباك إند الفعلي (Terminal Console & Operations Live Execution)

- **تاريخ الإنجاز:** 2026-10-07
- **الهدف المعماري:**  
  ترقية الطرفية التفاعلية (`commands`) وأدوات العمليات الفورية (`ops`) داخل قمرة القيادة [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue) وربطها بمسار الباك إند الحقيقي `POST /api/system/run-command`:
  1. استبدال الردود الثابتة في الطرفية بتنفيذ حقيقي للأوامر عبر `SystemController::runCommand`.
  2. تطبيع نصوص الأوامر بإزالة بادئة `php artisan ` تلقائياً في المتحكم [`app/Http/Controllers/SystemController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SystemController.php).
  3. توسيع القائمة البيضاء للأوامر الآمنة المصرح بها لتشمل أوامر الصيانة الأساسية (`optimize:clear`, `cache:clear`, `config:clear`, `route:clear`, `view:clear`, `migrate:status`, `about`).
  4. ربط بطاقة "تفريغ الكاش ومزامنة السياسات" في تبويب العمليات بتنفيذ فوري لـ `optimize:clear` عبر دالة `triggerOpsCacheClear()`.
  5. عرض مخرجات الأوامر الحقيقية بألوان وتنسيق الطرفيات (`pre` format) مع التمرير التلقائي للأسفل، وعرض رسائل الخطأ والمنع 403 بوضوح باللون الأحمر.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار:**  
  - باك إند: [`tests/Feature/SystemCommandExecutionTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SystemCommandExecutionTest.php).
  - فرونت إند: [`resources/js/__tests__/AdminDashboard.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/AdminDashboard.test.js).
- **الحالات التي تم اختبارها:**
  1. `it_allows_super_admin_to_run_whitelisted_artisan_command`: التحقق من تشغيل الأوامر المصرحة بنجاح.
  2. `it_normalizes_php_artisan_prefix_in_command_string`: فحص قبول الأوامر المسبوقة بـ `php artisan `.
  3. `it_rejects_unwhitelisted_commands_with_403`: فحص رفض الأوامر الخطرة أو غير المدرجة في القائمة البيضاء.
  4. `executes artisan command via runCmd and displays real output in terminal`: فحص اتصال الطرفية واستدعاء مسار الباك إند عبر axios وعرض المخرجات.
  5. `displays error in terminal when command fails or is rejected`: فحص إظهار رسائل الرفض والخطأ.
- **نتيجة التشغيل الأولى (RED):**
  * فشل اختبار الباك إند: `Expected 200 but received 403` لعدم تطبيع بادئة `php artisan`.
  * فشل اختبار الفرونت إند: `Number of calls to axios.post: 0` وظهور رسالة النجاح الصورية القديمة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة:**  
  1. [`app/Http/Controllers/SystemController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SystemController.php):
     - تطبيع الأمر المدخل عبر `preg_replace('/^php\s+artisan\s+/', '', trim($rawCommand))`.
     - اعتماد القائمة البيضاء الموسعة للأوامر الإدارية الآمنة.
  2. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue):
     - ترقية `runCmd()` إلى دالة غير متزامنة (`async`) ترسل الطلب إلى `/api/system/run-command`.
     - إضافة سطر حالة تفاعلي أثناء المعالجة، وعرض المخرجات الحقيقية بتنسيق الكود الملون.
     - إضافة دالة `triggerOpsCacheClear()` وربطها ببطاقة تفريغ الكاش في تبويب `ops`.
- **نتيجة التشغيل (GREEN):**
  * `SystemCommandExecutionTest`: **3 Passed (7 Assertions) بنسبة 100%**.
  * `AdminDashboard.test.js`: **6 Passed (100% نجاح)**.
  * نجاح بناء حزم الإنتاج عبر Vite: `AdminDashboard-BulnWrZ0.js (210.51 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **39 Passed (100% نجاح عبر 9 ملفات اختبار)**.
- **اختبارات الباك إند (PHPUnit):** **8 Passed (59 Assertions)** بنجاح تام.
