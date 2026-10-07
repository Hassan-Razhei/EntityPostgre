<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

defineProps({
    columns: {
        type: Array,
        required: true,
        default: () => []
    }
});

const emit = defineEmits(['toggle-column', 'reset-all']);

const isOpen = ref(false);

const toggleDropdown = (e) => {
    if (e) {
        e.stopPropagation();
    }
    isOpen.value = !isOpen.value;
};

const handleDocumentClick = (e) => {
    const wrapper = e.target.closest('.columns-picker-wrapper');
    if (!wrapper) {
        isOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
});

onUnmounted(() => {
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<template>
  <div class="columns-picker-wrapper relative inline-block">
    <!-- Toggle Button -->
    <button
      type="button"
      id="btnToggleColumns"
      class="toolbar-btn h-[27px] box-border bg-black/5 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-md px-2 text-xs font-bold text-gray-700 dark:text-zinc-200 hover:bg-black/10 dark:hover:bg-white/10 hover:border-indigo-500 outline-none cursor-pointer transition-all inline-flex items-center gap-1.5"
      title="تحديد الأعمدة الظاهرة"
      @click="toggleDropdown"
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
        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"/>
      </svg>
      <span>الأعمدة</span>
    </button>

    <!-- Dropdown Menu -->
    <div
      :class="[
        'columns-dropdown-menu absolute top-[calc(100%+4px)] left-0 min-w-[185px] max-h-[260px] overflow-y-auto overflow-x-hidden bg-white/95 dark:bg-[#121216]/95 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-xl shadow-2xl p-1.5 z-50 flex-col gap-0.5 custom-scrollbar',
        isOpen ? 'show flex' : 'hidden'
      ]"
    >
      <label
        v-for="col in columns"
        :key="col.key"
        class="column-toggle-item flex items-center gap-2.5 px-2 py-1 rounded-md text-xs font-semibold text-gray-700 dark:text-zinc-200 hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer select-none transition-colors"
      >
        <input
          type="checkbox"
          :data-key="col.key"
          :checked="col.visible"
          :disabled="col.required"
          :title="col.required ? 'عمود أساسي' : ''"
          class="cursor-pointer accent-indigo-600 w-3.5 h-3.5"
          @change="$emit('toggle-column', col.key, $event.target.checked)"
        >
        <span :class="{ 'opacity-60': col.required }">{{ col.label }}</span>
      </label>

      <div class="columns-menu-divider h-px bg-gray-100 dark:bg-white/5 my-1" />

      <button
        type="button"
        class="columns-reset-btn bg-transparent border-0 text-indigo-600 dark:text-indigo-400 text-xs font-bold py-1 px-2 text-right cursor-pointer hover:underline"
        @click="$emit('reset-all')"
      >
        إظهار الكل
      </button>
    </div>
  </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(156, 163, 175, 0.4);
  border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #6366f1;
}
</style>
