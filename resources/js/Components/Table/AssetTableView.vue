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
    assetType: {
        type: String,
        default: 'books',
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
    initialViewMode: {
        type: String,
        default: 'table',
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
const viewMode = ref(props.initialViewMode || 'table');
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
        :asset-type="assetType"
        :search-input-id="`${assetType}SearchInput`"
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
      <div v-show="viewMode === 'table'" :id="`${assetType}TableView`" class="dense-table-wrapper">
        <DenseDataTable
          :table-id="`${assetType}DataTable`"
          :asset-type="assetType"
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
        :id="`${assetType}GridView`"
        class="catalog-grid"
        style="padding: 1.25rem;"
      >
        <!-- 1. Authors Cards -->
        <template v-if="assetType === 'authors'">
          <div
            v-for="row in filteredRows"
            :key="row.id"
            class="entity-card"
          >
            <div>
              <span class="entity-tag tag-scholarly">{{ row.tag || 'عَلَم محقق 🏛️' }}</span>
              <h3 class="entity-title">{{ row.name }}</h3>
              <div class="entity-meta-tags">
                <span class="meta-chip">{{ row.lifespan || '—' }}</span>
                <span class="meta-chip category">{{ row.books_count !== undefined ? `${row.books_count} مصنفاً` : (row.works_count || '0 مصنفاً') }}</span>
                <span class="meta-chip">{{ row.original_region || 'الجزيرة العربية' }}</span>
              </div>
              <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">
                {{ row.bio || 'عَلَم من أئمة الإسلام ومصنف بارز في العلوم الشرعية والتاريخية.' }}
              </p>
            </div>
            <div class="card-footer">
              <a :href="row.profile_url || `/authors/${row.id}`" class="btn-indigo-small"><span>تصفح المؤلفات 📚</span></a>
              <a :href="row.edit_url || `/authors/${row.id}/edit`" class="btn-action-small"><span>تعديل السيرة ✏️</span></a>
            </div>
          </div>
        </template>

        <!-- 2. Publishers Cards -->
        <template v-else-if="assetType === 'publishers'">
          <div
            v-for="row in filteredRows"
            :key="row.id"
            class="entity-card"
          >
            <div>
              <span class="entity-tag tag-public">{{ row.status || 'ناشر معتمد 🏢' }}</span>
              <h3 class="entity-title">{{ row.name }}</h3>
              <div class="entity-meta-tags">
                <span class="meta-chip">{{ row.country || 'بيروت - لبنان' }}</span>
                <span class="meta-chip category">{{ row.publications_count || '150 مطبوعة مؤرشفة' }}</span>
              </div>
              <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">
                {{ row.description || 'مؤسسة ودور نشر تراثية متخصصة في طباعة وتحقيق التراث الإسلامي بأعلى معايير الإخراج.' }}
              </p>
            </div>
            <div class="card-footer">
              <a :href="row.profile_url || `/publishers/${row.id}`" class="btn-indigo-small"><span>عرض المنشورات 📖</span></a>
              <span style="font-size: 0.68rem; color: var(--text-dim);">منذ {{ row.established_year || '1985' }}</span>
            </div>
          </div>
        </template>

        <!-- 3. Users Cards -->
        <template v-else-if="assetType === 'users'">
          <div
            v-for="row in filteredRows"
            :key="row.id"
            class="entity-card"
          >
            <div>
              <span :class="['role-chip', row.role === 'super_admin' ? 'chip-admin' : (row.role === 'editor' ? 'chip-studio' : 'chip-public')]">
                {{ row.role === 'super_admin' ? 'مدير عام 👑' : (row.role === 'editor' ? 'محرر استوديو ✍️' : 'عضو باحث 👤') }}
              </span>
              <h3 class="entity-title" style="margin-top: 0.5rem;">{{ row.name }}</h3>
              <div class="entity-meta-tags">
                <span class="meta-chip" style="font-family: monospace;">{{ row.email }}</span>
                <span class="meta-chip">{{ row.status || 'نشط' }}</span>
              </div>
            </div>
            <div class="card-footer">
              <button class="btn-action-small" :onclick="`alert('تعديل صلاحيات المستخدم: ${row.name}')`">
                <span>صلاحيات ⚙️</span>
              </button>
              <span style="font-size: 0.65rem; color: var(--text-dim);">
                {{ row.created_at_human || row.created_at || 'مؤخراً' }}
              </span>
            </div>
          </div>
        </template>

        <!-- 4. Deletions Cards -->
        <template v-else-if="assetType === 'deletions'">
          <div
            v-for="row in filteredRows"
            :key="row.id"
            class="entity-card"
          >
            <div>
              <span :class="['role-chip', row.type_chip || 'chip-studio']">{{ row.type_label || 'كيان محذوف' }}</span>
              <h3 class="entity-title" style="margin-top: 0.5rem;">{{ row.title }}</h3>
              <div class="entity-meta-tags">
                <span class="meta-chip">{{ row.deleted_at_human || 'مؤخراً' }}</span>
                <span class="meta-chip category" style="color: #f59e0b;">{{ row.days_remaining || 'باقي 29 يوماً' }}</span>
              </div>
            </div>
            <div class="card-footer">
              <button
                class="btn-action-small"
                style="color: #34d399; border-color: rgba(16, 185, 129, 0.3);"
                :onclick="`alert('تمت استعادة الكيان (${row.title}) بنجاح!')`"
              >
                <span>استعادة الكيان ♻️</span>
              </button>
            </div>
          </div>
        </template>

        <!-- 5. Books, Manuscripts, Audios, Videos (Media & Assets) -->
        <template v-else>
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
                <span v-if="row.code" class="meta-chip" style="color: var(--indigo); font-family: monospace;">{{ row.code }}</span>
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
                  v-if="assetType === 'manuscripts'"
                  :href="row.reader_url || `/dev/manuscripter/${row.slug}`"
                  class="btn-indigo-small"
                >
                  🔬 الفحص
                </a>
                <a
                  v-else-if="assetType === 'audios'"
                  :href="row.player_url || row.reader_url || `/audios/${row.slug}/player`"
                  class="btn-indigo-small"
                >
                  🎧 المشغل
                </a>
                <a
                  v-else-if="assetType === 'videos'"
                  :href="row.player_url || row.reader_url || `/videos/${row.slug}/player`"
                  class="btn-indigo-small"
                >
                  🎬 المشغل
                </a>
                <a
                  v-else
                  :href="row.reader_url || `/books/${row.slug}/reader`"
                  class="btn-indigo-small"
                >
                  📖 القارئ
                </a>

                <a
                  :href="row.studio_url || `/studio/${assetType === 'manuscripts' ? 'manuscript' : (assetType === 'audios' ? 'audio' : (assetType === 'videos' ? 'video' : 'book'))}/${row.slug}`"
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
        </template>
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
