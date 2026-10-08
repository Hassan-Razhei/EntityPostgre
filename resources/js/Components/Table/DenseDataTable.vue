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
</script>

<template>
  <div class="dense-table-wrapper w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/[0.02] shadow-xs custom-scrollbar">
    <table class="dense-table w-full text-right border-collapse text-xs">
      <thead>
        <tr class="bg-gray-50/80 dark:bg-white/[0.03] border-b border-gray-200 dark:border-white/10">
          <!-- Master Checkbox -->
          <th class="w-9 py-2.5 px-3 text-center">
            <input
              type="checkbox"
              id="masterCheckbox"
              :checked="isAllSelected"
              class="cursor-pointer accent-indigo-600 w-3.5 h-3.5 rounded"
              @change="toggleSelectAll"
            >
          </th>

          <!-- Column Headers -->
          <th
            v-for="col in visibleColumns"
            :key="col.key"
            :class="[
              'py-2.5 px-3 font-extrabold text-gray-600 dark:text-zinc-400 select-none whitespace-nowrap',
              col.align === 'center' ? 'text-center' : col.align === 'left' ? 'text-left' : 'text-right'
            ]"
          >
            <div
              :class="[
                'inline-flex items-center gap-1.5',
                col.sortable ? 'cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400' : ''
              ]"
              @click="col.sortable && emit('sort', col.key)"
            >
              <span>{{ col.label }}</span>
              <span
                v-if="col.sortable"
                class="text-[10px] text-gray-400"
              >⇅</span>
            </div>
          </th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-100 dark:divide-white/5">
        <tr
          v-for="row in rows"
          :key="row[idKey]"
          :class="[
            'transition-colors hover:bg-gray-50/80 dark:hover:bg-white/[0.03] group',
            isRowSelected(row[idKey]) ? 'bg-indigo-50/40! dark:bg-indigo-500/10!' : ''
          ]"
          @click="emit('row-click', row)"
        >
          <!-- Row Checkbox -->
          <td
            class="w-9 py-2.5 px-3 text-center"
            @click.stop
          >
            <input
              type="checkbox"
              :data-row-id="row[idKey]"
              :checked="isRowSelected(row[idKey])"
              class="row-checkbox cursor-pointer accent-indigo-600 w-3.5 h-3.5 rounded"
              @change="toggleRowSelection(row[idKey])"
            >
          </td>

          <!-- Dynamic Cells -->
          <td
            v-for="col in visibleColumns"
            :key="col.key"
            :class="[
              'py-2.5 px-3 align-middle whitespace-nowrap text-gray-800 dark:text-zinc-200',
              col.align === 'center' ? 'text-center' : col.align === 'left' ? 'text-left' : 'text-right',
              col.isMono ? 'font-mono' : ''
            ]"
          >
            <slot
              :name="`cell(${col.key})`"
              :row="row"
              :value="row[col.key]"
            >
              <!-- Default Actions Cell -->
              <template v-if="col.key === 'actions'">
                <div class="flex items-center justify-center gap-1.5">
                  <button
                    type="button"
                    class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-white/10 text-gray-500 dark:text-zinc-400 transition-colors"
                    title="عرض"
                  >
                    📖
                  </button>
                  <button
                    type="button"
                    class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-white/10 text-gray-500 dark:text-zinc-400 transition-colors"
                    title="الاستوديو"
                  >
                    ✍️
                  </button>
                  <button
                    type="button"
                    class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-white/10 text-gray-500 dark:text-zinc-400 transition-colors"
                    title="تعديل"
                  >
                    ⚙️
                  </button>
                  <button
                    type="button"
                    class="p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-500/20 text-red-500 transition-colors"
                    title="حذف"
                  >
                    🗑️
                  </button>
                </div>
              </template>

              <!-- Default Fallback -->
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
            class="py-12 text-center text-gray-400 dark:text-zinc-500"
          >
            <div class="flex flex-col items-center justify-center gap-2">
              <span class="text-3xl">📭</span>
              <p class="font-bold">
                لا توجد سجلات مطابقة في هذا الفهرس
              </p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  height: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(156, 163, 175, 0.3);
  border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #6366f1;
}
</style>
