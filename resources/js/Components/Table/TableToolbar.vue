<script setup>
import { computed } from 'vue';
import ColumnsDropdown from './ColumnsDropdown.vue';

const props = defineProps({
    assetTitle: {
        type: String,
        default: '',
    },
    searchInputId: {
        type: String,
        default: '',
    },
    searchQuery: {
        type: String,
        default: '',
    },
    filterValue: {
        type: String,
        default: '',
    },
    filterPlaceholder: {
        type: String,
        default: 'التصنيف',
    },
    filterOptions: {
        type: Array,
        default: () => [
            { label: 'الحديث', value: 'الحديث' },
            { label: 'الأصول', value: 'الأصول' },
            { label: 'العقيدة', value: 'العقيدة' },
            { label: 'التراجم', value: 'التراجم' },
            { label: 'اللغة', value: 'اللغة' },
            { label: 'التفسير', value: 'التفسير' },
            { label: 'الفقه', value: 'الفقه' },
            { label: 'المقاصد', value: 'المقاصد' },
        ],
    },
    columns: {
        type: Array,
        required: true,
        default: () => [],
    },
    viewMode: {
        type: String,
        default: 'table', // 'table' | 'cards'
    },
});

const emit = defineEmits([
    'update:searchQuery',
    'update:filterValue',
    'update:viewMode',
    'toggle-column',
    'reset-all-columns',
]);

const computedSearchId = computed(() => {
    if (props.searchInputId) return props.searchInputId;
    if (props.assetTitle === 'الكتب') return 'booksSearchInput';
    return 'toolbarSearchInput';
});

const computedFilterId = computed(() => {
    if (props.assetTitle === 'الكتب') return 'booksCategoryFilter';
    return 'toolbarFilterSelect';
});

const computedTableBtnId = computed(() => {
    if (props.assetTitle === 'الكتب') return 'btnViewTable';
    return 'btnViewModeTable';
});

const computedCardsBtnId = computed(() => {
    if (props.assetTitle === 'الكتب') return 'btnViewGrid';
    return 'btnViewModeCards';
});
</script>

<template>
  <div class="table-toolbar">
    <div class="toolbar-row-primary">
      <!-- Instant Search Box (بحث...) -->
      <div class="toolbar-search-box">
        <span class="toolbar-search-icon">🔍</span>
        <input
          type="text"
          :id="computedSearchId"
          class="toolbar-search-input"
          placeholder="بحث..."
          :value="searchQuery"
          @input="emit('update:searchQuery', $event.target.value)"
        >
      </div>

      <!-- Filters & View Switcher -->
      <div class="toolbar-filters">
        <!-- فلتر التصنيف -->
        <select
          class="toolbar-select"
          :id="computedFilterId"
          :value="filterValue"
          @change="emit('update:filterValue', $event.target.value)"
        >
          <option value="">{{ filterPlaceholder }}</option>
          <option
            v-for="opt in filterOptions"
            :key="opt.value || opt"
            :value="opt.value || opt"
          >
            {{ opt.label || opt }}
          </option>
        </select>

        <!-- فلتر الترتيب -->
        <select class="toolbar-select">
          <option>الترتيب</option>
          <option>الأحدث</option>
          <option>الأقدم</option>
          <option>أبجدياً</option>
          <option>الصفحات</option>
        </select>

        <!-- زر وقائمة تحديد الأعمدة المعروضة -->
        <ColumnsDropdown
          :columns="columns"
          @toggle-column="(key, isVisible) => emit('toggle-column', key, isVisible)"
          @reset-all="emit('reset-all-columns')"
        />

        <!-- View Mode Toggle (جدول / بطاقات) -->
        <div class="view-mode-toggle">
          <button
            type="button"
            class="view-mode-btn"
            :class="{ active: viewMode === 'table' }"
            :id="computedTableBtnId"
            title="عرض الجدول المدمج"
            @click="emit('update:viewMode', 'table')"
          >
            <span>جدول</span>
          </button>
          <button
            type="button"
            class="view-mode-btn"
            :class="{ active: viewMode === 'cards' }"
            :id="computedCardsBtnId"
            title="عرض البطاقات"
            @click="emit('update:viewMode', 'cards')"
          >
            <span>بطاقات</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
