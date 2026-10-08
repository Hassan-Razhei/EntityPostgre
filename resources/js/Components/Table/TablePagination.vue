<script setup>
import { computed } from 'vue';

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
        default: 'كياناً',
    },
});

const emit = defineEmits(['update:currentPage', 'update:perPage']);

const totalPages = computed(() => Math.max(1, Math.ceil(props.total / props.perPage)));

const from = computed(() => {
    if (props.total === 0) return 0;
    return (props.currentPage - 1) * props.perPage + 1;
});

const to = computed(() => {
    return Math.min(props.currentPage * props.perPage, props.total);
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value && page !== props.currentPage) {
        emit('update:currentPage', page);
    }
};

const handlePerPageChange = (e) => {
    const val = Number(e.target.value);
    emit('update:perPage', val);
    emit('update:currentPage', 1);
};
</script>

<template>
  <div class="table-pagination-bar flex flex-col sm:flex-row justify-between items-center gap-4 py-3 px-4 bg-gray-50/80 dark:bg-white/[0.02] border border-gray-200 dark:border-white/10 rounded-xl mt-4 text-xs">
    <!-- Statement: عرض X - Y من أصل Z -->
    <div class="pagination-info flex items-center gap-1.5 text-gray-500 dark:text-zinc-400">
      <span>عرض</span>
      <strong class="font-mono font-black text-gray-900 dark:text-white">
        {{ from }} - {{ to }}
      </strong>
      <span>من أصل</span>
      <strong class="font-mono font-black text-gray-900 dark:text-white">
        {{ total.toLocaleString() }}
      </strong>
      <span>{{ entityLabel }}</span>
    </div>

    <!-- Controls: Per Page + Navigation Buttons -->
    <div class="pagination-controls flex items-center gap-3">
      <!-- Per Page Selector -->
      <div class="flex items-center gap-1.5 text-gray-500 dark:text-zinc-400">
        <span>في الصفحة:</span>
        <select
          id="perPageSelect"
          :value="perPage"
          class="bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-md py-1 px-2 text-xs font-mono font-bold text-gray-700 dark:text-zinc-200 focus:outline-none focus:border-indigo-500 cursor-pointer"
          @change="handlePerPageChange"
        >
          <option
            v-for="opt in perPageOptions"
            :key="opt"
            :value="opt"
          >
            {{ opt }}
          </option>
        </select>
      </div>

      <!-- Nav Buttons -->
      <div class="pagination-buttons flex items-center gap-1">
        <!-- First Page -->
        <button
          type="button"
          id="btnPageFirst"
          :disabled="currentPage <= 1"
          class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-gray-100 dark:hover:not-disabled:bg-white/10 cursor-pointer transition-colors"
          title="الصفحة الأولى"
          @click="goToPage(1)"
        >
          ««
        </button>

        <!-- Prev Page -->
        <button
          type="button"
          id="btnPagePrev"
          :disabled="currentPage <= 1"
          class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-gray-100 dark:hover:not-disabled:bg-white/10 cursor-pointer transition-colors"
          title="الصفحة السابقة"
          @click="goToPage(currentPage - 1)"
        >
          ‹
        </button>

        <!-- Current Page Badge -->
        <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-md bg-indigo-600 text-white font-mono font-bold text-xs shadow-xs">
          {{ currentPage }}
        </span>

        <!-- Next Page -->
        <button
          type="button"
          id="btnPageNext"
          :disabled="currentPage >= totalPages"
          class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-gray-100 dark:hover:not-disabled:bg-white/10 cursor-pointer transition-colors"
          title="الصفحة التالية"
          @click="goToPage(currentPage + 1)"
        >
          ›
        </button>

        <!-- Last Page -->
        <button
          type="button"
          id="btnPageLast"
          :disabled="currentPage >= totalPages"
          class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-600 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed hover:not-disabled:bg-gray-100 dark:hover:not-disabled:bg-white/10 cursor-pointer transition-colors"
          title="الصفحة الأخيرة"
          @click="goToPage(totalPages)"
        >
          »»
        </button>
      </div>
    </div>
  </div>
</template>
