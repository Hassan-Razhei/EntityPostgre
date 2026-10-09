<script setup>
import { computed } from 'vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';
import {
  booksColumns, sampleBooksRows,
  manuscriptsColumns, sampleManuscriptsRows,
  audiosColumns, sampleAudiosRows,
  videosColumns, sampleVideosRows
} from '@/Config/assetTableConfigs';

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
  createUrl: {
    type: String,
    default: '',
  },
});

const currentConfig = computed(() => {
  switch (props.libraryType) {
    case 'manuscripts':
      return {
        title: 'المخطوطات',
        assetType: 'manuscripts',
        columns: manuscriptsColumns,
        defaultRows: sampleManuscriptsRows,
        createUrl: props.createUrl || '/manuscripts/create',
        stats: {
          total: props.stats?.manuscripts || (props.items?.length || 48920),
          published: 32450,
          scholarly: 11200,
          draft: 5270,
        },
      };
    case 'audios':
      return {
        title: 'الصوتيات',
        assetType: 'audios',
        columns: audiosColumns,
        defaultRows: sampleAudiosRows,
        createUrl: props.createUrl || '/audios/create',
        stats: {
          total: props.stats?.audios || (props.items?.length || 14680),
          published: 11820,
          scholarly: 2140,
          draft: 720,
        },
      };
    case 'videos':
      return {
        title: 'المرئيات',
        assetType: 'videos',
        columns: videosColumns,
        defaultRows: sampleVideosRows,
        createUrl: props.createUrl || '/videos/create',
        stats: {
          total: props.stats?.videos || (props.items?.length || 8420),
          published: 6150,
          scholarly: 1820,
          draft: 450,
        },
      };
    case 'books':
    default:
      return {
        title: 'الكتب',
        assetType: 'books',
        columns: booksColumns,
        defaultRows: sampleBooksRows,
        createUrl: props.createUrl || '/books/create',
        stats: {
          total: props.stats?.books || (props.items?.length || 248510),
          published: 184200,
          scholarly: 42150,
          draft: 18630,
        },
      };
  }
});

const activeRows = computed(() => {
  if (props.items && props.items.length > 0) {
    return props.items;
  }
  return currentConfig.value.defaultRows;
});

const totalCount = computed(() => {
  return props.stats?.[props.libraryType] || activeRows.value.length;
});
</script>

<template>
  <div class="dashboard-library-view" :data-library-type="libraryType">
    <AssetTableView
      :asset-title="currentConfig.title"
      :asset-type="currentConfig.assetType"
      :stats="currentConfig.stats"
      :columns="currentConfig.columns"
      :rows="activeRows"
      :total="totalCount"
      :create-url="currentConfig.createUrl"
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
