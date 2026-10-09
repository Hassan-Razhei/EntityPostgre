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
      <!-- 7. Users Asset Table (النظام -> المستخدمون) -->
      <AssetTableView
        v-else-if="currentViewKey === 'users'"
        asset-title="المستخدمون"
        asset-type="users"
        initial-view-mode="table"
        :stats="usersKpiStats"
        :columns="usersColumns"
        :rows="activeUsersRows"
        :total="props.stats?.users || activeUsersRows.length"
      />
      <!-- 8. Deletions Asset Table (النظام -> المهملات) -->
      <AssetTableView
        v-else-if="currentViewKey === 'deletions'"
        asset-title="المهملات"
        asset-type="deletions"
        initial-view-mode="table"
        :stats="deletionsKpiStats"
        :columns="deletionsColumns"
        :rows="activeDeletionsRows"
        :total="props.stats?.deletions || activeDeletionsRows.length"
      />
      <!-- 9. Activities Timeline (النظام -> النشاطات) -->
      <ActivitiesTimelineView
        v-else-if="currentViewKey === 'activities'"
        :activities="props.recentActivities"
        :total="props.stats?.activities || (props.recentActivities ? props.recentActivities.length : 0)"
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
import { ref, computed, onMounted, onUnmounted } from 'vue';
import AssetTableView from '@/Components/Table/AssetTableView.vue';
import ActivitiesTimelineView from '@/Components/Timeline/ActivitiesTimelineView.vue';
import DashboardStatsView from './AdminDashboard/Views/DashboardStatsView.vue';
import DashboardCommandsView from './AdminDashboard/Views/DashboardCommandsView.vue';
import DashboardOpsView from './AdminDashboard/Views/DashboardOpsView.vue';
import DashboardStudioView from './AdminDashboard/Views/DashboardStudioView.vue';
import DashboardTaxonomyView from './AdminDashboard/Views/DashboardTaxonomyView.vue';
import DashboardLibraryView from './AdminDashboard/Views/DashboardLibraryView.vue';
import DashboardPeopleView from './AdminDashboard/Views/DashboardPeopleView.vue';
import AdminDashboardSidebar from './AdminDashboard/AdminDashboardSidebar.vue';
import AdminDashboardNavbar from './AdminDashboard/AdminDashboardNavbar.vue';
import {
  usersColumns, sampleUsersRows,
  deletionsColumns, sampleDeletionsRows
} from '@/Config/assetTableConfigs';
import axios from 'axios';

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

const currentViewKey = ref(typeof window !== 'undefined' && (window.location.hash || "").replace("#", "") || "stats");
const currentViewHtml = ref('');

const getLibraryItems = (key) => {
  switch (key) {
    case 'books': return props.books || [];
    case 'manuscripts': return props.manuscripts || [];
    case 'audios': return props.audios || [];
    case 'videos': return props.videos || [];
    default: return [];
  }
};

const getPeopleItems = (key) => {
  switch (key) {
    case 'authors': return props.authors || [];
    case 'publishers': return props.publishers || [];
    default: return [];
  }
};

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

function getStudioItems(viewKey) {
  switch (viewKey) {
    case 'studio-books': return props.studioBooks || props.books || [];
    case 'studio-manuscripts': return props.manuscripts || [];
    case 'studio-audios': return props.audios || [];
    case 'studio-videos': return props.videos || [];
    case 'versions': return props.versions || [];
    default: return [];
  }
}

function getTaxonomyItems(viewKey) {
  switch (viewKey) {
    case 'collections': return props.collections || [];
    case 'series': return props.series || [];
    case 'topics': return props.topics || [];
    case 'tags': return props.tags || [];
    case 'categories': return props.categories || [];
    default: return [];
  }
}

const viewCatalog = {
  books: { title: 'الكتب', group: 'المكتبة' },
  manuscripts: { title: 'المخطوطات', group: 'المكتبة' },
  audios: { title: 'الصوتيات', group: 'المكتبة' },
  videos: { title: 'المرئيات', group: 'المكتبة' },
  authors: { title: 'المؤلفون', group: 'الأشخاص' },
  publishers: { title: 'الناشرون', group: 'الأشخاص' },
  categories: { title: 'التصنيفات', group: 'التنظيم' },
  tags: { title: 'الأوسمة', group: 'التنظيم' },
  collections: { title: 'المجموعات', group: 'التنظيم' },
  series: { title: 'السلاسل', group: 'التنظيم' },
  topics: { title: 'الموضوعات', group: 'التنظيم' },
  'studio-books': { title: 'الكتب', group: 'الاستوديو' },
  'studio-manuscripts': { title: 'المخطوطات', group: 'الاستوديو' },
  'studio-audios': { title: 'الصوتيات', group: 'الاستوديو' },
  'studio-videos': { title: 'المرئيات', group: 'الاستوديو' },
  versions: { title: 'الإصدارات', group: 'الاستوديو' },
  stats: { title: 'الإحصائيات', group: 'النظام' },
  ops: { title: 'العمليات', group: 'النظام' },
  users: { title: 'المستخدمون', group: 'النظام' },
  activities: { title: 'النشاطات', group: 'النظام' },
  deletions: { title: 'المهملات', group: 'النظام' },
  commands: { title: 'الأوامر', group: 'النظام' },
};

const currentGroupTitle = computed(() => {
  return viewCatalog[currentViewKey.value]?.group || 'النظام';
});

const currentViewTitle = computed(() => {
  return viewCatalog[currentViewKey.value]?.title || 'الإحصائيات';
});

    function toggleNavGroup(groupId) {
      if (isSidebarCollapsed) return;
      const group = document.getElementById(groupId);
      if (group) {
        group.classList.toggle('collapsed');
        updateToolbarState();
      }
    }

    function expandAllGroups() {
      if (isSidebarCollapsed) return;
      document.querySelectorAll('.nav-group').forEach(group => {
        group.classList.remove('collapsed');
      });
      updateToolbarState();
    }

    function collapseAllGroups() {
      if (isSidebarCollapsed) return;
      document.querySelectorAll('.nav-group').forEach(group => {
        group.classList.add('collapsed');
      });
      updateToolbarState();
    }

    function updateToolbarState() {
      const groups = Array.from(document.querySelectorAll('.nav-group'));
      if (!groups.length) return;
      const allCollapsed = groups.every(g => g.classList.contains('collapsed'));
      const allExpanded = groups.every(g => !g.classList.contains('collapsed'));

      const btnExpand = document.getElementById('btnExpandAll');
      const btnCollapse = document.getElementById('btnCollapseAll');

      if (btnExpand) btnExpand.classList.toggle('active', allExpanded);
      if (btnCollapse) btnCollapse.classList.toggle('active', allCollapsed);
    }

    function loadView(viewKey) {
      currentViewKey.value = viewKey;
      const view = viewCatalog[viewKey] || viewCatalog.stats;

      // Update active sidebar item
      document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
      const activeNav = document.getElementById('nav-' + viewKey);
      
      let groupName = 'النظام';
      if (activeNav) {
        activeNav.classList.add('active');
        const parentGroup = activeNav.closest('.nav-group');
        if (parentGroup) {
          const groupTitleEl = parentGroup.querySelector('.group-title');
          if (groupTitleEl) groupName = groupTitleEl.textContent.trim();
          if (parentGroup.classList.contains('collapsed')) {
            parentGroup.classList.remove('collapsed');
          }
        }
      }

      // Update 3-tier breadcrumbs: الرئيسية ‹ اسم المجموعة الحالية ‹ اسم الصفحة الحالية
      const breadcrumbGroup = document.getElementById('breadcrumbGroup');
      const breadcrumbCurrent = document.getElementById('breadcrumbCurrent');
      if (breadcrumbGroup) breadcrumbGroup.textContent = view.group || groupName;
      if (breadcrumbCurrent) breadcrumbCurrent.textContent = view.title;

      updateToolbarState();

      if (typeof window !== 'undefined' && window.location.hash !== '#' + viewKey) {
        history.replaceState(null, '', '#' + viewKey);
      }

      // Render content
      const contentArea = document.getElementById('dynamicContentArea');
      if (contentArea) {
        contentArea.style.opacity = '0';
        contentArea.style.transform = 'translateY(6px)';
        contentArea.style.transition = 'all 0.2s ease-out';

        const vueComponentViews = ['books', 'manuscripts', 'audios', 'videos', 'authors', 'publishers', 'users', 'deletions', 'activities', 'stats', 'commands', 'ops', 'collections', 'series', 'topics', 'tags', 'categories', 'studio-books', 'studio-manuscripts', 'studio-audios', 'studio-videos', 'versions'];
        setTimeout(() => {
          if (vueComponentViews.includes(viewKey)) {
            currentViewHtml.value = '';
          } else {
            currentViewHtml.value = typeof view.render === 'function' ? view.render() : '';
          }
          contentArea.style.opacity = '1';
          contentArea.style.transform = 'translateY(0)';
        }, 50);
      }

      if (typeof window !== 'undefined' && typeof window.scrollTo === 'function') {
        try { window.scrollTo({ top: 0, behavior: 'smooth' }); } catch(e) {}
      }
    }

    async function runCmd() {
      const input = document.getElementById('cmdInput');
      const output = document.getElementById('terminalOutput');
      if (!input || !output) return;
      const cmd = input.value.trim();
      if (!cmd) return;

      const userLine = document.createElement('div');
      userLine.style.color = '#fff';
      userLine.style.fontWeight = 'bold';
      userLine.textContent = '$ ' + cmd;
      output.appendChild(userLine);

      const statusLine = document.createElement('div');
      statusLine.style.color = '#fbbf24';
      statusLine.style.fontSize = '0.75rem';
      statusLine.textContent = '⏳ جاري تنفيذ الأمر عبر خادم التطبيق...';
      output.appendChild(statusLine);
      input.value = '';
      output.scrollTop = output.scrollHeight;

      try {
        const response = await axios.post('/api/system/run-command', { command: cmd });
        statusLine.remove();
        const resLine = document.createElement('pre');
        resLine.style.color = '#38bdf8';
        resLine.style.fontFamily = 'monospace';
        resLine.style.whiteSpace = 'pre-wrap';
        resLine.style.margin = '4px 0 10px';
        resLine.textContent = response.data?.output || 'Command executed successfully: [OK]';
        output.appendChild(resLine);
      } catch (err) {
        statusLine.remove();
        const errLine = document.createElement('div');
        errLine.style.color = '#f87171';
        errLine.style.fontWeight = 'bold';
        errLine.style.margin = '4px 0 10px';
        errLine.textContent = '❌ ' + (err.response?.data?.message || err.message || 'خطأ أثناء تنفيذ الأمر');
        output.appendChild(errLine);
      }
      output.scrollTop = output.scrollHeight;
    }

    async function runPresetCmd(cmd) {
      const input = document.getElementById('cmdInput');
      if (input) {
        input.value = cmd;
      }
      await runCmd();
    }

    async function triggerOpsCacheClear() {
      try {
        const res = await axios.post('/api/system/run-command', { command: 'optimize:clear' });
        alert(res.data?.output || 'تم تفريغ كاش التطبيق وكاش التوجيه وسياسات الصلاحيات بنجاح.');
      } catch (err) {
        alert('حدث خطأ أثناء تفريغ الكاش: ' + (err.response?.data?.message || err.message));
      }
    }

    let isSidebarCollapsed = false;
    function toggleSidebarCollapse() {
      const sidebar = document.getElementById('appSidebar');
      const navbar = document.getElementById('appNavbar');
      const main = document.getElementById('appMain');
      const toolbar = document.getElementById('sidebarAccordionToolbar');

      if (!isSidebarCollapsed) {
        sidebar.style.width = '70px';
        navbar.style.right = '70px';
        main.style.marginRight = '70px';
        if (toolbar) toolbar.style.display = 'none';
        const header = document.querySelector('.sidebar-header');
        if (header) {
          header.style.justifyContent = 'center';
          header.style.padding = '0';
        }
        document.querySelectorAll('.sidebar-title, .group-title, .group-badge, .chevron-icon, .nav-item span, .badge-count').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.nav-group-items').forEach(el => el.style.maxHeight = '1000px');
        document.querySelectorAll('.nav-group-header').forEach(el => el.style.justifyContent = 'center');
        isSidebarCollapsed = true;
      } else {
        sidebar.style.width = '270px';
        navbar.style.right = '270px';
        main.style.marginRight = '270px';
        if (toolbar) toolbar.style.display = 'flex';
        const header = document.querySelector('.sidebar-header');
        if (header) {
          header.style.justifyContent = '';
          header.style.padding = '0 1.25rem';
        }
        document.querySelectorAll('.sidebar-title, .group-title, .group-badge, .chevron-icon, .nav-item span, .badge-count').forEach(el => el.style.display = '');
        document.querySelectorAll('.nav-group.collapsed .nav-group-items').forEach(el => el.style.maxHeight = '0');
        document.querySelectorAll('.nav-group-header').forEach(el => el.style.justifyContent = 'space-between');
        isSidebarCollapsed = false;
      }
    }

            function toggleUserDropdown() {
      const menu = document.getElementById('userDropdownMenu');
      if (menu) {
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
      }
    }

    document.addEventListener('click', (e) => {
      const wrapper = document.querySelector('.user-menu-wrapper');
      const menu = document.getElementById('userDropdownMenu');
      if (wrapper && menu && !wrapper.contains(e.target)) {
        menu.style.display = 'none';
      }
    });

    let isDarkMode = true;

    function initTheme() {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme === 'light') {
        setTheme(false);
      } else {
        setTheme(true);
      }
    }

    function toggleTheme() {
      setTheme(!isDarkMode);
    }

    function setTheme(dark) {
      isDarkMode = dark;
      const sunIcon = document.getElementById('themeIconSun');
      const moonIcon = document.getElementById('themeIconMoon');
      const toggleBtn = document.getElementById('themeToggleBtn');

      if (dark) {
        document.body.classList.remove('light-mode');
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        if (sunIcon) sunIcon.style.display = 'block';
        if (moonIcon) moonIcon.style.display = 'none';
        if (toggleBtn) toggleBtn.title = 'تفعيل الوضع النهاري (Light Mode)';
      } else {
        document.body.classList.add('light-mode');
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        if (sunIcon) sunIcon.style.display = 'none';
        if (moonIcon) moonIcon.style.display = 'block';
        if (toggleBtn) toggleBtn.title = 'تفعيل الوضع الليلي (Dark Mode)';
      }
    }

    // Default startup view: Books Catalog
    window.addEventListener('DOMContentLoaded', () => {
      initTheme();
      const initialView = (window.location.hash || "").replace("#", "") || "books";
      loadView(initialView);
      updateToolbarState();
    });
  
onMounted(() => {
  // Expose global methods to window for inline onclick handlers and tests
  window.loadView = loadView;
  window.toggleNavGroup = toggleNavGroup;
  window.expandAllGroups = expandAllGroups;
  window.collapseAllGroups = collapseAllGroups;
  window.toggleSidebarCollapse = toggleSidebarCollapse;
  window.toggleUserDropdown = toggleUserDropdown;
  window.toggleTheme = toggleTheme;
  window.initTheme = initTheme;
  window.setTheme = setTheme;
  window.runCmd = runCmd;
  window.triggerOpsCacheClear = triggerOpsCacheClear;
  window.runPresetCmd = runPresetCmd;

  initTheme();
  const initialView = (typeof window !== 'undefined' && (window.location.hash || "").replace("#", "")) || "stats";
  currentViewKey.value = initialView;
  const vueComponentViews = ['books', 'manuscripts', 'audios', 'videos', 'authors', 'publishers', 'users', 'deletions', 'activities', 'stats', 'commands', 'ops', 'collections', 'series', 'topics', 'tags', 'categories', 'studio-books', 'studio-manuscripts', 'studio-audios', 'studio-videos', 'versions'];
  if (!vueComponentViews.includes(initialView)) {
    currentViewHtml.value = typeof viewCatalog[initialView]?.render === 'function' ? viewCatalog[initialView].render() : '';
  }
  loadView(initialView);
  updateToolbarState();

  const handleHashChange = () => {
    const targetView = (window.location.hash || "").replace("#", "") || "stats";
    loadView(targetView);
  };
  window.addEventListener('hashchange', handleHashChange);
  window.__adminDashboardHashHandler = handleHashChange;
});

onUnmounted(() => {
  if (typeof window !== 'undefined' && window.__adminDashboardHashHandler) {
    window.removeEventListener('hashchange', window.__adminDashboardHashHandler);
    delete window.__adminDashboardHashHandler;
  }
  // Cleanup window attachments
  delete window.loadView;
  delete window.toggleNavGroup;
  delete window.expandAllGroups;
  delete window.collapseAllGroups;
  delete window.toggleSidebarCollapse;
  delete window.toggleUserDropdown;
  delete window.toggleTheme;
  delete window.initTheme;
  delete window.setTheme;
  delete window.runCmd;
  delete window.triggerOpsCacheClear;
  delete window.runPresetCmd;
});
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
