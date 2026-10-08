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
    const wrapper = e.target?.closest ? e.target.closest('.columns-picker-wrapper') : null;
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
  <div class="columns-picker-wrapper" style="position: relative;">
    <!-- Toggle Button -->
    <button
      type="button"
      id="btnToggleColumns"
      class="toolbar-btn"
      title="تحديد الأعمدة الظاهرة المستمدة من المايجريشن"
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
        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18" />
      </svg>
      <span>الأعمدة</span>
    </button>

    <!-- Dropdown Menu -->
    <div
      id="columnsDropdownMenu"
      class="columns-dropdown-menu"
      :class="{ show: isOpen }"
      v-show="isOpen"
    >
      <label
        v-for="col in columns"
        :key="col.key"
        class="column-toggle-item"
      >
        <input
          type="checkbox"
          :data-key="col.key"
          :checked="col.visible !== false"
          :disabled="col.required"
          :title="col.required ? 'عمود أساسي' : ''"
          @change="emit('toggle-column', col.key, $event.target.checked)"
        >
        <span>{{ col.label }}</span>
      </label>

      <div class="columns-menu-divider" />

      <button
        type="button"
        class="columns-reset-btn"
        @click="emit('reset-all')"
      >
        إظهار الكل
      </button>
    </div>
  </div>
</template>
