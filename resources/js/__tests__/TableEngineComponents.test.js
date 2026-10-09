import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import AssetHeaderBanner from '../Components/Table/AssetHeaderBanner.vue';
import TableToolbar from '../Components/Table/TableToolbar.vue';
import BulkActionsStrip from '../Components/Table/BulkActionsStrip.vue';
import TablePagination from '../Components/Table/TablePagination.vue';
import DenseDataTable from '../Components/Table/DenseDataTable.vue';
import AssetTableView from '../Components/Table/AssetTableView.vue';

describe('Enterprise Asset Tables Engine (Cycle 15 TDD)', () => {
    describe('1. AssetHeaderBanner.vue', () => {
        const mockStats = {
            total: 1482,
            published: 1040,
            scholarly: 312,
            draft: 130,
        };

        it('renders 4 KPI status cards with correct counts and labels', () => {
            const wrapper = mount(AssetHeaderBanner, {
                props: {
                    stats: mockStats,
                    entityName: 'الكتب',
                },
            });

            expect(wrapper.text()).toContain('الكل');
            expect(wrapper.text()).toContain('1,482');
            expect(wrapper.text()).toContain('منشور');
            expect(wrapper.text()).toContain('1,040');
            expect(wrapper.text()).toContain('محكّم');
            expect(wrapper.text()).toContain('312');
            expect(wrapper.text()).toContain('مسودات');
            expect(wrapper.text()).toContain('130');
        });

        it('emits filter-status when a KPI card is clicked', async () => {
            const wrapper = mount(AssetHeaderBanner, {
                props: {
                    stats: mockStats,
                    activeStatus: 'all',
                },
            });

            const publishedCard = wrapper.find('[data-status="published"]');
            expect(publishedCard.exists()).toBe(true);

            await publishedCard.trigger('click');
            expect(wrapper.emitted('filter-status')).toBeTruthy();
            expect(wrapper.emitted('filter-status')[0]).toEqual(['published']);
        });

        it('renders 2x2 executive action buttons grid and emits respective events', async () => {
            const wrapper = mount(AssetHeaderBanner, {
                props: {
                    stats: mockStats,
                },
            });

            const createBtn = wrapper.find('#btnBannerCreate');
            const exportBtn = wrapper.find('#btnBannerExport');
            const importBtn = wrapper.find('#btnBannerImport');
            const refreshBtn = wrapper.find('#btnBannerRefresh');

            expect(createBtn.exists()).toBe(true);
            expect(exportBtn.exists()).toBe(true);
            expect(importBtn.exists()).toBe(true);
            expect(refreshBtn.exists()).toBe(true);

            await createBtn.trigger('click');
            expect(wrapper.emitted('create')).toBeTruthy();

            await exportBtn.trigger('click');
            expect(wrapper.emitted('export')).toBeTruthy();

            await importBtn.trigger('click');
            expect(wrapper.emitted('import')).toBeTruthy();

            await refreshBtn.trigger('click');
            expect(wrapper.emitted('refresh')).toBeTruthy();
        });
    });

    describe('2. TableToolbar.vue', () => {
        const mockColumns = [
            { key: 'serial', label: 'الرقم', visible: true, required: false },
            { key: 'title', label: 'العنوان', visible: true, required: true },
        ];

        it('renders search input, filter select, columns dropdown, and view mode toggle', () => {
            const wrapper = mount(TableToolbar, {
                props: {
                    searchQuery: 'صحيح',
                    columns: mockColumns,
                    viewMode: 'table',
                },
            });

            const searchInput = wrapper.find('#toolbarSearchInput');
            expect(searchInput.exists()).toBe(true);
            expect(searchInput.element.value).toBe('صحيح');

            const columnsDropdown = wrapper.findComponent({ name: 'ColumnsDropdown' });
            expect(columnsDropdown.exists()).toBe(true);

            const viewModeToggle = wrapper.find('.view-mode-toggle');
            expect(viewModeToggle.exists()).toBe(true);
        });

        it('emits update:searchQuery when typing in the search input', async () => {
            const wrapper = mount(TableToolbar, {
                props: {
                    searchQuery: '',
                    columns: mockColumns,
                },
            });

            const searchInput = wrapper.find('#toolbarSearchInput');
            await searchInput.setValue('البخاري');

            expect(wrapper.emitted('update:searchQuery')).toBeTruthy();
            expect(wrapper.emitted('update:searchQuery')[0]).toEqual(['البخاري']);
        });

        it('emits update:viewMode when toggling between table and cards mode', async () => {
            const wrapper = mount(TableToolbar, {
                props: {
                    searchQuery: '',
                    columns: mockColumns,
                    viewMode: 'table',
                },
            });

            const cardsBtn = wrapper.find('#btnViewModeCards');
            expect(cardsBtn.exists()).toBe(true);

            await cardsBtn.trigger('click');
            expect(wrapper.emitted('update:viewMode')).toBeTruthy();
            expect(wrapper.emitted('update:viewMode')[0]).toEqual(['cards']);
        });
    });

    describe('3. BulkActionsStrip.vue', () => {
        it('is hidden when selectedCount is 0 and visible when selectedCount > 0', async () => {
            const wrapper = mount(BulkActionsStrip, {
                props: { selectedCount: 0 },
            });

            expect(wrapper.find('.bulk-actions-strip').classes()).toContain('hidden');

            await wrapper.setProps({ selectedCount: 5 });
            expect(wrapper.find('.bulk-actions-strip').classes()).not.toContain('hidden');
            expect(wrapper.text()).toContain('5');
        });

        it('emits export-selected, delete-selected, and clear-selection events', async () => {
            const wrapper = mount(BulkActionsStrip, {
                props: { selectedCount: 3 },
            });

            const exportBtn = wrapper.find('#btnBulkExport');
            const deleteBtn = wrapper.find('#btnBulkDelete');
            const clearBtn = wrapper.find('#btnBulkClear');

            await exportBtn.trigger('click');
            expect(wrapper.emitted('export-selected')).toBeTruthy();

            await deleteBtn.trigger('click');
            expect(wrapper.emitted('delete-selected')).toBeTruthy();

            await clearBtn.trigger('click');
            expect(wrapper.emitted('clear-selection')).toBeTruthy();
        });
    });

    describe('4. TablePagination.vue', () => {
        it('renders correct record range and total count', () => {
            const wrapper = mount(TablePagination, {
                props: {
                    total: 100,
                    perPage: 25,
                    currentPage: 2,
                },
            });

            // Page 2 of 25: 26 to 50 of 100
            expect(wrapper.text()).toContain('26');
            expect(wrapper.text()).toContain('50');
            expect(wrapper.text()).toContain('100');
        });

        it('emits update:currentPage on pagination button click', async () => {
            const wrapper = mount(TablePagination, {
                props: {
                    total: 100,
                    perPage: 25,
                    currentPage: 1,
                },
            });

            const nextBtn = wrapper.find('#btnPageNext');
            expect(nextBtn.exists()).toBe(true);

            await nextBtn.trigger('click');
            expect(wrapper.emitted('update:currentPage')).toBeTruthy();
            expect(wrapper.emitted('update:currentPage')[0]).toEqual([2]);
        });

        it('emits update:perPage when perPage select is changed', async () => {
            const wrapper = mount(TablePagination, {
                props: {
                    total: 100,
                    perPage: 25,
                    currentPage: 1,
                    perPageOptions: [25, 50, 100],
                },
            });

            const select = wrapper.find('#perPageSelect');
            await select.setValue('50');

            expect(wrapper.emitted('update:perPage')).toBeTruthy();
            expect(wrapper.emitted('update:perPage')[0]).toEqual([50]);
        });
    });

    describe('5. Polymorphic Taxonomy Attachment (Cycle 22 TDD)', () => {
        const mockColumns = [
            { key: 'title', label: 'العنوان' },
            { key: 'actions', label: 'الإجراءات' },
        ];
        const mockRows = [
            { id: 'b-1', title: 'جامع العلوم والحكم', slug: 'jami-al-ulum', code: 'BK-101' },
        ];

        it('DenseDataTable renders attach taxonomy button and emits attach-taxonomy event on click', async () => {
            const wrapper = mount(DenseDataTable, {
                props: {
                    assetType: 'books',
                    columns: mockColumns,
                    rows: mockRows,
                },
            });

            const attachBtn = wrapper.find('.btn-attach-taxonomy');
            expect(attachBtn.exists()).toBe(true);
            await attachBtn.trigger('click');

            expect(wrapper.emitted('attach-taxonomy')).toBeTruthy();
            expect(wrapper.emitted('attach-taxonomy')[0][0]).toEqual(mockRows[0]);
        });

        it('AssetTableView opens attachment modal when attach-taxonomy event is emitted', async () => {
            const wrapper = mount(AssetTableView, {
                props: {
                    assetTitle: 'الكتب',
                    assetType: 'books',
                    columns: mockColumns,
                    rows: mockRows,
                },
            });

            expect(wrapper.find('#taxonomyAttachModal').exists()).toBe(false);

            const denseTable = wrapper.findComponent(DenseDataTable);
            await denseTable.vm.$emit('attach-taxonomy', mockRows[0]);

            const modal = wrapper.find('#taxonomyAttachModal');
            expect(modal.exists()).toBe(true);
            expect(modal.text()).toContain('جامع العلوم والحكم');
            expect(modal.text()).toContain('ضم إلى مجموعة أو سلسلة');
        });
    });
});
