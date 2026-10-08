<script setup>
import ColumnsDropdown from './ColumnsDropdown.vue';

defineProps({
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
</script>

<template>
  <div class="table-toolbar flex flex-col md:flex-row justify-between items-stretch md:items-center gap-3 p-2 bg-gray-50/80 dark:bg-white/[0.02] border border-gray-200 dark:border-white/10 rounded-xl mb-4">
    <!-- Row Primary: Search + Filters -->
    <div class="toolbar-row-primary flex flex-1 items-center gap-2.5 flex-wrap">

      <!-- Instant Search Box -->
      <div class="toolbar-search-box relative flex-1 min-w-[200px] max-w-sm">
        <span class="toolbar-search-icon absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-gray-400 text-xs">
          🔍
        </span>
        <input
          type="text"
          id="toolbarSearchInput"
          :value="searchQuery"
          class="toolbar-search-input w-full pr-8 pl-3 py-1.5 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg text-xs font-medium text-gray-900 dark:text-zinc-100 placeholder-gray-400 dark:placeholder-zinc-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
          placeholder="بحث..."
          @input="emit('update:searchQuery', $event.target.value)"
        >
      </div>

      <!-- Filters & Columns Picker -->
      <div class="toolbar-filters flex items-center gap-2 flex-wrap">

        <!-- Category / Main Filter -->
        <select
          id="toolbarFilterSelect"
          :value="filterValue"
          class="toolbar-select py-1.5 px-3 bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg text-xs font-semibold text-gray-700 dark:text-zinc-200 focus:outline-none focus:border-indigo-500 cursor-pointer transition-colors"
          @change="emit('update:filterValue', $event.target.value)"
        >
          <option value="">
            {{ filterPlaceholder }}
          </option>
          <option
            v-for="opt in filterOptions"
            :key="opt.value"
            :value="opt.value"
          >
            {{ opt.label }}
          </option>
        </select>

        <!-- Columns Dropdown -->
        <ColumnsDropdown
          :columns="columns"
          @toggle-column="(key, isVisible) => emit('toggle-column', key, isVisible)"
          @reset-all="emit('reset-all-columns')"
        />

      </div>

    </div>

    <!-- View Switcher (جدول / بطاقات) -->
    <div class="view-mode-toggle flex items-center bg-gray-200/70 dark:bg-white/5 border border-gray-300/60 dark:border-white/10 rounded-lg p-0.5 self-end md:self-auto shrink-0">
      <button
        type="button"
        id="btnViewModeTable"
        :class="[
          'view-mode-btn inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold transition-all cursor-pointer border-0',
          viewMode === 'table'
            ? 'bg-white dark:bg-indigo-600 text-gray-900 dark:text-white shadow-xs'
            : 'bg-transparent text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white'
        ]"
        title="عرض كجدول بيانات تفصيلي"
        @click="emit('update:viewMode', 'table')"
      >
        <svg
          width="13"
          height="13"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <rect
            x="3"
            y="3"
            width="18"
            height="18"
            rx="2"
          />
          <path d="M3 9h18M3 15h18M9 3v18" />
        </svg>
        <span>جدول</span>
      </button>

      <button
        type="button"
        id="btnViewModeCards"
        :class="[
          'view-mode-btn inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold transition-all cursor-pointer border-0',
          viewMode === 'cards'
            ? 'bg-white dark:bg-indigo-600 text-gray-900 dark:text-white shadow-xs'
            : 'bg-transparent text-gray-600 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white'
        ]"
        title="عرض كبطاقات شبكية مرئية"
        @click="emit('update:viewMode', 'cards')"
      >
        <svg
          width="13"
          height="13"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <rect
            x="3"
            y="3"
            width="7"
            height="7"
          />
          <rect
            x="14"
            y="3"
            width="7"
            height="7"
          />
          <rect
            x="14"
            y="14"
            width="7"
            height="7"
          />
          <rect
            x="3"
            y="14"
            width="7"
            height="7"
          />
        </svg>
        <span>بطاقات</span>
      </button>
    </div>

  </div>
</template>
