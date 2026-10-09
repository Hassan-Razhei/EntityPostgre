<script setup>
import { computed } from 'vue';

const props = defineProps({
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
    selectedIds: {
        type: Array,
        default: () => [],
    },
    idKey: {
        type: String,
        default: 'id',
    },
    tableId: {
        type: String,
        default: 'booksDataTable',
    },
    assetType: {
        type: String,
        default: 'books',
    },
});

const emit = defineEmits(['update:selectedIds', 'sort', 'row-click', 'attach-taxonomy']);

const visibleColumns = computed(() => {
    return props.columns.filter(col => col.visible !== false);
});

const isAllSelected = computed(() => {
    if (!props.rows.length) return false;
    return props.rows.every(r => props.selectedIds.includes(r[props.idKey]));
});

const toggleSelectAll = (e) => {
    if (e.target.checked) {
        const allIds = props.rows.map(r => r[props.idKey]);
        emit('update:selectedIds', allIds);
    } else {
        emit('update:selectedIds', []);
    }
};

const toggleRowSelection = (id) => {
    const current = [...props.selectedIds];
    const index = current.indexOf(id);
    if (index > -1) {
        current.splice(index, 1);
    } else {
        current.push(id);
    }
    emit('update:selectedIds', current);
};

const isRowSelected = (id) => {
    return props.selectedIds.includes(id);
};

const getColHeaderStyle = (col) => {
    if (col.width) return { width: col.width };
    if (col.key === 'serial' || col.key === 'id') return { width: '70px' };
    if (col.key === 'slug') return { width: '110px' };
    if (col.key === 'isbn') return { width: '120px' };
    if (col.key === 'files') return { width: '90px', textAlign: 'center' };
    if (col.key === 'created_at') return { width: '85px' };
    if (col.key === 'actions') return { width: '110px', textAlign: 'center' };
    return {};
};

const getColCellStyle = (col) => {
    if (col.key === 'serial' || col.key === 'id') {
        return { fontFamily: `'Outfit', monospace`, color: 'var(--text-dim)', fontSize: '0.75rem' };
    }
    if (col.key === 'slug') {
        return { fontFamily: `'Outfit', monospace`, fontSize: '0.75rem', color: 'var(--indigo)' };
    }
    if (col.key === 'isbn') {
        return { fontFamily: `'Outfit', monospace`, color: 'var(--text-muted)', fontSize: '0.75rem' };
    }
    if (col.key === 'files' || col.key === 'actions') {
        return { textAlign: 'center' };
    }
    if (col.key === 'created_at') {
        return { fontSize: '0.72rem', color: 'var(--text-dim)', fontFamily: `'Outfit'` };
    }
    return {};
};
</script>

<template>
  <div class="dense-table-wrapper">
    <table :id="tableId" class="dense-table">
      <thead>
        <tr>
          <!-- Master Checkbox -->
          <th style="width: 36px; text-align: center;">
            <input
              type="checkbox"
              id="masterCheckbox"
              :checked="isAllSelected"
              class="cursor-pointer"
              @change="toggleSelectAll"
            >
          </th>

          <!-- Columns -->
          <th
            v-for="col in visibleColumns"
            :key="col.key"
            :class="{ sortable: col.sortable }"
            :style="getColHeaderStyle(col)"
            @click="col.sortable && emit('sort', col.key)"
          >
            {{ col.label }} <span v-if="col.sortable">⇅</span>
          </th>
        </tr>
      </thead>

      <tbody id="booksTableBody">
        <tr
          v-for="row in rows"
          :key="row[idKey]"
          :data-title="row.title"
          :data-author="row.author"
          :data-isbn="row.isbn"
          :class="{ selected: isRowSelected(row[idKey]) }"
          @click="emit('row-click', row)"
        >
          <!-- Checkbox -->
          <td style="text-align: center;" @click.stop>
            <input
              type="checkbox"
              class="row-checkbox"
              :data-row-id="row[idKey]"
              :checked="isRowSelected(row[idKey])"
              @change="toggleRowSelection(row[idKey])"
            >
          </td>

          <!-- Dynamic Cells -->
          <td
            v-for="col in visibleColumns"
            :key="col.key"
            :style="getColCellStyle(col)"
          >
            <slot
              :name="`cell(${col.key})`"
              :row="row"
              :value="row[col.key]"
            >
              <!-- 1. Serial -->
              <template v-if="col.key === 'serial'">
                {{ row.serial || `#${row.id}` }}
              </template>

              <!-- 2. Title / Name -->
              <template v-else-if="col.key === 'title'">
                <a
                  :href="row.reader_url || `/books/${row.slug}/reader`"
                  class="book-title-link"
                >
                  {{ row.title }}
                </a>
              </template>
              <template v-else-if="col.key === 'name'">
                <a
                  v-if="assetType === 'authors'"
                  :href="row.profile_url || `/authors/${row.id}`"
                  class="book-title-link"
                >
                  {{ row.name }}
                </a>
                <a
                  v-else-if="assetType === 'publishers'"
                  :href="row.profile_url || `/publishers/${row.id}`"
                  class="book-title-link"
                >
                  {{ row.name }}
                </a>
                <strong v-else-if="assetType === 'users'" style="color: var(--text-main);">
                  {{ row.name }}
                </strong>
                <span v-else>{{ row.name }}</span>
              </template>

              <!-- 3. Code / Slug -->
              <template v-else-if="col.key === 'code'">
                <span style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 600;">
                  {{ row.code }}
                </span>
              </template>
              <template v-else-if="col.key === 'slug'">
                <span style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">
                  {{ row.slug }}
                </span>
              </template>

              <!-- 4. Author / Copyist -->
              <template v-else-if="col.key === 'author' || col.key === 'copyist'">
                <div style="font-weight: 700;">
                  <a
                    :href="row.author_url || '/authors'"
                    style="color: var(--text-main); text-decoration: none;"
                  >
                    {{ row[col.key] || row.author || row.scribe || '—' }}
                  </a>
                </div>
              </template>

              <!-- 5. ISBN -->
              <template v-else-if="col.key === 'isbn'">
                {{ row.isbn || '—' }}
              </template>

              <!-- Email (Users) -->
              <template v-else-if="col.key === 'email'">
                <span style="font-family: monospace; font-size: 0.75rem; color: var(--text-dim);">
                  {{ row.email }}
                </span>
              </template>

              <!-- Role (Users) -->
              <template v-else-if="col.key === 'role'">
                <span :class="['role-chip', row.role === 'super_admin' ? 'chip-admin' : (row.role === 'editor' ? 'chip-studio' : 'chip-public')]">
                  {{ row.role }}
                </span>
              </template>

              <!-- Status -->
              <template v-else-if="col.key === 'status'">
                <span v-if="assetType === 'publishers'" class="role-chip chip-academic">
                  {{ row.status || 'ناشر معتمد 🏢' }}
                </span>
                <span v-else-if="assetType === 'users'" style="color: #34d399; font-weight: 700; display: inline-flex; align-items: center; gap: 0.25rem;">
                  <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#10b981;"></span>
                  {{ row.status || 'نشط' }}
                </span>
                <span v-else>{{ row.status || '—' }}</span>
              </template>

              <!-- Deletions Type & Days -->
              <template v-else-if="col.key === 'type_label'">
                <span :class="['role-chip', row.type_chip || 'chip-studio']">
                  {{ row.type_label || 'كيان محذوف' }}
                </span>
              </template>
              <template v-else-if="col.key === 'days_remaining'">
                <span class="icon-refresh" style="color: #f59e0b; font-weight: 700;">
                  {{ row.days_remaining || 'باقي 29 يوماً' }}
                </span>
              </template>

              <!-- Authors & Publishers Custom Fields -->
              <template v-else-if="col.key === 'century_lived'">
                <span class="role-chip chip-editor">{{ row.century_lived || 'القرن 8 هـ' }}</span>
              </template>
              <template v-else-if="col.key === 'lifespan'">
                <span style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--text-dim);">
                  {{ row.lifespan || '—' }}
                </span>
              </template>
              <template v-else-if="col.key === 'original_region'">
                <span>{{ row.original_region || 'الجزيرة العربية' }}</span>
              </template>
              <template v-else-if="col.key === 'madhab'">
                <span class="role-chip chip-academic">{{ row.madhab || 'مجتهد' }}</span>
              </template>
              <template v-else-if="col.key === 'works_count'">
                <span style="font-weight: 700; color: #34d399;">
                  {{ row.books_count !== undefined ? `${row.books_count} مصنفاً` : (row.works_count || '0 مصنفاً') }}
                </span>
              </template>
              <template v-else-if="col.key === 'country'">
                <span>{{ row.country || 'بيروت - لبنان' }}</span>
              </template>
              <template v-else-if="col.key === 'established_year'">
                <span style="font-family: 'Outfit', monospace; font-size: 0.75rem;">{{ row.established_year || '1985' }}</span>
              </template>
              <template v-else-if="col.key === 'publications_count'">
                <span style="font-weight: 700; color: #818cf8;">{{ row.publications_count || '150 مطبوعة مؤرشفة' }}</span>
              </template>

              <!-- Script Type & Badges -->
              <template v-else-if="col.key === 'script_type'">
                <span class="role-chip chip-editor">{{ row.script_type || 'نسخ' }}</span>
              </template>

              <!-- Condition -->
              <template v-else-if="col.key === 'condition'">
                <span class="role-chip chip-academic">{{ row.condition || 'ممتازة 95%' }}</span>
              </template>

              <!-- Duration -->
              <template v-else-if="col.key === 'duration'">
                <span style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--text-main);">
                  {{ row.duration }}
                </span>
              </template>

              <!-- Format -->
              <template v-else-if="col.key === 'format'">
                <span class="role-chip chip-studio">{{ row.format }}</span>
              </template>

              <!-- 6. Description / Bio -->
              <template v-else-if="col.key === 'description' || col.key === 'bio'">
                <div class="cell-desc" :title="row[col.key]">
                  {{ row[col.key] }}
                </div>
              </template>

              <!-- 7. Files Badges (Cycle 9 Fidelity) -->
              <template v-else-if="col.key === 'files'">
                <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                  <span
                    v-if="row.has_cover !== false"
                    title="غلاف متوفر"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;"
                  >🖼️ غلاف</span>
                  <span
                    v-if="assetType === 'manuscripts' || row.code?.startsWith('MS')"
                    title="لوحات متوفرة"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;"
                  >📜 لوحات</span>
                  <span
                    v-else-if="assetType === 'audios' || row.format === 'MP3'"
                    title="ملف صوتي"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;"
                  >🎧 صوتي</span>
                  <span
                    v-else-if="assetType === 'videos' || row.format === 'MP4'"
                    title="ملف مرئي"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;"
                  >▶️ مرئي</span>
                  <span
                    v-else
                    title="ملف PDF متوفر"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;"
                  >📄 PDF</span>
                </div>
              </template>

              <!-- 8. Created At / Deleted At -->
              <template v-else-if="col.key === 'created_at' || col.key === 'deleted_at'">
                {{ row.created_at_human || row.deleted_at_human || row[col.key] || 'مؤخراً' }}
              </template>

              <!-- 9. Actions (Specialized per assetType) -->
              <template v-else-if="col.key === 'actions'">
                <div class="table-actions-cell" style="justify-content: center;">
                  <!-- Manuscripts Actions -->
                  <template v-if="assetType === 'manuscripts'">
                    <button
                      type="button"
                      class="table-btn-icon btn-attach-taxonomy"
                      title="ضم إلى مجموعة أو سلسلة"
                      @click="emit('attach-taxonomy', row)"
                    >📦</button>
                    <a
                      :href="row.reader_url || `/dev/manuscripter/${row.slug}`"
                      class="table-btn-icon"
                      title="معمل الفحص"
                    >🔬</a>
                    <a
                      :href="row.studio_url || `/studio/manuscript/${row.slug}`"
                      class="table-btn-icon"
                      title="الاستوديو"
                    >✍️</a>
                    <a
                      :href="row.edit_url || `/manuscripts/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل"
                    >⚙️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل العنصر للمهملات')"
                    >🗑️</button>
                  </template>

                  <!-- Audios Actions -->
                  <template v-else-if="assetType === 'audios'">
                    <button
                      type="button"
                      class="table-btn-icon btn-attach-taxonomy"
                      title="ضم إلى مجموعة أو سلسلة"
                      @click="emit('attach-taxonomy', row)"
                    >📦</button>
                    <a
                      :href="row.player_url || row.reader_url || `/audios/${row.slug}/player`"
                      class="table-btn-icon"
                      title="المشغل الصوتي"
                    >🎧</a>
                    <a
                      :href="row.studio_url || `/studio/audio/${row.slug}`"
                      class="table-btn-icon"
                      title="استوديو التقطيع"
                    >✍️</a>
                    <a
                      :href="row.edit_url || `/audios/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل"
                    >⚙️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل العنصر للمهملات')"
                    >🗑️</button>
                  </template>

                  <!-- Videos Actions -->
                  <template v-else-if="assetType === 'videos'">
                    <button
                      type="button"
                      class="table-btn-icon btn-attach-taxonomy"
                      title="ضم إلى مجموعة أو سلسلة"
                      @click="emit('attach-taxonomy', row)"
                    >📦</button>
                    <a
                      :href="row.player_url || row.reader_url || `/videos/${row.slug}/player`"
                      class="table-btn-icon"
                      title="المشغل المرئي"
                    >🎬</a>
                    <a
                      :href="row.studio_url || `/studio/video/${row.slug}`"
                      class="table-btn-icon"
                      title="استوديو المونتاج"
                    >✍️</a>
                    <a
                      :href="row.edit_url || `/videos/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل"
                    >⚙️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل العنصر للمهملات')"
                    >🗑️</button>
                  </template>

                  <!-- Authors Actions -->
                  <template v-else-if="assetType === 'authors'">
                    <a
                      :href="row.profile_url || `/authors/${row.id}`"
                      class="table-btn-icon"
                      title="تصفح المؤلفات"
                    >📚</a>
                    <a
                      :href="row.edit_url || `/authors/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل السيرة"
                    >✏️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل المؤلف للمهملات')"
                    >🗑️</button>
                  </template>

                  <!-- Publishers Actions -->
                  <template v-else-if="assetType === 'publishers'">
                    <a
                      :href="row.profile_url || `/publishers/${row.id}`"
                      class="table-btn-icon"
                      title="عرض المنشورات"
                    >📖</a>
                    <a
                      :href="row.edit_url || `/publishers/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل دار النشر"
                    >⚙️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل دار النشر للمهملات')"
                    >🗑️</button>
                  </template>

                  <!-- Users Actions -->
                  <template v-else-if="assetType === 'users'">
                    <button
                      type="button"
                      class="btn-action-small"
                      :onclick="`alert('تعديل صلاحيات المستخدم: ${row.name}')`"
                    >
                      صلاحيات ⚙️
                    </button>
                  </template>

                  <!-- Deletions Actions -->
                  <template v-else-if="assetType === 'deletions'">
                    <button
                      type="button"
                      class="btn-action-small"
                      style="color: #34d399; border-color: rgba(16, 185, 129, 0.3);"
                      :onclick="`alert('تمت استعادة الكيان (${row.title}) بنجاح!')`"
                    >
                      استعادة الكيان ♻️
                    </button>
                  </template>

                  <!-- Books Actions (Default) -->
                  <template v-else>
                    <button
                      type="button"
                      class="table-btn-icon btn-attach-taxonomy"
                      title="ضم إلى مجموعة أو سلسلة"
                      @click="emit('attach-taxonomy', row)"
                    >📦</button>
                    <a
                      :href="row.reader_url || `/books/${row.slug}/reader`"
                      class="table-btn-icon"
                      title="فتح القارئ التفاعلي"
                    >📖</a>
                    <a
                      :href="row.studio_url || `/studio/book/${row.slug}`"
                      class="table-btn-icon"
                      title="فتح محرر الاستوديو"
                    >✍️</a>
                    <a
                      :href="row.edit_url || `/books/${row.id}/edit`"
                      class="table-btn-icon"
                      title="تعديل بيانات المصنف"
                    >⚙️</a>
                    <button
                      type="button"
                      class="table-btn-icon btn-danger"
                      title="حذف"
                      onclick="alert('تم نقل العنصر للمهملات')"
                    >🗑️</button>
                  </template>
                </div>
              </template>

              <template v-else>
                {{ row[col.key] ?? '—' }}
              </template>
            </slot>
          </td>
        </tr>

        <!-- Empty State -->
        <tr v-if="!rows.length">
          <td
            :colspan="visibleColumns.length + 1"
            style="text-align: center; padding: 2rem; color: var(--text-dim);"
          >
            لا توجد سجلات مطابقة في هذا الفهرس
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
