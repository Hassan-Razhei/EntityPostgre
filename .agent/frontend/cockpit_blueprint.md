# 🏛️ المخطط المعماري لقمرة القيادة (Cockpit Architecture Blueprint)
## منصة الأرشيف الرقمي الموحد — Entity Digital Library

---

> [!IMPORTANT]
> **المرجعية المعمارية:** هذا المستند يمثل المرجع الهيكلي لواجهات قمرة القيادة الإدارية (`/superadmin/dashboard`)، معتمداً على المرجع البصري الحاكم [`public/super_admin_dashboard_preview.html`](file:///home/a/PhpstormProjects/EntityPostgre/public/super_admin_dashboard_preview.html) وخارطة التفكيك الهندسية في [`decomposition_map.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/decomposition_map.md).

---

## 🧭 1. المعمارية المفككة لقمرة القيادة (Decoupled Cockpit Structure)

تم تفكيك قمرة القيادة بالكامل إلى **22 واجهة فرعية مستقلة** موزعة عبر المكونات الآتية في [`resources/js/Pages/AdminDashboard/Views/`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Pages/AdminDashboard/Views/):

```
resources/js/Pages/AdminDashboard/
├── AdminDashboard.vue                   # الحاوية السيادية والقشرة الخارجية (Shell)
└── Views/
    ├── DashboardStatsView.vue           # مؤشرات الأداء الحية وقمع التحويل (Funnel)
    ├── DashboardCommandsView.vue        # مركز الأوامر والطرفية التفاعلية
    ├── DashboardOpsView.vue             # مركز العمليات، الطوابير، والنسخ الاحتياطي
    ├── DashboardStudioView.vue          # محرك عروض الاستوديو (جداول + بطاقات زجاجية)
    └── DashboardTaxonomyView.vue        # المستكشف المعرفي التفاعلي بالهويات البصرية الـ 5
```

---

## 📊 2. الواجهات الـ 22 المفككة بحسب القطاعات

### أ. قطاع النظرة العامة والعمليات (Core & Operations)
1. `stats`: لوحة الإحصائيات الشاملة ومؤشرات أداء PostgreSQL ومسار التحويل.
2. `commands`: مركز الأوامر مع شاشة الطرفية الحية وأزرار أوامر النظام المخصصة.
3. `ops`: مركز العمليات وصحة الخوادم والنسخ الاحتياطية.
4. `activities`: سجل النشاطات الحية المباشر.
5. `users`: إدارة المستخدمين بمحرك الجداول عالي الكثافة.
6. `deletions`: سلة المهملات وإدارة المحذوفات المرنة (`SoftDeletes`).

### ب. قطاع المكتبة والأصول (Library & Assets)
7. `books`: جدول الكتب عالي الكثافة مع مؤشرات التحقيق وروابط القراءة.
8. `manuscripts`: جدول المخطوطات مع أرقام اللوحات والوجوه وحالة المقابلة النصية.
9. `audios`: جدول الصوتيات مع رصيد الشرائح والتردد وروابط الاستماع.
10. `videos`: جدول المرئيات مع عدد الفصول والترميز وروابط التقطيع.

### ج. قطاع الأشخاص (Entities & People)
11. `authors`: بطاقات العلماء والمؤلفين وسيرهم الذاتية ورصيد أعمالهم.
12. `publishers`: بطاقات دور النشر وتوثيقها وعدد منشوراتها.

### د. قطاع التنظيم المعرفي (Taxonomy Explorer)
13. `categories`: الشجرة الهرمية التفاعلية بوصلات متوهجة وعدادات المصنفات.
14. `tags`: سحابة الوسوم الدلالية العائمة المتدرجة بالأوزان والألوان.
15. `collections`: بطاقات دوسيه ثلاثية الأبعاد مع حصر تفصيلي للأصول.
16. `series`: بطاقات السلاسل التتابعية مع شريط تقدم إنجاز الأجزاء والمجلدات.
17. `topics`: بطاقات القيد الأنطولوجي مع شريط الهوية اللوني والوسم التعريفي.

### هـ. قطاع الاستوديو والمختبر (Studio & Lab)
18. `studio-books`: استوديو تحرير الكتب ونسب الإنجاز ونمط البطاقات الذكي.
19. `studio-manuscripts`: استوديو المخطوطات وشارات المقابلة والطلاسم.
20. `studio-audios`: استوديو الصوتيات ومحرر الشرائح ودقة المطابقة.
21. `studio-videos`: استوديو المرئيات وتقطيع الفصول والمشاهد.
22. `versions`: إدارة الإصدارات والنسخ المقارنة وسجلات الإضافة.

---

## 🛡️ 3. القواعد الحاكمة لمحرك الجداول والتصميم (Table & Design Engine)

1. **الاعتماد على محرك الجداول الموحد:** استخدام مكونات [`resources/js/Components/Table/`](file:///home/a/PhpstormProjects/EntityPostgre/resources/js/Components/Table/) لضمان الكثافة العالية وتوحيد الهوية البصرية.
2. **الأنماط الزجاجية المكتفية ذاتياً:** كل مكون يحتوي على كتلة `<style>` معزولة تدعم الوضعين الداكن والفاتح (`Dark / Light Mode`).
3. **الطباعة الرقمية والأرقام:** خط `Outfit` للأرقام والمعرفات والرموز البرمجية، و`Inter` لواجهات التحكم، مع دعم كامل للاتجاه العربي `RTL`.
4. **توثيق الدورات:** كافة التعديلات مسجلة وموثقة في [`frontend_cycles_log.md`](file:///home/a/PhpstormProjects/EntityPostgre/.agent/frontend/frontend_cycles_log.md).
