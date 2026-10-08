<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
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
    perPageOptions: {
        type: Array,
        default: () => [25, 50, 100, 250],
    },
    entityLabel: {
        type: String,
        default: 'كتاب',
    },
});

const emit = defineEmits(['update:currentPage', 'update:perPage']);

const jumpInput = ref(props.currentPage);

const totalPages = computed(() => Math.max(1, Math.ceil(props.total / props.perPage)));

const from = computed(() => {
    if (props.total === 0) return 0;
    return (props.currentPage - 1) * props.perPage + 1;
});

const to = computed(() => {
    return Math.min(props.currentPage * props.perPage, props.total);
});

const visiblePages = computed(() => {
    const pages = [];
    const maxVisible = 5;
    let start = Math.max(1, props.currentPage - Math.floor(maxVisible / 2));
    let end = Math.min(totalPages.value, start + maxVisible - 1);
    if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1);
    }
    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value && page !== props.currentPage) {
        emit('update:currentPage', page);
        jumpInput.value = page;
    }
};

const jumpToPage = () => {
    if (jumpInput.value >= 1 && jumpInput.value <= totalPages.value) {
        goToPage(jumpInput.value);
    }
};

const handlePerPageChange = (e) => {
    const val = Number(e.target.value);
    emit('update:perPage', val);
    emit('update:currentPage', 1);
    jumpInput.value = 1;
};
</script>

<template>
  <div class="table-pagination-bar">
    <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
      <div>
        <span>عرض </span>
        <strong style="color: var(--text-main); font-family: 'Outfit';">{{ from }} - {{ to }}</strong>
        <span> من أصل </span>
        <strong style="color: var(--text-main); font-family: 'Outfit';">{{ total.toLocaleString() }}</strong>
        <span> {{ entityLabel }}</span>
      </div>
      <div style="display: flex; align-items: center; gap: 0.5rem;">
        <span>عرض:</span>
        <select
          id="perPageSelect"
          class="toolbar-select"
          style="padding: 0.2rem 0.5rem; font-size: 0.75rem;"
          :value="perPage"
          @change="handlePerPageChange"
        >
          <option
            v-for="opt in perPageOptions"
            :key="opt"
            :value="opt"
          >
            {{ opt }} في الصفحة
          </option>
        </select>
      </div>
    </div>

    <!-- Page navigation numbers -->
    <div class="pagination-pages-group">
      <button
        type="button"
        id="btnPageFirst"
        class="page-btn"
        :disabled="currentPage <= 1"
        title="الصفحة الأولى"
        @click="goToPage(1)"
      >
        ««
      </button>
      <button
        type="button"
        id="btnPagePrev"
        class="page-btn"
        :disabled="currentPage <= 1"
        title="السابق"
        @click="goToPage(currentPage - 1)"
      >
        ‹ السابق
      </button>

      <button
        v-for="p in visiblePages"
        :key="p"
        type="button"
        class="page-btn"
        :class="{ active: p === currentPage }"
        @click="goToPage(p)"
      >
        {{ p }}
      </button>

      <button
        type="button"
        id="btnPageNext"
        class="page-btn"
        :disabled="currentPage >= totalPages"
        title="التالي"
        @click="goToPage(currentPage + 1)"
      >
        التالي ›
      </button>
      <button
        type="button"
        id="btnPageLast"
        class="page-btn"
        :disabled="currentPage >= totalPages"
        title="الصفحة الأخيرة"
        @click="goToPage(totalPages)"
      >
        »»
      </button>
    </div>

    <!-- Quick jump to page -->
    <div style="display: flex; align-items: center; gap: 0.4rem;">
      <span>الانتقال لصفحة:</span>
      <input
        type="number"
        min="1"
        :max="totalPages"
        v-model.number="jumpInput"
        style="width: 55px; background: rgba(255,255,255,0.04); border: 1px solid var(--border-subtle); border-radius: 6px; padding: 0.2rem 0.4rem; color: var(--text-main); text-align: center; font-size: 0.75rem; font-family: 'Outfit'; outline: none;"
      >
      <button
        type="button"
        class="btn-action-small"
        style="padding: 0.2rem 0.6rem; font-size: 0.72rem;"
        @click="jumpToPage"
      >
        انتقال
      </button>
    </div>
  </div>
</template>
