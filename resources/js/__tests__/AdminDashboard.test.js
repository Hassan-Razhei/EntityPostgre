import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import axios from 'axios';
import AdminDashboard from '../Pages/AdminDashboard.vue';

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

    it('renders full rich manuscripts table with restoration and folio badges when switching to manuscripts view', async () => {
        const wrapper = createWrapper();
        window.loadView('manuscripts');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('manuscriptsDataTable');
        expect(contentArea.html()).toContain('صحيح البخاري - المجلد الرابع');
        expect(contentArea.html()).toContain('/dev/manuscripter/sahih-bukhari-koprulu');
        expect(contentArea.html()).toContain('/studio/manuscript/sahih-bukhari-koprulu');
    });

    it('renders full rich authors view with scholar biography cards and works count when switching to authors view', async () => {
        const wrapper = createWrapper();
        window.loadView('authors');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('ابن حجر العسقلاني');
        expect(contentArea.html()).toContain('الإمام البخاري');
        expect(contentArea.html()).toContain('تصفح المؤلفات 📚');
        expect(contentArea.html()).toContain('تعديل السيرة ✏️');
    });

    it('renders full rich publishers view with verified press cards and publication counts when switching to publishers view', async () => {
        const wrapper = createWrapper();
        window.loadView('publishers');
        await new Promise(r => setTimeout(r, 120));

        const contentArea = wrapper.find('#dynamicContentArea');
        expect(contentArea.html()).toContain('دار الرسالة العالمية');
        expect(contentArea.html()).toContain('دار المنهاج');
        expect(contentArea.html()).toContain('مطبوعة مؤرشفة');
        expect(contentArea.html()).toContain('عرض المنشورات 📖');
    });
});
