import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import axios from 'axios';
import AdminDashboard from '../Pages/AdminDashboard/Index.vue';

vi.mock('axios', () => ({
    default: {
        post: vi.fn(),
    },
}));

describe('AdminDashboard Cockpit Component (TDD)', () => {
    const mockStats = {
        books: 1500,
        manuscripts: 450,
        audios: 600,
        videos: 200,
        authors: 350,
        publishers: 90,
        categories: 45,
        tags: 160,
        users: 130,
        deletions: 12,
        versions: 850,
        activities: 75,
    };

    const mockActivities = [
        {
            id: 1,
            type: 'book',
            activity_type: 'publish',
            description: 'إجازة ونشر مصنف جديد',
            entity_title: 'صحيح البخاري',
            user_name: 'د. طارق الحارثي',
            user_avatar_char: 'ط',
            created_at: 'منذ 10 دقائق',
        },
    ];

    const mockUsers = [
        {
            id: 1,
            name: 'أحمد المشرف',
            email: 'admin@entity.org',
            role: 'super_admin',
            created_at: 'منذ يومين',
        },
    ];

    beforeEach(() => {
        vi.clearAllMocks();
        document.body.innerHTML = '';
        window.location.hash = '';
        window.scrollTo = vi.fn();

        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 1,
                        name: 'المدير العام',
                        role: 'super_admin',
                    },
                },
            },
        });
    });

    const createWrapper = (props = {}) => {
        return mount(AdminDashboard, {
            props: {
                stats: mockStats,
                recentActivities: mockActivities,
                recentUsers: mockUsers,
                ...props,
            },
            attachTo: document.body,
        });
    };

    it('renders live stats counts in sidebar badges', () => {
        const wrapper = createWrapper();
        const navBooks = wrapper.find('#nav-books');
        expect(navBooks.text()).toContain('1,500');

        const navManuscripts = wrapper.find('#nav-manuscripts');
        expect(navManuscripts.text()).toContain('450');

        const navDeletions = wrapper.find('#nav-deletions');
        expect(navDeletions.text()).toContain('12');
    });

    it('initializes with stats overview view by default', async () => {
        const wrapper = createWrapper();
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('لوحة المؤشرات والإحصائيات المركزية');
        expect(contentArea.html()).toContain('النظام يعمل بكفاءة');
        expect(contentArea.html()).toContain('قاعدة البيانات متصلة ومستقرة');
    });

    it('renders live users in users view when switched to users', async () => {
        const wrapper = createWrapper();
        window.loadView('users');

        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('المستخدمون');
        expect(contentArea.html()).toContain('أحمد المشرف');
        expect(contentArea.html()).toContain('admin@entity.org');
    });

    it('renders live activities in activities view when switched to activities', async () => {
        const wrapper = createWrapper();
        window.loadView('activities');

        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('النشاطات');
        expect(contentArea.html()).toContain('د. طارق الحارثي');
        expect(contentArea.html()).toContain('صحيح البخاري');
    });

    it('executes artisan command via runCmd and displays real output in terminal', async () => {
        axios.post.mockResolvedValueOnce({
            data: {
                status: 'success',
                output: 'Application cache cleared successfully.\nCompiled views cleared!',
            },
        });

        const wrapper = createWrapper();
        window.loadView('commands');
        await new Promise(r => setTimeout(r, 120));

        const input = document.getElementById('cmdInput');
        const output = document.getElementById('terminalOutput');
        expect(input).not.toBeNull();
        expect(output).not.toBeNull();

        input.value = 'optimize:clear';
        await window.runCmd();

        expect(axios.post).toHaveBeenCalledWith('/api/system/run-command', {
            command: 'optimize:clear',
        });
        expect(output.textContent).toContain('Application cache cleared successfully.');
    });

    it('displays error in terminal when command fails or is rejected', async () => {
        axios.post.mockRejectedValueOnce({
            response: {
                data: {
                    message: 'Command not allowed',
                },
            },
        });

        const wrapper = createWrapper();
        window.loadView('commands');
        await new Promise(r => setTimeout(r, 120));

        const input = document.getElementById('cmdInput');
        const output = document.getElementById('terminalOutput');
        input.value = 'migrate:fresh';
        await window.runCmd();

        expect(output.textContent).toContain('Command not allowed');
    });

    it('renders custom console command buttons in commands view and executes on click', async () => {
        axios.post.mockResolvedValueOnce({
            data: {
                status: 'success',
                output: 'Storage sync completed: 4 files registered.',
            },
        });

        const wrapper = createWrapper();
        window.loadView('commands');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        // Check presence of custom commands section and buttons
        expect(contentArea.html()).toContain('أوامر المنظومة المخصصة');
        expect(contentArea.html()).toContain('storage:sync');
        expect(contentArea.html()).toContain('manuscript:sync');
        expect(contentArea.html()).toContain('content:regenerate-slugs');
        expect(contentArea.html()).toContain('analyze:architecture');

        // Test preset command trigger
        expect(typeof window.runPresetCmd).toBe('function');
        await window.runPresetCmd('storage:sync');

        expect(axios.post).toHaveBeenCalledWith('/api/system/run-command', {
            command: 'storage:sync',
        });
        const input = document.getElementById('cmdInput');
        expect(input.value).toBe('');
        const output = document.getElementById('terminalOutput');
        expect(output.textContent).toContain('Storage sync completed');
    });

    it('renders full rich books table with interactive reader links, badges, and action buttons when switching to books view', async () => {
        const wrapper = createWrapper();
        window.loadView('books');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('booksDataTable');
        expect(contentArea.html()).toContain('booksSearchInput');
        expect(contentArea.html()).toContain('booksCategoryFilter');
        expect(contentArea.html()).toContain('columnsDropdownMenu');
        expect(contentArea.html()).toContain('bulkActionsStrip');
        expect(contentArea.html()).toContain('/books/fath-al-bari/reader');
        expect(contentArea.html()).toContain('/studio/book/fath-al-bari');
        expect(contentArea.html()).toContain('/authors');
        expect(contentArea.html()).toContain('🖼️ غلاف');
        expect(contentArea.html()).toContain('📄 PDF');
    });

    it('renders live database books from props.books via modular table engine preserving all Cycle 9 links and badges', async () => {
        const liveBooksMock = [
            {
                id: 99,
                serial: '#00099',
                title: 'مقدمة ابن خلدون التاريخية',
                slug: 'muqaddimah-ibn-khaldun',
                author: 'ابن خلدون',
                author_slug: 'ibn-khaldun',
                isbn: '978-977-123-456-7',
                description: 'ديوان المبتدأ والخبر في تاريخ العرب والبربر',
                has_cover: true,
                has_file: true,
                created_at_human: 'منذ ساعة',
                reader_url: '/books/muqaddimah-ibn-khaldun/reader',
                studio_url: '/studio/book/muqaddimah-ibn-khaldun',
                edit_url: '/books/99/edit',
            },
        ];

        const wrapper = createWrapper({ books: liveBooksMock });
        window.loadView('books');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(wrapper.findComponent({ name: 'AssetTableView' }).exists()).toBe(true);
        expect(contentArea.html()).toContain('مقدمة ابن خلدون التاريخية');
        expect(contentArea.html()).toContain('/books/muqaddimah-ibn-khaldun/reader');
        expect(contentArea.html()).toContain('/studio/book/muqaddimah-ibn-khaldun');
        expect(contentArea.html()).toContain('/books/99/edit');
        expect(contentArea.html()).toContain('ابن خلدون');
        expect(contentArea.html()).toContain('🖼️ غلاف');
        expect(contentArea.html()).toContain('📄 PDF');
        expect(contentArea.html()).toContain('booksDataTable');
        expect(contentArea.html()).toContain('booksSearchInput');
        expect(contentArea.html()).toContain('booksCategoryFilter');
        expect(contentArea.html()).toContain('columnsDropdownMenu');
        expect(contentArea.html()).toContain('bulkActionsStrip');
        expect(contentArea.html()).toContain('enterprise-card');
    });

    it('renders full rich manuscripts table with restoration and folio badges when switching to manuscripts view', async () => {
        const wrapper = createWrapper();
        window.loadView('manuscripts');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(wrapper.findAllComponents({ name: 'AssetTableView' }).length).toBe(1);
        expect(contentArea.html()).toContain('manuscriptsDataTable');
        expect(contentArea.html()).toContain('المخطوطات');
    });

    it('renders live database manuscripts from props.manuscripts via AssetTableView', async () => {
        const liveManuscripts = [
            {
                id: 'ms-1',
                serial: '#20101',
                code: 'MS-KOP-01',
                title: 'صحيح البخاري - نسخة كوبريلي الخزائنية',
                slug: 'sahih-bukhari-koprulu',
                century: 'القرن 7 هـ',
                copy_date: '685 هـ',
                copyist: 'شرف الدين اليونيني',
                script_type: 'ثلث مشرقي',
                source_library: 'مكتبة كوبريلي',
                condition: 'ممتازة 95%',
                has_cover: true,
                created_at_human: 'منذ ساعتين',
                reader_url: '/dev/manuscripter/sahih-bukhari-koprulu',
                studio_url: '/studio/manuscript/sahih-bukhari-koprulu',
                edit_url: '/manuscripts/ms-1/edit',
            },
        ];

        const wrapper = createWrapper({ manuscripts: liveManuscripts });
        window.loadView('manuscripts');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('صحيح البخاري - نسخة كوبريلي الخزائنية');
        expect(contentArea.html()).toContain('MS-KOP-01');
        expect(contentArea.html()).toContain('/dev/manuscripter/sahih-bukhari-koprulu');
        expect(contentArea.html()).toContain('/studio/manuscript/sahih-bukhari-koprulu');
        expect(contentArea.html()).toContain('/manuscripts/ms-1/edit');
    });

    it('renders live database audios from props.audios via AssetTableView', async () => {
        const liveAudios = [
            {
                id: 'aud-1',
                serial: '#30101',
                code: 'AUD-AJR-01',
                title: 'شرح الآجرومية في علم العربية',
                slug: 'sharh-ajrumiyyah',
                duration: '01:15:30',
                format: 'MP3',
                author: 'الشيخ ابن عثيمين',
                files: '🎧 صوتي + 🖼️ غلاف',
                created_at_human: 'أمس',
                player_url: '/audios/sharh-ajrumiyyah/player',
                studio_url: '/studio/audio/sharh-ajrumiyyah',
                edit_url: '/audios/aud-1/edit',
            },
        ];

        const wrapper = createWrapper({ audios: liveAudios });
        window.loadView('audios');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('audiosDataTable');
        expect(contentArea.html()).toContain('شرح الآجرومية في علم العربية');
        expect(contentArea.html()).toContain('AUD-AJR-01');
        expect(contentArea.html()).toContain('/audios/sharh-ajrumiyyah/player');
        expect(contentArea.html()).toContain('/studio/audio/sharh-ajrumiyyah');
    });

    it('renders live database videos from props.videos via AssetTableView', async () => {
        const liveVideos = [
            {
                id: 'vid-1',
                serial: '#40101',
                code: 'VID-HDT-01',
                title: 'مجلس علوم الحديث ومناهج المحدثين',
                slug: 'majlis-hadith',
                duration: '02:00:00',
                format: 'MP4',
                author: 'د. طارق الحارثي',
                files: '▶️ مرئي + 🖼️ غلاف',
                created_at_human: 'منذ يومين',
                player_url: '/videos/majlis-hadith/player',
                studio_url: '/studio/video/majlis-hadith',
                edit_url: '/videos/vid-1/edit',
            },
        ];

        const wrapper = createWrapper({ videos: liveVideos });
        window.loadView('videos');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('videosDataTable');
        expect(contentArea.html()).toContain('مجلس علوم الحديث ومناهج المحدثين');
        expect(contentArea.html()).toContain('VID-HDT-01');
        expect(contentArea.html()).toContain('/videos/majlis-hadith/player');
        expect(contentArea.html()).toContain('/studio/video/majlis-hadith');
    });

    it('renders full rich authors view with scholar biography cards and works count when switching to authors view', async () => {
        const liveAuthors = [
            {
                id: 'auth-1',
                name: 'ابن خلدون الحضرمي',
                slug: 'ibn-khaldun',
                century_lived: 'القرن 8 هـ',
                lifespan: '732 - 808 هـ',
                original_region: 'تونس / القاهرة',
                works_count: '24 مصنفاً',
                bio: 'مؤسس علم الاجتماع وصاحب المقدمة والتاريخ.',
                profile_url: '/authors/auth-1',
                edit_url: '/authors/auth-1/edit',
            },
        ];

        const wrapper = createWrapper({ authors: liveAuthors });
        window.loadView('authors');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('المؤلفون');
        expect(contentArea.html()).toContain('authorsDataTable');
        expect(contentArea.html()).toContain('authorsSearchInput');
        expect(contentArea.html()).toContain('authorsCategoryFilter');
        expect(contentArea.html()).toContain('ابن خلدون الحضرمي');
        expect(contentArea.html()).toContain('732 - 808 هـ');
        expect(contentArea.html()).toContain('24 مصنفاً');
        expect(contentArea.html()).toContain('/authors/auth-1');
        expect(contentArea.html()).toContain('/authors/auth-1/edit');
        expect(contentArea.html()).toContain('تصفح المؤلفات 📚');
        expect(contentArea.html()).toContain('تعديل السيرة ✏️');
    });

    it('renders full rich publishers view with verified press cards and publication counts when switching to publishers view', async () => {
        const livePublishers = [
            {
                id: 'pub-1',
                name: 'مؤسسة الرسالة ناشرون',
                slug: 'muassasat-al-risalah',
                country: 'بيروت - دمشق',
                established_year: '1975',
                publications_count: '520 مطبوعة مؤرشفة',
                status: 'ناشر معتمد 🏢',
                description: 'دار نشر متخصصة في تحقيق أمهات كتب السنة والتاريخ.',
                profile_url: '/publishers/pub-1',
                edit_url: '/publishers/pub-1/edit',
            },
        ];

        const wrapper = createWrapper({ publishers: livePublishers });
        window.loadView('publishers');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('الناشرون');
        expect(contentArea.html()).toContain('publishersDataTable');
        expect(contentArea.html()).toContain('publishersSearchInput');
        expect(contentArea.html()).toContain('publishersCategoryFilter');
        expect(contentArea.html()).toContain('مؤسسة الرسالة ناشرون');
        expect(contentArea.html()).toContain('520 مطبوعة مؤرشفة');
        expect(contentArea.html()).toContain('/publishers/pub-1');
        expect(contentArea.html()).toContain('عرض المنشورات 📖');
    });

    it('renders live users via modular table engine when switched to users view', async () => {
        const liveUsers = [
            {
                id: 'usr-1',
                name: 'د. عبد الله المنصور',
                email: 'admin@entity.local',
                role: 'super_admin',
                created_at: 'منذ شهرين',
            },
        ];

        const wrapper = createWrapper({ recentUsers: liveUsers });
        window.loadView('users');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('المستخدمون');
        expect(contentArea.html()).toContain('usersDataTable');
        expect(contentArea.html()).toContain('usersSearchInput');
        expect(contentArea.html()).toContain('د. عبد الله المنصور');
        expect(contentArea.html()).toContain('admin@entity.local');
        expect(contentArea.html()).toContain('chip-admin');
        expect(contentArea.html()).toContain('صلاحيات ⚙️');
    });

    it('renders live deletions in deletions view when soft-deleted items exist via modular table engine', async () => {
        const liveDeletions = [
            {
                id: 'del-1',
                title: 'مخطوطة السنن الكبرى المحذوفة مؤقتاً',
                type_label: 'مخطوط / Manuscript',
                type_chip: 'chip-academic',
                deleted_at_human: 'منذ يومين',
                days_remaining: 'باقي 28 يوماً',
            },
        ];

        const wrapper = createWrapper({ deletions: liveDeletions });
        window.loadView('deletions');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('المهملات');
        expect(contentArea.html()).toContain('deletionsDataTable');
        expect(contentArea.html()).toContain('deletionsSearchInput');
        expect(contentArea.html()).toContain('مخطوطة السنن الكبرى المحذوفة مؤقتاً');
        expect(contentArea.html()).toContain('باقي 28 يوماً');
        expect(contentArea.html()).toContain('استعادة الكيان ♻️');
    });

    it('renders native reactive ActivitiesTimelineView when switching to activities view', async () => {
        const liveActivities = [
            {
                id: 'act-1',
                user_name: 'د. عبد الله المنصور',
                user_avatar_char: 'ع',
                activity_type: 'إنشاء وتوثيق',
                description: 'إضافة مخطوطة نفيسة في الفقه المقارن',
                entity_title: 'صحيح البخاري - نسخة كوبريلي',
                created_at: 'منذ 15 دقيقة',
            },
        ];

        const wrapper = createWrapper({ recentActivities: liveActivities });
        window.loadView('activities');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('activities-timeline-view');
        expect(contentArea.html()).toContain('النشاطات');
        expect(contentArea.html()).toContain('timeline-container');
        expect(contentArea.html()).toContain('timeline-rail');
        expect(contentArea.html()).toContain('د. عبد الله المنصور');
        expect(contentArea.html()).toContain('إضافة مخطوطة نفيسة في الفقه المقارن');
        expect(contentArea.html()).toContain('صحيح البخاري - نسخة كوبريلي');
        expect(contentArea.html()).toContain('/activities');
    });

    it('maintains canonical metadata, breadcrumbs and component mounting for all 9 modular entities without raw string renderers', async () => {
        const wrapper = createWrapper();
        const entities = [
            { key: 'books', group: 'المكتبة', title: 'الكتب', expectedSelector: '#booksTableView' },
            { key: 'manuscripts', group: 'المكتبة', title: 'المخطوطات', expectedSelector: '#manuscriptsTableView' },
            { key: 'audios', group: 'المكتبة', title: 'الصوتيات', expectedSelector: '#audiosTableView' },
            { key: 'videos', group: 'المكتبة', title: 'المرئيات', expectedSelector: '#videosTableView' },
            { key: 'authors', group: 'الأشخاص', title: 'المؤلفون', expectedSelector: '#authorsGridView' },
            { key: 'publishers', group: 'الأشخاص', title: 'الناشرون', expectedSelector: '#publishersGridView' },
            { key: 'users', group: 'النظام', title: 'المستخدمون', expectedSelector: '#usersTableView' },
            { key: 'activities', group: 'النظام', title: 'النشاطات', expectedSelector: '.activities-timeline-view' },
            { key: 'deletions', group: 'النظام', title: 'المهملات', expectedSelector: '#deletionsTableView' },
        ];

        for (const entity of entities) {
            window.loadView(entity.key);
            await new Promise(r => setTimeout(r, 60));

            expect(wrapper.find('#breadcrumbGroup').text()).toBe(entity.group);
            expect(wrapper.find('#breadcrumbCurrent').text()).toBe(entity.title);
            expect(wrapper.find(entity.expectedSelector).exists()).toBe(true);
        }
    });

    it('renders live categories tree from props.categories', async () => {
        const liveCategories = [
            { id: 1, name: 'الفقه المقارن وأصوله', slug: 'comparative-fiqh', books_count: 145 },
            { id: 2, name: 'علوم الحديث ورجاله', slug: 'hadith-sciences', books_count: 320 },
        ];
        const wrapper = createWrapper({ categories: liveCategories });
        window.loadView('categories');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('الفقه المقارن وأصوله');
        expect(content).toContain('145 مصنفاً');
        expect(content).toContain('علوم الحديث ورجاله');
        expect(content).toContain('320 مصنفاً');
    });

    it('renders live tags cloud from props.tags', async () => {
        const liveTags = [
            { id: 1, name: 'الأصول_الفقهية', slug: 'usul-fiqh', books_count: 88 },
            { id: 2, name: 'مخطوطات_الأندلس', slug: 'andalus-manuscripts', books_count: 54 },
        ];
        const wrapper = createWrapper({ tags: liveTags });
        window.loadView('tags');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('#الأصول_الفقهية (88)');
        expect(content).toContain('#مخطوطات_الأندلس (54)');
    });

    it('renders live versions table from props.versions', async () => {
        const liveVersions = [
            {
                id: 101,
                title: 'طبعة المكنز المباركة',
                edition_number: 3,
                versionable_title: 'صحيح الإمام مسلم',
                versionable_type: 'book',
                versionable_slug: 'sahih-muslim',
                publisher_name: 'جمعية المكنز الإسلامي',
                format: 'PDF',
                file_size_human: '18.4 MB',
                created_at_human: 'منذ ساعتين',
            }
        ];
        const wrapper = createWrapper({ versions: liveVersions });
        window.loadView('versions');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('طبعة المكنز المباركة');
        expect(content).toContain('صحيح الإمام مسلم');
        expect(content).toContain('جمعية المكنز الإسلامي');
        expect(content).toContain('18.4 MB');
    });

    it('renders live studio books from props.studioBooks with direct editor links', async () => {
        const liveStudioBooks = [
            {
                id: 12,
                title: 'تيسير العلام شرح عمدة الأحكام',
                slug: 'taysir-al-allam',
                current_node: 'كتاب الطهارة - باب المياه',
                progress_percent: 85,
                editor_name: 'د. سامي العطاس',
                updated_at_human: 'منذ نصف ساعة',
                studio_url: '/studio/book/taysir-al-allam',
            }
        ];
        const wrapper = createWrapper({ studioBooks: liveStudioBooks });
        window.loadView('studio-books');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('تيسير العلام شرح عمدة الأحكام');
        expect(content).toContain('كتاب الطهارة - باب المياه');
        expect(content).toContain('85%');
        expect(content).toContain('د. سامي العطاس');
        expect(content).toContain('/studio/book/taysir-al-allam');
    });

    it('renders live PostgreSQL funnel and KPI stats in overview stats view without hardcoded strings', async () => {
        const detailedStats = {
            ...mockStats,
            books: 1980,
            funnel_drafts: 412,
            funnel_reviewed: 530,
            funnel_scholarly: 290,
            funnel_published: 1980,
            studio_books: 412,
            studio_manuscripts: 125,
            studio_audios: 98,
            studio_videos: 47,
        };
        const wrapper = createWrapper({ stats: detailedStats });
        window.loadView('stats');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('1,980');
        expect(content).toContain('412');
        expect(content).toContain('530');
        expect(content).toContain('290');
        expect(content).not.toContain("props.stats?.books");
        expect(content).not.toContain("'+ (props.stats");

        const sidebar = wrapper.find('#appSidebar');
        expect(sidebar.find('#nav-studio-books .badge-count').text()).toBe('412 مسودة');
        expect(sidebar.find('#nav-studio-manuscripts .badge-count').text()).toBe('125 لوحة');
        expect(sidebar.find('#nav-studio-audios .badge-count').text()).toBe('98 شريحة');
        expect(sidebar.find('#nav-studio-videos .badge-count').text()).toBe('47 مشهد');
    });

    it('renders live collections view from props.collections', async () => {
        const liveCollections = [
            {
                id: 'col-1',
                name: 'خزانة التراث الأندلسي',
                description: 'مختارات من نوادر المخطوطات والكتب الأندلسية',
                is_public: true,
                entities_count: 34,
                user_name: 'د. طارق الحارثي',
                show_url: '/collections/col-1',
            }
        ];
        const wrapper = createWrapper({ collections: liveCollections });
        window.loadView('collections');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('خزانة التراث الأندلسي');
        expect(content).toContain('34');
        expect(content).toContain('/collections/col-1');
        expect(wrapper.find('#breadcrumbGroup').text()).toBe('التنظيم');
        expect(wrapper.find('#breadcrumbCurrent').text()).toBe('المجموعات');
    });

    it('renders live series view from props.series', async () => {
        const liveSeries = [
            {
                id: 'ser-1',
                title: 'سلسلة أعلام الحديث النبوي',
                description: 'موسوعة تراجم أئمة الرواية والدراية عبر العصور',
                books_count: 18,
                show_url: '/series/ser-1',
            }
        ];
        const wrapper = createWrapper({ series: liveSeries });
        window.loadView('series');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('سلسلة أعلام الحديث النبوي');
        expect(content).toContain('18 مصنفاً');
        expect(content).toContain('/series/ser-1');
        expect(wrapper.find('#breadcrumbGroup').text()).toBe('التنظيم');
        expect(wrapper.find('#breadcrumbCurrent').text()).toBe('السلاسل');
    });

    it('renders live topics view from props.topics', async () => {
        const liveTopics = [
            {
                id: 'top-1',
                name: 'فقه المعاملات المالية المعاصرة',
                slug: 'financial-fiqh',
                books_count: 42,
            }
        ];
        const wrapper = createWrapper({ topics: liveTopics });
        window.loadView('topics');
        await new Promise(r => setTimeout(r, 60));

        const content = wrapper.find('#dynamicContentArea').html();
        expect(content).toContain('فقه المعاملات المالية المعاصرة');
        expect(content).toContain('42 مصنفاً');
        expect(wrapper.find('#breadcrumbGroup').text()).toBe('التنظيم');
        expect(wrapper.find('#breadcrumbCurrent').text()).toBe('الموضوعات');
    });

    it('renders live taxonomy stats counts in sidebar badges for collections, series, and topics', async () => {
        const taxonomyStats = {
            ...mockStats,
            collections: 28,
            series: 14,
            topics: 89,
        };
        const wrapper = createWrapper({ stats: taxonomyStats });

        const sidebar = wrapper.find('#appSidebar');
        expect(sidebar.find('#nav-collections .badge-count').text()).toBe('28');
        expect(sidebar.find('#nav-series .badge-count').text()).toBe('14');
        expect(sidebar.find('#nav-topics .badge-count').text()).toBe('89');
        expect(sidebar.find('#group-taxonomy .group-badge').text()).toBe('5');
    });
});


