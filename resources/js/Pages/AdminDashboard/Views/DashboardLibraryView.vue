<script setup>
import { ref, computed, watch } from 'vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';
import {
  booksColumns, sampleBooksRows,
  manuscriptsColumns, sampleManuscriptsRows,
  audiosColumns, sampleAudiosRows,
  videosColumns, sampleVideosRows
} from '@/Config/assetTableConfigs';
import { rowsOf, metaOf } from '@/Composables/useAdminCockpit';

const props = defineProps({
  libraryType: {
    type: String,
    required: true,
    validator: (val) => ['books', 'manuscripts', 'audios', 'videos'].includes(val),
  },
  items: {
    type: Array,
    default: () => [],
  },
  stats: {
    type: Object,
    default: () => ({}),
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
  createUrl: {
    type: String,
    default: '',
  },
  // ─── التصنيفات الحقيقية (جدول categories + pivot categorizables) ──
  // 10 تصنيفات، 400 ارتباط حقيقي. تُغذّي قائمة "التصنيف" في الشريط.
  categories: {
    type: Array,
    default: () => [],
  },
});

// statusCounts = stats نفسها (المفاتيح: books_draft, books_transcribed, ...)
// الباك إند يُصدّرها في stats مباشرة — لا حاجة لإعادة بناء.
const statusCounts = computed(() => props.stats || {});

const currentConfig = computed(() => {
  switch (props.libraryType) {
    case 'manuscripts':
      return {
        title: 'المخطوطات',
        assetType: 'manuscripts',
        columns: manuscriptsColumns,
        defaultRows: sampleManuscriptsRows,
        createUrl: props.createUrl || '/manuscripts/create',
      };
    case 'audios':
      return {
        title: 'الصوتيات',
        assetType: 'audios',
        columns: audiosColumns,
        defaultRows: sampleAudiosRows,
        createUrl: props.createUrl || '/audios/create',
      };
    case 'videos':
      return {
        title: 'المرئيات',
        assetType: 'videos',
        columns: videosColumns,
        defaultRows: sampleVideosRows,
        createUrl: props.createUrl || '/videos/create',
      };
    case 'books':
    default:
      return {
        title: 'الكتب',
        assetType: 'books',
        columns: booksColumns,
        defaultRows: sampleBooksRows,
        createUrl: props.createUrl || '/books/create',
      };
  }
});

// حالة محلية للصفحات المُجلوبة من الخادم (ترقيم من جهة الخادم)
// عندما ينقر المستخدم صفحة، AssetTableView يطلبها ويُرسل page-fetched،
// فنخزّنها هنا ونُمرّرها لـ AssetTableView بدلاً من props.items الأصلية.
const fetchedPage = ref(null);

const handlePageFetched = ({ data, meta }) => {
    fetchedPage.value = { data, meta };
};

const activeRows = computed(() => {
    // الصفحة المُجلوبة حديثاً لها الأولوية
    if (fetchedPage.value) return fetchedPage.value.data;

    const rows = rowsOf(props.items);
    // إن لم يُمرّر الأب بيانات (أو مرّر مصفوفة فارغة)، نستخدم الصفوف النموذجية
    // حتى لا تظهر الشاشة فارغة (سلوك ما قبل الترقيم من الخادم).
    if (rows.length === 0) {
        return currentConfig.value.defaultRows || [];
    }
    return rows;
});

// meta من الخادم: الصفحة المُجلوبة أولاً، ثم props.items الأصلية
const activeMeta = computed(() => {
    if (fetchedPage.value?.meta) return fetchedPage.value.meta;
    const raw = props.items;
    if (raw && !Array.isArray(raw) && raw.meta) return raw.meta;
    return null;
});

// إعادة ضبط عند تبديل نوع المكتبة (props.libraryType)
watch(
    () => props.libraryType,
    () => { fetchedPage.value = null; }
);

const totalCount = computed(() => {
    return activeMeta.value?.total || activeRows.value.length;
});
</script>

<template>
  <div class="dashboard-library-view" :data-library-type="libraryType">
    <AssetTableView
      :asset-title="currentConfig.title"
      :asset-type="currentConfig.assetType"
      :stats="stats"
      :columns="currentConfig.columns"
      :rows="activeRows"
      :total="totalCount"
      :pagination-meta="activeMeta"
      :create-url="currentConfig.createUrl"
      :status-meta="statusMeta"
      :asset-statuses="assetStatuses"
      :status-counts="statusCounts"
      :filter-options="categories"
      @page-fetched="handlePageFetched"
    />
  </div>
</template>

<style scoped>
.dashboard-library-view {
  width: 100%;
  animation: fadeInLibrary 0.25s ease-out;
}

@keyframes fadeInLibrary {
  from {
    opacity: 0;
    transform: translateY(6px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
