import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import { ref } from 'vue';
import * as inertia from '@inertiajs/vue3';
import Navbar from '../Layouts/Partials/Navbar.vue';

describe('Navbar Navigation & Profile Component (TDD)', () => {
    const themeContextMock = {
        isDark: ref(true),
        toggleDarkMode: vi.fn(),
    };

    beforeEach(() => {
        vi.clearAllMocks();
        // Mock Ziggy route() helper
        global.route = vi.fn((name) => {
            const routes = {
                'dashboard': '/dashboard',
                'logout': '/logout',
                'search': '/search',
                'login': '/login',
                'register': '/register',
            };
            return routes[name] || `/${name}`;
        });

        // Default super_admin user
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 1,
                        name: 'د. إبراهيم الفاسي',
                        email: 'super_admin@archive.org',
                        role: 'super_admin',
                        role_label: 'مدير النظام الشامل',
                        can: { system_commands: true },
                    },
                },
            },
        });
    });

    it('renders 3-tier breadcrumbs (الرئيسية ‹ المجموعة ‹ الصفحة) matching super_admin_dashboard_preview.html', () => {
        const wrapper = mount(Navbar, {
            props: {
                title: 'الكتب',
                group: 'المكتبة',
                isSidebarOpen: true,
            },
            global: {
                provide: {
                    themeContext: themeContextMock,
                },
            },
        });

        const breadcrumbs = wrapper.find('.breadcrumbs');
        expect(breadcrumbs.exists()).toBe(true);
        expect(breadcrumbs.text()).toContain('الرئيسية');
        expect(breadcrumbs.text()).toContain('المكتبة');
        expect(breadcrumbs.text()).toContain('الكتب');
    });

    it('renders the system notifications button with alert trigger', () => {
        const wrapper = mount(Navbar, {
            props: { title: 'الكتب' },
            global: {
                provide: {
                    themeContext: themeContextMock,
                },
            },
        });

        const notifBtn = wrapper.find('#notificationsBtn');
        expect(notifBtn.exists()).toBe(true);
    });

    it('renders user email and profile details inside the user dropdown header', async () => {
        const wrapper = mount(Navbar, {
            props: { title: 'الكتب' },
            global: {
                provide: {
                    themeContext: themeContextMock,
                },
            },
        });

        const avatarBtn = wrapper.find('#userAvatarBtn');
        expect(avatarBtn.exists()).toBe(true);

        // Click to open dropdown
        await avatarBtn.trigger('click');

        const dropdown = wrapper.find('#userDropdownMenu');
        expect(dropdown.exists()).toBe(true);
        expect(dropdown.text()).toContain('super_admin@archive.org');
        expect(dropdown.text()).toContain('د. إبراهيم الفاسي');
    });

    it('toggles theme when theme button is clicked', async () => {
        const wrapper = mount(Navbar, {
            props: { title: 'الكتب' },
            global: {
                provide: {
                    themeContext: themeContextMock,
                },
            },
        });

        const themeBtn = wrapper.find('#themeToggleBtn');
        expect(themeBtn.exists()).toBe(true);

        await themeBtn.trigger('click');
        expect(themeContextMock.toggleDarkMode).toHaveBeenCalledTimes(1);
    });
});
