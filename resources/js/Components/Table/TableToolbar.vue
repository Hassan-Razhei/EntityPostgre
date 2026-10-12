<script setup>
import { computed } from 'vue';
import ColumnsDropdown from './ColumnsDropdown.vue';

const props = defineProps({
    assetTitle: {
        type: String,
        default: '',
    },
    assetType: {
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
    /**
     * المؤلفون المستخلصون من الصفوف الحالية.
     *
     * السبب: جدول books ليس فيه عمود تصنيف (تحقّقنا بـ
     * Schema::getColumnListing). فلتر التصنيف السابق كان يعرض
     * "الحديث/الأصول/العقيدة..." وهي تصنيفات غير موجودة في
     * البيانات إطلاقاً — اختيار أيٍّ منها لا يُرجع أي صف
     * (وهو كذب على المستخدم).
     *
     * البديل الصادق: فلترة بالمؤلف، وهو عمود حقيقي.
     */
    authorOptions: {
        type: Array,
        default: () => [],
    },
    /**
     * قيمة فلتر التصنيف/المؤلف الحالية.
     */
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
    /**
     * قيمة فلتر الترتيب الحالية — تمرّرها الواجهة ليظل الـ select
     * متوافقاً مع ما اختاره المستخدم (عند إعادة الجلب من الخادم).
     */
    sortValue: {
        type: String,
        default: '',
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
    if (props.assetType) return `${props.assetType}SearchInput`;
    if (props.assetTitle === 'الكتب') return 'booksSearchInput';
    return 'toolbarSearchInput';
});

const computedFilterId = computed(() => {
    if (props.assetType) return `${props.assetType}CategoryFilter`;
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
        <!-- فلتر التصنيف (المؤلف) -->
        <select
          class="toolbar-select"
          :id="computedFilterId"
          :value="filterValue"
          @change="emit('update:filterValue', $event.target.value)"
        >
          <option value="">{{ filterPlaceholder }}</option>
          <option value="">كل المؤلفين</option>
          <option
            v-for="opt in filterOptions"
            :key="opt.value || opt"
            :value="opt.value || opt"
          >
            {{ opt.label || opt }}
          </option>
        </select>

        <!-- فلتر الترتيب -->
        <select
          class="toolbar-select"
          :id="`${assetType}SortSelect`"
          :value="sortValue"
          @change="emit('update:sortValue', $event.target.value)"
        >
          <option value="">الترتيب</option>
          <option value="الأحدث">الأحدث</option>
          <option value="الأقدم">الأقدم</option>
          <option value="أبجدياً">أبجدياً</option>
          <option value="الصفحات">الصفحات</option>
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
