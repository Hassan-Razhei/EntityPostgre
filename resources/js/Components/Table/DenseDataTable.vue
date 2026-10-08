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
});

const emit = defineEmits(['update:selectedIds', 'sort', 'row-click']);

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

              <!-- 2. Title -->
              <template v-else-if="col.key === 'title'">
                <a
                  :href="row.reader_url || `/books/${row.slug}/reader`"
                  class="book-title-link"
                >
                  {{ row.title }}
                </a>
              </template>

              <!-- 3. Slug -->
              <template v-else-if="col.key === 'slug'">
                {{ row.slug }}
              </template>

              <!-- 4. Author -->
              <template v-else-if="col.key === 'author'">
                <div style="font-weight: 700;">
                  <a
                    :href="row.author_url || '/authors'"
                    style="color: var(--text-main); text-decoration: none;"
                  >
                    {{ row.author }}
                  </a>
                </div>
              </template>

              <!-- 5. ISBN -->
              <template v-else-if="col.key === 'isbn'">
                {{ row.isbn || '—' }}
              </template>

              <!-- 6. Description -->
              <template v-else-if="col.key === 'description'">
                <div class="cell-desc" :title="row.description">
                  {{ row.description }}
                </div>
              </template>

              <!-- 7. Files Badges (Cycle 9 Fidelity) -->
              <template v-else-if="col.key === 'files'">
                <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                  <span
                    title="cover_path متوفر"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;"
                  >🖼️ غلاف</span>
                  <span
                    title="file_path متوفر"
                    style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;"
                  >📄 PDF</span>
                </div>
              </template>

              <!-- 8. Created At -->
              <template v-else-if="col.key === 'created_at'">
                {{ row.created_at_human || row.created_at || 'مؤخراً' }}
              </template>

              <!-- 9. Actions -->
              <template v-else-if="col.key === 'actions'">
                <div class="table-actions-cell" style="justify-content: center;">
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
                    onclick="alert('تم نقل الكتاب للمهملات')"
                  >🗑️</button>
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
