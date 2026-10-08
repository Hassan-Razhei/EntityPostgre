<script setup>
import { ref, computed, watch } from 'vue';
import AssetHeaderBanner from './AssetHeaderBanner.vue';
import TableToolbar from './TableToolbar.vue';
import BulkActionsStrip from './BulkActionsStrip.vue';
import DenseDataTable from './DenseDataTable.vue';
import TablePagination from './TablePagination.vue';

const props = defineProps({
    assetTitle: {
        type: String,
        default: 'الأصول',
    },
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            published: 0,
            scholarly: 0,
            draft: 0,
        }),
    },
    columns: {
        type: Array,
        required: true,
        default: () => [],
    },
    rows: {
        type: Array,
        required: true,
        default: () => [],
    },
    total: {
        type: Number,
        default: 0,
    },
    perPage: {
        type: Number,
        default: 25,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
    createUrl: {
        type: String,
        default: '',
    },
    filterPlaceholder: {
        type: String,
        default: 'التصنيف',
    },
    filterOptions: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits([
    'update:currentPage',
    'update:perPage',
    'filter-status',
    'export-selected',
    'delete-selected',
    'create',
    'export',
    'import',
    'refresh',
]);

const internalColumns = ref([...props.columns]);
const searchQuery = ref('');
const filterValue = ref('');
const activeStatus = ref('all');
const viewMode = ref('table');
const selectedIds = ref([]);

watch(
    () => props.columns,
    (newCols) => {
        internalColumns.value = [...newCols];
    },
    { deep: true }
);

const handleToggleColumn = (key, isVisible) => {
    const col = internalColumns.value.find(c => c.key === key);
    if (col && !col.required) {
        col.visible = isVisible;
    }
};

const handleResetAllColumns = () => {
    internalColumns.value.forEach(col => {
        col.visible = true;
    });
};

const handleFilterStatus = (status) => {
    activeStatus.value = status;
    emit('filter-status', status);
};

const handleClearSelection = () => {
    selectedIds.value = [];
};

const handleExportSelected = () => {
    emit('export-selected', selectedIds.value);
};

const handleDeleteSelected = () => {
    emit('delete-selected', selectedIds.value);
};

// Filter rows client-side if not paginated server-side
const filteredRows = computed(() => {
    let result = props.rows;
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase();
        result = result.filter(row => {
            return Object.values(row).some(val =>
                String(val || '').toLowerCase().includes(q)
            );
        });
    }
    return result;
});
</script>

<template>
  <div class="asset-table-view space-y-4">
    <!-- 1. Horizontal Split Header Banner -->
    <AssetHeaderBanner
      :stats="stats"
      :active-status="activeStatus"
      :entity-name="assetTitle"
      :create-url="createUrl"
      @filter-status="handleFilterStatus"
      @create="emit('create')"
      @export="emit('export')"
      @import="emit('import')"
      @refresh="emit('refresh')"
    />

    <!-- 2. Table Toolbar (Search, Filter, Columns, View Mode) -->
    <TableToolbar
      v-model:search-query="searchQuery"
      v-model:filter-value="filterValue"
      v-model:view-mode="viewMode"
      :filter-placeholder="filterPlaceholder"
      :filter-options="filterOptions"
      :columns="internalColumns"
      @toggle-column="handleToggleColumn"
      @reset-all-columns="handleResetAllColumns"
    />

    <!-- 3. Bulk Actions Strip -->
    <BulkActionsStrip
      :selected-count="selectedIds.length"
      @export-selected="handleExportSelected"
      @delete-selected="handleDeleteSelected"
      @clear-selection="handleClearSelection"
    />

    <!-- 4. Dense Data Table (Table View) -->
    <div v-show="viewMode === 'table'">
      <DenseDataTable
        :columns="internalColumns"
        :rows="filteredRows"
        v-model:selected-ids="selectedIds"
      >
        <!-- Forward all custom slots -->
        <template
          v-for="(_, slotName) in $slots"
          #[slotName]="slotProps"
        >
          <slot
            :name="slotName"
            v-bind="slotProps"
          />
        </template>
      </DenseDataTable>
    </div>

    <!-- 4. Alt: Cards Grid (Cards View) -->
    <div
      v-show="viewMode === 'cards'"
      class="cards-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
    >
      <div
        v-for="row in filteredRows"
        :key="row.id"
        class="bg-white dark:bg-white/[0.025] border border-gray-200 dark:border-white/10 rounded-2xl p-4 hover:border-indigo-500/50 transition-all shadow-xs"
      >
        <div class="flex items-center justify-between gap-2 mb-2">
          <span class="font-mono text-xs font-bold text-gray-400">{{ row.serial || row.code || `#${row.id}` }}</span>
          <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">
            {{ row.format || row.status || assetTitle }}
          </span>
        </div>
        <h4 class="font-black text-sm text-gray-900 dark:text-white truncate mb-1">
          {{ row.title }}
        </h4>
        <p
          v-if="row.author"
          class="text-xs text-gray-500 dark:text-zinc-400 font-medium truncate mb-2"
        >
          {{ row.author }}
        </p>
        <p
          v-if="row.description"
          class="text-xs text-gray-400 dark:text-zinc-500 line-clamp-2 mb-3"
        >
          {{ row.description }}
        </p>
      </div>
    </div>

    <!-- 5. Advanced Pagination -->
    <TablePagination
      :total="total || filteredRows.length"
      :per-page="perPage"
      :current-page="currentPage"
      :entity-label="assetTitle"
      @update:current-page="emit('update:currentPage', $event)"
      @update:per-page="emit('update:perPage', $event)"
    />
  </div>
</template>
