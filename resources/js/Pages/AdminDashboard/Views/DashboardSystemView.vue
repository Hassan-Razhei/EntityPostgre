<script setup>
import { computed } from 'vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';
import ActivitiesTimelineView from '@/Components/Timeline/ActivitiesTimelineView.vue';
import {
  usersColumns, sampleUsersRows,
  deletionsColumns, sampleDeletionsRows
} from '@/Config/assetTableConfigs';

const props = defineProps({
  systemType: {
    type: String,
    required: true,
    validator: (val) => ['users', 'deletions', 'activities'].includes(val),
  },
  stats: {
    type: Object,
    default: () => ({}),
  },
  recentUsers: {
    type: Array,
    default: () => [],
  },
  deletions: {
    type: Array,
    default: () => [],
  },
  recentActivities: {
    type: Array,
    default: () => [],
  },
});

const activeUsersRows = computed(() => {
  if (props.recentUsers && props.recentUsers.length > 0) {
    return props.recentUsers;
  }
  return sampleUsersRows;
});

const activeDeletionsRows = computed(() => {
  if (props.deletions && props.deletions.length > 0) {
    return props.deletions;
  }
  return sampleDeletionsRows;
});

const usersKpiStats = computed(() => {
  const total = props.stats?.users || activeUsersRows.value.length;
  return {
    total,
    published: activeUsersRows.value.filter(u => u.role === 'super_admin').length || 2,
    scholarly: activeUsersRows.value.filter(u => u.role === 'editor').length || 8,
    draft: activeUsersRows.value.filter(u => u.role === 'viewer').length || Math.max(0, total - 10),
  };
});

const deletionsKpiStats = computed(() => {
  const total = props.stats?.deletions || activeDeletionsRows.value.length;
  return {
    total,
    published: activeDeletionsRows.value.filter(d => d.type_label?.includes('كتاب')).length || 1,
    scholarly: activeDeletionsRows.value.filter(d => d.type_label?.includes('مخطوط')).length || 1,
    draft: activeDeletionsRows.value.filter(d => !d.type_label?.includes('كتاب') && !d.type_label?.includes('مخطوط')).length || 1,
  };
});
</script>

<template>
  <div class="dashboard-system-view" :data-system-type="systemType">
    <!-- 1. Users Asset Table (النظام -> المستخدمون) -->
    <AssetTableView
      v-if="systemType === 'users'"
      asset-title="المستخدمون"
      asset-type="users"
      initial-view-mode="table"
      :stats="usersKpiStats"
      :columns="usersColumns"
      :rows="activeUsersRows"
      :total="stats?.users || activeUsersRows.length"
    />

    <!-- 2. Deletions Asset Table (النظام -> المهملات) -->
    <AssetTableView
      v-else-if="systemType === 'deletions'"
      asset-title="المهملات"
      asset-type="deletions"
      initial-view-mode="table"
      :stats="deletionsKpiStats"
      :columns="deletionsColumns"
      :rows="activeDeletionsRows"
      :total="stats?.deletions || activeDeletionsRows.length"
    />

    <!-- 3. Activities Timeline (النظام -> النشاطات) -->
    <ActivitiesTimelineView
      v-else-if="systemType === 'activities'"
      :activities="recentActivities"
      :total="stats?.activities || (recentActivities ? recentActivities.length : 0)"
    />
  </div>
</template>

<style scoped>
.dashboard-system-view {
  width: 100%;
  animation: fadeInSystem 0.25s ease-out;
}

@keyframes fadeInSystem {
  from {
    opacity: 0;
    transform: translateY(4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
