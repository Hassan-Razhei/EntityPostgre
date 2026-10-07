import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import Sidebar from '../Layouts/Partials/Sidebar.vue';

describe('Sidebar Navigation & Accordion Component (TDD)', () => {
    beforeEach(() => {
        vi.clearAllMocks();
        // Mock Ziggy route() helper
        global.route = vi.fn((name) => {
            const routes = {
                'dashboard': '/dashboard',
                'superadmin.dashboard': '/superadmin/dashboard',
                'books.index': '/books',
                'manuscripts.index': '/manuscripts',
                'audios.index': '/audios',
                'videos.index': '/videos',
                'authors.index': '/authors',
                'publishers.index': '/publishers',
                'categories.index': '/categories',
                'tags.index': '/tags',
                'studio.resume': '/studio/resume',
                'activities.index': '/activities',
                'deletions.index': '/deletions',
                'system.commands': '/system/commands',
            };
            return {
                current: vi.fn(() => false),
                toString: () => routes[name] || `/${name}`,
            };
        });

        // Default super_admin user with full permissions
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 1,
                        name: 'المدير العام',
                        role: 'super_admin',
                        can: {
                            access_studio: true,
                            curate_metadata: true,
                            publish: true,
                            manage_users: true,
                            system_commands: true,
                        },
                    },
                },
            },
        });
    });

    it('renders all five canonical groups matching super_admin_dashboard_preview.html', () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        const text = wrapper.text();
        expect(text).toContain('المكتبة');
        expect(text).toContain('الأشخاص');
        expect(text).toContain('التنظيم');
        expect(text).toContain('الاستوديو');
        expect(text).toContain('النظام');
    });

    it('renders the accordion micro-toolbar with expand and collapse buttons', () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        expect(wrapper.find('#sidebarAccordionToolbar').exists()).toBe(true);
        expect(wrapper.find('#btnExpandAll').exists()).toBe(true);
        expect(wrapper.find('#btnCollapseAll').exists()).toBe(true);
    });

    it('toggles collapse state of a navigation group when header is clicked', async () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        const libraryHeader = wrapper.find('#group-library .nav-group-header');
        expect(libraryHeader.exists()).toBe(true);

        const libraryGroup = wrapper.find('#group-library');
        // Initial state is expanded (not collapsed)
        expect(libraryGroup.classes()).not.toContain('collapsed');

        // Click to collapse
        await libraryHeader.trigger('click');
        expect(libraryGroup.classes()).toContain('collapsed');

        // Click to expand again
        await libraryHeader.trigger('click');
        expect(libraryGroup.classes()).not.toContain('collapsed');
    });

    it('collapses all groups when collapse-all button is clicked', async () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        const collapseBtn = wrapper.find('#btnCollapseAll');
        await collapseBtn.trigger('click');

        const groups = wrapper.findAll('.nav-group');
        expect(groups.length).toBeGreaterThanOrEqual(5);
        groups.forEach((group) => {
            expect(group.classes()).toContain('collapsed');
        });
    });

    it('expands all groups when expand-all button is clicked', async () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        // First collapse all
        await wrapper.find('#btnCollapseAll').trigger('click');

        // Then expand all
        await wrapper.find('#btnExpandAll').trigger('click');

        const groups = wrapper.findAll('.nav-group');
        groups.forEach((group) => {
            expect(group.classes()).not.toContain('collapsed');
        });
    });

    it('renders the sovereign group with sovereign-group class and crown icon', () => {
        const wrapper = mount(Sidebar, {
            props: { isOpen: true },
        });

        const sovereignGroup = wrapper.find('#group-sovereignty');
        expect(sovereignGroup.exists()).toBe(true);
        expect(sovereignGroup.classes()).toContain('sovereign-group');
    });
});
