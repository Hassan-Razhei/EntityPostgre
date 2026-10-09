<template>
  <div class="admin-dashboard-container">
  <!-- ============================================================
       1. FIXED RIGHT SIDEBAR (AdminDashboardSidebar - Option B)
       ============================================================ -->
  <AdminDashboardSidebar
    :stats="props.stats"
    :current-view-key="currentViewKey"
    @load-view="loadView"
  />

  <!-- ============================================================
       2. TOP FIXED NAVBAR (AdminDashboardNavbar - Option B)
       ============================================================ -->
  <AdminDashboardNavbar
    :current-group-title="currentGroupTitle"
    :current-view-title="currentViewTitle"
    @load-view="loadView"
  />


  <!-- ============================================================
       3. DYNAMIC CONTENT CONTAINER (SPA Router Driven)
       ============================================================ -->
  <main class="app-main" id="appMain">
    <div id="dynamicContentArea">
      <!-- 1. Library Sector: Books, Manuscripts, Audios, Videos (Cycle 26 Modular Decoupling) -->
      <DashboardLibraryView
        v-if="['books', 'manuscripts', 'audios', 'videos'].includes(currentViewKey)"
        :library-type="currentViewKey"
        :items="getLibraryItems(currentViewKey)"
        :stats="props.stats"
        :create-url="`/${currentViewKey}/create`"
      />
      <!-- 2. People Sector: Authors & Publishers (Cycle 26 Modular Decoupling - Tables Preserved) -->
      <DashboardPeopleView
        v-else-if="['authors', 'publishers'].includes(currentViewKey)"
        :people-type="currentViewKey"
        :items="getPeopleItems(currentViewKey)"
        :stats="props.stats"
        :create-url="`/${currentViewKey}/create`"
      />
      <!-- 3. System Sector: Users, Deletions, Activities (Cycle 29 System Sector Decoupling) -->
      <DashboardSystemView
        v-else-if="['users', 'deletions', 'activities'].includes(currentViewKey)"
        :system-type="currentViewKey"
        :stats="props.stats"
        :recent-users="props.recentUsers"
        :deletions="props.deletions"
        :recent-activities="props.recentActivities"
      />
      <!-- 10. Central Stats Overview -->
      <DashboardStatsView
        v-else-if="currentViewKey === 'stats'"
        :stats="props.stats"
        @navigate="loadView"
      />
      <!-- 11. System Commands Console -->
      <DashboardCommandsView
        v-else-if="currentViewKey === 'commands'"
      />
      <!-- 12. System Operations & Maintenance -->
      <DashboardOpsView
        v-else-if="currentViewKey === 'ops'"
        @navigate="loadView"
      />
      <!-- 13. Studio Sub-views -->
      <DashboardStudioView
        v-else-if="['studio-books', 'studio-manuscripts', 'studio-audios', 'studio-videos', 'versions'].includes(currentViewKey)"
        :studio-type="currentViewKey"
        :items="getStudioItems(currentViewKey)"
        :versions="props.versions || []"
      />
      <!-- 14. Cognitive Taxonomy & Knowledge Organization -->
      <DashboardTaxonomyView
        v-else-if="['collections', 'series', 'topics', 'tags', 'categories'].includes(currentViewKey)"
        :taxonomy-type="currentViewKey"
        :items="getTaxonomyItems(currentViewKey)"
      />
      <!-- 15. Dynamic Fallback Viewport for legacy/custom HTML -->
      <div v-else-if="currentViewHtml" v-html="currentViewHtml" />
    </div>

    <!-- Entity Brand Footer (as in Dashboard.vue / AuthenticatedLayout) -->
    <footer class="app-footer">
      <p>&copy; 2026 Entity App. جميع الحقوق محفوظة.</p>
      <div class="footer-links">
        <a href="javascript:void(0)" onclick="alert('الدعم الفني متاح عبر البريد: support@entity.local')">الدعم الفني</a>
        <a href="javascript:void(0)" onclick="alert('سياسة الخصوصية الخاصة بتطبيق Entity')">سياسة الخصوصية</a>
      </div>
    </footer>
  </main>
  </div>
</template>

<script setup>
import DashboardStatsView from './Views/DashboardStatsView.vue';
import DashboardCommandsView from './Views/DashboardCommandsView.vue';
import DashboardOpsView from './Views/DashboardOpsView.vue';
import DashboardStudioView from './Views/DashboardStudioView.vue';
import DashboardTaxonomyView from './Views/DashboardTaxonomyView.vue';
import DashboardLibraryView from './Views/DashboardLibraryView.vue';
import DashboardPeopleView from './Views/DashboardPeopleView.vue';
import DashboardSystemView from './Views/DashboardSystemView.vue';
import AdminDashboardSidebar from './AdminDashboardSidebar.vue';
import AdminDashboardNavbar from './AdminDashboardNavbar.vue';
import { useAdminCockpit } from './useAdminCockpit';

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      books: 0,
      manuscripts: 0,
      audios: 0,
      videos: 0,
      authors: 0,
      publishers: 0,
      categories: 0,
      tags: 0,
      users: 0,
      deletions: 0,
      versions: 0,
      activities: 0,
      studio_books: 0,
      studio_manuscripts: 0,
      studio_audios: 0,
      studio_videos: 0,
      collections: 0,
      series: 0,
      topics: 0,
      funnel_drafts: 0,
      funnel_reviewed: 0,
      funnel_scholarly: 0,
      funnel_published: 0,
    })
  },
  recentActivities: {
    type: Array,
    default: () => []
  },
  recentUsers: {
    type: Array,
    default: () => []
  },
  books: {
    type: Array,
    default: () => []
  },
  manuscripts: {
    type: Array,
    default: () => []
  },
  audios: {
    type: Array,
    default: () => []
  },
  videos: {
    type: Array,
    default: () => []
  },
  authors: {
    type: Array,
    default: () => []
  },
  publishers: {
    type: Array,
    default: () => []
  },
  deletions: {
    type: Array,
    default: () => []
  },
  categories: {
    type: Array,
    default: () => []
  },
  tags: {
    type: Array,
    default: () => []
  },
  versions: {
    type: Array,
    default: () => []
  },
  studioBooks: {
    type: Array,
    default: () => []
  },
  collections: {
    type: Array,
    default: () => []
  },
  series: {
    type: Array,
    default: () => []
  },
  topics: {
    type: Array,
    default: () => []
  }
});

const {
  currentViewKey,
  currentViewHtml,
  currentGroupTitle,
  currentViewTitle,
  getLibraryItems,
  getPeopleItems,
  getStudioItems,
  getTaxonomyItems,
  loadView,
} = useAdminCockpit(props);
</script>

<style>
:root {
  --bg-base: #09090b;
  --bg-surface: #121215;
  --bg-sidebar: #0d0d10;
  --bg-navbar: rgba(13, 13, 16, 0.85);
  --bg-card: rgba(22, 22, 27, 0.7);
  --border-subtle: rgba(255, 255, 255, 0.08);
  --border-accent: rgba(239, 68, 68, 0.3);
  --crimson: #ef4444;
  --crimson-glow: rgba(239, 68, 68, 0.2);
  --emerald: #10b981;
  --indigo: #6366f1;
  --amber: #f59e0b;
  --cyan: #06b6d4;
  --purple: #a855f7;
  --text-main: #f4f4f5;
  --text-muted: #a1a1aa;
  --text-dim: #71717a;
  --sidebar-width: 270px;
  --navbar-height: 64px;
}

body.light-mode {
  --bg-base: #f8fafc;
  --bg-surface: #ffffff;
  --bg-sidebar: #ffffff;
  --bg-navbar: rgba(255, 255, 255, 0.92);
  --bg-card: #ffffff;
  --border-subtle: rgba(0, 0, 0, 0.08);
  --border-accent: rgba(239, 68, 68, 0.3);
  --crimson: #ef4444;
  --crimson-glow: rgba(239, 68, 68, 0.15);
  --emerald: #10b981;
  --indigo: #6366f1;
  --amber: #f59e0b;
  --cyan: #06b6d4;
  --purple: #a855f7;
  --text-main: #0f172a;
  --text-muted: #475569;
  --text-dim: #64748b;
  background-color: var(--bg-base);
  color: var(--text-main);
  background-image:
    radial-gradient(circle at 10% 20%, rgba(239, 68, 68, 0.02) 0%, transparent 40%),
    radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.02) 0%, transparent 40%);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Cairo', sans-serif;
  -webkit-font-smoothing: antialiased;
}

body {
  background-color: var(--bg-base);
  color: var(--text-main);
  min-height: 100vh;
  overflow-x: hidden;
  line-height: 1.6;
  background-image:
    radial-gradient(circle at 10% 20%, rgba(239, 68, 68, 0.04) 0%, transparent 40%),
    radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.04) 0%, transparent 40%);
}

/* Scrollbar */
::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--bg-base); }
::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }

body.light-mode ::-webkit-scrollbar-track {
  background: #f1f5f9;
}

body.light-mode ::-webkit-scrollbar-thumb {
  background: #cbd5e1;
}

/* Dashboard Shell Layout */
.admin-dashboard-container {
  min-height: 100vh;
  position: relative;
  background-color: var(--bg-base);
}

.app-main {
  margin-right: var(--sidebar-width);
  padding-top: calc(var(--navbar-height) + 1.5rem);
  padding-left: 2rem;
  padding-right: 2rem;
  padding-bottom: 4rem;
  min-height: 100vh;
  transition: margin-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.app-footer {
  margin-top: 3.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--border-subtle);
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.75rem;
  color: var(--text-dim);
  font-weight: 500;
  flex-wrap: wrap;
  gap: 1rem;
}

.footer-links {
  display: flex;
  gap: 1.5rem;
}

.footer-links a {
  color: var(--text-dim);
  text-decoration: none;
  transition: color 0.2s;
}

.footer-links a:hover {
  color: var(--indigo);
}
</style>
