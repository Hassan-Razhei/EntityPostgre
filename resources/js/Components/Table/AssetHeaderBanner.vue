<script setup>
import { computed } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total: 0,
            published: 0,
            scholarly: 0,
            draft: 0,
        }),
    },
    activeStatus: {
        type: String,
        default: 'all',
    },
    entityName: {
        type: String,
        default: 'الكتب',
    },
    createUrl: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['filter-status', 'create', 'export', 'import', 'refresh']);

const totalCount = computed(() => Number(props.stats?.total ?? 0));
const publishedCount = computed(() => Number(props.stats?.published ?? 0));
const scholarlyCount = computed(() => Number(props.stats?.scholarly ?? 0));
const draftCount = computed(() => Number(props.stats?.draft ?? 0));

const getPercentage = (count) => {
    if (!totalCount.value) return 0;
    return Math.min(100, Math.round((count / totalCount.value) * 100));
};

const handleStatusClick = (status) => {
    emit('filter-status', status);
};
</script>

<template>
  <div class="horizontal-header-banner flex flex-wrap justify-between items-center gap-5 bg-transparent p-0 mb-6">
    <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع -->
    <div class="banner-kpi-col flex items-center gap-3 flex-wrap">

      <!-- Card 1: الكل -->
      <div
        data-status="all"
        :class="[
          'kpi-h-card bg-white dark:bg-white/[0.025] border border-gray-200 dark:border-white/10 rounded-xl py-2 px-3.5 min-w-[125px] cursor-pointer select-none transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 dark:hover:bg-white/[0.05] hover:border-gray-300 dark:hover:border-white/20 shadow-xs dark:shadow-none flex flex-col',
          activeStatus === 'all' || !activeStatus ? 'border-indigo-500! dark:border-indigo-500! bg-indigo-50/60! dark:bg-indigo-500/10! shadow-md shadow-indigo-500/15!' : ''
        ]"
        title="عرض كامل الأرشيف"
        @click="handleStatusClick('all')"
      >
        <div class="kpi-h-title flex items-center justify-between text-[11px] font-bold text-gray-500 dark:text-zinc-400 mb-0.5">
          <span>الكل</span>
          <span class="text-xs">📚</span>
        </div>
        <div class="kpi-h-value font-mono font-black text-xl text-gray-900 dark:text-white leading-tight my-0.5">
          {{ totalCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar flex h-[3px] w-full rounded-full overflow-hidden my-1 bg-gray-200 dark:bg-white/10">
          <div
            class="h-full bg-indigo-500 transition-all duration-500"
            style="width: 100%;"
          />
        </div>
        <div class="text-[10px] text-gray-400 dark:text-zinc-500 font-bold">
          100%
        </div>
      </div>

      <!-- Card 2: منشور -->
      <div
        data-status="published"
        :class="[
          'kpi-h-card bg-white dark:bg-white/[0.025] border border-gray-200 dark:border-white/10 rounded-xl py-2 px-3.5 min-w-[125px] cursor-pointer select-none transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 dark:hover:bg-white/[0.05] hover:border-gray-300 dark:hover:border-white/20 shadow-xs dark:shadow-none flex flex-col',
          activeStatus === 'published' ? 'border-emerald-500! dark:border-emerald-500! bg-emerald-50/60! dark:bg-emerald-500/10! shadow-md shadow-emerald-500/15!' : ''
        ]"
        title="تصفية حسب المنشور"
        @click="handleStatusClick('published')"
      >
        <div class="kpi-h-title flex items-center justify-between text-[11px] font-bold text-gray-500 dark:text-zinc-400 mb-0.5">
          <span>منشور</span>
          <span class="text-xs text-emerald-500">●</span>
        </div>
        <div class="kpi-h-value font-mono font-black text-xl text-emerald-600 dark:text-emerald-400 leading-tight my-0.5">
          {{ publishedCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar flex h-[3px] w-full rounded-full overflow-hidden my-1 bg-gray-200 dark:bg-white/10">
          <div
            class="h-full bg-emerald-500 transition-all duration-500"
            :style="{ width: `${getPercentage(publishedCount)}%` }"
          />
        </div>
        <div class="text-[10px] text-gray-400 dark:text-zinc-500 font-bold">
          {{ getPercentage(publishedCount) }}%
        </div>
      </div>

      <!-- Card 3: محكّم / معتمد -->
      <div
        data-status="scholarly"
        :class="[
          'kpi-h-card bg-white dark:bg-white/[0.025] border border-gray-200 dark:border-white/10 rounded-xl py-2 px-3.5 min-w-[125px] cursor-pointer select-none transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 dark:hover:bg-white/[0.05] hover:border-gray-300 dark:hover:border-white/20 shadow-xs dark:shadow-none flex flex-col',
          activeStatus === 'scholarly' ? 'border-blue-500! dark:border-blue-500! bg-blue-50/60! dark:bg-blue-500/10! shadow-md shadow-blue-500/15!' : ''
        ]"
        title="تصفية حسب المعتمد علمياً"
        @click="handleStatusClick('scholarly')"
      >
        <div class="kpi-h-title flex items-center justify-between text-[11px] font-bold text-gray-500 dark:text-zinc-400 mb-0.5">
          <span>محكّم</span>
          <span class="text-xs text-blue-500">🏛️</span>
        </div>
        <div class="kpi-h-value font-mono font-black text-xl text-blue-600 dark:text-blue-400 leading-tight my-0.5">
          {{ scholarlyCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar flex h-[3px] w-full rounded-full overflow-hidden my-1 bg-gray-200 dark:bg-white/10">
          <div
            class="h-full bg-blue-500 transition-all duration-500"
            :style="{ width: `${getPercentage(scholarlyCount)}%` }"
          />
        </div>
        <div class="text-[10px] text-gray-400 dark:text-zinc-500 font-bold">
          {{ getPercentage(scholarlyCount) }}%
        </div>
      </div>

      <!-- Card 4: مسودات / استوديو -->
      <div
        data-status="draft"
        :class="[
          'kpi-h-card bg-white dark:bg-white/[0.025] border border-gray-200 dark:border-white/10 rounded-xl py-2 px-3.5 min-w-[125px] cursor-pointer select-none transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 dark:hover:bg-white/[0.05] hover:border-gray-300 dark:hover:border-white/20 shadow-xs dark:shadow-none flex flex-col',
          activeStatus === 'draft' ? 'border-amber-500! dark:border-amber-500! bg-amber-50/60! dark:bg-amber-500/10! shadow-md shadow-amber-500/15!' : ''
        ]"
        title="تصفية حسب مسودات الاستوديو"
        @click="handleStatusClick('draft')"
      >
        <div class="kpi-h-title flex items-center justify-between text-[11px] font-bold text-gray-500 dark:text-zinc-400 mb-0.5">
          <span>مسودات</span>
          <span class="text-xs text-amber-500">✍️</span>
        </div>
        <div class="kpi-h-value font-mono font-black text-xl text-amber-600 dark:text-amber-400 leading-tight my-0.5">
          {{ draftCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar flex h-[3px] w-full rounded-full overflow-hidden my-1 bg-gray-200 dark:bg-white/10">
          <div
            class="h-full bg-amber-500 transition-all duration-500"
            :style="{ width: `${getPercentage(draftCount)}%` }"
          />
        </div>
        <div class="text-[10px] text-gray-400 dark:text-zinc-500 font-bold">
          {{ getPercentage(draftCount) }}%
        </div>
      </div>

    </div>

    <!-- دِف اليسار: شبكة أزرار العمليات التنفيذية 2 × 2 -->
    <div class="banner-actions-col grid grid-cols-2 gap-2 items-center shrink-0">

      <!-- 1. إضافة كيان جديد (Primary) -->
      <a
        v-if="createUrl"
        :href="createUrl"
        id="btnBannerCreate"
        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white shadow-md shadow-indigo-500/30 hover:shadow-indigo-500/45 border border-white/15 transition-all hover:-translate-y-0.5 cursor-pointer"
        :title="`إضافة ${entityName} جديد (+)`"
        :aria-label="`إضافة ${entityName}`"
      >
        <svg
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <line
            x1="12"
            y1="5"
            x2="12"
            y2="19"
          />
          <line
            x1="5"
            y1="12"
            x2="19"
            y2="12"
          />
        </svg>
      </a>
      <button
        v-else
        type="button"
        id="btnBannerCreate"
        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white shadow-md shadow-indigo-500/30 hover:shadow-indigo-500/45 border border-white/15 transition-all hover:-translate-y-0.5 cursor-pointer"
        :title="`إضافة ${entityName} جديد (+)`"
        :aria-label="`إضافة ${entityName}`"
        @click="emit('create')"
      >
        <svg
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <line
            x1="12"
            y1="5"
            x2="12"
            y2="19"
          />
          <line
            x1="5"
            y1="12"
            x2="19"
            y2="12"
          />
        </svg>
      </button>

      <!-- 2. تصدير الفهرس -->
      <button
        type="button"
        id="btnBannerExport"
        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-white/[0.035] hover:bg-gray-100 dark:hover:bg-white/[0.08] text-gray-700 dark:text-zinc-200 border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 transition-all hover:-translate-y-0.5 cursor-pointer shadow-xs dark:shadow-none"
        title="تصدير الفهرس (CSV/Excel)"
        aria-label="تصدير"
        @click="emit('export')"
      >
        <svg
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="text-indigo-600 dark:text-indigo-400"
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
      </button>

      <!-- 3. استيراد جماعي -->
      <button
        type="button"
        id="btnBannerImport"
        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-white/[0.035] hover:bg-gray-100 dark:hover:bg-white/[0.08] text-gray-700 dark:text-zinc-200 border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 transition-all hover:-translate-y-0.5 cursor-pointer shadow-xs dark:shadow-none"
        title="استيراد جماعي للمصنفات"
        aria-label="استيراد"
        @click="emit('import')"
      >
        <svg
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="text-emerald-600 dark:text-emerald-400"
        >
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="17 8 12 3 7 8" />
          <line
            x1="12"
            y1="3"
            x2="12"
            y2="15"
          />
        </svg>
      </button>

      <!-- 4. تحديث الفهرس -->
      <button
        type="button"
        id="btnBannerRefresh"
        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-white/[0.035] hover:bg-gray-100 dark:hover:bg-white/[0.08] text-gray-700 dark:text-zinc-200 border border-gray-200 dark:border-white/10 hover:border-gray-300 dark:hover:border-white/20 transition-all hover:-translate-y-0.5 cursor-pointer shadow-xs dark:shadow-none"
        title="تحديث الفهرس العام"
        aria-label="تحديث"
        @click="emit('refresh')"
      >
        <svg
          width="18"
          height="18"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="text-amber-500"
        >
          <polyline points="23 4 23 10 17 10" />
          <polyline points="1 20 1 14 7 14" />
          <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
        </svg>
      </button>

    </div>
  </div>
</template>
