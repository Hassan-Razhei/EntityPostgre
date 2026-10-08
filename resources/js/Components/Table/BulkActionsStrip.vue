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
    id="bulkActionsStrip"
    :class="['bulk-actions-strip', selectedCount > 0 ? 'active' : 'hidden']"
    v-show="selectedCount > 0"
  >
    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; color: var(--indigo);">
      <span>✓</span>
      <span id="bulkSelectedCount">المحدد ({{ selectedCount }})</span>
    </div>
    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
      <button
        type="button"
        id="btnBulkExport"
        class="btn-action-small"
        @click="emit('export-selected')"
      >
        تصدير
      </button>
      <button
        type="button"
        id="btnBulkDelete"
        class="btn-action-small"
        style="color: var(--crimson); border-color: rgba(239, 68, 68, 0.3);"
        @click="emit('delete-selected')"
      >
        حذف
      </button>
      <button
        type="button"
        id="btnBulkClear"
        class="btn-action-small"
        @click="emit('clear-selection')"
      >
        إلغاء التحديد
      </button>
    </div>
  </div>
</template>
