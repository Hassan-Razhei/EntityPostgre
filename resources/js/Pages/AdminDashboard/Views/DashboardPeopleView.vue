<script setup>
import { computed } from 'vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';
import {
  authorsColumns, sampleAuthorsRows,
  publishersColumns, samplePublishersRows
} from '@/Config/assetTableConfigs';

const props = defineProps({
  peopleType: {
    type: String,
    required: true,
    validator: (val) => ['authors', 'publishers'].includes(val),
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
  if (props.peopleType === 'publishers') {
    const total = props.stats?.publishers || (props.items?.length || samplePublishersRows.length);
    return {
      title: 'الناشرون',
      assetType: 'publishers',
      columns: publishersColumns,
      defaultRows: samplePublishersRows,
      createUrl: props.createUrl || '/publishers/create',
      stats: {
        total,
        published: Math.round(total * 0.82),
        scholarly: Math.round(total * 0.12),
        draft: Math.max(0, total - Math.round(total * 0.94)),
      },
    };
  }

  // Default: authors
  const total = props.stats?.authors || (props.items?.length || sampleAuthorsRows.length);
  return {
    title: 'المؤلفون',
    assetType: 'authors',
    columns: authorsColumns,
    defaultRows: sampleAuthorsRows,
    createUrl: props.createUrl || '/authors/create',
    stats: {
      total,
      published: Math.round(total * 0.78),
      scholarly: Math.round(total * 0.16),
      draft: Math.max(0, total - Math.round(total * 0.94)),
    },
  };
});

const activeRows = computed(() => {
  if (props.items && props.items.length > 0) {
    return props.items;
  }
  return currentConfig.value.defaultRows;
});

const totalCount = computed(() => {
  return props.stats?.[props.peopleType] || activeRows.value.length;
});
</script>

<template>
  <div class="dashboard-people-view" :data-people-type="peopleType">
    <!-- Preserving Table View Mode strictly as requested by user -->
    <AssetTableView
      :asset-title="currentConfig.title"
      :asset-type="currentConfig.assetType"
      initial-view-mode="table"
      :stats="currentConfig.stats"
      :columns="currentConfig.columns"
      :rows="activeRows"
      :total="totalCount"
      :create-url="currentConfig.createUrl"
    />
  </div>
</template>

<style scoped>
.dashboard-people-view {
  width: 100%;
  animation: fadeInPeople 0.25s ease-out;
}

@keyframes fadeInPeople {
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
