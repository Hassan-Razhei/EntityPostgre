# 🏛️ المخطط المعماري لقمرة القيادة السيادية (Cockpit Architecture Blueprint)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library
### المسار المعماري المعتمد: `resources/js/Pages/AdminDashboard/`
**تاريخ التحديث المرجعي:** 2026-10-10 | **الحالة المعمارية:** الدورة 30 (Decoupled, Modular & Authoritative)

---

> [!IMPORTANT]
> **المرجعية المعمارية الشاملة:**  
> يمثل هذا المستند المخطط المعماري الهيكلي لقمرة القيادة الإدارية (`/superadmin/dashboard`)، معتمداً على المرجع البصري والتشريحي الحاكم في [`cockpit_ui_inventory.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/cockpit_ui_inventory.md) وخارطة التفكيك الهندسية في [`decomposition_map.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/decomposition_map.md).

---

## 🧭 1. المعمارية المفككة لقمرة القيادة (Decoupled Cockpit Structure)

تم تفكيك قمرة القيادة بالكامل إلى **قشرة رقيقة موحدة (Ultra-Thin Shell)** تدير **22 واجهة فرعية مستقلة** موزعة عبر **8 مكونات قطاعية مفككة** في [`resources/js/Pages/AdminDashboard/Views/`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard/Views/):

```
resources/js/Pages/AdminDashboard/
├── Index.vue                            # الغلاف الرقيق وقشرة القمرة السيادية (Ultra-Thin Shell)
├── AdminDashboardSidebar.vue            # القائمة الجانبية الثابتة وشريط تحكم الأكورديون (270px / 70px)
├── AdminDashboardNavbar.vue             # الشريط العلوي الثابت مع الثيم والمسار وقائمة المستخدم (64px)
├── useAdminCockpit.js                   # إعادة تصدير Composable قمرة القيادة الموحد
└── Views/
    ├── DashboardStatsView.vue           # لوحة المؤشرات والإحصائيات المركزية وقمع النشر (Funnel)
    ├── DashboardLibraryView.vue         # قطاع المكتبة (الكتب، المخطوطات، الصوتيات، المرئيات)
    ├── DashboardPeopleView.vue          # قطاع الأشخاص والجهات (المؤلفون، الناشرون - وضع الجدول)
    ├── DashboardSystemView.vue          # قطاع النظام (المستخدمون، سلة المهملات، سجل النشاطات)
    ├── DashboardCommandsView.vue        # مركز الأوامر السيادية ومحطة الطرفية التفاعلية بنمط macOS
    ├── DashboardOpsView.vue             # حقيبة العمليات، وضع الصيانة، والنسخ الاحتياطي اللحظي
    ├── DashboardStudioView.vue          # استوديو الكيانات (جداول مدمجة + شبكة بطاقات الإنجاز)
    └── DashboardTaxonomyView.vue        # المستكشف المعرفي التفاعلي بالهويات البصرية الـ 5 المخصصة
```

---

## 📊 2. خريطة الواجهات الـ 22 المفككة بحسب المجموعات الخمس

تتوزع الشاشات الـ 22 بدقة تامة وفق شجرة المجموعات الخمس في السايدبار:

### 🔹 المجموعة 1: 📚 المكتبة الرقمية العامة (`DashboardLibraryView.vue` عبر `AssetTableView`)
1. **`books` (الكتب):** جدول الكتب عالي الكثافة مع مؤشرات التحقيق، أشرطة النسب، وروابط القراءة.
2. **`manuscripts` (المخطوطات):** جدول المخطوطات مع أرقام اللوحات، الخزائن، وشارات الترميم والمقابلة.
3. **`audios` (الصوتيات):** جدول التسجيلات الصوتية مع رصيد الشرائح، التردد، الصيغ، وزر الاستماع.
4. **`videos` (المرئيات):** جدول المرئيات مع الدقة (4K/HD)، المدد الزمنية، وعدد الفصول.

### 🔹 المجموعة 2: 👥 الأشخاص والجهات (`DashboardPeopleView.vue` عبر `AssetTableView`)
5. **`authors` (المؤلفون):** جدول الأعلام والعلماء عالي الكثافة (Dense Table Mode)، الرتب العلمية، العصر، وسيرهم ومصنفاتهم.
6. **`publishers` (الناشرون):** جدول دور النشر والمؤسسات (Dense Table Mode)، المقر، شارة الاعتماد، وعدد الإصدارات.

### 🔹 المجموعة 3: 🏷️ البيانات والتنظيم المعرفي (`DashboardTaxonomyView.vue`)
7. **`categories` (التصنيفات):** الشجرة الهرمية للعلوم بفروعها وعقدها المشعة وعدادات الكيانات التابعة.
8. **`tags` (الأوسمة):** سحابة الوسوم الدلالية التفاعلية المتدرجة بالأوزان والألوان.
9. **`collections` (المجموعات):** بطاقات الدوسيه والمحافظ الأرشيفية مع شارات الخصوصية وحصر الأصول.
10. **`series` (السلاسل):** بطاقات السلاسل التتابعية مع متابعة المجلدات وترقيم الأجزاء المتسلسلة.
11. **`topics` (الموضوعات):** مكنز المسائل والموضوعات التخصصية الدقيقة وشبكة روابطها التراثية.

### 🔹 المجموعة 4: ✍️ استوديو الكيانات والتحقيق (`DashboardStudioView.vue`)
12. **`studio-books` (استوديو الكتب):** متابعة مسار التحرير، نسبة الإنجاز، ونمط البطاقات الذكي مع زر الاستئناف.
13. **`studio-manuscripts` (استوديو المخطوطات):** مقارنة اللوحات الخطية وفك الطلاسم وتفريغ النصوص المسندة.
14. **`studio-audios` (استوديو الصوتيات):** تجزئة المسارات، توليد الشرائح، وتفريغ النصوص المسندة بدقة.
15. **`studio-videos` (استوديو المرئيات):** تقطيع الفصول والمشاهد وربط الندوات التفاعلية.
16. **`versions` (سجل الإصدارات):** محرك الإصدارات والنسخ المقارنة وتتبع الفروق النصية اللحظية.

### 🔹 المجموعة 5: 👑 الإدارة والحوكمة السيادية (Sovereignty & System)
17. **`stats` (الإحصائيات - `DashboardStatsView.vue`):** لوحة المؤشرات المركزية، بطاقات الـ KPI الـ 4، منصة الإطلاق السريع، وقمع تدفق النشر الهرمي (Editorial Funnel).
18. **`ops` (العمليات والصيانة - `DashboardOpsView.vue`):** حقيبة الصيانة الفورية، وضع الصيانة المؤسسي، والنسخ الاحتياطي.
19. **`users` (المستخدمون - `DashboardSystemView.vue`):** إدارة المستخدمين والصلاحيات وشارات الرتب السيادية.
20. **`activities` (سجل النشاطات - `ActivitiesTimelineView.vue`):** الخط الزمني المتصل وسجل التدقيق اللحظي من PostgreSQL.
21. **`deletions` (المهملات - `DashboardSystemView.vue`):** سلة المحذوفات الرخوة مع مؤقت الأيام وزر الاستعادة الفورية.
22. **`commands` (الأوامر - `DashboardCommandsView.vue`):** كونسول أوامر Artisan الـ 7 المخصصة ومحطة الطرفية بنمط macOS.

---

## 🛡️ 3. القواعد المعمارية ومحرك الجداول والتصميم (Core Architecture & Standards)

1. **الاعتماد على محرك الجداول الموحد (`AssetTableView` Subsystem):**
   - استخدام منظومة الجداول المشتركة في [`resources/js/Components/Table/`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/) بمكوناتها الستة: (`AssetHeaderBanner.vue` مع شريط الـ Micro-KPI التفاعلي، `TableToolbar.vue`، `BulkActionsStrip.vue`، `DenseDataTable.vue`، `TablePagination.vue`، و**نافذة الربط التصنيفي متعدد الأشكال المنبثقة**).
2. **محرك إدارة الحالة والتوجيه السيادي (`useAdminCockpit.js`):**
   - التوجيه الداخلي SPA المرتبط بالـ Hash ودعم أزرار المتصفح عبر `history.replaceState` ومستمع `hashchange`.
   - إدارة حالة طي السايدبار (270px ↔ 70px) والأكورديون الفني وتحديث شريط التحكم تلقائياً.
   - تصدير دوال التحكم لكائن `window` لتمكين الفحص الآلي واختبارات القبول.
3. **نظام الطباعة والهوية البصرية:**
   - **`Cairo`**: الخط العربي الأساسي لكافة النصوص والعناوين والواجهات.
   - **`Outfit`**: الخط الرقمي اللاتيني المعتمد للأرقام والإحصائيات والنسب المئوية.
   - **`monospace`**: خط الطرفية وشاشة موجه الأوامر والمعرفات البرمجية.
4. **العزل والتوافق مع الثيمات (Dark / Light Themes):**
   - دعم كامل للوضع الليلي الفاخر (افتراضي) والوضع النهاري الصافي عبر متغيرات `:root` وكلاس `body.light-mode`.
5. **توثيق الدورات وعدم الانكسار:**
   - كافة التعديلات والتفكيكات مسجلة وموثقة بنسبة نجاح 100% (111 Vitest + 551 PHPUnit) في [`frontend_cycles_log.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/frontend_cycles_log.md).
