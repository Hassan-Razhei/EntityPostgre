import { describe, it, expect, vi } from 'vitest';
import { mount } from '@vue/test-utils';
import ColumnsDropdown from '../Components/Table/ColumnsDropdown.vue';

describe('ColumnsDropdown Component (TDD)', () => {
    const sampleColumns = [
        { key: 'serial', label: 'الرقم', visible: true, required: false },
        { key: 'title', label: 'العنوان', visible: true, required: true },
        { key: 'slug', label: 'المعرف', visible: true, required: false },
        { key: 'author', label: 'المؤلف', visible: true, required: false },
        { key: 'isbn', label: 'الرقم الدولي', visible: true, required: false },
        { key: 'description', label: 'الوصف', visible: true, required: false },
    ];

    it('renders the columns dropdown toggle button with label الأعمدة', () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        const btn = wrapper.find('#btnToggleColumns');
        expect(btn.exists()).toBe(true);
        expect(btn.text()).toContain('الأعمدة');
    });

    it('toggles dropdown visibility when button is clicked', async () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        // Initially closed
        expect(wrapper.find('.columns-dropdown-menu').classes()).not.toContain('show');

        // Click to open
        await wrapper.find('#btnToggleColumns').trigger('click');
        expect(wrapper.find('.columns-dropdown-menu').classes()).toContain('show');

        // Click to close
        await wrapper.find('#btnToggleColumns').trigger('click');
        expect(wrapper.find('.columns-dropdown-menu').classes()).not.toContain('show');
    });

    it('renders a checkbox item for each column in the menu', async () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        await wrapper.find('#btnToggleColumns').trigger('click');

        const items = wrapper.findAll('.column-toggle-item');
        expect(items.length).toBe(sampleColumns.length);
        expect(wrapper.text()).toContain('الرقم');
        expect(wrapper.text()).toContain('العنوان');
        expect(wrapper.text()).toContain('المعرف');
    });

    it('disables checkbox for required primary columns', async () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        await wrapper.find('#btnToggleColumns').trigger('click');

        const titleCheckbox = wrapper.find('input[data-key="title"]');
        expect(titleCheckbox.exists()).toBe(true);
        expect(titleCheckbox.attributes('disabled')).toBeDefined();
    });

    it('emits toggle event with column key and visibility when a checkbox is toggled', async () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        await wrapper.find('#btnToggleColumns').trigger('click');

        const slugCheckbox = wrapper.find('input[data-key="slug"]');
        expect(slugCheckbox.exists()).toBe(true);

        await slugCheckbox.setValue(false);
        expect(wrapper.emitted('toggle-column')).toBeTruthy();
        expect(wrapper.emitted('toggle-column')[0]).toEqual(['slug', false]);
    });

    it('emits reset-all event when إظهار الكل button is clicked', async () => {
        const wrapper = mount(ColumnsDropdown, {
            props: { columns: sampleColumns },
        });

        await wrapper.find('#btnToggleColumns').trigger('click');

        const resetBtn = wrapper.find('.columns-reset-btn');
        expect(resetBtn.exists()).toBe(true);
        expect(resetBtn.text()).toContain('إظهار الكل');

        await resetBtn.trigger('click');
        expect(wrapper.emitted('reset-all')).toBeTruthy();
    });
});
