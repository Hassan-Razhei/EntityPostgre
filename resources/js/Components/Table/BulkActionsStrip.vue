<script setup>
defineProps({
    selectedCount: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(['export-selected', 'delete-selected', 'clear-selection']);
</script>

<template>
  <div
    :class="[
      'bulk-actions-strip items-center justify-between gap-3 p-3 my-2.5 bg-white/95 dark:bg-[#121216]/95 backdrop-blur-xl border border-indigo-500/40 rounded-xl shadow-lg transition-all duration-300',
      selectedCount > 0 ? 'flex' : 'hidden'
    ]"
  >
    <!-- Counter Badge -->
    <div class="bulk-counter flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-zinc-200">
      <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 font-mono text-[11px] font-black">
        ✓
      </span>
      <span>تم تحديد</span>
      <span class="font-mono font-black text-indigo-600 dark:text-indigo-400 text-sm">
        {{ selectedCount }}
      </span>
      <span>عناصر من الجدول</span>
    </div>

    <!-- Actions Buttons -->
    <div class="bulk-buttons flex items-center gap-2">
      <!-- Export Button -->
      <button
        type="button"
        id="btnBulkExport"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30 rounded-lg text-xs font-bold cursor-pointer transition-all hover:-translate-y-0.5"
        title="تصدير السجلات المحددة إلى ملف CSV"
        @click="emit('export-selected')"
      >
        <svg
          width="13"
          height="13"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="7 10 12 15 17 10" />
          <line
            x1="12"
            y1="15"
            x2="12"
            y2="3"
          />
        </svg>
        <span>تصدير المحدد</span>
      </button>

      <!-- Delete Button (Danger) -->
      <button
        type="button"
        id="btnBulkDelete"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 rounded-lg text-xs font-bold cursor-pointer transition-all hover:-translate-y-0.5"
        title="نقل السجلات المحددة إلى سلة المهملات"
        @click="emit('delete-selected')"
      >
        <svg
          width="13"
          height="13"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <polyline points="3 6 5 6 21 6" />
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
        </svg>
        <span>حذف المحدد</span>
      </button>

      <!-- Clear / Cancel Button -->
      <button
        type="button"
        id="btnBulkClear"
        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white cursor-pointer border-0 transition-colors"
        title="إلغاء التحديد"
        @click="emit('clear-selection')"
      >
        ✕
      </button>
    </div>
  </div>
</template>
