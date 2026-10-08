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
  <!-- HORIZONTAL SPLIT BANNER (Cycle 9 Fidelity) -->
  <div class="horizontal-header-banner">
    <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع -->
    <div class="banner-kpi-col">
      <!-- Card 1: الكل -->
      <div
        data-status="all"
        class="kpi-h-card"
        :class="{ active: activeStatus === 'all' || !activeStatus }"
        title="عرض كامل الأرشيف"
        @click="handleStatusClick('all')"
      >
        <div class="kpi-h-title">
          <span>الكل</span>
          <span style="font-size: 0.75rem;">📚</span>
        </div>
        <div class="kpi-h-value">
          {{ totalCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div style="width: 100%; background: #6366f1;" />
        </div>
        <div class="kpi-h-subtext">
          <span>الأرشيف</span>
          <span>100%</span>
        </div>
      </div>

      <!-- Card 2: منشور -->
      <div
        data-status="published"
        class="kpi-h-card"
        :class="{ active: activeStatus === 'published' }"
        title="عرض الكتب المنشورة"
        @click="handleStatusClick('published')"
      >
        <div class="kpi-h-title">
          <span>منشور</span>
          <span style="font-size: 0.75rem;">🌐</span>
        </div>
        <div class="kpi-h-value val-published">
          {{ publishedCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div :style="{ width: `${getPercentage(publishedCount)}%`, background: '#10b981' }" />
        </div>
        <div class="kpi-h-subtext">
          <span>متاح</span>
          <span>{{ getPercentage(publishedCount) }}%</span>
        </div>
      </div>

      <!-- Card 3: محكّم -->
      <div
        data-status="scholarly"
        class="kpi-h-card"
        :class="{ active: activeStatus === 'scholarly' }"
        title="عرض الكتب المحكّمة"
        @click="handleStatusClick('scholarly')"
      >
        <div class="kpi-h-title">
          <span>محكّم</span>
          <span style="font-size: 0.75rem;">🎓</span>
        </div>
        <div class="kpi-h-value val-scholarly">
          {{ scholarlyCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div :style="{ width: `${getPercentage(scholarlyCount)}%`, background: '#3b82f6' }" />
        </div>
        <div class="kpi-h-subtext">
          <span>معتمد</span>
          <span>{{ getPercentage(scholarlyCount) }}%</span>
        </div>
      </div>

      <!-- Card 4: مسودات -->
      <div
        data-status="draft"
        class="kpi-h-card"
        :class="{ active: activeStatus === 'draft' }"
        title="عرض المسودات"
        @click="handleStatusClick('draft')"
      >
        <div class="kpi-h-title">
          <span>مسودات</span>
          <span style="font-size: 0.75rem;">✍️</span>
        </div>
        <div class="kpi-h-value val-draft">
          {{ draftCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div :style="{ width: `${getPercentage(draftCount)}%`, background: '#f59e0b' }" />
        </div>
        <div class="kpi-h-subtext">
          <span>الاستوديو</span>
          <span>{{ getPercentage(draftCount) }}%</span>
        </div>
      </div>
    </div>

    <!-- دِف اليسار: أزرار الإجراءات التنفيذية (2 × 2 متناسقة تماماً مع ارتفاع البطاقات) -->
    <div class="banner-actions-col">
      <!-- 1. إضافة كتاب (Primary) -->
      <a
        v-if="createUrl"
        :href="createUrl"
        id="btnBannerCreate"
        class="btn-grid-item btn-grid-primary"
        :title="`إضافة ${entityName} جديد (+)`"
        :aria-label="`إضافة ${entityName}`"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19" />
          <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
      </a>
      <button
        v-else
        type="button"
        id="btnBannerCreate"
        class="btn-grid-item btn-grid-primary"
        :title="`إضافة ${entityName} جديد (+)`"
        :aria-label="`إضافة ${entityName}`"
        @click="emit('create')"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19" />
          <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
      </button>

      <!-- 2. تصدير الفهرس -->
      <button
        type="button"
        id="btnBannerExport"
        class="btn-grid-item btn-grid-secondary"
        title="تصدير الفهرس (CSV/Excel)"
        aria-label="تصدير"
        @click="emit('export')"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-export">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="7 10 12 15 17 10" />
          <line x1="12" y1="15" x2="12" y2="3" />
        </svg>
      </button>

      <!-- 3. استيراد جماعي -->
      <button
        type="button"
        id="btnBannerImport"
        class="btn-grid-item btn-grid-secondary"
        title="استيراد ملفات مصنفات"
        aria-label="استيراد"
        @click="emit('import')"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-import">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="17 8 12 3 7 8" />
          <line x1="12" y1="3" x2="12" y2="15" />
        </svg>
      </button>

      <!-- 4. تحديث الفهرس -->
      <button
        type="button"
        id="btnBannerRefresh"
        class="btn-grid-item btn-grid-secondary"
        title="تحديث الفهرس العام"
        aria-label="تحديث"
        @click="emit('refresh')"
      >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
          <polyline points="23 4 23 10 17 10" />
          <polyline points="1 20 1 14 7 14" />
          <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15" />
        </svg>
      </button>
    </div>
  </div>
</template>
