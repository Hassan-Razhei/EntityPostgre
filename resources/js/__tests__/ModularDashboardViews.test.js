import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import DashboardStatsView from '@/Pages/AdminDashboard/Views/DashboardStatsView.vue';
import DashboardCommandsView from '@/Pages/AdminDashboard/Views/DashboardCommandsView.vue';
import DashboardOpsView from '@/Pages/AdminDashboard/Views/DashboardOpsView.vue';
import DashboardTaxonomyView from '@/Pages/AdminDashboard/Views/DashboardTaxonomyView.vue';
import DashboardStudioView from '@/Pages/AdminDashboard/Views/DashboardStudioView.vue';
import axios from 'axios';

vi.mock('axios', () => ({
  default: {
    post: vi.fn(),
  },
}));

describe('Modular Dashboard Views (Cycle 23 TDD)', () => {
  describe('1. DashboardStatsView.vue', () => {
    it('renders live stats counts and KPI cards correctly', () => {
      const stats = {
        books: 1250,
        manuscripts: 340,
        audios: 89,
        videos: 45,
        funnel_drafts: 15,
        funnel_reviewed: 30,
        funnel_scholarly: 50,
        funnel_published: 1250,
      };

      const wrapper = mount(DashboardStatsView, {
        props: { stats },
      });

      expect(wrapper.text()).toContain('لوحة المؤشرات والإحصائيات المركزية');
      expect(wrapper.text()).toContain('1,250');
      expect(wrapper.text()).toContain('340');
      expect(wrapper.text()).toContain('89');
      expect(wrapper.text()).toContain('45');
      expect(wrapper.text()).toContain('مسار تدفق النشر والتحقيق');
    });

    it('emits navigate event when a KPI card is clicked', async () => {
      const wrapper = mount(DashboardStatsView, {
        props: { stats: { books: 100 } },
      });

      const cards = wrapper.findAll('.kpi-card');
      expect(cards.length).toBe(4);

      await cards[0].trigger('click');
      expect(wrapper.emitted('navigate')).toBeTruthy();
      expect(wrapper.emitted('navigate')[0]).toEqual(['books']);

      await cards[1].trigger('click');
      expect(wrapper.emitted('navigate')[1]).toEqual(['manuscripts']);
    });
  });

  describe('2. DashboardCommandsView.vue', () => {
    it('renders custom console commands and executes artisan command on button click', async () => {
      axios.post.mockResolvedValueOnce({
        data: {
          status: 'success',
          output: 'Storage synchronized successfully',
        },
      });

      const wrapper = mount(DashboardCommandsView, {
        attachTo: document.body,
      });

      expect(wrapper.text()).toContain('أوامر المنظومة المخصصة');
      expect(wrapper.text()).toContain('storage:sync');
      expect(wrapper.text()).toContain('manuscript:sync');
      expect(wrapper.text()).toContain('analyze:architecture');

      // Test preset command trigger
      await wrapper.vm.runPresetCmd('storage:sync');
      expect(axios.post).toHaveBeenCalledWith('/api/system/run-command', {
        command: 'storage:sync',
      });

      const output = document.getElementById('terminalOutput');
      expect(output.textContent).toContain('Storage synchronized successfully');

      wrapper.unmount();
    });
  });

  describe('3. DashboardOpsView.vue', () => {
    it('renders operations tools and handles navigation', async () => {
      const wrapper = mount(DashboardOpsView);

      expect(wrapper.text()).toContain('العمليات');
      expect(wrapper.text()).toContain('وضع الصيانة المؤسسي');
      expect(wrapper.text()).toContain('أدوات الصيانة الفورية المباشرة');

      const cards = wrapper.findAll('.entity-card');
      expect(cards.length).toBe(4);

      // 4th card is console commands
      await cards[3].trigger('click');
      expect(wrapper.emitted('navigate')).toBeTruthy();
      expect(wrapper.emitted('navigate')[0]).toEqual(['commands']);
    });
  });

  describe('4. DashboardTaxonomyView.vue', () => {
    it('renders collections taxonomy table with actions and count badges', () => {
      const collections = [
        {
          id: 'col-1',
          name: 'خزانة التراث الأندلسي',
          description: 'مختارات من نوادر المخطوطات والكتب الأندلسية',
          is_public: true,
          entities_count: 34,
          user_name: 'د. طارق الحارثي',
          show_url: '/collections/col-1',
          edit_url: '/collections/col-1/edit',
        },
      ];

      const wrapper = mount(DashboardTaxonomyView, {
        props: {
          taxonomyType: 'collections',
          items: collections,
        },
      });

      expect(wrapper.text()).toContain('المجموعات المعرفية');
      expect(wrapper.text()).toContain('خزانة التراث الأندلسي');
      expect(wrapper.text()).toContain('34');
      expect(wrapper.text()).toContain('د. طارق الحارثي');
      expect(wrapper.find('a[href="/collections/col-1"]').exists()).toBe(true);
    });

    it('renders series taxonomy table correctly', () => {
      const series = [
        {
          id: 'ser-1',
          title: 'سلسلة أعلام المحدثين',
          description: 'تراجم مسندة للأئمة',
          books_count: 12,
          order_column: 1,
          show_url: '/series/ser-1',
        },
      ];

      const wrapper = mount(DashboardTaxonomyView, {
        props: {
          taxonomyType: 'series',
          items: series,
        },
      });

      expect(wrapper.text()).toContain('السلاسل العلمية');
      expect(wrapper.text()).toContain('سلسلة أعلام المحدثين');
      expect(wrapper.text()).toContain('12 مصنفاً');
    });
  });

  describe('5. DashboardStudioView.vue (Cycle 24 TDD)', () => {
    it('renders studio books with high density table, progress bar, and editor link', () => {
      const studioBooks = [
        {
          id: 101,
          title: 'فتح الباري شرح صحيح البخاري',
          slug: 'fath-al-bari',
          current_node: 'كتاب الإيمان - باب علامة الإيمان حب الأنصار',
          progress_percent: 88,
          editor_name: 'د. عبد الله الشمري',
          updated_at_human: 'منذ ساعة',
          studio_url: '/studio/book/fath-al-bari',
        },
      ];

      const wrapper = mount(DashboardStudioView, {
        props: {
          studioType: 'studio-books',
          items: studioBooks,
        },
      });

      expect(wrapper.text()).toContain('استوديو تحرير الكتب');
      expect(wrapper.text()).toContain('فتح الباري شرح صحيح البخاري');
      expect(wrapper.text()).toContain('كتاب الإيمان - باب علامة الإيمان حب الأنصار');
      expect(wrapper.text()).toContain('88%');
      expect(wrapper.text()).toContain('د. عبد الله الشمري');
      expect(wrapper.find('a[href="/studio/book/fath-al-bari"]').exists()).toBe(true);
      expect(wrapper.find('#studioSearchInput').exists()).toBe(true);
      expect(wrapper.find('#btnStudioViewTable').exists()).toBe(true);
      expect(wrapper.find('#btnStudioViewCards').exists()).toBe(true);
    });

    it('renders studio manuscripts with inspection indicators and cards view mode switch', async () => {
      const manuscripts = [
        {
          id: 202,
          title: 'مخطوطة موطأ مالك رواية يحيى',
          slug: 'muwatta-malik-ms',
          folio_count: 'اللوحة 45 (الوجه أ)',
          author: 'الإمام مالك بن أنس',
          studio_url: '/studio/manuscript/muwatta-malik-ms',
        },
      ];

      const wrapper = mount(DashboardStudioView, {
        props: {
          studioType: 'studio-manuscripts',
          items: manuscripts,
        },
      });

      expect(wrapper.text()).toContain('استوديو المخطوطات');
      expect(wrapper.text()).toContain('مخطوطة موطأ مالك رواية يحيى');
      expect(wrapper.text()).toContain('اللوحة 45 (الوجه أ)');
      expect(wrapper.find('a[href="/studio/manuscript/muwatta-malik-ms"]').exists()).toBe(true);

      // Switch to cards view mode
      const cardsBtn = wrapper.find('#btnStudioViewCards');
      expect(cardsBtn.exists()).toBe(true);
      await cardsBtn.trigger('click');

      expect(wrapper.find('.studio-cards-grid').isVisible()).toBe(true);
      expect(wrapper.find('.studio-entity-card').exists()).toBe(true);
    });

    it('filters studio items when typing into studio search input', async () => {
      const books = [
        { id: 1, title: 'سنن أبي داود', current_node: 'المقدمة', progress_percent: 50 },
        { id: 2, title: 'سنن الترمذي', current_node: 'أبواب الطهارة', progress_percent: 70 },
      ];

      const wrapper = mount(DashboardStudioView, {
        props: {
          studioType: 'studio-books',
          items: books,
        },
      });

      expect(wrapper.text()).toContain('سنن أبي داود');
      expect(wrapper.text()).toContain('سنن الترمذي');

      const searchInput = wrapper.find('#studioSearchInput');
      await searchInput.setValue('الترمذي');

      expect(wrapper.text()).not.toContain('سنن أبي داود');
      expect(wrapper.text()).toContain('سنن الترمذي');
    });

    it('renders versions view with version details and format chips', () => {
      const versions = [
        {
          id: 501,
          title: 'طبعة المكنز الإسلامي الفاخرة',
          versionable_title: 'سنن النسائي الصغرى',
          publisher_name: 'دار التأصيل',
          file_size_human: '15.6 MB',
          format: 'PDF',
          created_at_human: 'منذ يومين',
        },
      ];

      const wrapper = mount(DashboardStudioView, {
        props: {
          studioType: 'versions',
          items: versions,
          versions,
        },
      });

      expect(wrapper.text()).toContain('الإصدارات والنسخ المقارنة');
      expect(wrapper.text()).toContain('طبعة المكنز الإسلامي الفاخرة');
      expect(wrapper.text()).toContain('سنن النسائي الصغرى');
      expect(wrapper.text()).toContain('دار التأصيل');
      expect(wrapper.text()).toContain('15.6 MB');
      expect(wrapper.text()).toContain('PDF');
    });
  });
});

