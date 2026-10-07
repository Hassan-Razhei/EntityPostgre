import { describe, it, expect, vi, beforeEach } from 'vitest';
import { mount } from '@vue/test-utils';
import * as inertia from '@inertiajs/vue3';
import BooksIndex from '../Pages/Books/Index.vue';
import ColumnsDropdown from '../Components/Table/ColumnsDropdown.vue';

describe('Books/Index.vue with ColumnsDropdown & High-Density Table (TDD)', () => {
    const sampleBooks = {
        data: [
            {
                id: 1,
                formatted_serial_number: '#10401',
                title: 'صحيح البخاري',
                slug: 'sahih-al-bukhari',
                isbn: '978-0-123456-47-2',
                description: 'الجامع المسند الصحيح المختصر',
                created_at: '2026-01-01T00:00:00Z',
                authors: [{ id: 1, name: 'الإمام البخاري' }],
                tags: [{ id: 1, name: 'حديث' }],
            },
        ],
        links: [],
    };

    beforeEach(() => {
        vi.clearAllMocks();
        global.route = vi.fn((name, params) => {
            if (params && typeof params === 'object') {
                return `/${name}/${Object.values(params).join('/')}`;
            }
            return `/${name}`;
        });

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

    const createWrapper = () => {
        return mount(BooksIndex, {
            props: {
                books: sampleBooks,
                filters: {},
                categories: [],
                tags: [],
            },
            global: {
                stubs: {
                    AuthenticatedLayout: {
                        template: '<div class="authenticated-layout"><slot name="header" /><slot /></div>',
                    },
                    Link: {
                        template: '<a><slot /></a>',
                    },
                    Pagination: true,
                    PrimaryButton: {
                        template: '<button><slot /></button>',
                    },
                    TextInput: true,
                    SelectInput: true,
                    Card: {
                        template: '<div class="card"><slot /></div>',
                    },
                    Badge: {
                        template: '<span class="badge"><slot /></span>',
                    },
                    IconButton: {
                        template: '<button class="icon-btn"><slot /></button>',
                    },
                },
            },
        });
    };

    it('renders the ColumnsDropdown component in the toolbar', () => {
        const wrapper = createWrapper();
        const dropdown = wrapper.findComponent(ColumnsDropdown);
        expect(dropdown.exists()).toBe(true);
    });

    it('provides columns configuration with required title column', () => {
        const wrapper = createWrapper();
        const dropdown = wrapper.findComponent(ColumnsDropdown);
        expect(dropdown.exists()).toBe(true);

        const columns = dropdown.props('columns');
        expect(Array.isArray(columns)).toBe(true);
        expect(columns.length).toBeGreaterThanOrEqual(6);

        const titleCol = columns.find(c => c.key === 'title');
        expect(titleCol).toBeDefined();
        expect(titleCol.required).toBe(true);
    });

    it('hides column header and cells when column visibility is toggled off', async () => {
        const wrapper = createWrapper();
        const dropdown = wrapper.findComponent(ColumnsDropdown);

        // Initially isbn is visible
        expect(wrapper.find('[data-col="isbn"]').exists()).toBe(true);

        // Emit toggle-column event to turn isbn off
        await dropdown.vm.$emit('toggle-column', 'isbn', false);

        // After toggle, isbn should not be in document
        expect(wrapper.find('[data-col="isbn"]').exists()).toBe(false);
    });

    it('restores all columns when reset-all event is emitted', async () => {
        const wrapper = createWrapper();
        const dropdown = wrapper.findComponent(ColumnsDropdown);

        // Turn off isbn
        await dropdown.vm.$emit('toggle-column', 'isbn', false);
        expect(wrapper.find('[data-col="isbn"]').exists()).toBe(false);

        // Emit reset-all
        await dropdown.vm.$emit('reset-all');

        // isbn should be visible again
        expect(wrapper.find('[data-col="isbn"]').exists()).toBe(true);
    });
});
