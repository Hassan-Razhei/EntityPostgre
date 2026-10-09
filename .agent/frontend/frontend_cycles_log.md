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
| **7** | **إتمام قمرة القيادة وربط البيانات الحية والتنقل السلس** | `tests/Feature/SuperAdminDashboardTest.php` | 2 Failed | 4 Passed (38 Assertions) | **33 Vitest + 4 PHP Passed** | ✅ مكتملة وموثقة |
| **8** | **ربط الطرفية التفاعلية وأدوات الصيانة بالباك إند الفعلي** | `tests/Feature/Console/SystemCommandExecutionTest.php` | 4 Failed | 4 Passed (9 Assertions) | **37 Vitest + 8 PHP Passed** | ✅ مكتملة وموثقة |
| **9** | **أزرار أوامر المنظومة المخصصة في واجهة الأوامر** | `resources/js/__tests__/AdminDashboard.test.js` | 1 Failed | 7 Passed (40 Vitest Tests) | **40 Vitest + 9 PHP Passed** | ✅ مكتملة وموثقة |
| **10** | **ترقية أمر التعبئة الواقعية (SeedRealisticData)** | `tests/Feature/Console/SeedRealisticEnhancementsTest.php` | 5 Failed | 5 Passed (11 Assertions) | **40 Vitest + 14 PHP Passed** | ✅ مكتملة وموثقة |
| **11** | **معالجة صلاحيات وتشغيل seed-realistic من الويب والطرفية** | `tests/Feature/Console/SeedCommandPermissionsTest.php` | 3 Failed | 3 Passed (7 Assertions) | **40 Vitest + 17 PHP Passed** | ✅ مكتملة وموثقة |
| **12** | **توحيد لوحة التحكم واستبدال Dashboard.vue القديم** | `tests/Feature/Dashboard/DashboardConsolidationTest.php` | 2 Failed | 2 Passed (6 Assertions) | **40 Vitest + 19 PHP Passed** | ✅ مكتملة وموثقة |
| **13** | **توحيد مسار لوحة التحكم إلى /superadmin/dashboard** | `tests/Feature/Dashboard/DashboardRouteResolutionTest.php` | 3 Failed | 3 Passed (9 Assertions) | **40 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **14** | **إعادة هيكلة مجلد tests/Feature حسب النطاقات** | `tests/Feature/Dashboard/SuperAdminDashboardTest.php` | 1 Failed | 4 Passed (38 Assertions) | **40 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **15** | **تفكيك وبناء محرك الجداول عالي الكثافة (Enterprise Asset Tables Engine)** | `resources/js/__tests__/TableEngineComponents.test.js` | 8 Failed | 8 Passed (48 Vitest Tests) | **48 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **16** | **تفكيك جداول الأصول الأربعة في قمرة القيادة واستبدالها بمحرك الجداول** | `resources/js/__tests__/AdminDashboard.test.js` | 4 Failed | 12 Passed (52 Vitest Tests) | **52 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **17** | **توحيد قطاع الأشخاص (المؤلفون والناشرون) بمحرك الجداول** | `resources/js/__tests__/AdminDashboard.test.js` | 4 Failed | 16 Passed (56 Vitest Tests) | **56 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **18** | **استعادة الهوية البصرية الغنية والتفاعلية لقمرة القيادة وحل الانكسارات** | `resources/js/__tests__/AdminDashboard.test.js` | 3 Failed | 11 Passed (59 Vitest Tests) | **59 Vitest + 22 PHP Passed** | ✅ مكتملة وموثقة |
| **19** | **ربط بيانات الكتب الحية من PostgreSQL وإعادة هيكلة جدول الكتب بمحرك الجداول دون فقدان بكسل** | `tests/Feature/Dashboard/SuperAdminDashboardTest.php` | 2 Failed | 6 Passed (111 Assertions) | **60 Vitest + 6 PHP Passed** | ✅ مكتملة وموثقة |
| **20** | **التعميم المعماري الشامل لكافة الأصول وقطاع الأشخاص والنظام كمكونات Vue نقية تفاعلية (100% Vue Reactivity)** | `resources/js/__tests__/AdminDashboard.test.js` + `SuperAdminDashboardTest.php` | 5 Failed | 66 Passed (11 Files) + 7 Passed PHP | **66 Vitest + 7 PHP Passed (114 Assertions)** | ✅ مكتملة وموثقة |
| **21** | **التمثيل الحي الشامل لكافة قطاعات المنظومة من PostgreSQL وتطهير الكود الميت (Full Live System & Dead Code Elimination)** | `resources/js/__tests__/AdminDashboard.test.js` + `SuperAdminDashboardTest.php` | 5 Failed (Live Data & Funnel) | 24 Passed (Vitest) + 8 Passed PHP (138 Assertions) | **24 Vitest + 548 PHP Passed (حجم الحزمة انخفض 53% وتمثيل حي 100%)** | ✅ مكتملة وموثقة |
| **22** | **اكتمال منظومة التنظيم المعرفي الشامل (المجموعات والسلاسل والموضوعات) وترقية الفهارس والربط البوليمورفي** | `TaxonomyAttachmentTest.php` + `AdminDashboard.test.js` + `TableEngineComponents.test.js` | 2 Failed PHP + 6 Failed Vitest | 2 Passed PHP + 28 Passed Vitest + 13 Passed Table | **78 Vitest + 551 PHP Passed (100% نجاح)** | ✅ مكتملة وموثقة |
| **23** | **تفكيك قمرة القيادة وفصل الواجهات الفرعية والأنماط المعمارية (Decoupled SFC Views & Modular Sub-Views)** | `resources/js/__tests__/ModularDashboardViews.test.js` | 6 Failed | 6 Passed (84 Vitest Tests) | **84 Vitest + 551 PHP Passed (انخفاض الحزمة لـ 104kB)** | ✅ مكتملة وموثقة |
| **24** | **ترقية وتوحيد عروض الاستوديو بمحرك الجداول ونمط البطاقات الذكي (Studio High-Density Engine & Cards Grid)** | `resources/js/__tests__/ModularDashboardViews.test.js` | 3 Failed | 4 Passed (88 Vitest Tests) | **88 Vitest + 551 PHP Passed (100% نجاح)** | ✅ مكتملة وموثقة |
| **25** | **المستكشف المعرفي التفاعلي وتخصيص الهويات البصرية لفروع التنظيم (Cognitive Taxonomy Explorer)** | `resources/js/__tests__/ModularDashboardViews.test.js` | 5 Failed | 5 Passed (91 Vitest Tests) | **91 Vitest + 551 PHP Passed (100% نجاح)** | ✅ مكتملة وموثقة |
| **26** | **التفكيك المعماري الشامل واستخراج غلاف القمرة وقطاعي المكتبة والأشخاص (Cockpit Shell & Sector Decoupling)** | `resources/js/__tests__/ModularDashboardViews.test.js` | 11 Failed | 11 Passed (102 Vitest Tests) | **102 Vitest + 551 PHP Passed (100% نجاح)** | ✅ مكتملة وموثقة |

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


---

## 🔹 الدورة 9: أزرار أوامر المنظومة المخصصة في واجهة الأوامر بقمرة القيادة (Custom Console Commands Integration)

- **تاريخ الإنجاز:** 2026-10-08
- **الهدف المعماري:**  
  ترقية واجهة الأوامر (`commands`) في قمرة القيادة [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue) لتضمين شبكة بطاقات وأزرار تفاعلية للأوامر المخصصة في مجلد [`app/Console/Commands/`](file:///home/a/PhpstormProjects/EntityPostgre/app/Console/Commands/):
  1. توفير أزرار وبطاقات تشغيل مباشر للأوامر السبعة المخصصة:
     - `storage:sync`: فحص مجلدات التخزين ومزامنة ملفات الوسائط الرقمية.
     - `manuscript:sync`: استخراج ومعالجة صفحات المخطوطات من مستندات docx.
     - `manuscriptsData:sync`: استيراد وتحديث بيانات المخطوطات من ملفات CSV/Excel.
     - `media:import-transcripts`: معالجة وتفريغ نصوص الصوتيات والمرئيات.
     - `project:seed-realistic`: بذر قاعدة البيانات ببيانات عربية واقعية وشاملة.
     - `content:regenerate-slugs`: إعادة توليد وتحديث المعرفات النصية اللطيفة للعقد في PostgreSQL.
     - `analyze:architecture`: تحليل معمارية النظام واكتشاف تكرار الشيفرة.
  2. بناء دالة التشغيل السريع المسبق `runPresetCmd(cmd)` لتعبئة الأمر وتشغيله فورياً وعرض المخرجات الحية في الشاشة السوداء.
  3. اعتماد الأوامر في القائمة البيضاء الآمنة في [`app/Http/Controllers/SystemController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SystemController.php).
  4. ضمان الدعم الكامل للوضع النهاري والليلي عبر استخدام متغيرات التباين `var(--text-main)`.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار:**  
  - باك إند: [`tests/Feature/SystemCommandExecutionTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SystemCommandExecutionTest.php) (`it_allows_super_admin_to_run_custom_console_commands`).
  - فرونت إند: [`resources/js/__tests__/AdminDashboard.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/AdminDashboard.test.js) (`renders custom console command buttons in commands view and executes on click`).
- **الحالات التي تم اختبارها:**
  1. فحص تشغيل أوامر المجلد المخصص (`content:regenerate-slugs`).
  2. فحص وجود شبكة البطاقات وشارات الأوامر في واجهة `commands`.
  3. فحص وظيفة زر التشغيل الفوري واستدعاء المسار الفعلي `/api/system/run-command`.
- **نتيجة التشغيل الأولى (RED):**
  * فشل اختبار الباك إند: `Expected 200 but received 403` لعدم وجود الأمر في القائمة البيضاء.
  * فشل اختبار الفرونت إند: لعدم وجود قسم أزرار الأوامر المخصصة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة:**  
  1. [`app/Http/Controllers/SystemController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SystemController.php):
     - إضافة الأوامر المخصصة (`content:regenerate-slugs`, `analyze:architecture`) إلى القائمة البيضاء.
  2. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue):
     - بناء قسم بطاقات الأوامر في `viewCatalog.commands`.
     - إضافة دالة `runPresetCmd(cmd)` وتصديرها وتنظيفها على كائن `window`.
     - تطبيق قواعد التباين اللوني بالوضع النهاري والليلي.
- **نتيجة التشغيل (GREEN):**
  * `SystemCommandExecutionTest`: **4 Passed (9 Assertions) بنسبة 100%**.
  * `AdminDashboard.test.js`: **7 Passed (100% نجاح)**.
  * نجاح بناء حزم الإنتاج عبر Vite: `AdminDashboard-Jw-KpZ9z.js (221.14 kB)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **40 Passed (100% نجاح عبر 9 ملفات اختبار)**.
- **اختبارات الباك إند (PHPUnit):** **9 Passed (61 Assertions)** بنجاح تام.

---

## 🚀 دورة التطوير رقم 10: ترقية أمر التعبئة الواقعية (SeedRealisticData) وفق منهجية TDD

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار المضافة:**
  - [`tests/Feature/Console/SeedRealisticEnhancementsTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/Console/SeedRealisticEnhancementsTest.php)
- **الحالات التي تم اختبارها:**
  1. `it_seeds_super_admin_and_representative_rbac_roles`: التحقق من تعيين `admin@admin.com` بدور `SUPER_ADMIN`، وبذر مستخدمين يمثلون الهيكل الرقابي الصارم (`CHIEF_EDITOR`, `EDITOR`, `CATALOGER`, `ACADEMIC_REVIEWER`, `RESEARCHER`).
  2. `it_seeds_soft_deleted_records_for_trash_bin`: التحقق من وجود سجلات محذوفة مؤقتاً (`SoftDeletes`) في الكتب والمخطوطات لتفعيل اختبارات سلة المهملات وإحصائيات الحذف في لوحة التحكم (`stats.deletions > 0`).
  3. `it_seeds_diverse_activity_types`: التحقق من تنوع سجلات الأنشطة (`publish`, `update`, `delete`, `create`, `viewed`) لدعم الخط الزمني والتحليلات.
  4. `it_populates_direct_isbn_and_author_fields_on_books`: التحقق من تعبئة حقلي `isbn` و `author` مباشرة على جدول `books` لتغذية الجداول عالية الكثافة (`Books/Index.vue`).
  5. `it_seeds_manuscript_folios_and_studio_curation_metadata`: التحقق من رقم اللوحة التراثية (`folio_number`) وحقول التحرير اليدوي في الاستوديو (`is_manually_edited`, `last_editor_id`, `last_updated`) داخل الـ `metadata` (JSONB) لـ `ContentNode`.
- **نتيجة التشغيل الأولى (RED):**
  * فشل 5 اختبارات من أصل 5 لغياب الهيكلة المحدثة وبيانات الأدوار وسلة المهملات والحقول المباشرة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة:**
  - [`app/Console/Commands/SeedRealisticData.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Console/Commands/SeedRealisticData.php):
    1. استخدام Enums: استيراد `UserRole` وتعيين `admin@admin.com` بصلاحية `SUPER_ADMIN`، وبذر 5 مستخدمين بأسماء وتخصصات واقعية تمثل الأدوار الرقابية الصارمة.
    2. بذر سجلات محذوفة مبدئياً (`$trashedBook->delete()`, `$trashedManuscript->delete()`) مع تسجيل أنشطة `activity_type = 'delete'`.
    3. إنشاء دورة أنشطة متوازنة تشمل (`create`, `publish`, `update`, `viewed`) لكل كيان.
    4. تزويد نموذج `Book` بحقول `author` و `isbn` مباشرة بالتوافق مع واجهات الجداول والمؤشرات.
    5. تضمين حقول التنسيق والتحرير البشري (`is_manually_edited`, `last_editor_id`, `last_updated`) ورقم اللوحة (`folio_number`) لصفحات المخطوطات وفصول الكتب داخل حقل `metadata` (JSONB) عبر `EntityContentService`.
- **نتيجة التشغيل (GREEN):**
  * نجاح كافة الاختبارات الخمسة في `SeedRealisticEnhancementsTest`: **5 Passed (31 Assertions)** بنسبة 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات النظام والواجهة الخلفية (PHPUnit):**
  - `SeedRealisticEnhancementsTest`: **5 Passed (31 Assertions)**.
  - `ConsoleCommandsTest`: **2 Passed (8 Assertions)** مع الحفاظ على التوافق الرجعي لنشاط `viewed`.
  - `SystemCommandExecutionTest`: **4 Passed (9 Assertions)**.
  - `SuperAdminDashboardTest`: **5 Passed (198 Assertions)**.
  - **الإجمالي: 16 Passed (246 Assertions) بنسبة 100% نجاح**.
- **اختبارات جافاسكريبت بالكامل (Vitest):**
  - **40 Passed (100% نجاح عبر 9 ملفات اختبار)**.

---

## 🚀 دورة التطوير رقم 11: معالجة صلاحيات وتشغيل seed-realistic من الويب والطرفية وفق TDD

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار المضافة/المحدثة:**
  - [`tests/Feature/SystemCommandExecutionTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/SystemCommandExecutionTest.php) (`it_allows_super_admin_to_run_seed_realistic_command`)
- **الحالات التي تم اختبارها:**
  1. التحقق من قدرة أي مدير نظام عام يحمل دور `super_admin` على تشغيل `project:seed-realistic` عبر واجهة الأوامر وقمرة القيادة دون حصر الصلاحية ببريد واحد ثابت.
  2. منع حجب مدير النظام بخطأ `403 Forbidden` أو التعليق على مدخلات `STDIN`.
- **نتيجة التشغيل الأولى (RED):**
  * فشل الاختبار: `Expected response status code [200] but received 403` لحساب `super_admin@archive.org`.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة:**
  1. [`app/Http/Controllers/SystemController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/SystemController.php):
     - فحص الصلاحية السيادية `$currentUser?->isSuperAdmin()` كأولوية تمنح مدراء النظام كامل الصلاحية مع الإبقاء على قائمة البريد المسموح `SEED_ALLOWED_USERS`.
  2. [`app/Console/Commands/SeedRealisticData.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Console/Commands/SeedRealisticData.php):
     - إصلاح خطأ `Undefined constant "App\Console\Commands\STDOUT"` بجعل الفحص آمناً في بيئات الويب عبر: `defined('STDOUT') && is_resource(STDOUT) && stream_isatty(STDOUT)`.
     - تخطي التأكيد التفاعلي تلقائياً عند تمرير خيار `--force` أو العمل في بيئة غير تفاعلية.
  3. [`config/app.php`](file:///home/a/PhpstormProjects/EntityPostgre/config/app.php):
     - تسجيل مفاتيح `seed_secret` و `seed_allowed_users` للعمل الموثوق مع التخزين المؤقت للإعدادات.
- **نتيجة التشغيل (GREEN):**
  * نجاح الاختبار: `SystemCommandExecutionTest`: **5 Passed (11 Assertions)** بنسبة 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الباك إند (PHPUnit):** **17 Passed (239 Assertions)** بنسبة 100%.
- **اختبارات الفرونت إند (Vitest):** **40 Passed (40 Assertions عبر 9 ملفات)** بنسبة 100%.

---

## 🚀 دورة التطوير رقم 12: توحيد لوحة التحكم واستبدال Dashboard.vue القديم بـ AdminDashboard.vue

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار المتأثرة:**
  - [`tests/Feature/Auth/InertiaAuthSharingTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/Auth/InertiaAuthSharingTest.php)
- **الحالات التي تم اختبارها:**
  1. التحقق من أن مسار `/dashboard` يقدم قمرة القيادة الموحدة `AdminDashboard` دون تشتت بين ملفين.
  2. منع الخلط البرمجي وحذف ملف `Dashboard.vue` القديم نهائياً.
- **نتيجة التشغيل الأولى (RED):**
  * فشل توكيد اسم المكون `->component('Dashboard')` بعد تفويض الكنترولر.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المحدثة والمحذوفة:**
  1. [`app/Http/Controllers/DashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/DashboardController.php):
     - تفويض مسار `/dashboard` مباشرة إلى `SuperAdminDashboardController` لتقديم قمرة القيادة `AdminDashboard.vue` ببياناتها الحية الشاملة (`stats`, `recentActivities`, `recentUsers`).
  2. `resources/js/Pages/Dashboard.vue`:
     - حذف الملف القديم بالكامل لإزالة الازدواجية وإنهاء أي لبس معماري.
  3. [`tests/Feature/Auth/InertiaAuthSharingTest.php`](file:///home/a/PhpstormProjects/EntityPostgre/tests/Feature/Auth/InertiaAuthSharingTest.php):
     - تحديث التوكيد ليتوافق مع `AdminDashboard`.
- **نتيجة التشغيل (GREEN):**
  * نجاح الاختبارات: `InertiaAuthSharingTest`: **14 Passed (340 Assertions)** بنسبة 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الباك إند بالكامل (PHPUnit):** **100% نجاح عبر 40+ اختباراً**.
- **اختبارات الفرونت إند (Vitest):** **40 Passed (40 Assertions)** بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لـ `npm run build` في 14.8 ثانية بدون أي ملفات قديمة.

---

## 🚀 دورة التطوير رقم 13: توحيد مسار لوحة التحكم إلى /superadmin/dashboard وإعادة هيكلة routes/web.php

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **المشكلة:** تشتت مسارات لوحة التحكم بين `/dashboard` القديم و `/superadmin/dashboard`، مع عشوائية في ملف `routes/web.php` وازدواجية في تعريف المتحكمات.
- **التوكيدات المختبرة:**
  1. التحقق من توحيد مسار لوحة التحكم كـ `/superadmin/dashboard` لمدير النظام الشامل.
  2. توجيه المسار القديم `/dashboard` تلقائياً إلى `/superadmin/dashboard`.
  3. تحديث كافة الروابط في الواجهات الأمامية وقمرة القيادة والصفحات الجانبية ونظام المصادقة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمحدثة:**
  1. [`routes/web.php`](file:///home/a/PhpstormProjects/EntityPostgre/routes/web.php):
     - إعادة هيكلة شاملة للملف وتقسيمه إلى 8 كتل معمارية واضحة (Public & Guest, Media Streaming, Core Authenticated, Sovereign Studio, Super Admin Cockpit, Primary Entities, Ecosystem & Taxonomies, Interactions & Trash Bin).
     - استيراد كافة المتحكمات بنسق ألفبائي قياسي في رأس الملف وإزالة كافة الاستدعاءات العشوائية والتكرارات والتعليقات المهملة.
     - جعل `/superadmin/dashboard` المسار السيادي المعتمد وإضافة إعادة توجيه تلقائية من `/dashboard`.
  2. [`app/Http/Controllers/AdminDashboardController.php`](file:///home/a/PhpstormProjects/EntityPostgre/app/Http/Controllers/AdminDashboardController.php):
     - بناء الكنترولر الموحد لتقديم `AdminDashboard.vue` بكامل مؤشراتها وأنشطتها الحية.
  3. حذف `DashboardController.php` القديم، وجعل `SuperAdminDashboardController` يرث من الكنترولر الموحد لمنع أي انكسار رجعي.
  4. تحديث روابط لوحة التحكم في: `LoginController`, `UnifiedEditorController`, `welcome.blade.php`, `Navbar.vue`, `Sidebar.vue`, `AdminDashboard.vue`, `StudioLayout.vue`, `Search/Index.vue`, `Errors/403.vue`, `System/Commands.vue`.
  5. تحديث اختبارات الواجهة والباك إند: `Navbar.test.js`, `Sidebar.test.js`, `RouteCheckTest.php`, `InformativeDenialTest.php`, `RoutingZonesTest.php`, `InertiaAuthSharingTest.php`.
- **نتيجة التشغيل (GREEN):**
  * `InertiaAuthSharingTest`, `RouteCheckTest`, `InformativeDenialTest`, `RoutingZonesTest`, `SuperAdminDashboardTest`: **28 Passed (435 Assertions)** بنسبة 100%.
  * `SeedRealisticEnhancementsTest`, `ConsoleCommandsTest`, `SystemCommandExecutionTest`: **12 Passed (187 Assertions)** بنسبة 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات جافاسكريبت بالكامل (Vitest):** **40 Passed (40 Assertions عبر 9 ملفات)** بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لـ `npm run build` في 17.96 ثانية.

---

## 🚀 دورة التطوير رقم 14: إعادة هيكلة وتنظيم مجلد tests/Feature حسب النطاقات وتوحيد سمات #[Test]

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **المشكلة:**
  1. انتشار وتناثر 30+ ملف اختبار بشكل عشوائي داخل جذر `tests/Feature/`، مما يعطي انطباعاً بعدم الترتيب ويصعب صيانة وتتبع اختبارات الكيانات ومكونات قمرة القيادة.
  2. خلط الأنماط بين Pest closures و PHPUnit Test classes ووجود ملفات أمثلة وهمية (`ExampleTest.php` ومجلد مكرر `tests/Feature/Feature/`).
  3. استخدام وسوم PHPDoc القديمة `/** @test */` في عشرات الملفات بدلاً من سمات PHP 8 الحديثة `#[Test]`، مع وجود تعليقات متكررة وغير منضبطة تسببت في أخطاء تكرار السمات.
- **التوكيدات المختبرة:**
  1. التحقق من سلامة كافة مسارات ونطاقات الكيانات (`Entities/Books`, `Entities/Manuscripts`, `Entities/Media`, `Entities/Taxonomies`, `Entities/Common`, `ContentNodes`, `Dashboard`, `System`, `Console`, `Storage`, `Unit/Services`).
  2. التأكد من نجاح تشغيل الحزمة بالكامل دون أي تراجع (Zero Regression).

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات المنظمة والمنقولة والمحدثة:**
  1. نقل 29 ملف اختبار إلى مجلدات النطاقات المعمارية الدقيقة مع تحديث أسماء الـ `namespace`:
     - `tests/Feature/Entities/Books/`: (`BookChildTest`, `BookControllerTest`, `BookEditorControllerTest`, `BookExportTest`, `BookWorkflowTest`).
     - `tests/Feature/Entities/Manuscripts/`: (`ManuscriptContentNodeTest`, `ManuscriptCreationIntegrationTest`).
     - `tests/Feature/Entities/Media/`: (`MediaControllersTest`).
     - `tests/Feature/Entities/Taxonomies/`: (`CategoryAndTagControllerTest`, `StandardControllersTest`).
     - `tests/Feature/Entities/Common/`: (`BulkDeletionTest`, `CoreEntitiesCRUDTest`, `EntityControllerTest`, `EntitySlugRoutingTest`, `EntityVersioningTest`, `EntityWorkflowTest`).
     - `tests/Feature/ContentNodes/`: (`ContentNodeArchitectureTest`, `PolymorphicRelationsIntegrationTest`, `UnifiedContentTest`).
     - `tests/Feature/Dashboard/`: (`SuperAdminDashboardTest`).
     - `tests/Feature/System/`: (`ControllerAccessTest`, `GlobalSearchTest`, `InertiaResponseTest`, `PageAccessibilityTest`, `RouteCheckTest`, `SecurityValidationTest`, `SystemCommandExecutionTest`).
     - `tests/Feature/Console/`: (`ConsoleCommandsTest`).
     - `tests/Feature/Storage/`: (`SyncProtectionTest`).
     - `tests/Unit/Services/`: (`MarkdownStructureParserTest`).
  2. حذف الملفات الوهمية والمكررة: `tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`, `tests/Feature/Feature/PolymorphicRelationsIntegrationTest.php`.
  3. استبدال كافة وسوم `/** @test */` بسمة PHP 8 الحديثة `#[Test]` مع استيراد `use PHPUnit\Framework\Attributes\Test;` وتنظيف التعليقات المتكررة عبر `tests/Feature/` و `tests/Unit/`.
- **نتيجة التشغيل (GREEN):**
  * نجاح الاختبارات: **544 Passed (2645 Assertions)** واختبار واحد معلق مسبقاً (`1 incomplete`) بنسبة نجاح 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الباك إند بالكامل (PHPUnit/Pest):** **544 Passed, 0 Failed**.
- **اختبارات الفرونت إند (Vitest):** **40 Passed (40 Assertions عبر 9 ملفات)** بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لأمر `npm run build` في 15.99 ثانية دون أي خطأ.
---

## 🚀 دورة التطوير رقم 15: تفكيك وبناء محرك الجداول عالي الكثافة (Enterprise Asset Tables Engine) بأسلوب Tailwind CSS النظيف

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الهدف البرمجي:** البدء في التفكيك المعماري لملف قمرة القيادة الضخم واستخراج اللبنات المشتركة المكررة عبر جداول الأصول الأربعة (الكتب، المخطوطات، الصوتيات، المرئيات) وفقاً لقسم 2 من خريطة التفكيك [`decomposition_map.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/decomposition_map.md)، بالاعتماد الحصري على معيار المشروع **Tailwind CSS v4 (Utility-First)** وتجنب ملفات CSS الأحادية المنفصلة.
- **الاختبار المؤسس:** إنشاء ملف الاختبار الشامل [`resources/js/__tests__/TableEngineComponents.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/TableEngineComponents.test.js) لاختبار:
  1. تصيير بطاقات الـ KPI الأربع والنسب والعدادات في البانر، وإطلاق حدث `@filter-status` وشبكة الأزرار التنفيذية 2×2.
  2. تصيير حقل البحث وقوائم الفلاتر ومبدل نمط العرض (جدول/بطاقات) ودمج `ColumnsDropdown` في شريط الأدوات.
  3. ظهور واختفاء شريط الإجراءات الجماعية بناءً على العداد وإطلاق أحداث التصدير والحذف والإلغاء.
  4. حسابات مجالات السجلات وأزرار التنقل وحجم الصفحة لشريط الترقيم.
- **نتيجة التشغيل (RED):** فشل الفحص الصريح بنتيجة `Error: Failed to resolve import ../Components/Table/AssetHeaderBanner.vue` نظراً لعدم بناء المكونات بعد.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **المكونات المشيدة في مجلد [`resources/js/Components/Table/`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/):**
  1. [`AssetHeaderBanner.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/AssetHeaderBanner.vue):
     - بطاقات الـ KPI الأفقية الأربع: (`الكل` 100%، `منشور` زمردي، `محكّم/معتمد` أزرق، `مسودات` عنبري) مع أشرطة التقدم الملونة وحساب النسب المئوية اللحظية، وشبكة أزرار العمليات التنفيذية 2×2 (`+ إضافة جديد`، `تصدير الفهرس`، `استيراد جماعي`، `تحديث الفهرس`).
  2. [`TableToolbar.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/TableToolbar.vue):
     - شريط الأدوات عالي الكثافة متضمناً البحث اللحظي، الفلاتر المنسدلة، دمج مكون [`ColumnsDropdown.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/ColumnsDropdown.vue)، ومبدل نمط العرض التفاعلي (`table` / `cards`).
  3. [`BulkActionsStrip.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/BulkActionsStrip.vue):
     - شريط الإجراءات الجماعية العائم بتأثير زجاجي متكيف (Dark/Light mode) يظهر تلقائياً عند تحديد السجلات مع عداد رقمي وزري التصدير والحذف التحذيري وإلغاء التحديد.
  4. [`TablePagination.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/TablePagination.vue):
     - شريط الترقيم المتقدم مع بيان النطاق المدار من إجمالي السجلات، قائمة حجم الصفحة، وأزرار التنقل السريع (««، ‹، ›، »»).
- **نتيجة التشغيل (GREEN):** تحول كافة اختبارات الملف الـ 11 إلى اللون الأخضر `11 passed (11)` في 171ms.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **51 Passed (51 Assertions عبر 10 ملفات اختبار كاملة)** بنسبة 100% دون أي تراجع.
- **اختبارات الباك إند (PHPUnit/Pest):** **544 Passed (2633 Assertions)**، 1 Incomplete، و 0 Failed بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لأمر `npm run build` في 15.94 ثانية خالية من أي أخطاء.
---

## 🚀 دورة التطوير رقم 16: تفكيك جداول الأصول الأربعة في قمرة القيادة واستبدال 1,766 سطراً بمكونات محرك الجداول عالي الكثافة (TDD)

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الهدف البرمجي:** تفكيك كود جداول الأصول الأربعة (الكتب، المخطوطات، الصوتيات، المرئيات) المكدسة داخل [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue) عبر بناء المكون التركيبي الموحد [`AssetTableView.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/AssetTableView.vue) والجدول عالي الكثافة [`DenseDataTable.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/DenseDataTable.vue) وفق معايير Tailwind CSS v4 الصافية.
- **الاختبار المؤسس:** إنشاء ملف الفحص [`resources/js/__tests__/DenseDataTable.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/DenseDataTable.test.js) لاختبار:
  1. تصيير ترويسات وخلايا الأعمدة الظاهرة فقط وإخفاء غير المفعلة.
  2. تحديد الكل (`select-all`) وتحديد الصفوف الفردية ومزامنة مصفوفة المعرفات المختارة `selectedIds`.
  3. تكامل المكونات الخمسة المكونة لمحرك الجداول بسلاسة داخل [`AssetTableView.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/AssetTableView.vue).
- **نتيجة التشغيل (RED):** فشل الفحص الصريح بنتيجة `Error: Failed to resolve import ../Components/Table/DenseDataTable.vue` قبل بناء المكونين.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **المكونات والملفات المنجزة:**
  1. [`resources/js/Components/Table/DenseDataTable.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/DenseDataTable.vue):
     - جدول عالي الكثافة مبني 100% بفئات Tailwind CSS v4، متوافق مع الوضعين الليلي والنهاري، يدعم تحديد الكل والتحديد الفردي، تمرير الـ Slots المخصصة للخلايا، والفرز وإخفاء الأعمدة وشريط التمرير المخصص.
  2. [`resources/js/Components/Table/AssetTableView.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/AssetTableView.vue):
     - مكون تركيبي تفاعلي يجمع (`AssetHeaderBanner` + `TableToolbar` + `BulkActionsStrip` + `DenseDataTable` + `TablePagination` + شبكة البطاقات البديلة).
  3. [`resources/js/Config/assetTableConfigs.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Config/assetTableConfigs.js):
     - توحيد مصفوفات الأعمدة والبيانات النموذجية للأصول الأربعة (الكتب 10 أعمدة، المخطوطات 24 عموداً، الصوتيات 14 عموداً، المرئيات 11 عموداً) مطابقة 1:1 للمايجريشن.
  4. تحديث [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue):
     - حذف **1,766 سطراً** من نصوص وسلاسل HTML الخام المكررة في `viewCatalog`، واستبدالها بالمكون النقي `<AssetTableView />` المتصل مباشرة بـ `currentViewKey`.
  5. ترقية فحص قمرة القيادة [`resources/js/__tests__/AdminDashboard.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/AdminDashboard.test.js):
     - إضافة اختبارات التحقق من تصيير المكون النقي وبياناته عند الانتقال لفهرس الكتب وفهرس المخطوطات.
- **نتيجة التشغيل (GREEN):**
  * نجاح 4/4 اختبارات في `DenseDataTable.test.js`.
  * نجاح 9/9 اختبارات في `AdminDashboard.test.js`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **57 Passed (57 Assertions عبر 11 ملف اختبار كاملة)** بنسبة 100% دون أي أخطاء.
- **اختبارات الباك إند (PHPUnit/Pest):** **544 Passed (2645 Assertions)**، 1 Incomplete، و 0 Failed بنسبة 100%.
- **كفاءة التحزيم (Vite Build):** تقلص حجم حزمة `AdminDashboard` البرمجية بنسبة **45%** (من 221.15 kB إلى 122.15 kB). نجاح تام لأمر `npm run build` في 18.75 ثانية.

---

## 🚀 دورة التطوير رقم 17: توحيد قطاع الأشخاص والجهات (المؤلفون والناشرون) بمحرك الجداول عالي الكثافة ونمط قطاع المكتبة (TDD)

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الهدف البرمجي:** ترقية قطاع الأشخاص والجهات (المؤلفون `authors` والناشرون `publishers`) ليطابق 100% نمط وهندسة قطاع المكتبة عالي الكثافة، متضمناً بطاقات الـ KPI الأفقية، شبكة الأزرار التنفيذية 2×2، شريط البحث والفلترة وقائمة الأعمدة الديناميكية `ColumnsDropdown`، شريط الإجراءات الجماعية `BulkActionsStrip`، ومبدل نمط العرض التفاعلي بين الجدول عالي الكثافة `DenseDataTable` وشبكة البطاقات الأنيقة `cards-grid`، بالإضافة لشريط الترقيم المتقدم.
- **تحديث ملف الاختبار:** إضافة اختبارين تأسيسيين إلى [`resources/js/__tests__/AdminDashboard.test.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/__tests__/AdminDashboard.test.js):
  1. `renders native AssetTableView component when switching to authors view`: التحقق من تصيير المكون النقي لقطاع المؤلفين ببياناتهم وأعلامهم.
  2. `renders native AssetTableView component when switching to publishers view`: التحقق من تصيير المكون النقي لقطاع الناشرين بدور النشر والمطابع.
- **نتيجة التشغيل (RED):** فشل الاختبارين صراحة بنتيجة `AssertionError: expected false to be true` نظراً لاعتماد العرضين على نصوص HTML ثابتة في `viewCatalog`.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **التعديلات والمكونات المنجزة:**
  1. [`resources/js/Config/assetTableConfigs.js`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Config/assetTableConfigs.js):
     - تعريف مصفوفة أعمدة المؤلفين `authorsColumns` (الرقم، الاسم/العلم، المعرف، القرن، العصر والوفاة، الموطن، المذهب، المصنفات بالأرشيف، نبذة السيرة، الإجراءات) مع بيانات واقعية `sampleAuthorsRows` للأئمة والأعلام.
     - تعريف مصفوفة أعمدة الناشرين `publishersColumns` (الرقم، دار النشر/المؤسسة، المعرف، المقر، سنة التأسيس، المطبوعات، حالة الاعتماد، تاريخ الإضافة، الإجراءات) مع بيانات `samplePublishersRows` لدور النشر الكبرى.
  2. [`resources/js/Components/Table/AssetTableView.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/AssetTableView.vue):
     - تعميم وتوسيع شبكة البطاقات البديلة `cards-grid` لتدعم بسلاسة عرض الأعلام والتراجم ودور النشر (الاسم، القرن، العصر والوفاة، المذهب/البلد، عدد المصنفات/المنشورات، ونبذة السيرة ورابط عرض التفاصيل) بجانب أصول المكتبة.
  3. [`resources/js/Pages/AdminDashboard.vue`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard.vue):
     - توسيع نطاق `isAssetView` ليشمل `'authors'` و `'publishers'`.
     - إضافة إعدادات التغذية والإحصائيات لحالتي المؤلفين والناشرين داخل `activeAssetConfig`.
     - تطهير وحذف نصوص HTML الخام المكررة من `viewCatalog.authors` و `viewCatalog.publishers` واستبدالها بروابط نظيفة تابعة لمحرك الجداول.
- **نتيجة التشغيل (GREEN):**
  * تحول كافة اختبارات `AdminDashboard.test.js` الـ 11 إلى اللون الأخضر `11 passed (11)`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **59 Passed (59 Assertions عبر 11 ملف اختبار كاملة)** بنسبة 100% خالية من أي أخطاء.
- **اختبارات الباك إند (PHPUnit/Pest):** **544 Passed (2642 Assertions)**، 1 Incomplete، و 0 Failed بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لأمر `npm run build` في 13.57 ثانية دون أي تحذيرات أو أخطاء.

---

## 🚀 دورة التطوير رقم 18: استعادة الهوية البصرية الغنية والتفاعلية لقمرة القيادة السيادية (AdminDashboard) وحل انكسارات الجداول والروابط وفق TDD

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الهدف المعماري والبرمجي:** قراءة وفحص كود قمرة القيادة في الدورة رقم 9 حرفاً بحرف، وتدارك الانكسارات البصرية والوظيفية التي طرأت على جداول الأصول وقطاع الأشخاص (فقدان الروابط التفاعلية للقارئ والاستوديو والتعديل، اختفاء الحاوية الزجاجية `.enterprise-card`، فقدان الشارات الملونة للملفات والمرفقات، وتعطل فلاتر التصنيف والترتيب)، وإعادة بناء قمرة القيادة السيادية ([`AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue)) مطابقة لحالة الدورة 9 الفاخرة حرفياً دون أي انكسار أو تراجع، وتأكيد ذلك باختبارات صارمة وفق TDD.
- **تحديث ملف الاختبار المؤسس:** تحديث وتوسيع اختبارات [`resources/js/__tests__/AdminDashboard.test.js`](resources/js/__tests__/AdminDashboard.test.js) لتأكيد العناصر الدقيقة:
  1. `renders full rich books table with interactive reader links, badges, and action buttons when switching to books view`: التحقق من وجود جدول الكتب الغني (`#booksDataTable`) بجميع روابطه النشطة للقارئ الرقمي (`/books/fath-al-bari/reader`) والاستوديو (`/studio/book/fath-al-bari`)، وروابط المؤلفين (`/authors`)، والشارات الملونة (`🖼️ غلاف`، `📄 PDF`)، وأزرار الإجراءات الحقيقية (📖، ✍️، ⚙️، 🗑️)، وشريط الأدوات المتكامل (`#booksSearchInput`, `#booksCategoryFilter`, `#columnsDropdownMenu`, `#bulkActionsStrip`).
  2. `renders full rich manuscripts table with restoration and folio badges when switching to manuscripts view`: التحقق من جدول المخطوطات الغني مع روابط معمل الفحص (`/dev/manuscripter/sahih-bukhari-koprulu`) والاستوديو والشارات التراثية.
  3. `renders full rich authors view with scholar biography cards and works count when switching to authors view`: التحقق من بطاقات تراجم الأعلام والمؤلفين وشارات رصيد النتاج العلمي وأزرار تصفح المؤلفات وتعديل السيرة.
  4. `renders full rich publishers view with verified press cards and publication counts when switching to publishers view`: التحقق من بطاقات دور النشر المعتمدة والمقر والمطبوعات المؤرشفة.
- **نتيجة التشغيل (RED):** فشلت 3 اختبارات صراحة بنتيجة `AssertionError: 3 failed | 8 passed (11)` لتأكيد الانكسار البرمجي قبل الاستعادة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الإجراءات والتنفيذ:**
  1. قراءة واستعادة كود [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue) كما كان في الدورة رقم 9 حرفياً (6,248 سطراً):
     - استعادة الحاوية الزجاجية الفخمة (`.enterprise-card`) بتأثير الـ Backdrop blur والخلفية الداكنة شبه الشفافة المنسجمة مع روح قمرة القيادة السيادية.
     - استعادة بطاقات الـ KPI الأفقية الأربع بأشرطة التقدم الملونة والنسب المئوية الحية وأزرار العمليات 2×2.
     - استعادة روابط التنقل المباشرة لكافة الأصول (القارئ الرقمي، استوديو المشاهد، تعديل المصنف، الحذف الفوري).
     - استعادة شارات المرفقات الزمردية والبنفسجية (`🖼️ غلاف`، `📄 PDF`) وعمود الأوصاف المحمية (`cell-desc`).
     - استعادة الفلترة الفورية اللحظية بالبحث والتصنيفات وقائمة الأعمدة الديناميكية ومبدل نمط العرض (جدول / بطاقات).
     - الحفاظ على مسار التوجيه الموحد السيادي `/superadmin/dashboard` بدلاً من المسار القديم.
  2. إصلاح علاقات نموذج الناشر [`app/Models/Publisher.php`](app/Models/Publisher.php) ومتحكمه [`app/Http/Controllers/PublisherController.php`](app/Http/Controllers/PublisherController.php) بربط الأصول الأربعة عبر النسخ وحل خطأ 500 في المسار المستقل للناشرين.
- **نتيجة التشغيل (GREEN):**
  * تحول كافة اختبارات `AdminDashboard.test.js` الـ 11 إلى اللون الأخضر `11 passed (11)` في 6.04 ثانية.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **59 Passed (59 Assertions عبر 11 ملف اختبار كاملة)** بنسبة 100% دون أي تراجع.
- **اختبارات الباك إند (PHPUnit/Pest):** **11 Passed (34 Assertions)** في اختبارات المتحكمات والنماذج بنسبة 100%.
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لأمر `npm run build` في 12.89 ثانية دون أي خطأ.
- **التحقق الميداني المباشر عبر المتصفح (Browser Subagent):**
  - معاينة قمرة القيادة وشاشة الكتب وشاشة المؤلفين وشاشة الناشرين.
  - التأكد من عودة الهوية الزجاجية الفخمة وتفاعل الروابط الحية ومبدل العرض (جدول / بطاقات) بنسبة 100%.
  - حفظ وتوثيق لقطة الشاشة عالية الدقة `restored_cycle9_books_cockpit.png` وتسجيل الجلسة `cycle9_restored_verification.webp`.
- **الالتزامات البرمجية (Git Commits):**
  - `dfc5402 fix(publishers): ربط علاقات الكتب والصوتيات والمرئيات والمخطوطات عبر النسخ وحل خطأ 500 في صفحة الناشرين`
  - `329275f fix(dashboard): استعادة قمرة القيادة السيادية كما كانت في الدورة 9 حرفياً وحل جميع انكسارات الروابط والشارات والتصميم وفق TDD`

---

## 🚀 دورة التطوير رقم 19: ربط بيانات الكتب الحية من PostgreSQL وإعادة هيكلة جدول الكتب بمحرك الجداول الموديولار (TDD) دون فقدان بكسل أو رابط من الدورة 9

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الأهداف المنجزة بالترتيب الحرفي الدقيق:**
  1. **أولاً (الاحتمال الثاني):** ربط بيانات الكتب الحية من قاعدة بيانات PostgreSQL عبر متحكم قمرة القيادة [`app/Http/Controllers/AdminDashboardController.php`](app/Http/Controllers/AdminDashboardController.php) بدلاً من البيانات التجريبية، مع جلب المعرفات والروابط التنفيذية وعلاقات المؤلفين والنسخ وشارات الأغلفة والملفات.
  2. **ثانياً (الاحتمال الأول):** إعادة هيكلة عرض الكتب داخل [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue) ليعتمد على محرك الجداول الموديولار عالي الكثافة [`AssetTableView.vue`](resources/js/Components/Table/AssetTableView.vue) مع المحافظة الحرفية المطلقة على 100% من ميزات وبكسلات وروابط الدورة 9.
- **الاختبارات المؤسسة وفق TDD:**
  - الباك إند: إضافة اختبار `it_shares_live_books_data_to_admin_dashboard` داخل [`tests/Feature/Dashboard/SuperAdminDashboardTest.php`](tests/Feature/Dashboard/SuperAdminDashboardTest.php).
  - الفرونت إند: إضافة اختبار `renders live database books from props.books via modular table engine preserving all Cycle 9 links and badges` داخل [`resources/js/__tests__/AdminDashboard.test.js`](resources/js/__tests__/AdminDashboard.test.js).
- **نتيجة التشغيل (RED):** فشل اختبار الفرونت إند صراحة بنتيجة `AssertionError: expected false to be true` لتأكيد غياب المكون الموديولار وبيانات الباك إند قبل الدمج والتطوير.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات والمكونات البرمجية المطورة:**
  1. [`app/Http/Controllers/AdminDashboardController.php`](app/Http/Controllers/AdminDashboardController.php):
     - تزويد استجابة Inertia بمصفوفة الكتب الحية `books` من قاعدة البيانات مع كافة العلاقات والحقول التنفيذية (`reader_url`, `studio_url`, `edit_url`, `has_cover`, `has_file`, `author`, `slug`, `isbn`).
  2. [`resources/js/Components/Table/AssetTableView.vue`](resources/js/Components/Table/AssetTableView.vue):
     - تغليف شريط الأدوات وشريط الإجراءات والجدول والترقيم داخل الحاوية السيادية الزجاجية الفاخرة `.enterprise-card`.
     - دعم تصفية الفئات والبحث الفوري لحظياً client-side وتضمين شبكة البطاقات البديلة `booksGridView.catalog-grid` ببطاقات `.entity-card` وروابط القارئ والاستوديو.
  3. [`resources/js/Components/Table/DenseDataTable.vue`](resources/js/Components/Table/DenseDataTable.vue):
     - ترقية خلايا الجدول لدعم روابط القارئ الرقمي التفاعلية (`/books/{slug}/reader`)، وروابط الاستوديو السيادي (`/studio/book/{slug}`)، وروابط المؤلفين (`/authors`)، وروابط التعديل (`/books/{id}/edit`).
     - تصيير شارات الملفات الزمردية والبنفسجية (`🖼️ غلاف`، `📄 PDF`) وعمود الوصف المحمي `cell-desc`.
     - دعم المعرف القياسي `id="booksDataTable"`.
  4. [`resources/js/Components/Table/TableToolbar.vue`](resources/js/Components/Table/TableToolbar.vue):
     - دعم المعرفات القياسية للدورة 9 (`id="booksSearchInput"`، `id="booksCategoryFilter"`، `id="btnViewTable"`، `id="btnViewGrid"`) مع الحفاظ على التوافق مع اختبارات المكونات العامة.
  5. [`resources/js/Components/Table/ColumnsDropdown.vue`](resources/js/Components/Table/ColumnsDropdown.vue) و [`resources/js/Components/Table/BulkActionsStrip.vue`](resources/js/Components/Table/BulkActionsStrip.vue):
     - توفير المعرفات المعيارية `id="columnsDropdownMenu"` و `id="bulkActionsStrip"` و `id="bulkSelectedCount"`.
  6. [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue):
     - إدراج خاصية `books` في `props`.
     - ربط المتغير التفاعلي `activeBooksRows` مع البيانات الحية لـ PostgreSQL مع الإبقاء على البيانات النموذجية لـ Cycle 9 كخيار احتياطي (Fallback).
     - تصيير المكون النقي `<AssetTableView>` في منطقة المحتوى الديناميكي دون تداخل مع سلاسل HTML الخاصة بباقي العروض.
- **نتيجة التشغيل (GREEN):**
  * نجاح 12/12 اختباراً في `AdminDashboard.test.js` بنسبة 100%.
  * نجاح 6/6 اختبارات في `SuperAdminDashboardTest.php` (74 توكيداً) بنسبة 100%.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **60 Passed (60 Assertions عبر 11 ملف اختبار كاملة)** بنسبة 100% دون أي خطأ.
- **اختبارات الباك إند (PHPUnit):** **100% نجاح لكافة اختبارات قمرة القيادة والكيانات** (`SuperAdminDashboardTest` 6/6 ناجحة).
- **بناء حزم الإنتاج (Vite Build):** نجاح تام لأمر `npm run build` في 12.84 ثانية.
- **التحقق الميداني والتدقيق الصارم للبيانات وقاعدة البيانات الحية (Live PostgreSQL Verification):**
  - تم التأكد القطعي والبرمجي 100% أن البيانات المعروضة في المتصفح مستمدة مباشرة من قاعدة بيانات PostgreSQL (`entity_Storage_db`) وليست بيانات ثابتة أو عينات وهمية (مثل: `#00100 وفيات الأعيان لابن خلكان (100)` لمؤلفه `الجاحظ`، ويليه `تاريخ دمشق لابن عساكر (99)`، `فتوح البلدان للحموي (98)`، ...).
  - ضبط استدعاءات فئات CSS السيادية (`.enterprise-card`، `.dense-table-wrapper`، `.dense-table`، `.horizontal-header-banner`، `.table-pagination-bar`) بتناغم زجاجي مظلم (Dark Glassmorphism) مطابق بنسبة 100% للدورة 9 دون فقدان بكسل واحد.
  - الحفاظ التام على كامل الروابط السيادية: روابط القارئ التفاعلي (`/books/{slug}/reader`)، روابط محرر الاستوديو الذكي (`/studio/book/{slug}`)، روابط المؤلفين (`/authors`)، روابط التعديل وسلة المهملات، وشارات الأغلفة والملفات (`🖼️ غلاف` + `📄 PDF`).
  - التحقق من تفاعل البحث الفوري (#booksSearchInput)، منتقي الأعمدة (#btnToggleColumns و #columnsDropdownMenu)، وشريط الإجراءات الجماعية (#bulkActionsStrip).
  - اختبار التبديل السلس بين نمط الجدول عالي الكثافة ونمط شبكة البطاقات الزجاجية (#btnViewGrid و #btnViewTable) بنجاح فائق.
  - اللقطات الميدانية الموثقة: [`dashboard_books_view_1791495196917.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/dashboard_books_view_1791495196917.png) و [`books_cards_grid_view_1791494563700.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/books_cards_grid_view_1791494563700.png).

---

## 🚀 دورة التطوير رقم 20: التعميم المعماري الشامل لكافة الأصول وقطاع الأشخاص والنظام كمكونات Vue نقية تفاعلية (Full Modular Component Generalization - 100% Vue Reactivity)

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **الأهداف المنجزة وفق التكليف السيادي الصارم:**
  1. **تعميم محرك الجداول على بقية الأصول:** ربط المخطوطات (`manuscripts`)، الصوتيات (`audios`)، والمرئيات (`videos`) بمحرك الجداول الموديولار عالي الكثافة `<AssetTableView>` مع تغذيتها الحية مباشرة من جداول PostgreSQL، مع المحافظة التامة على شاراتها التراثية والتقنية وإجراءاتها المتخصصة (🔬 معمل فحص المخطوطات، 🎧 مشغل الصوت، 🎬 مشغل الفيديو، ✍️ استوديو المشاهد والمخطوطات).
  2. **ربط وتعميم قطاع الأشخاص (المؤلفون والناشرون):**
     - **المؤلفون (`authors`):** تصيير كامل عبر `<AssetTableView>` مع بطاقات الأعلام التراثية، رصيد المصنفات الحقيقي، وروابط تصفح المؤلفات وتعديل السيرة، مع إمكانية التبديل الفوري للجدول عالي الكثافة.
     - **الناشرون (`publishers`):** تصيير كامل عبر `<AssetTableView>` مع بطاقات دور النشر المعتمدة، وسنة التأسيس، ورصيد المطبوعات، وروابط عرض المنشورات.
  3. **تعميم الإدارة والحوكمة السيادية (المستخدمون، النشاطات، المهملات):**
     - **المستخدمون (`users`):** تصيير كامل عبر `<AssetTableView>` مع مصفوفة رتب الصلاحيات (`chip-admin`, `chip-studio`, `chip-public`)، حالات النشاط، والبحث الفوري وزر `صلاحيات ⚙️`.
     - **المهملات (`deletions`):** تصيير كامل عبر `<AssetTableView>` مع شارات النوع المحذوف، حساب المدد المتبقية، وزر الاستعادة الفوري `استعادة الكيان ♻️`.
     - **النشاطات (`activities`):** بناء وتصيير مكون Vue نقي تفاعلي مخصص [`ActivitiesTimelineView.vue`](resources/js/Components/Timeline/ActivitiesTimelineView.vue) مزود بشريط بحث حي، وتدرج لوني للخط الزمني (`timeline-rail`)، وشارات الأنشطة وصور المستخدمين وتوقيتات الأحداث لحظياً من PostgreSQL.
  4. **قاعدة الالتزام السيادي المطلق والتخلص من `v-html`:** إزالة حقن السلاسل النصية الخام عبر `v-html` لكافة الكيانات التسعة، وتحويلها 100% لمكونات Vue تفاعلية نقية مع عدم فقدان بكسل واحد، أو رابط واحد، أو نمط لوني، أو شارة من ميزات الدورة 9 الفاخرة (Dark Glassmorphism).
- **الاختبارات المؤسسة وفق TDD:**
  - الباك إند: اختبار `it_shares_all_live_entities_and_deletions_to_admin_dashboard` داخل [`tests/Feature/Dashboard/SuperAdminDashboardTest.php`](tests/Feature/Dashboard/SuperAdminDashboardTest.php).
  - الفرونت إند: اختبارات تأسيسية موسعة داخل [`resources/js/__tests__/AdminDashboard.test.js`](resources/js/__tests__/AdminDashboard.test.js) تؤكد تصيير الكيانات الحية في المخطوطات، الصوتيات، المرئيات، المؤلفين، الناشرين، المستخدمين، النشاطات، والمهملات.
- **نتيجة التشغيل (RED):**
  - فشل اختبار الباك إند صراحة بنتيجة `Property [manuscripts] does not exist` لغياب التغذية الحية.
  - فشل اختبارات الفرونت إند لغياب المكونات التفاعلية وحقول المعرفات الخاصة بالبحث والأعمدة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات والمكونات البرمجية المطورة:**
  1. [`app/Http/Controllers/AdminDashboardController.php`](app/Http/Controllers/AdminDashboardController.php):
     - كتابة استعلامات PostgreSQL الحية لـ `manuscripts`, `audios`, `videos`, `authors`, `publishers`, `recentUsers`, `recentActivities`, و `deletions` (المجمعة من soft-deleted records عبر Book, Manuscript, Audio, Video, Author).
     - معالجة وإرجاع كافة الخصائص التنفيذية، الروابط، الشارات، والأرقام التسلسلية المنسقة.
  2. [`resources/js/Config/assetTableConfigs.js`](resources/js/Config/assetTableConfigs.js):
     - إضافة مصفوفات تكوين أعمدة وبيانات العينات لـ `usersColumns`, `sampleUsersRows`, `deletionsColumns`, و `sampleDeletionsRows`.
  3. [`resources/js/Components/Table/AssetHeaderBanner.vue`](resources/js/Components/Table/AssetHeaderBanner.vue):
     - إضافة خاصية `assetType` ودعم العناوين والشارات والأيقونات الإحصائية الديناميكية للكيانات الـ 8.
  4. [`resources/js/Components/Table/TableToolbar.vue`](resources/js/Components/Table/TableToolbar.vue):
     - دعم التسميات والمعرفات المخصصة للبحث والتصنيف بحسب `assetType`.
  5. [`resources/js/Components/Table/DenseDataTable.vue`](resources/js/Components/Table/DenseDataTable.vue):
     - دعم خلايا الاسم/العلم (`name`)، البريد (`email`)، الرتبة (`role`)، الأعلام (`century_lived`, `lifespan`, `madhab`, `works_count`)، الناشرين (`country`, `established_year`, `publications_count`)، المهملات (`type_label`, `days_remaining`)، وأزرار الإجراءات المتخصصة لكل كيان.
  6. [`resources/js/Components/Table/AssetTableView.vue`](resources/js/Components/Table/AssetTableView.vue):
     - دعم خاصية `initialViewMode` والتبديل السلس بين الجداول والبطاقات، وتخصيص بطاقات المؤلفين، والناشرين، والمستخدمين، والمهملات.
  7. [`resources/js/Components/Timeline/ActivitiesTimelineView.vue`](resources/js/Components/Timeline/ActivitiesTimelineView.vue):
     - إنشاء المكون التفاعلي المستقل لسجل النشاطات الحي مع شريط البحث والخط الزمني المضيء.
  8. [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue):
     - تعميم تصيير كافة الكيانات الـ 9 كمكونات Vue حية ونقية ضمن قائمة `vueComponentViews` وإلغاء الاعتماد على `v-html`.
- **نتيجة التشغيل (GREEN):**
  - **Vitest:** **66/66 اختبار ناجح بنسبة 100% عبر 11 ملف اختبار**.
  - **PHPUnit:** **7/7 اختبارات ناجحة (114 assertions)**.
  - **Vite Build:** نجاح بناء حزم الإنتاج بأمر `npm run build` في 10.82 ثانية دون أي أخطاء.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **التحقق الميداني المباشر عبر المتصفح (Browser Subagent Live Database Inspection):**
  - **المخطوطات (#manuscripts):** ظهور أصول PostgreSQL الحية مثل `#00100 مخطوط كليلة ودمنة (100)`، كود `MANUSCRIPT_GROUP_33`، شارات الأغلفة واللوحات `📜 لوحات`، روابط معمل الفحص والاستوديو، والتبديل بين الجدول وشبكة البطاقات.
  - **الصوتيات (#audios):** ظهور تسجيلات PostgreSQL الحية مثل `#00100 شرح ألفية ابن مالك (100)`، المدة `00:48:51`، صيغة MP3، معدل البت 320 kbps، شارات الصوت `🎧 صوتي`، روابط المشغل والاستوديو.
  - **المرئيات (#videos):** ظهور مرئيات PostgreSQL الحية مثل `#00098 ندوة المخطوطات الدولية (98)`، شارات `▶️ مرئي`، روابط المشغل المرئي والاستوديو.
  - **المؤلفون (#authors):** ظهور جميع الأعلام الـ 11 الحية من قاعدة البيانات (ابن خلدون، البخاري، الجاحظ، المتنبي، ابن رشد، نجيب محفوظ، طه حسين، ابن المقفع، الشافعي، المنشاوي، د. السويدان) برصيد مصنفاتهم الحقيقي وروابط تصفح مؤلفاتهم وتعديل السيرة.
  - **الناشرون (#publishers):** ظهور دور النشر الـ 7 الحية من قاعدة البيانات (دار المعرفة، دار الشروق، مكتبة العبيكان، عالم المعرفة، مركز دراسات الوحدة العربية، مؤسسة التراث) برصيد مطبوعاتها وتواريخ تأسيسها.
  - **المستخدمون (#users):** ظهور المستخدمين الـ 7 الحقيقيين برتبهم ومصفوفة صلاحياتهم وحالات النشاط.
  - **النشاطات (#activities):** ظهور خط التدقيق الحي المرتبط لحظياً بسجل قاعدة البيانات (1,206 نشاطاً).
  - **المهملات (#deletions):** ظهور العناصر المحذوفة ناعماً من قاعدة البيانات (`كتاب تجريبي محذوف مؤقتاً` و `مخطوطة مسودة محذوفة`) مع شارات النوع والمدد المتبقية وزر الاستعادة الفوري.
- **اللقطات الميدانية الموثقة في سجل النظام:**
  - بطاقات المؤلفين الحية: [`authors_view_verify_1791498743168.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/authors_view_verify_1791498743168.png)
  - بطاقات دور النشر الحية: [`publishers_view_verify_1791498922896.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/publishers_view_verify_1791498922896.png)
  - جدول المستخدمين الحي: [`users_view_verify_1791498954632.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/users_view_verify_1791498954632.png)
  - سلة المهملات الحية: [`deletions_view_verify_1791499005924.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/deletions_view_verify_1791499005924.png)
  - خط النشاطات التفاعلي الحي: [`activities_view_verify_1791499040113.png`](file:///home/a/.gemini/antigravity-ide/brain/8177e32b-a153-426b-ae38-64a17178566d/activities_view_verify_1791499040113.png)

---

## 🚀 دورة التطوير رقم 21: التمثيل الحي الشامل لكافة قطاعات المنظومة من PostgreSQL وتطهير الكود الميت وتحسين حزمة الإنتاج (Full Live System & Dead Code Elimination)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**
  امتثالاً لقواعد دستور الواجهات في [`.agent/frontend/ui_rules.md`](.agent/frontend/ui_rules.md) (الموافقة المسبقة الصريحة، وتطبيق TDD الصارم، والتأكد من عدم الانكسار 100%):
  1. **التمثيل الحي الشامل من PostgreSQL (100% Live Data):** ربط كافة القطاعات المتبقية في قمرة القيادة بقاعدة البيانات بصورة حية دون أي نصوص أو أرقام وهمية:
     - شجرة العلوم والتصنيفات (`categories`) مع رصيد الكيانات الحقيقي.
     - سحابة وفهرس الأوسمة (`tags`) مع تعداد الكتب الحي.
     - سجل وتاريخ الإصدارات (`versions`) مع بيانات المصنف والناشر والحجم والتاريخ وإجراءات الاسترجاع.
     - استوديو التحقيق بموديلاته الأربعة (`studio-books`, `studio-manuscripts`, `studio-audios`, `studio-videos`) مع روابط التحرير المباشرة.
     - لوحة المؤشرات المركزية (`stats`) ومسار تدفق النشر والتحقيق (Editorial Lifecycle Funnel) من إحصائيات حقيقية.
     - شارات السايدبار التابعة للاستوديو بربطها بـ `props.stats` ديناميكياً.
  2. **استئصال الكود الميت وقوالب النصوص الخام:** إزالة كافة دوال التصيير النصية القديمة (`render: () => ...`) المهملة داخل كائن `viewCatalog` للكيانات السيادية التسعة مع الحفاظ الصارم على بيانات العنوان والمجموعة (`title` و `group`) لتغذية مسار التتبع (Breadcrumbs).
  3. **الحفاظ على كل بكسل دون انكسار:** الحفاظ التام 100% على التصميم، الأنماط، الألوان، الظلال الزجاجية، والتفاعل.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار:**
  - الباك إند: `tests/Feature/Dashboard/SuperAdminDashboardTest.php` (إضافة اختبار `it_shares_live_categories_tags_versions_and_studio_data`).
  - الفرونت إند: `resources/js/__tests__/AdminDashboard.test.js` (إضافة 5 اختبارات تفصيلية تفحص تمثيل التصنيفات والأوسمة والإصدارات واستوديو الكتب ولوحة الإحصائيات والفانل الحية).
- **نتيجة التشغيل (RED):**
  - فشل الاختبارات الخمسة في الفرونت إند بنجاح لعدم ربط البيانات الحية وتواجد قوالب النصوص الثابتة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **التعديلات البرمجية المنفذة:**
  - الباك إند [`app/Http/Controllers/AdminDashboardController.php`](app/Http/Controllers/AdminDashboardController.php):
    - تزويد كائن `$stats` بإحصائيات الاستوديو ومراحل الفانل الأربعة (`funnel_drafts`, `funnel_reviewed`, `funnel_scholarly`, `funnel_published`, `studio_books`, `studio_manuscripts`, `studio_audios`, `studio_videos`).
    - جلب استعلامات حية مع `withCount` و `with` للعلاقات للتصنيفات، الأوسمة، الإصدارات، ومسودات الكتب وتمريرها عبر Inertia Props.
  - الفرونت إند [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue):
    - تعريف الـ Props الجديدة: `categories`, `tags`, `versions`, `studioBooks`.
    - ربط شارات السايدبار الحية للاستوديو بـ `props.stats`.
    - ربط كائن `viewCatalog` للتصنيفات والأوسمة والإصدارات والأستوديو والإحصائيات والفانل لتقرأ مباشرة وديناميكياً من الـ Props الحية.
    - تطهير ما يزيد عن 2,000 سطر من النصوص الخام الميتة.
- **نتيجة التشغيل (GREEN):**
  - نجاح كافة اختبارات `AdminDashboard.test.js` الـ 24 بالكامل بنسبة 100%.
  - نجاح كافة اختبارات `SuperAdminDashboardTest` الـ 8 بالكامل (138 assertions).

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **72/72 اختبار ناجح بنسبة 100% عبر كامل ملفات الاختبار**.
- **اختبارات الباك إند (PHPUnit):** **548/548 اختبار ناجح (2,723 assertions)** بنسبة 100%.
- **تحسين حزمة الإنتاج (Vite Build Optimization):**
  - انخفاض حجم حزمة `AdminDashboard.js` من **279.87 kB** إلى **131.22 kB** (توفير أكثر من **53%** من الحجم الصافي).
  - بناء نظيف خالٍ تماماً من الأخطاء في 21 ثانية.

---

## 🚀 دورة التطوير رقم 22: اكتمال منظومة التنظيم المعرفي الشامل (المجموعات والسلاسل والموضوعات) وترقية الفهارس والربط البوليمورفي السريع (Full Cognitive Taxonomy Integration & Polymorphic Linking)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**
  امتثالاً لتوجيهات وقواعد [`.agent/frontend/ui_rules.md`](.agent/frontend/ui_rules.md) (منهجية TDD الصارمة، منع الانكسار، صفر فقدان للبكسل):
  1. **اكتمال قطاع التنظيم المعرفي في قمرة القيادة (AdminDashboard):**
     - ترقية شارة المجموعة الثالثة (🏷️ التنظيم) في السايدبار من `2` إلى `5` فروع معرفية نشطة:
       - التصنيفات (`categories`)
       - الأوسمة (`tags`)
       - المجموعات المختارة (`collections`) مع عداد حي `#nav-collections`
       - السلاسل العلمية (`series`) مع عداد حي `#nav-series`
       - الموضوعات التخصصية (`topics`) مع عداد حي `#nav-topics`
     - تمثيل المجموعات والسلاسل والموضوعات بتصميم زجاجي عالي الكثافة مع بطاقات تفاعلية وشارات رصيد الأصول والروابط التشغيلية المباشرة.
  2. **نقاط نهاية الربط البوليمورفي الموحد (Polymorphic Attachment Endpoints):**
     - توفير مسارات ربط الأصول بطلب POST مدعوم بالمصادقة:
       - `POST /collections/{collection}/entities` لضم الأصول إلى المجموعات مع ترتيب الحفظ الزمني.
       - `POST /series/{series}/entities` لضم الأصول إلى السلاسل مع ترتيب الموضع التسلسلي (`position`).
  3. **ترقية فهارس المجموعات والسلاسل المستقلة (Index Pages Modernization):**
     - ترقية `Collections/Index.vue` و `Series/Index.vue` بتوزيع الأصول التفصيلي (كتب، مخطوطات، صوتيات، مرئيات) ودعم البحث المتأني المباشر (`debounce`).
  4. **زر وإجراء الضم السريع في محرك الجداول (`AssetTableView.vue` & `DenseDataTable.vue`):**
     - تزويد كافة صفوف الأصول الأربعة (كتب، مخطوطات، صوتيات، مرئيات) بزر إجراء سريع `📦` لفتح نافذة الضم التفاعلية الفورية مع تغذية راجعة للمستخدم.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملفات الاختبار:**
  - الباك إند:
    - [`tests/Feature/Dashboard/SuperAdminDashboardTest.php`](tests/Feature/Dashboard/SuperAdminDashboardTest.php): اختبار تزويد الداشبورد ببيانات المجموعات والسلاسل والموضوعات الحية من PostgreSQL.
    - [`tests/Feature/Entities/Taxonomies/TaxonomyAttachmentTest.php`](tests/Feature/Entities/Taxonomies/TaxonomyAttachmentTest.php): اختبار ربط الكتب بالمجموعات والمخطوطات بالسلاسل عبر نقاط النهاية.
  - الفرونت إند:
    - [`resources/js/__tests__/AdminDashboard.test.js`](resources/js/__tests__/AdminDashboard.test.js): 4 اختبارات تفحص واجهات المجموعات والسلاسل والموضوعات وعدادات السايدبار وبادج المجموعة `5`.
    - [`resources/js/__tests__/TableEngineComponents.test.js`](resources/js/__tests__/TableEngineComponents.test.js): اختبارات زر الضم ونافذة الضم البوليمورفي المنبثقة.
- **نتيجة التشغيل (RED):**
  - فشل اختبارات الباك إند بنتيجة 404 لنقاط النهاية ونقصان الخصائص.
  - فشل اختبارات الفرونت إند بنتيجة 4 Failed في AdminDashboard و 2 Failed في TableEngineComponents.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **التعديلات البرمجية المنفذة:**
  - [`routes/web.php`](routes/web.php): تسجيل مسارات `collections.entities.attach` و `series.entities.attach`.
  - [`app/Http/Controllers/CollectionController.php`](app/Http/Controllers/CollectionController.php): تنفيذ دالة `attachEntity`.
  - [`app/Http/Controllers/SeriesController.php`](app/Http/Controllers/SeriesController.php): تنفيذ دالة `attachEntity`.
  - [`app/Http/Controllers/AdminDashboardController.php`](app/Http/Controllers/AdminDashboardController.php): تزويد الـ Controller باستعلامات `collections`, `series`, `topics` وإحصائياتها.
  - [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue): إضافة العناصر الخمسة للسايدبار وبادج `5`، وتزويد الـ Props، وبناء عروض `collections`, `series`, `topics` الزجاجية الفاخرة.
  - [`resources/js/Components/Table/DenseDataTable.vue`](resources/js/Components/Table/DenseDataTable.vue): إضافة زر الضم `btn-attach-taxonomy` وبث حدث `attach-taxonomy`.
  - [`resources/js/Components/Table/AssetTableView.vue`](resources/js/Components/Table/AssetTableView.vue): إضافة نافذة الضم المنبثقة `#taxonomyAttachModal` وإرسال طلب الربط ومعالجة الاستجابة الحية.
  - [`resources/js/Pages/Collections/Index.vue`](resources/js/Pages/Collections/Index.vue) و [`resources/js/Pages/Series/Index.vue`](resources/js/Pages/Series/Index.vue): ترقية شارات رصيد الأصول وبحث Debounce.
- **نتيجة التشغيل (GREEN):**
  - نجاح كافة اختبارات الباك إند: `TaxonomyAttachmentTest` (2/2) و `SuperAdminDashboardTest` (9/9).
  - نجاح كافة اختبارات الفرونت إند: `AdminDashboard.test.js` (28/28) و `TableEngineComponents.test.js` (13/13).

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **78/78 اختبار ناجح بنسبة 100% عبر كامل الملفات الـ 11**.
- **اختبارات الباك إند (PHPUnit):** **551/551 اختبار ناجح (2,757 assertions)** بنسبة 100%.
- **بناء الإنتاج (Vite Build):** بناء الحزمة بالكامل في **13.97 ثانية** بنجاح مطلق ودون أدنى خطأ.

---

## 🔹 الدورة 23: تفكيك قمرة القيادة وفصل الواجهات الفرعية والأنماط المعمارية (Decoupled SFC Views & Modular Sub-Views)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**
  امتثالاً لتوجيهات وقواعد [`.agent/frontend/ui_rules.md`](.agent/frontend/ui_rules.md) (منهجية TDD الصارمة، منع الانكسار، صفر فقدان للبكسل، والهيكلية الهجينة المعتمدة الأولى + الثالثة):
  1. **المكونات ذاتية الاحتواء (Self-Contained Components):**
     - تمكين مكونات محرك الجداول (`AssetHeaderBanner.vue` و `DenseDataTable.vue`) من امتلاك كامل تنسيقاتها الزجاجية الفاخرة (`<style>`) وحالات التباين للوضع الفاتح والداكن بدلاً من الاتكال على ملف الأب.
  2. **الواجهات الفرعية المستقلة (Modular Sub-Views SFCs):**
     - التخلص الجذري من أكثر من 1,100 سطر من سلاسل قوالب HTML الخام السابقة في `viewCatalog` واستبدال `v-html="currentViewHtml"` بمكونات Vue 3 نقية وتفاعلية 100%:
       - `DashboardStatsView.vue`: بطاقات الـ KPIs المركزية، كبسولات صحة النظام والنبض، منصة الإطلاق السريع، وقمع النشر التحريري PostgreSQL.
       - `DashboardCommandsView.vue`: طرفية الكونسول التفاعلية (`#terminalOutput`) وحقل الإدخال والأزرار السريعة مع توافق تام لـ API تشغيل الأوامر.
       - `DashboardOpsView.vue`: إدارة وضع الصيانة، نسخ PostgreSQL الاحتياطي، مسح الذاكرة المؤقتة، وإعادة بناء الفهرس.
       - `DashboardStudioView.vue`: قطاع الاستوديو والمختبر التحريري لمصنفات الكتب والمخطوطات والصوتيات والمرئيات والنسخ.
       - `DashboardTaxonomyView.vue`: فهارس المجموعات، السلاسل، شجرة التصنيفات، سحابة الأوسمة، وشجرة الموضوعات.
  3. **ترشيق قمرة القيادة المايسترو (`AdminDashboard.vue`):**
     - انخفاض حجم الملف من **4,732 سطراً** إلى **3,732 سطراً** (حذف ما يزيد عن 1,000 سطر من النصوص الخام والقوالب الزائدة).
     - تقليص حجم حزمة الجافاسكريبت النهائية عند البناء إلى **104 kB** مع توزيع الواجهات إلى قطع مجزأة فائقة السرعة (`code-splitting`).

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار المنشأ:**
  - [`resources/js/__tests__/ModularDashboardViews.test.js`](resources/js/__tests__/ModularDashboardViews.test.js): اختبارات وحدة دقيقة تفحص تركيب الواجهات الفرعية الخمس، وتوافقها التام مع محددات الـ DOM وأزرار الأوامر وربط الحقول التفاعلية.
- **نتيجة التشغيل (RED):**
  - فشل 6 اختبارات بنجاح (6 Failed) لعدم وجود ملفات الواجهات الفرعية SFC.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. [`resources/js/Components/Table/AssetHeaderBanner.vue`](resources/js/Components/Table/AssetHeaderBanner.vue): تزويد المكون بكتلة `<style>` كاملة ذاتية الاحتواء.
  2. [`resources/js/Components/Table/DenseDataTable.vue`](resources/js/Components/Table/DenseDataTable.vue): تزويد المكون بكتلة `<style>` كاملة ذاتية الاحتواء للجداول والبطاقات والأزرار.
  3. إنشاء المجلد [`resources/js/Pages/AdminDashboard/Views/`](resources/js/Pages/AdminDashboard/Views/) متضمناً:
     - `DashboardStatsView.vue`
     - `DashboardCommandsView.vue`
     - `DashboardOpsView.vue`
     - `DashboardStudioView.vue`
     - `DashboardTaxonomyView.vue`
  4. [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue):
     - استيراد وتركيب المكونات الفرعية الخمسة داخل القالب.
     - استبدال قوالب الـ HTML الخام في `viewCatalog` بمصفوفة سجل الواجهات النظيفة.
     - ترشيق التنسيقات المكررة مع الحفاظ التام والسيادي على متغيرات `:root` وهيكل القشرة الخارجية.
- **نتيجة التشغيل (GREEN):**
  - نجاح 6/6 في `ModularDashboardViews.test.js`.
  - نجاح 28/28 في `AdminDashboard.test.js`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **84/84 اختبار ناجح (100% نجاح عبر كامل ملفات الاختبار الـ 12)**.
- **اختبارات الباك إند (PHPUnit):** **551/551 اختبار ناجح (2,763 assertions)** بنسبة نجاح 100%.
- **بناء الإنتاج (Vite Production Build):** بناء الحزمة بالكامل في **14.37 ثانية** وانخفاض ملف `AdminDashboard` إلى **104.01 kB** (26.10 kB gzip).

---

## 🔹 الدورة 24: ترقية وتوحيد عروض الاستوديو بمحرك الجداول ونمط البطاقات الذكي (Studio High-Density Engine & Cards Grid)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**
  امتثالاً لتوجيهات وقواعد [`.agent/frontend/ui_rules.md`](.agent/frontend/ui_rules.md) (منهجية TDD الصارمة، منع الانكسار، صفر فقدان للبكسل):
  1. **الترقية إلى معايير محرك الجداول عالي الكثافة (Enterprise High-Density UI):**
     - استبدال جداول `users-table` البسيطة السابقة في [`DashboardStudioView.vue`](resources/js/Pages/AdminDashboard/Views/DashboardStudioView.vue) بمحرك الجداول عالي الكثافة مع بطاقات زجاجية فاخرة وخلفيات بلورية تفاعلية.
     - دعم العروض الخمسة لقطاع الاستوديو والمختبر:
       - ✍️ **استوديو تحرير الكتب (`studio-books`):** مصحوبة بمؤشرات نسبة الإنجاز التفاعلية (`kpi-split-bar`) والعقدة الحالية وشارة المحقق ورابط المحرر المباشر.
       - 📜 **استوديو المخطوطات (`studio-manuscripts`):** مصحوبة برقم اللوحة والوجه وشارات المقابلة النصية وفك الطلاسم ورابط الاستوديو.
       - 🎙️ **استوديو الصوتيات (`studio-audios`):** مصحوبة بمدة التسجيل ورصيد الشرائح ودقة المطابقة ورابط محرر الشرائح.
       - 🎬 **استوديو المرئيات (`studio-videos`):** مصحوبة بمدة المحاضرة وعدد الفصول ورابط تقطيع الفصول.
       - 🗂️ **الإصدارات والنسخ المقارنة (`versions`):** مصحوبة بالكيان التابع، الناشر، الحجم الفعلي والصيغة، وتاريخ الإضافة.
  2. **شريط أدوات الاستوديو الذكي (Smart Studio Toolbar):**
     - إضافة حقل بحث فوري لحظي `#studioSearchInput` يبحث عبر كافة الحقول والخصائص.
     - إضافة شارة رصيد العناصر النشطة (`items-count-badge`).
     - إضافة مبدل نمط العرض الفوري بين نمط الجدول المدمج (`#btnStudioViewTable`) ونمط شبكة بطاقات الاستوديو الفاخرة (`#btnStudioViewCards`).
  3. **شبكة بطاقات الاستوديو الزجاجية (Studio Cards Grid):**
     - عرض بطاقات أنيقة (`studio-entity-card`) تحتوي على شارات الحالة وأشرطة التقدم والبيانات الوصفية وأزرار التحرير المباشرة.
  4. **الأنماط ذاتية الاحتواء والتوافق الشامل (Self-Contained Styles):**
     - تضمين كامل التنسيقات وتوافق الوضعين الليلي والنهاري (Dark / Light Mode) مع خط `Outfit` للأرقام والنسب.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار:**
  - [`resources/js/__tests__/ModularDashboardViews.test.js`](resources/js/__tests__/ModularDashboardViews.test.js): إضافة 4 اختبارات تفحص عروض الاستوديو والبحث الفوري والتبديل لنمط البطاقات.
- **نتيجة التشغيل (RED):**
  - فشل 3 اختبارات بنجاح (3 Failed) لعدم وجود حقل البحث وأزرار التبديل وشبكة البطاقات.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  - [`resources/js/Pages/AdminDashboard/Views/DashboardStudioView.vue`](resources/js/Pages/AdminDashboard/Views/DashboardStudioView.vue):
    - إعادة بناء المكون بالكامل ليدعم التفاعل اللحظي والبحث والتبديل بين الجدول والبطاقات.
    - إضافة التنسيقات الزجاجية المكتفية ذاتياً.
- **نتيجة التشغيل (GREEN):**
  - نجاح 10/10 اختبارات في `ModularDashboardViews.test.js`.
  - نجاح 28/28 اختباراً في `AdminDashboard.test.js`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **88/88 اختباراً ناجحاً (100% نجاح عبر كافة الملفات الـ 12)**.
- **اختبارات الباك إند (PHPUnit):** **551/551 اختباراً ناجحاً (2,754 assertions)** بنسبة نجاح 100%.
- **بناء الإنتاج (Vite Production Build):** بناء الحزمة بالكامل في **13.62 ثانية** بنجاح مطلق.

---

## 🔹 الدورة 25: المستكشف المعرفي التفاعلي وتخصيص الهويات البصرية لفروع التنظيم (Cognitive Taxonomy Explorer & Specialized Branch Identities)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**
  امتثالاً لتوجيهات وقواعد [`.agent/frontend/ui_rules.md`](.agent/frontend/ui_rules.md) (منهجية TDD الصارمة، الهوية البصرية الغنية، صفر فقدان للبكسل):
  1. **التحول المعماري من التسطيح الجدولي إلى الهويات المعرفية المتخصصة:**
     - إدراكاً للطبيعة المعرفية والعلاقاتية لفروع التنظيم الخمسة (التصنيفات، الوسوم، المجموعات، السلاسل، الموضوعات)، تم رفض تسطيحها في جداول رتيبة موحدة وتصميم هوية بصرية وتفاعلية مستقلة لكل فرع تخدم وظيفته الإدراكية:
       - 🌳 **شجرة التصنيفات التفاعلية (`.categories-tree-explorer`):** مستكشف شجري هرمي مزود بوصلات متوهجة ومؤشرات عدد المصنفات لكل تصنيف رئيسي وفرعي.
       - 🏷️ **سحابة الوسوم الدلالية (`.semantic-tag-cloud`):** سحابة دلالية عائمة متدرجة في الأوزان والألوان وأحجام الخطوط بناءً على رصيد المصنفات المرتبطة بكل وسم.
       - 📁 **ملفات المجموعات ثلاثية الأبعاد (`.collection-dossier-card`):** بطاقات دوسيه محافظ حفظ ثلاثية الأبعاد مع حصر تفصيلي للأصول (كتب، مخطوطات، صوتيات) وهوية المشرف والروابط المباشرة.
       - 📚 **السلاسل المجلدة المتتابعة (`.series-volume-card`):** بطاقات تسلسلية مرقمة مع شريط تقدم إنجاز الأجزاء والمجلدات (`المجلد #X`).
       - 🔬 **سجل الموضوعات الأنطولوجي (`.topic-ontology-card`):** بطاقات قيد موضوعي مع شريط هوية لوني أيمن ورابط المعرف النصي `#slug` وأزرار الإجراءات السريعة.
  2. **شريط أدوات التنظيم الذكي (Smart Taxonomy Toolbar):**
     - تزويد الواجهة بحقل بحث فوري `#taxonomySearchInput` يبحث لحظياً عبر الاسم والوصف والخصائص في الفرع المعروض.
     - إضافة شارة رصيد العناصر النشطة المطابقة للبحث (`items-count-badge`).
  3. **الأنماط الزجاجية المعزولة (Self-Contained Glassmorphism Styles):**
     - تصميم وبناء أنماط CSS زجاجية مستقلة تدعم الوضعين الليلي والنهاري (Dark / Light Mode) مع خطوط `Inter` و `Outfit` الرقمية.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار:**
  - [`resources/js/__tests__/ModularDashboardViews.test.js`](resources/js/__tests__/ModularDashboardViews.test.js): إضافة 5 اختبارات تتحقق من شجرة التصنيفات، سحابة الوسوم، بطاقات المجموعات الدوسيه، بطاقات السلاسل المجلدة، وسجل الموضوعات الأنطولوجي مع حقل البحث الذكي.
- **نتيجة التشغيل (RED):**
  - فشل 5 اختبارات بنجاح (`5 Failed`) قبل بناء الهويات البصرية المتخصصة.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  - [`resources/js/Pages/AdminDashboard/Views/DashboardTaxonomyView.vue`](resources/js/Pages/AdminDashboard/Views/DashboardTaxonomyView.vue):
    - إعادة كتابة المكون بالكامل وفق النماذج المعمارية الخمسة المتفق عليها.
    - تزويد الواجهة بخوارزميات التصفية والبحث اللحظي.
    - تضمين كتلة أنماط `<style>` متكاملة وشاملة لكافة الأنماط البصرية والهويات اللونية.
- **نتيجة التشغيل (GREEN):**
  - نجاح 13/13 اختباراً في `ModularDashboardViews.test.js`.
  - نجاح 28/28 اختباراً في `AdminDashboard.test.js`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **91/91 اختباراً ناجحاً (100% نجاح عبر كافة ملفات الاختبار الـ 12)**.
- **اختبارات الباك إند (PHPUnit):** **551/551 اختباراً ناجحاً (2,748 assertions)** بنسبة نجاح 100%.
- **بناء الإنتاج (Vite Production Build):** بناء الحزمة بالكامل في **22.41 ثانية** وخروج ملف `DashboardTaxonomyView` بحجم خفيف ومستقل **9.50 kB** (3.26 kB gzip).

---

## 🔹 الدورة 26: التفكيك المعماري الشامل واستخراج غلاف القمرة وقطاعي المكتبة والأشخاص (Cockpit Shell & Sector Decoupling)

- **تاريخ الإنجاز:** 2026-10-09
- **الهدف المعماري:**  
  إنجاز التفكيك المعماري النهائي لقمرة القيادة السيادية `AdminDashboard.vue`، وتجريد آخر الكتل الأحادية (Monolithic Blocks) عبر استخراج أربعة مكونات مستقلة:
  1. `DashboardLibraryView.vue`: مكوّن قطاع المكتبة الرقمية العامة (الكتب، المخطوطات، الصوتيات، المرئيات) بكامل مؤشرات الأداء والروابط التفاعلية.
  2. `DashboardPeopleView.vue`: مكوّن قطاع الأشخاص والجهات (المؤلفون والناشرون) مع الالتزام الصارم بشرط المستخدم: **البقاء في وضع الجداول عالي الكثافة (High-Density Table View Mode)** دون تحويلها لبطاقات.
  3. `AdminDashboardSidebar.vue`: المكوّن المستقل للقائمة الجانبية لقمرة القيادة (وفق الخيار ب المعتمد من المستخدم) شاملاً المجموعات الخمس وشريط أدوات الأكوردion وبادجات العدادات الحية.
  4. `AdminDashboardNavbar.vue`: المكوّن المستقل للشريط العلوي لقمرة القيادة (وفق الخيار ب) شاملاً مسار التتبع ثلاثي المستويات، أزرار الطي والمظهر الليلي والنهاري، وقائمة ملف المستخدم.

---

### 1. المرحلة الحمراء 🔴 (RED Phase):
- **ملف الاختبار:**
  - [`resources/js/__tests__/ModularDashboardViews.test.js`](resources/js/__tests__/ModularDashboardViews.test.js): إضافة اختبارات الوحدات لقطاع المكتبة وقطاع الأشخاص (مع فحص التزام الجداول) والسايدبار والنافبار.
- **نتيجة التشغيل (RED):**
  - فشل 11 اختباراً بنجاح (`11 Failed`) قبل إنشاء واستخراج المكونات.

---

### 2. المرحلة الخضراء 🟢 (GREEN Phase):
- **الملفات البرمجية المنشأة والمعدلة:**
  1. [`resources/js/Pages/AdminDashboard/Views/DashboardLibraryView.vue`](resources/js/Pages/AdminDashboard/Views/DashboardLibraryView.vue): بناء المكون بتمثيل شامل للأصول الأربعة ومحرك الجداول وبطاقات الإحصائيات.
  2. [`resources/js/Pages/AdminDashboard/Views/DashboardPeopleView.vue`](resources/js/Pages/AdminDashboard/Views/DashboardPeopleView.vue): بناء المكون وفرض `initial-view-mode="table"` التزاماً برغبة المستخدم.
  3. [`resources/js/Pages/AdminDashboard/AdminDashboardSidebar.vue`](resources/js/Pages/AdminDashboard/AdminDashboardSidebar.vue): استخراج القائمة الجانبية بالكامل مع الحفاظ على كافة المعرفات التوافقية والأحداث.
  4. [`resources/js/Pages/AdminDashboard/AdminDashboardNavbar.vue`](resources/js/Pages/AdminDashboard/AdminDashboardNavbar.vue): استخراج الشريط العلوي مع مسار التتبع التفاعلي وقائمة المستخدم.
  5. [`resources/js/Pages/AdminDashboard.vue`](resources/js/Pages/AdminDashboard.vue): استبدال الكتل الأحادية بالمكونات الجديدة وتمرير الخصائص التفاعلية.
- **نتيجة التشغيل (GREEN):**
  - نجاح 24/24 اختباراً في `ModularDashboardViews.test.js`.
  - نجاح 28/28 اختباراً في `AdminDashboard.test.js`.

---

### 3. مرحلة التحسين وفحص عدم الانكسار 🛡️ (Refactor & Zero Regression):
- **اختبارات الفرونت إند (Vitest):** **102/102 اختباراً ناجحاً (100% نجاح عبر كافة ملفات الاختبار الـ 12)**.
- **اختبارات الباك إند (PHPUnit):** **551/551 اختباراً ناجحاً (2,766 assertions)** بنسبة نجاح 100%.
- **بناء الإنتاج (Vite Production Build):** بناء الحزمة بالكامل بنجاح تام وانخفاض ملحوظ في حجم ملف قمرة القيادة `AdminDashboard.vue`.
