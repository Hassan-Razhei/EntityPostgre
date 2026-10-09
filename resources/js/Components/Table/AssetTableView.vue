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

// Polymorphic Taxonomy Attachment (Cycle 22)
const showAttachModal = ref(false);
const activeAttachEntity = ref(null);
const attachTargetType = ref('collection');
const attachTargetId = ref('');
const attachPosition = ref(1);
const isSubmittingAttach = ref(false);
const attachSuccessMessage = ref('');
const attachErrorMessage = ref('');

const handleOpenAttachModal = (row) => {
    activeAttachEntity.value = row;
    attachTargetId.value = '';
    attachPosition.value = 1;
    attachSuccessMessage.value = '';
    attachErrorMessage.value = '';
    showAttachModal.value = true;
};

const handleCloseAttachModal = () => {
    showAttachModal.value = false;
    activeAttachEntity.value = null;
};

const submitAttach = async () => {
    if (!attachTargetId.value.trim()) {
        attachErrorMessage.value = 'يرجى إدخال معرّف المجموعة أو السلسلة';
        return;
    }

    isSubmittingAttach.value = true;
    attachErrorMessage.value = '';
    attachSuccessMessage.value = '';

    const endpoint = attachTargetType.value === 'collection'
        ? `/collections/${attachTargetId.value.trim()}/entities`
        : `/series/${attachTargetId.value.trim()}/entities`;

    const typeMap = {
        books: 'book',
        manuscripts: 'manuscript',
        audios: 'audio',
        videos: 'video',
    };
    const entityType = typeMap[props.assetType] || 'book';

    try {
        const payload = {
            entity_type: entityType,
            entity_id: activeAttachEntity.value.id,
        };
        if (attachTargetType.value === 'series') {
            payload.position = Number(attachPosition.value) || 1;
        }

        const csrfToken = typeof document !== 'undefined' ? (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '') : '';
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json();
        if (response.ok && data.success) {
            attachSuccessMessage.value = data.message || 'تم ضم الكيان بنجاح!';
            setTimeout(() => {
                handleCloseAttachModal();
            }, 1200);
        } else {
            attachErrorMessage.value = data.message || 'تعذر ضم الكيان، تأكد من صحة المعرف.';
        }
    } catch (e) {
        attachErrorMessage.value = 'حدث خطأ أثناء الاتصال بالخادم.';
    } finally {
        isSubmittingAttach.value = false;
    }
};
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
          @attach-taxonomy="handleOpenAttachModal"
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

    <!-- 6. Polymorphic Taxonomy Attachment Modal (Cycle 22) -->
    <div
      v-if="showAttachModal"
      id="taxonomyAttachModal"
      class="modal-backdrop-blur"
      style="position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); padding: 1rem;"
      @click.self="handleCloseAttachModal"
    >
      <div
        class="modal-glass-content"
        style="width: 100%; max-width: 520px; background: rgba(17, 24, 39, 0.95); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 16px; padding: 1.75rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);"
      >
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
          <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 0.5rem;">
            <span>📦</span>
            <span>ضم إلى مجموعة أو سلسلة</span>
          </h3>
          <button
            type="button"
            style="background: transparent; border: none; color: var(--text-dim); cursor: pointer; font-size: 1.25rem; line-height: 1;"
            @click="handleCloseAttachModal"
          >&times;</button>
        </div>

        <div style="margin-bottom: 1.25rem; padding: 0.85rem 1rem; border-radius: 10px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08);">
          <div style="font-size: 0.72rem; color: var(--text-dim); font-weight: 700; margin-bottom: 0.25rem;">الأصل المراد ربطه:</div>
          <div style="font-size: 0.95rem; font-weight: 800; color: #60a5fa;">{{ activeAttachEntity?.title || activeAttachEntity?.name }}</div>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem;">نوع الربط والتنظيم:</label>
          <div style="display: flex; gap: 0.75rem;">
            <label style="flex: 1; display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid; cursor: pointer; transition: all 0.2s;" :style="attachTargetType === 'collection' ? 'background: rgba(16, 185, 129, 0.15); border-color: #10b981; color: #34d399;' : 'background: rgba(255, 255, 255, 0.03); border-color: rgba(255, 255, 255, 0.1); color: var(--text-dim);'">
              <input type="radio" value="collection" v-model="attachTargetType" style="accent-color: #10b981;" />
              <span style="font-weight: 700; font-size: 0.85rem;">مجموعة مختارة 📦</span>
            </label>
            <label style="flex: 1; display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem; border-radius: 10px; border: 1px solid; cursor: pointer; transition: all 0.2s;" :style="attachTargetType === 'series' ? 'background: rgba(168, 85, 247, 0.15); border-color: #a855f7; color: #c084fc;' : 'background: rgba(255, 255, 255, 0.03); border-color: rgba(255, 255, 255, 0.1); color: var(--text-dim);'">
              <input type="radio" value="series" v-model="attachTargetType" style="accent-color: #a855f7;" />
              <span style="font-weight: 700; font-size: 0.85rem;">سلسلة علمية 📚</span>
            </label>
          </div>
        </div>

        <div style="margin-bottom: 1.25rem;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.4rem;">
            {{ attachTargetType === 'collection' ? 'معرف المجموعة (Collection ID / UUID):' : 'معرف السلسلة (Series ID / UUID):' }}
          </label>
          <input
            v-model="attachTargetId"
            type="text"
            placeholder="أدخل معرّف الوجهة..."
            style="width: 100%; padding: 0.65rem 0.9rem; border-radius: 8px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; font-size: 0.85rem;"
          />
        </div>

        <div v-if="attachTargetType === 'series'" style="margin-bottom: 1.25rem;">
          <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.4rem;">ترتيب الموضع داخل السلسلة:</label>
          <input
            v-model="attachPosition"
            type="number"
            min="1"
            style="width: 100%; padding: 0.65rem 0.9rem; border-radius: 8px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; font-size: 0.85rem;"
          />
        </div>

        <div v-if="attachSuccessMessage" style="margin-bottom: 1rem; padding: 0.75rem; border-radius: 8px; background: rgba(16, 185, 129, 0.2); color: #34d399; font-weight: 700; font-size: 0.8rem; text-align: center;">
          ✓ {{ attachSuccessMessage }}
        </div>
        <div v-if="attachErrorMessage" style="margin-bottom: 1rem; padding: 0.75rem; border-radius: 8px; background: rgba(239, 68, 68, 0.2); color: #f87171; font-weight: 700; font-size: 0.8rem; text-align: center;">
          ⚠️ {{ attachErrorMessage }}
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem;">
          <button
            type="button"
            class="btn-action-small"
            style="padding: 0.6rem 1.25rem; font-size: 0.85rem;"
            @click="handleCloseAttachModal"
          >إلغاء</button>
          <button
            type="button"
            class="btn-primary-small"
            style="padding: 0.6rem 1.4rem; font-size: 0.85rem; background: #3b82f6; border-color: #2563eb;"
            :disabled="isSubmittingAttach"
            @click="submitAttach"
          >
            {{ isSubmittingAttach ? 'جارِ الضم...' : 'تأكيد الضم 🔗' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
