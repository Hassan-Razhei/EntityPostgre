<script setup>
import { computed } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({}),
    },
    activeStatus: {
        type: String,
        default: 'all',
    },
    entityName: {
        type: String,
        default: 'الكتب',
    },
    assetType: {
        type: String,
        default: 'books',
    },
    createUrl: {
        type: String,
        default: '',
    },
    // ─── العقد مع الباك إند (المصدر الوحيد للحقيقة) ─────────────
    statusMeta: {
        type: Object,
        default: () => ({}),
    },
    assetStatuses: {
        type: Object,
        default: () => ({}),
    },
    statusCounts: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['filter-status', 'create', 'export', 'import', 'refresh']);

const isNonLifecycle = computed(() => {
    const statuses = props.assetStatuses?.[props.assetType];
    return !statuses || statuses.length === 0;
});

const statusCards = computed(() => {
    if (isNonLifecycle.value) return [];
    const statuses = props.assetStatuses[props.assetType] || [];
    return statuses
        .map(status => {
            const meta = props.statusMeta?.[status] || {};
            const count = Number(props.statusCounts?.[`${props.assetType}_${status}`] ?? 0);
            return {
                status,
                title: meta.label || status,
                color: meta.color || '#6366f1',
                weight: meta.weight ?? 0,
                count,
            };
        })
        .sort((a, b) => a.weight - b.weight);
});

const totalCount = computed(() => {
    if (isNonLifecycle.value) {
        return Number(props.stats?.total ?? 0);
    }
    return statusCards.value.reduce((sum, c) => sum + c.count, 0);
});

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
    <!-- دِف اليمين: بطاقات KPI تُبنى من العقد مع الباك إند (v-for) -->
    <div class="banner-kpi-col">
      <!-- بطاقة "الكل" — تُصفّي على الكل -->
      <div
        data-status="all"
        class="kpi-h-card"
        :class="{ active: activeStatus === 'all' || !activeStatus }"
        :title="`عرض كل ${entityName}`"
        @click="handleStatusClick('all')"
      >
        <div class="kpi-h-title">
          <span>الكل</span>
          <span style="font-size: 0.75rem;">📊</span>
        </div>
        <div class="kpi-h-value">
          {{ totalCount.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div style="width: 100%; background: #6366f1;" />
        </div>
        <div class="kpi-h-subtext">
          <span>{{ entityName }}</span>
          <span>100%</span>
        </div>
      </div>

      <!-- بطاقات الحالات — خط أنابيب بترتيب weight -->
      <div
        v-for="card in statusCards"
        :key="card.status"
        :data-status="card.status"
        class="kpi-h-card"
        :class="{ active: activeStatus === card.status }"
        :title="`عرض ${card.title}`"
        @click="handleStatusClick(card.status)"
      >
        <div class="kpi-h-title">
          <span>{{ card.title }}</span>
        </div>
        <div class="kpi-h-value" :style="{ color: card.color }">
          {{ card.count.toLocaleString() }}
        </div>
        <div class="kpi-h-bar">
          <div :style="{ width: `${getPercentage(card.count)}%`, background: card.color }" />
        </div>
        <div class="kpi-h-subtext">
          <span>{{ getPercentage(card.count) }}%</span>
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

<style>
/* ========================================================
   HORIZONTAL SPLIT BANNER (CARDS ON RIGHT, BUTTONS ON LEFT)
   ======================================================== */
.horizontal-header-banner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1.25rem;
  background: transparent;
  border: none;
  box-shadow: none;
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
  padding: 0;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
}
body.light-mode .horizontal-header-banner {
  background: transparent;
  border: none;
  box-shadow: none;
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
}

/* Right Div: KPI Cards */
.banner-kpi-col {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.banner-page-badge {
  font-size: 1.3rem;
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  padding-left: 0.85rem;
  border-left: 2px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  white-space: nowrap;
  margin: 0;
}

.kpi-h-card {
  background: rgba(255, 255, 255, 0.025);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 0.85rem;
  padding: 0.65rem 0.95rem;
  min-width: 125px;
  cursor: pointer;
  user-select: none;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  flex-direction: column;
}
body.light-mode .kpi-h-card {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.kpi-h-card:hover {
  border-color: rgba(255, 255, 255, 0.25);
  transform: translateY(-2px);
  background: rgba(255, 255, 255, 0.05);
}
body.light-mode .kpi-h-card:hover {
  background: #ffffff;
  border-color: rgba(99, 102, 241, 0.4);
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}

.kpi-h-card.active {
  border-color: var(--indigo, #6366f1);
  background: rgba(99, 102, 241, 0.1);
  box-shadow: 0 0 14px rgba(99, 102, 241, 0.22);
}
body.light-mode .kpi-h-card.active {
  background: rgba(99, 102, 241, 0.06);
  border-color: var(--indigo, #6366f1);
  box-shadow: 0 0 12px rgba(99, 102, 241, 0.15);
}

.kpi-h-title {
  font-size: 0.68rem;
  color: var(--text-muted, #a1a1aa);
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.kpi-h-card.active .kpi-h-title {
  color: var(--indigo, #6366f1);
}

.kpi-h-value {
  font-size: 1.35rem;
  font-weight: 900;
  font-family: 'Outfit', sans-serif;
  margin: 0.25rem 0;
  line-height: 1.1;
  color: var(--text-main, #f4f4f5);
}

.kpi-h-bar {
  display: flex;
  height: 3px;
  width: 100%;
  border-radius: 9999px;
  overflow: hidden;
  margin-bottom: 0.3rem;
  background: rgba(255, 255, 255, 0.06);
}
body.light-mode .kpi-h-bar {
  background: rgba(0, 0, 0, 0.06);
}

.kpi-h-subtext {
  display: flex;
  justify-content: space-between;
  font-size: 0.62rem;
  font-weight: 700;
  color: var(--text-dim, #71717a);
}

/* Left Div: 2x2 Buttons Grid */
.banner-actions-col {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0.5rem;
  align-items: center;
  flex-shrink: 0;
}

.btn-grid-item {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 10px;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  box-sizing: border-box;
  flex-shrink: 0;
}

.btn-grid-primary {
  background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
}
.btn-grid-primary:hover {
  background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 14px rgba(99, 102, 241, 0.45);
}

.btn-grid-secondary {
  background: rgba(255, 255, 255, 0.035);
  color: var(--text-main, #f4f4f5);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  backdrop-filter: blur(10px);
}
body.light-mode .btn-grid-secondary {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.12);
  color: #0f172a;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}
.btn-grid-secondary:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-1px);
}
body.light-mode .btn-grid-secondary:hover {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.22);
}

/* Adaptive colors for dark & light mode */
.val-published { color: #34d399; }
body.light-mode .val-published { color: #059669; }

.val-scholarly { color: #60a5fa; }
body.light-mode .val-scholarly { color: #2563eb; }

.val-draft { color: #fbbf24; }
body.light-mode .val-draft { color: #d97706; }

/* Button Icon Colors in Light Mode */
.icon-export { color: #60a5fa; }
body.light-mode .icon-export { color: #2563eb; }

.icon-import { color: #34d399; }
body.light-mode .icon-import { color: #059669; }

.icon-refresh { color: #fbbf24; }
body.light-mode .icon-refresh { color: #d97706; }
</style>
