import { describe, it, expect } from 'vitest';
import { mount } from '@vue/test-utils';
import DenseDataTable from '../Components/Table/DenseDataTable.vue';
import AssetTableView from '../Components/Table/AssetTableView.vue';

describe('DenseDataTable & AssetTableView (Cycle 16 TDD)', () => {
    const mockColumns = [
        { key: 'serial', label: 'الرقم', visible: true, required: false },
        { key: 'title', label: 'العنوان', visible: true, required: true },
        { key: 'author', label: 'المؤلف', visible: true, required: false },
        { key: 'isbn', label: 'الرقم الدولي', visible: false, required: false },
        { key: 'actions', label: 'الإجراءات', visible: true, required: true },
    ];

    const mockRows = [
        {
            id: 1,
            serial: '#10401',
            title: 'صحيح البخاري',
            author: 'الإمام البخاري',
            isbn: '978-603-500-025-4',
        },
        {
            id: 2,
            serial: '#10402',
            title: 'المستصفى',
            author: 'الإمام الغزالي',
            isbn: '978-9953-34-118-0',
        },
    ];

    describe('1. DenseDataTable.vue', () => {
        it('renders table headers according to visible columns only', () => {
            const wrapper = mount(DenseDataTable, {
                props: {
                    columns: mockColumns,
                    rows: mockRows,
                },
            });

            const headers = wrapper.findAll('th');
            // Checkbox th + 4 visible columns (serial, title, author, actions) = 5 th
            expect(headers.length).toBe(5);
            expect(wrapper.text()).toContain('الرقم');
            expect(wrapper.text()).toContain('العنوان');
            expect(wrapper.text()).toContain('المؤلف');
            expect(wrapper.text()).not.toContain('الرقم الدولي'); // Hidden column
        });

        it('handles select all and individual row selection', async () => {
            const wrapper = mount(DenseDataTable, {
                props: {
                    columns: mockColumns,
                    rows: mockRows,
                    selectedIds: [],
                },
            });

            // Click select all
            const masterCheckbox = wrapper.find('#masterCheckbox');
            expect(masterCheckbox.exists()).toBe(true);

            await masterCheckbox.setValue(true);
            expect(wrapper.emitted('update:selectedIds')).toBeTruthy();
            expect(wrapper.emitted('update:selectedIds')[0]).toEqual([[1, 2]]);

            // Select single row
            const firstRowCheckbox = wrapper.find('input[data-row-id="1"]');
            expect(firstRowCheckbox.exists()).toBe(true);
        });

        it('renders row data cells matching column keys', () => {
            const wrapper = mount(DenseDataTable, {
                props: {
                    columns: mockColumns,
                    rows: mockRows,
                },
            });

            expect(wrapper.text()).toContain('#10401');
            expect(wrapper.text()).toContain('صحيح البخاري');
            expect(wrapper.text()).toContain('الإمام البخاري');
            expect(wrapper.text()).toContain('#10402');
            expect(wrapper.text()).toContain('المستصفى');
        });
    });

    describe('2. AssetTableView.vue', () => {
        const mockStats = {
            total: 2500,
            published: 1800,
            scholarly: 500,
            draft: 200,
        };

        it('integrates banner, toolbar, bulk strip, table, and pagination seamlessly', () => {
            const wrapper = mount(AssetTableView, {
                props: {
                    assetTitle: 'الكتب',
                    stats: mockStats,
                    columns: mockColumns,
                    rows: mockRows,
                    total: 2500,
                    perPage: 25,
                    currentPage: 1,
                },
            });

            expect(wrapper.findComponent({ name: 'AssetHeaderBanner' }).exists()).toBe(true);
            expect(wrapper.findComponent({ name: 'TableToolbar' }).exists()).toBe(true);
            expect(wrapper.findComponent({ name: 'BulkActionsStrip' }).exists()).toBe(true);
            expect(wrapper.findComponent({ name: 'DenseDataTable' }).exists()).toBe(true);
            expect(wrapper.findComponent({ name: 'TablePagination' }).exists()).toBe(true);
        });
    });
});
