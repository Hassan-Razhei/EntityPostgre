import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import AdminDashboard from '../Pages/AdminDashboard.vue';

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
});
