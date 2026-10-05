import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import Error403 from '../Pages/Errors/403.vue';

describe('Error 403 Luxury Emerald Denial Page', () => {
    beforeEach(() => {
        vi.clearAllMocks();
    });

    it('renders the explanatory denial message and status code', () => {
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: {
                        id: 10,
                        name: 'عمر الباحث',
                        role: 'researcher',
                        role_label: 'باحث مسجل',
                        badge_color: 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                    },
                },
            },
        });

        const wrapper = mount(Error403, {
            props: {
                status: 403,
                message: 'عذراً، هذا المسار يتطلب إحدى الرتب التالية: محرر الاستوديو والوسائط.',
            },
        });

        expect(wrapper.text()).toContain('403');
        expect(wrapper.text()).toContain('عذراً، هذا المسار يتطلب إحدى الرتب التالية');
        expect(wrapper.text()).toContain('عمر الباحث');
        expect(wrapper.text()).toContain('باحث مسجل');
    });

    it('provides navigation links to return to dashboard or home', () => {
        vi.mocked(inertia.usePage).mockReturnValue({
            props: {
                auth: {
                    user: null,
                },
            },
        });

        const wrapper = mount(Error403, {
            props: {
                status: 403,
                message: 'يرجى تسجيل الدخول للوصول إلى هذه المنطقة.',
            },
        });

        expect(wrapper.text()).toContain('الرئيسية');
    });
});
