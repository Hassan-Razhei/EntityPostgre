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
        default: 'الكتب',
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
    if (filterValue.value) {
        const cat = filterValue.value.toLowerCase();
        result = result.filter(row => {
            return Object.values(row).some(val =>
                String(val || '').toLowerCase().includes(cat)
            );
        });
    }
    return result;
});
</script>

<template>
  <div class="asset-table-view">
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

    <!-- Enterprise High-Density Table Card -->
    <div class="enterprise-card">
      <!-- 2. Table Toolbar (Search, Filter, Columns, View Mode) -->
      <TableToolbar
        v-model:search-query="searchQuery"
        v-model:filter-value="filterValue"
        v-model:view-mode="viewMode"
        :asset-title="assetTitle"
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
      <div v-show="viewMode === 'table'" id="booksTableView" class="dense-table-wrapper">
        <DenseDataTable
          table-id="booksDataTable"
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
        id="booksGridView"
        class="catalog-grid"
        style="padding: 1.25rem;"
      >
        <div
          v-for="row in filteredRows"
          :key="row.id"
          class="entity-card"
        >
          <div>
            <span class="entity-tag tag-public">{{ row.format || row.status || 'منشور 🌐' }}</span>
            <h3 class="entity-title">
              {{ row.title }}
            </h3>
            <div class="entity-meta-tags">
              <span v-if="row.author" class="meta-chip">{{ row.author }}</span>
              <span v-if="row.isbn" class="meta-chip">{{ row.isbn }}</span>
            </div>
            <p
              v-if="row.description"
              style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;"
            >
              {{ row.description }}
            </p>
          </div>
          <div class="card-footer">
            <div class="card-actions-strip">
              <a
                :href="row.reader_url || `/books/${row.slug}/reader`"
                class="btn-indigo-small"
              >
                📖 القارئ
              </a>
              <a
                :href="row.studio_url || `/studio/book/${row.slug}`"
                class="btn-emerald-small"
              >
                ✍️ الاستوديو
              </a>
            </div>
            <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">
              {{ row.created_at_human || row.created_at || 'مؤخراً' }}
            </span>
          </div>
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
  </div>
</template>
