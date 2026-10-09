import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import DashboardStatsView from '@/Pages/AdminDashboard/Views/DashboardStatsView.vue';
import DashboardCommandsView from '@/Pages/AdminDashboard/Views/DashboardCommandsView.vue';
import DashboardOpsView from '@/Pages/AdminDashboard/Views/DashboardOpsView.vue';
import DashboardTaxonomyView from '@/Pages/AdminDashboard/Views/DashboardTaxonomyView.vue';
import DashboardStudioView from '@/Pages/AdminDashboard/Views/DashboardStudioView.vue';
import DashboardLibraryView from '@/Pages/AdminDashboard/Views/DashboardLibraryView.vue';
import DashboardPeopleView from '@/Pages/AdminDashboard/Views/DashboardPeopleView.vue';
import AdminDashboardSidebar from '@/Pages/AdminDashboard/AdminDashboardSidebar.vue';
import AdminDashboardNavbar from '@/Pages/AdminDashboard/AdminDashboardNavbar.vue';
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

  describe('4. DashboardTaxonomyView.vue (Cycle 25 Cognitive Explorer TDD)', () => {
    it('renders collections dossier portfolio binder cards with asset breakdown badges and actions', () => {
      const collections = [
        {
          id: 'col-1',
          name: 'خزانة التراث الأندلسي',
          description: 'مختارات من نوادر المخطوطات والكتب الأندلسية',
          is_public: true,
          entities_count: 34,
          books_count: 20,
          manuscripts_count: 10,
          audios_count: 4,
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
      expect(wrapper.find('a[href="/collections/col-1/edit"]').exists()).toBe(true);
      expect(wrapper.find('#taxonomySearchInput').exists()).toBe(true);
      expect(wrapper.find('.collection-dossier-card').exists()).toBe(true);
    });

    it('renders series linear volume sequence cards with volume ordering and counts', () => {
      const series = [
        {
          id: 'ser-1',
          title: 'سلسلة أعلام المحدثين',
          description: 'تراجم مسندة للأئمة',
          books_count: 12,
          order_column: 1,
          show_url: '/series/ser-1',
          edit_url: '/series/ser-1/edit',
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
      expect(wrapper.find('.series-volume-card').exists()).toBe(true);
      expect(wrapper.text()).toContain('المجلد #1');
    });

    it('renders semantic tag cloud with proportional weight tags and count labels', () => {
      const tags = [
        { id: 1, name: 'فقه_مقارن', books_count: 145 },
        { id: 2, name: 'مخطوطات_نادرة', books_count: 88 },
      ];

      const wrapper = mount(DashboardTaxonomyView, {
        props: {
          taxonomyType: 'tags',
          items: tags,
        },
      });

      expect(wrapper.text()).toContain('الأوسمة والكلمات المفتاحية');
      expect(wrapper.find('.semantic-tag-cloud').exists()).toBe(true);
      expect(wrapper.text()).toContain('#فقه_مقارن');
      expect(wrapper.text()).toContain('(145)');
    });

    it('renders hierarchical categories tree with glowing connector nodes', () => {
      const categories = [
        { id: 1, name: 'علوم القرآن والتفسير', books_count: 2450 },
      ];

      const wrapper = mount(DashboardTaxonomyView, {
        props: {
          taxonomyType: 'categories',
          items: categories,
        },
      });

      expect(wrapper.text()).toContain('التصنيفات والفئات');
      expect(wrapper.find('.categories-tree-explorer').exists()).toBe(true);
      expect(wrapper.text()).toContain('علوم القرآن والتفسير');
      expect(wrapper.text()).toContain('2,450 مصنفاً');
    });

    it('filters taxonomy items when typing into taxonomy search input', async () => {
      const collections = [
        { id: '1', name: 'خزانة التراث الأندلسي', description: 'أندلسيات', entities_count: 10 },
        { id: '2', name: 'موسوعة الفقه الحنبلي', description: 'فقهيات', entities_count: 25 },
      ];

      const wrapper = mount(DashboardTaxonomyView, {
        props: {
          taxonomyType: 'collections',
          items: collections,
        },
      });

      expect(wrapper.text()).toContain('خزانة التراث الأندلسي');
      expect(wrapper.text()).toContain('موسوعة الفقه الحنبلي');

      const searchInput = wrapper.find('#taxonomySearchInput');
      await searchInput.setValue('الحنبلي');

      expect(wrapper.text()).not.toContain('خزانة التراث الأندلسي');
      expect(wrapper.text()).toContain('موسوعة الفقه الحنبلي');
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

  describe('6. DashboardLibraryView.vue (Cycle 26 TDD)', () => {
    it('renders books view with high density table, active rows, and reader links', () => {
      const books = [
        {
          id: 1,
          title: 'صحيح البخاري - طبعة دار التأصيل',
          author: 'محمد بن إسماعيل البخاري',
          isbn: '978-1-23456-789-0',
          category: 'الحديث النبوي وعلومه',
          status: 'محقق معتمد',
          reader_url: '/reader/book/bukhari-taseel',
        },
      ];

      const wrapper = mount(DashboardLibraryView, {
        props: {
          libraryType: 'books',
          items: books,
          stats: { books: 1482 },
          createUrl: '/books/create',
        },
      });

      expect(wrapper.text()).toContain('الكتب');
      expect(wrapper.text()).toContain('صحيح البخاري - طبعة دار التأصيل');
      expect(wrapper.text()).toContain('محمد بن إسماعيل البخاري');
      expect(wrapper.find('a[href="/reader/book/bukhari-taseel"]').exists()).toBe(true);
    });

    it('renders manuscripts view with folio badges and restoration indicators', () => {
      const manuscripts = [
        {
          id: 'ms-1',
          title: 'الموطأ للإمام مالك - رواية يحيى بن يحيى الليثي',
          author: 'مالك بن أنس',
          code: 'MS-AR-842',
          condition: 'مرمم بالكامل',
          script_type: 'كوفي أندلسي عتيق',
          studio_url: '/studio/manuscript/muwatta-ms',
        },
      ];

      const wrapper = mount(DashboardLibraryView, {
        props: {
          libraryType: 'manuscripts',
          items: manuscripts,
          stats: { manuscripts: 428 },
          createUrl: '/manuscripts/create',
        },
      });

      expect(wrapper.text()).toContain('المخطوطات');
      expect(wrapper.text()).toContain('الموطأ للإمام مالك');
      expect(wrapper.text()).toContain('MS-AR-842');
      expect(wrapper.text()).toContain('مرمم بالكامل');
    });

    it('renders media views (audios and videos) with duration and player triggers', () => {
      const audios = [
        {
          id: 'aud-1',
          title: 'شرح العقيدة الواسطية - الشريط الأول',
          speaker: 'الشيخ محمد بن صالح العثيمين',
          duration: '45:20',
          format: 'MP3',
        },
      ];

      const wrapper = mount(DashboardLibraryView, {
        props: {
          libraryType: 'audios',
          items: audios,
          stats: { audios: 650 },
          createUrl: '/audios/create',
        },
      });

      expect(wrapper.text()).toContain('الصوتيات');
      expect(wrapper.text()).toContain('شرح العقيدة الواسطية');
      expect(wrapper.text()).toContain('45:20');
      expect(wrapper.text()).toContain('MP3');
    });
  });

  describe('7. DashboardPeopleView.vue (Cycle 26 TDD - Tables Preservation)', () => {
    it('renders authors view in table mode preserving high density table structure', () => {
      const authors = [
        {
          id: 'auth-1',
          name: 'شمس الدين الذهبي',
          bio: 'محدث العصر وإمام التراجم والتاريخ الإسلامي',
          works_count: 84,
          era: 'القرن الثامن الهجري',
        },
      ];

      const wrapper = mount(DashboardPeopleView, {
        props: {
          peopleType: 'authors',
          items: authors,
          stats: { authors: 340 },
          createUrl: '/authors/create',
        },
      });

      expect(wrapper.text()).toContain('المؤلفون');
      expect(wrapper.text()).toContain('شمس الدين الذهبي');
      expect(wrapper.text()).toContain('محدث العصر وإمام التراجم');
      expect(wrapper.text()).toContain('84');
      // Preserves table mode as strictly requested
      expect(wrapper.find('.dense-table, table, .asset-table-view').exists()).toBe(true);
    });

    it('renders publishers view in table mode preserving high density table structure', () => {
      const publishers = [
        {
          id: 'pub-1',
          name: 'دار المنهاج للنشر والتوزيع',
          location: 'جدة، المملكة العربية السعودية',
          publications_count: 312,
          is_verified: true,
        },
      ];

      const wrapper = mount(DashboardPeopleView, {
        props: {
          peopleType: 'publishers',
          items: publishers,
          stats: { publishers: 95 },
          createUrl: '/publishers/create',
        },
      });

      expect(wrapper.text()).toContain('الناشرون');
      expect(wrapper.text()).toContain('دار المنهاج للنشر والتوزيع');
      expect(wrapper.text()).toContain('312');
      // Preserves table mode as strictly requested
      expect(wrapper.find('.dense-table, table, .asset-table-view').exists()).toBe(true);
    });
  });

  describe('8. AdminDashboardSidebar.vue (Cycle 26 Shell Extraction TDD)', () => {
    const mockStats = {
      books: 2450,
      manuscripts: 430,
      audios: 120,
      videos: 85,
      authors: 310,
      publishers: 95,
      categories: 48,
      tags: 165,
      collections: 24,
      series: 18,
      topics: 92,
      studio_books: 32,
      studio_manuscripts: 14,
      studio_audios: 9,
      studio_videos: 5,
      versions: 140,
      users: 52,
      activities: 180,
      deletions: 7,
    };

    it('renders all 5 navigation groups and live stats counters in badges', () => {
      const wrapper = mount(AdminDashboardSidebar, {
        props: {
          stats: mockStats,
          currentViewKey: 'books',
        },
      });

      expect(wrapper.find('#appSidebar').exists()).toBe(true);
      expect(wrapper.find('#group-library').exists()).toBe(true);
      expect(wrapper.find('#group-entities').exists()).toBe(true);
      expect(wrapper.find('#group-taxonomy').exists()).toBe(true);
      expect(wrapper.find('#group-studio').exists()).toBe(true);
      expect(wrapper.find('#group-sovereignty').exists()).toBe(true);

      // Verify badges
      expect(wrapper.find('#nav-books .badge-count').text()).toBe('2,450');
      expect(wrapper.find('#nav-manuscripts .badge-count').text()).toBe('430');
      expect(wrapper.find('#nav-studio-books .badge-count').text()).toContain('32');
      expect(wrapper.find('#nav-collections .badge-count').text()).toBe('24');
      expect(wrapper.find('#nav-deletions .badge-count').text()).toBe('7');
    });

    it('emits loadView event and triggers window.loadView when navigation item is clicked', async () => {
      const wrapper = mount(AdminDashboardSidebar, {
        props: {
          stats: mockStats,
          currentViewKey: 'stats',
        },
      });

      const navBooks = wrapper.find('#nav-books');
      await navBooks.trigger('click');

      expect(wrapper.emitted('loadView')).toBeTruthy();
      expect(wrapper.emitted('loadView')[0]).toEqual(['books']);
    });

    it('renders accordion toolbar with expand and collapse buttons', async () => {
      const wrapper = mount(AdminDashboardSidebar, {
        props: {
          stats: mockStats,
        },
      });

      expect(wrapper.find('#sidebarAccordionToolbar').exists()).toBe(true);
      expect(wrapper.find('#btnExpandAll').exists()).toBe(true);
      expect(wrapper.find('#btnCollapseAll').exists()).toBe(true);
    });
  });

  describe('9. AdminDashboardNavbar.vue (Cycle 26 Shell Extraction TDD)', () => {
    it('renders navbar shell with reactive 3-tier breadcrumbs matching props', () => {
      const wrapper = mount(AdminDashboardNavbar, {
        props: {
          currentGroupTitle: 'المكتبة',
          currentViewTitle: 'الكتب',
        },
      });

      expect(wrapper.find('#appNavbar').exists()).toBe(true);
      expect(wrapper.find('#breadcrumbGroup').text()).toBe('المكتبة');
      expect(wrapper.find('#breadcrumbCurrent').text()).toBe('الكتب');
    });

    it('emits toggleSidebar event when collapse toggle button is clicked', async () => {
      const wrapper = mount(AdminDashboardNavbar, {
        props: {
          currentGroupTitle: 'النظام',
          currentViewTitle: 'الإحصائيات',
        },
      });

      const toggleBtn = wrapper.find('button[title*="القائمة الجانبية"]');
      expect(toggleBtn.exists()).toBe(true);
      await toggleBtn.trigger('click');

      expect(wrapper.emitted('toggleSidebar')).toBeTruthy();
    });

    it('renders theme toggle and user profile dropdown components', () => {
      const wrapper = mount(AdminDashboardNavbar, {
        props: {
          currentGroupTitle: 'النظام',
          currentViewTitle: 'المستخدمون',
          user: {
            name: 'د. طارق الحارثي',
            email: 'tareq@entity.local',
          },
        },
      });

      expect(wrapper.find('#themeToggleBtn').exists()).toBe(true);
      expect(wrapper.find('#themeIconSun').exists()).toBe(true);
      expect(wrapper.find('#themeIconMoon').exists()).toBe(true);
      expect(wrapper.find('#userAvatarBtn').exists()).toBe(true);
      expect(wrapper.find('#userDropdownMenu').exists()).toBe(true);
      expect(wrapper.find('.user-dropdown-name').text()).toBe('د. طارق الحارثي');
      expect(wrapper.find('.user-dropdown-role').text()).toBe('tareq@entity.local');
    });
  });
});


