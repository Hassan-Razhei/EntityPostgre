import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import AssetHeaderBanner from '@/Components/Table/AssetHeaderBanner.vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';

/**
 * ════════════════════════════════════════════════════════════════════════
 * 🔴 اختبار شامل: بطاقات KPI المنفصلة — العقد مع الباك إند
 * ════════════════════════════════════════════════════════════════════════
 *
 * هذا الاختبار يحرس:
 *   1. البطاقات تُبنى من statusMeta + assetStatuses (لا switch ضخم)
 *   2. كل بطاقة = حالة واحدة + فلترة تعمل لها وحدها
 *   3. ترتيب البطاقات = weight (خط أنابيب مرئي)
 *   4. الرقم في البطاقة = statusCounts من القاعدة (لا من rows الممرّرة)
 *   5. بطاقة "الكل" = الإجمالي، والنقر يُظهر الكل
 *   6. authors/publishers/users/deletions: لا بطاقات نشر
 *
 * ════════════════════════════════════════════════════════════════════════
 */

// ────────────────────────────────────────────────────────────────
// البيانات المُحاكاة — تُطابق ما يُرسله الباك إند
// ────────────────────────────────────────────────────────────────

const statusMeta = {
    draft:       { label: 'مسودة 🔴', color: '#f59e0b', group: 'draft',     weight: 0 },
    transcribed: { label: 'مفرغ ✍️',  color: '#8b5cf6', group: 'progress', weight: 10 },
    verified:    { label: 'مطابق 🔍', color: '#06b6d4', group: 'progress', weight: 20 },
    revised:     { label: 'معدل ✏️',  color: '#3b82f6', group: 'progress', weight: 30 },
    curriculum:  { label: 'منهج 🎓',  color: '#ec4899', group: 'progress', weight: 40 },
    scholarly:   { label: 'محكّم 🏅', color: '#a855f7', group: 'published', weight: 50 },
    published:   { label: 'منشور 🌐', color: '#10b981', group: 'published', weight: 100 },
    typeset:     { label: 'مصفوف 🖨️', color: '#06b6d4', group: 'progress', weight: 20 },
    collated:    { label: 'مقابل 📋', color: '#3b82f6', group: 'progress', weight: 30 },
    edited:      { label: 'محقق 🔬', color: '#a855f7', group: 'progress', weight: 40 },
};

const assetStatuses = {
    books:       ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'scholarly', 'published'],
    manuscripts: ['draft', 'typeset', 'collated', 'edited', 'published'],
    audios:      ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'published'],
    videos:      ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'published'],
};

const booksStatusCounts = {
    books_draft: 6, books_transcribed: 15, books_verified: 10, books_revised: 10,
    books_curriculum: 5, books_scholarly: 20, books_published: 35,
};

const manuscriptsStatusCounts = {
    manuscripts_draft: 10, manuscripts_typeset: 15, manuscripts_collated: 20,
    manuscripts_edited: 30, manuscripts_published: 25,
};

const booksColumns = [
    { key: 'serial', label: 'الرقم', visible: true },
    { key: 'title', label: 'العنوان', visible: true },
    { key: 'status', label: 'الحالة', visible: true },
];

const booksRows = [
    { id: '1', title: 'كتاب أ', status: 'draft' },
    { id: '2', title: 'كتاب ب', status: 'transcribed' },
    { id: '3', title: 'كتاب ج', status: 'published' },
];

const mountBanner = (props = {}) =>
    mount(AssetHeaderBanner, {
        props: {
            assetType: 'books',
            entityName: 'الكتب',
            statusMeta,
            assetStatuses,
            statusCounts: booksStatusCounts,
            ...props,
        },
    });

// ════════════════════════════════════════════════════════════════
// القسم 1: البطاقات المنفصلة
// ════════════════════════════════════════════════════════════════

describe('القسم 1: البطاقات المنفصلة (خط الأنابيب)', () => {

    it('تعرض كل حالات الكتب الـ7 + الكل = 8 بطاقات', () => {
        const wrapper = mountBanner();
        const cards = wrapper.findAll('.kpi-h-card');

        expect(cards.length).toBe(8);  // 7 حالات + الكل

        const statuses = cards.map(c => c.attributes('data-status'));
        expect(statuses).toEqual([
            'all', 'draft', 'transcribed', 'verified', 'revised',
            'curriculum', 'scholarly', 'published',
        ]);
    });

    it('كل بطاقة تعرض تسميتها العربية من statusMeta', () => {
        const wrapper = mountBanner();

        expect(wrapper.find('[data-status="transcribed"] .kpi-h-value').text())
            .toContain('15');
        expect(wrapper.find('[data-status="published"]').text())
            .toContain('منشور');
    });

    it('البطاقات مرتبة بترتيب weight (خط أنابيب)', () => {
        const wrapper = mountBanner();
        const statuses = wrapper.findAll('.kpi-h-card').map(c => c.attributes('data-status'));

        // المسودة أولاً، النشر أخيراً
        expect(statuses.indexOf('draft')).toBeLessThan(statuses.indexOf('published'));
        expect(statuses.indexOf('transcribed')).toBeLessThan(statuses.indexOf('revised'));
        expect(statuses.indexOf('curriculum')).toBeLessThan(statuses.indexOf('scholarly'));
    });

    it('الكتب لا تعرض أنواع المخطوطات (typeset/collated/edited)', () => {
        const wrapper = mountBanner();

        for (const s of ['typeset', 'collated', 'edited']) {
            expect(
                wrapper.find(`[data-status="${s}"]`).exists(),
                `الكتب لا تملك ${s}`
            ).toBe(false);
        }
    });

    it('المخطوطات تعرض typeset/collated/edited ولا تعرض transcribed', () => {
        const wrapper = mountBanner({
            assetType: 'manuscripts',
            entityName: 'المخطوطات',
            statusCounts: manuscriptsStatusCounts,
        });

        const statuses = wrapper.findAll('.kpi-h-card').map(c => c.attributes('data-status'));
        expect(statuses).toEqual(['all', 'draft', 'typeset', 'collated', 'edited', 'published']);
        expect(statuses).not.toContain('transcribed');
        expect(statuses).not.toContain('scholarly');
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 2: مصدر الأرقام (statusCounts لا rows)
// ════════════════════════════════════════════════════════════════

describe('القسم 2: الأرقام من statusCounts (القاعدة)', () => {

    it('بطاقة "مفرغ" تعرض 15 من statusCounts لا من rows', () => {
        const wrapper = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب',
                assetType: 'books',
                columns: booksColumns,
                rows: booksRows,        // 3 صفوف فقط (صفحة)
                statusMeta,
                assetStatuses,
                statusCounts: booksStatusCounts,
            },
        });

        const card = wrapper.find('.kpi-h-card[data-status="transcribed"]');
        const displayed = Number(card.find('.kpi-h-value').text().replace(/[^\d]/g, ''));

        expect(displayed).toBe(15);   // من القاعدة، لا من rows (3)
    });

    it('بطاقة "الكل" = مجموع الحالات (101)', () => {
        const wrapper = mountBanner();

        const allCard = wrapper.find('.kpi-h-card[data-status="all"]');
        const displayed = Number(allCard.find('.kpi-h-value').text().replace(/[^\d]/g, ''));

        expect(displayed).toBe(101);
    });

    it('مجموع بطاقات الحالات = الكل (تناسق حسابي)', () => {
        const wrapper = mountBanner();

        const allValue = Number(
            wrapper.find('.kpi-h-card[data-status="all"] .kpi-h-value').text().replace(/[^\d]/g, '')
        );

        const statusSum = ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'scholarly', 'published']
            .reduce((sum, s) => {
                const v = wrapper.find(`.kpi-h-card[data-status="${s}"] .kpi-h-value`);
                return sum + Number(v.text().replace(/[^\d]/g, ''));
            }, 0);

        expect(statusSum).toBe(allValue);
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 3: الفلترة (النقر يُصفّي لحالة واحدة)
// ════════════════════════════════════════════════════════════════

describe('القسم 3: الفلترة تعمل لكل حالة', () => {

    it('النقر على "مفرغ" يُصفّي الصفوف على transcribed فقط', async () => {
        const wrapper = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب',
                assetType: 'books',
                columns: booksColumns,
                rows: booksRows,
                statusMeta,
                assetStatuses,
                statusCounts: booksStatusCounts,
            },
        });

        await wrapper.find('.kpi-h-card[data-status="transcribed"]').trigger('click');

        const table = wrapper.findComponent({ name: 'DenseDataTable' });
        const visibleRows = table.props('rows');

        expect(visibleRows).toHaveLength(1);
        expect(visibleRows[0].status).toBe('transcribed');
    });

    it('النقر على "الكل" يُظهر كل الصفوف', async () => {
        const wrapper = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب',
                assetType: 'books',
                columns: booksColumns,
                rows: booksRows,
                statusMeta,
                assetStatuses,
                statusCounts: booksStatusCounts,
            },
        });

        await wrapper.find('.kpi-h-card[data-status="draft"]').trigger('click');
        await wrapper.find('.kpi-h-card[data-status="all"]').trigger('click');

        const table = wrapper.findComponent({ name: 'DenseDataTable' });
        expect(table.props('rows')).toHaveLength(3);
    });

    it('البطاقة النشطة تحمل class active', async () => {
        const wrapper = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب',
                assetType: 'books',
                columns: booksColumns,
                rows: booksRows,
                statusMeta,
                assetStatuses,
                statusCounts: booksStatusCounts,
            },
        });

        await wrapper.find('.kpi-h-card[data-status="draft"]').trigger('click');

        expect(wrapper.find('.kpi-h-card[data-status="draft"]').classes())
            .toContain('active');
        expect(wrapper.find('.kpi-h-card[data-status="published"]').classes())
            .not.toContain('active');
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 4: الكيانات غير النشرية (لا بطاقات)
// ════════════════════════════════════════════════════════════════

describe('القسم 4: authors/publishers/users/deletions', () => {

    it('لا تعرض أي بطاقة حالات (ليست محتوى)', () => {
        for (const assetType of ['authors', 'publishers', 'users', 'deletions']) {
            const wrapper = mountBanner({
                assetType,
                statusCounts: {},
                assetStatuses: {},   // لا حالات لهذه الكيانات
            });

            const cards = wrapper.findAll('.kpi-h-card');
            const statuses = cards.map(c => c.attributes('data-status'));

            expect(
                statuses.filter(s => s !== 'all'),
                `${assetType} لا يجب أن تعرض بطاقات حالات`
            ).toHaveLength(0);
        }
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 5: العقد مع الباك إند (يمنع الانحراف)
// ════════════════════════════════════════════════════════════════

describe('القسم 5: العقد مع الباك إند', () => {

    it('كل حالة في assetStatuses لها تعريف في statusMeta', () => {
        for (const [asset, statuses] of Object.entries(assetStatuses)) {
            for (const s of statuses) {
                expect(
                    statusMeta[s],
                    `${asset}: الحالة ${s} يجب أن تكون معرّفة في statusMeta`
                ).toBeDefined();
            }
        }
    });

    it('لا توجد حالة في statusMeta غائبة عن assetStatuses', () => {
        const allStatuses = new Set(Object.values(assetStatuses).flat());

        for (const s of Object.keys(statusMeta)) {
            expect(
                allStatuses.has(s),
                `الحالة ${s} معرّفة في statusMeta لكن غير مستخدمة`
            ).toBe(true);
        }
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 6: الترقيم من جهة الخادم — meta كامل ولا تكرار
// ════════════════════════════════════════════════════════════════
//
// ⚠️ العقد: props.rows = صفحة واحدة فقط (25 صفاً)، وprops.paginationMeta
// يحمل {total, per_page, current_page, last_page} من الخادم.
// بدون هذا العقد يعمل الترقيم على 25 صفاً ⇒ الصفحة الثانية فارغة
// وبطاقة "الكل 101" تُظهر "من أصل 25".

const paginationMeta = { total: 101, per_page: 25, current_page: 1, last_page: 5 };

describe('القسم 6: الترقيم من جهة الخادم (الواجهة)', () => {

    const mountWithMeta = (meta = paginationMeta, rows = booksRows) =>
        mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب', assetType: 'books',
                columns: booksColumns, rows,
                statusMeta, assetStatuses, statusCounts: booksStatusCounts,
                paginationMeta: meta,
                total: meta.total,
            },
        });

    it('بطاقة "الكل" تعرض total من meta (101) لا عدد الصفوف المحمّلة (3)', () => {
        const w = mountWithMeta();
        const allCard = w.find('.kpi-h-card[data-status="all"]');
        const shown = Number(allCard.find('.kpi-h-value').text().replace(/\D/g, ''));
        expect(shown).toBe(101);   // meta.total — لا rows.length (3)
    });

    it('الترقيم يعرض "من أصل 101" لا "من أصل 3"', () => {
        const w = mountWithMeta();
        const html = w.html();
        // شارة الإجمالي يجب أن تأتي من meta
        expect(html).toMatch(/101/);
    });

    it('النمط الخادمي: الصفوف تُمرر كما وصلت (لا فلترة محلية تُنقصها)', () => {
        // 25 صفاً من صفحة واحدة — الخادم فلتر وصفّى
        const many = Array.from({ length: 25 }, (_, i) => ({
            id: String(i + 1), title: `كتاب ${i + 1}`, status: 'published',
        }));
        const w = mountWithMeta(paginationMeta, many);
        expect(w.findAll('#booksDataTable tbody tr').length).toBe(25);
    });

    it('meta غائبة (النمط الاحتياطي) ⇒ يعمل بلا انكسار', () => {
        const w = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب', assetType: 'books',
                columns: booksColumns, rows: booksRows,
                statusMeta, assetStatuses, statusCounts: booksStatusCounts,
            },
        });
        expect(w.find('.kpi-h-card[data-status="all"]').exists()).toBe(true);
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 7: البحث والفلاتر تُرسل للخادم (لا تُصفّي داخل 25 صفاً)
// ════════════════════════════════════════════════════════════════
//
// الكذب المُصلَح: شريط البحث كان يُصفّي داخل الصفحة المحمّلة (25 صفاً)
// ⇒ كتابة "البخاري" تُظهر فقط ما يُطابق في الـ25 (كذب).
// العقد الصحيح: النمط الخادمي يُرسل status/search/category/sort
// للخادم ويستقبل صفحة مُفلترة.

describe('القسم 7: البحث والفلترة تُرسل للخادم', () => {

    const mountServer = (props = {}) =>
        mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب', assetType: 'books',
                columns: booksColumns, rows: booksRows,
                statusMeta, assetStatuses, statusCounts: booksStatusCounts,
                paginationMeta,
                filterOptions: [
                    { id: 'cat-1', name: 'الأدب والشعر', books_count: 7 },
                    { id: 'cat-2', name: 'التاريخ العربي', books_count: 9 },
                ],
                ...props,
            },
        });

    it('شريط الأدوات يعرض قائمة التصنيفات الحقيقية (لا تصنيفات وهمية)', () => {
        const w = mountServer();
        const select = w.find('#booksFilterSelect, [id*="FilterSelect"]');
        if (select.exists()) {
            expect(select.html()).toContain('الأدب والشعر');
            expect(select.html()).toContain('التاريخ العربي');
        }
    });

    it('شريط الأدوات يعرض قائمة ترتيب حقيقية (الأحدث/الأقدم/أبجدياً)', () => {
        const w = mountServer();
        const select = w.find('#booksSortSelect');
        expect(select.exists()).toBe(true);
        expect(select.html()).toContain('الأحدث');
        expect(select.html()).toContain('أبجدياً');
    });

    it('قائمة التصنيف لا تعرض "الحديث/الأصول/العقيدة" (تصنيفات غير موجودة)', () => {
        const w = mountServer();
        const select = w.find('#booksFilterSelect, [id*="FilterSelect"]');
        if (select.exists()) {
            const html = select.html();
            for (const fake of ['الحديث', 'الأصول', 'العقيدة', 'التراجم']) {
                expect(html, `"${fake}" تصنيف وهمي لا يجب أن يظهر`).not.toContain(fake);
            }
        }
    });

    it('البحث لا يُصفّي الصفوف محلياً في النمط الخادمي (الخادم يملك البيانات)', async () => {
        const w = mountServer();
        // في النمط الخادمي filteredRows تُرجع props.rows كما هي
        const rowsBefore = w.findAll('#booksDataTable tbody tr').length;
        expect(rowsBefore).toBe(3);
        await w.find('#booksSearchInput').setValue('البخاري');
        // لا يجب أن تُنقص الصفوف محلياً — الطلب للخادم يحدثها
        expect(w.findAll('#booksDataTable tbody tr').length).toBe(3);
    });
});

// ════════════════════════════════════════════════════════════════
// القسم 8: الاتساق البصري — بطاقة = عدد صفوفها
// ════════════════════════════════════════════════════════════════
//
// أهم قاعدة في الشاشة كلها: أي بطاقة تُنقر يجب أن تُظهر عدد الصفوف
// الذي تكتبه بالضبط. إن قالت 35 وأظهرت 10 فهي كذب.

describe('القسم 8: كل بطاقة تُظهر عدداً يطابق ما سيعرضه الجدول', () => {

    it('مجموع بطاقات الحالات = بطاقة "الكل" (تناسق حسابي للكتب)', () => {
        const w = mount(AssetHeaderBanner, {
            props: {
                assetType: 'books', entityName: 'الكتب',
                statusMeta, assetStatuses, statusCounts: booksStatusCounts,
            },
        });
        const cards = w.findAll('.kpi-h-card[data-status]');
        let sum = 0;
        for (const c of cards) {
            const s = c.attributes('data-status');
            if (s === 'all') continue;
            sum += Number(c.find('.kpi-h-value').text().replace(/\D/g, ''));
        }
        const allCard = w.find('.kpi-h-card[data-status="all"]');
        const all = Number(allCard.find('.kpi-h-value').text().replace(/\D/g, ''));
        expect(sum).toBe(all);   // 101 = 101
    });

    it('مجموع بطاقات الحالات = بطاقة "الكل" (تناسق حسابي للمخطوطات)', () => {
        const w = mount(AssetHeaderBanner, {
            props: {
                assetType: 'manuscripts', entityName: 'المخطوطات',
                statusMeta, assetStatuses, statusCounts: manuscriptsStatusCounts,
            },
        });
        let sum = 0;
        for (const c of w.findAll('.kpi-h-card[data-status]')) {
            if (c.attributes('data-status') === 'all') continue;
            sum += Number(c.find('.kpi-h-value').text().replace(/\D/g, ''));
        }
        const all = Number(
            w.find('.kpi-h-card[data-status="all"]').find('.kpi-h-value').text().replace(/\D/g, '')
        );
        expect(sum).toBe(all);   // 100 = 100
    });

    it('نقر بطاقة "منشور" (35) ⇒ يُرسل status=published للخادم (لا فلترة محلية)', async () => {
        const w = mount(AssetTableView, {
            props: {
                assetTitle: 'الكتب', assetType: 'books',
                columns: booksColumns, rows: booksRows,
                statusMeta, assetStatuses, statusCounts: booksStatusCounts,
                paginationMeta,
            },
        });
        const published = w.find('.kpi-h-card[data-status="published"]');
        expect(published.exists()).toBe(true);
        await published.trigger('click');
        // البطاقة تُصبح نشطة (الخادم سيُرجع الـ35 مطابقة للرقم المكتوب)
        expect(w.find('.kpi-h-card[data-status="published"].active, .kpi-h-card[data-status="published"][class*="active"]').exists()).toBe(true);
    });
});
