import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import { ref } from 'vue';
import * as inertia from '@inertiajs/vue3';
import Navbar from '../Layouts/Partials/Navbar.vue';
import Sidebar from '../Layouts/Partials/Sidebar.vue';
import BookShow from '../Pages/Books/Show.vue';

describe('Adaptive UI Rendering & Spatial Navigation', () => {
    const themeContextMock = {
        isDark: ref(false),
        toggleDarkMode: vi.fn(),
    };

    const dummyBook = {
        id: 1,
        title: 'صحيح البخاري',
        slug: 'sahih-bukhari',
        type: 'book',
        authors: [{ id: 1, name: 'الإمام البخاري' }],
        categories: [],
        tags: [],
        versions: [],
    };

    beforeEach(() => {
        vi.clearAllMocks();
    });

    describe('Navbar Adaptive Persona', () => {
        it('renders the dynamic Arabic role label instead of hardcoded text for chief editor', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: {
                            id: 4,
                            name: 'سالم المحقق',
                            role: 'chief_editor',
                            role_label: 'رئيس التحرير والاعتماد',
                            badge_color: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            can: { access_studio: true },
                        },
                    },
                },
            });

            const wrapper = mount(Navbar, {
                global: {
                    provide: {
                        themeContext: themeContextMock,
                    },
                },
            });

            expect(wrapper.text()).toContain('سالم المحقق');
            expect(wrapper.text()).toContain('رئيس التحرير والاعتماد');
            expect(wrapper.text()).not.toContain('مسؤول النظام');
        });

        it('renders guest login and register actions when user is not authenticated', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: null,
                    },
                },
            });

            const wrapper = mount(Navbar, {
                global: {
                    provide: {
                        themeContext: themeContextMock,
                    },
                },
            });

            expect(wrapper.text()).toContain('تسجيل الدخول');
            expect(wrapper.text()).toContain('إنشاء حساب');
        });
    });

    describe('Sidebar Spatial Access', () => {
        it('shows system commands navigation item only for users with system_commands permission', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: {
                            id: 1,
                            name: 'المدير العام',
                            role: 'super_admin',
                            can: { system_commands: true },
                        },
                    },
                },
            });

            const wrapper = mount(Sidebar, {
                props: { isOpen: true },
            });

            expect(wrapper.text()).toContain('أوامر النظام');
        });

        it('hides system commands from regular staff or researchers lacking permission', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: {
                            id: 8,
                            name: 'عمر الناسخ',
                            role: 'transcriber',
                            can: { access_studio: true, system_commands: false },
                        },
                    },
                },
            });

            const wrapper = mount(Sidebar, {
                props: { isOpen: true },
            });

            expect(wrapper.text()).not.toContain('أوامر النظام');
        });
    });

    describe('Entity Show Pages Adaptive Action Buttons', () => {
        it('shows studio editor button for users with studio capabilities', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: {
                            id: 5,
                            name: 'المحرر',
                            role: 'editor',
                            can: { access_studio: true, curate_metadata: true },
                        },
                    },
                },
            });

            const wrapper = mount(BookShow, {
                props: {
                    book: dummyBook,
                    first_content_slug: 'chapter-1',
                },
                global: {
                    stubs: {
                        AuthenticatedLayout: { template: '<div><slot /><slot name="header" /></div>' },
                    },
                },
            });

            expect(wrapper.text()).toContain('محرر المحتوى');
        });

        it('hides studio editor button for researchers or guest users lacking studio permission', () => {
            vi.mocked(inertia.usePage).mockReturnValue({
                props: {
                    auth: {
                        user: {
                            id: 10,
                            name: 'الباحث',
                            role: 'researcher',
                            can: { access_studio: false, curate_metadata: false },
                        },
                    },
                },
            });

            const wrapper = mount(BookShow, {
                props: {
                    book: dummyBook,
                    first_content_slug: 'chapter-1',
                },
                global: {
                    stubs: {
                        AuthenticatedLayout: { template: '<div><slot /><slot name="header" /></div>' },
                    },
                },
            });

            expect(wrapper.text()).not.toContain('محرر المحتوى');
        });
    });
});
