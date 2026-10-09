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
  booksColumns, sampleBooksRows,
  manuscriptsColumns, sampleManuscriptsRows,
  audiosColumns, sampleAudiosRows,
  videosColumns, sampleVideosRows,
  authorsColumns, sampleAuthorsRows,
  publishersColumns, samplePublishersRows,
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

const activeBooksRows = computed(() => {
  if (props.books && props.books.length > 0) {
    return props.books;
  }
  return sampleBooksRows;
});

const activeManuscriptsRows = computed(() => {
  if (props.manuscripts && props.manuscripts.length > 0) {
    return props.manuscripts;
  }
  return sampleManuscriptsRows;
});

const activeAudiosRows = computed(() => {
  if (props.audios && props.audios.length > 0) {
    return props.audios;
  }
  return sampleAudiosRows;
});

const activeVideosRows = computed(() => {
  if (props.videos && props.videos.length > 0) {
    return props.videos;
  }
  return sampleVideosRows;
});

const activeAuthorsRows = computed(() => {
  if (props.authors && props.authors.length > 0) {
    return props.authors;
  }
  return sampleAuthorsRows;
});

const activePublishersRows = computed(() => {
  if (props.publishers && props.publishers.length > 0) {
    return props.publishers;
  }
  return samplePublishersRows;
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

const booksKpiStats = computed(() => ({
  total: props.stats?.books || 248510,
  published: 184200,
  scholarly: 42150,
  draft: 18630,
}));

const manuscriptsKpiStats = computed(() => ({
  total: props.stats?.manuscripts || 48920,
  published: 32450,
  scholarly: 11200,
  draft: 5270,
}));

const audiosKpiStats = computed(() => ({
  total: props.stats?.audios || 14680,
  published: 11820,
  scholarly: 2140,
  draft: 720,
}));

const videosKpiStats = computed(() => ({
  total: props.stats?.videos || 8420,
  published: 6150,
  scholarly: 1820,
  draft: 450,
}));

const authorsKpiStats = computed(() => {
  const total = props.stats?.authors || activeAuthorsRows.value.length;
  return {
    total,
    published: Math.round(total * 0.78),
    scholarly: Math.round(total * 0.16),
    draft: Math.max(0, total - Math.round(total * 0.94)),
  };
});

const publishersKpiStats = computed(() => {
  const total = props.stats?.publishers || activePublishersRows.value.length;
  return {
    total,
    published: Math.round(total * 0.82),
    scholarly: Math.round(total * 0.14),
    draft: Math.max(0, total - Math.round(total * 0.96)),
  };
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

const sampleDeletions = sampleDeletionsRows;

function getStudioItems(viewKey) {
  switch (viewKey) {
    case 'studio-books': return props.studioBooks || activeBooksRows.value || [];
    case 'studio-manuscripts': return props.manuscripts || activeManuscriptsRows.value || [];
    case 'studio-audios': return props.audios || activeAudiosRows.value || [];
    case 'studio-videos': return props.videos || activeVideosRows.value || [];
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
  
    // ========================================================
    // UNIFIED TABLE & COLUMN PICKER LOGIC (FOR ALL ASSETS)
    // ========================================================
    function toggleColumnsDropdown(event, menuId) {
      if (event) {
        event.stopPropagation();
        event.preventDefault();
      }
      const targetMenu = menuId ? document.getElementById(menuId) : (document.getElementById('columnsDropdownMenu') || document.querySelector('.columns-dropdown-menu'));
      
      // Close all other open menus first
      document.querySelectorAll('.columns-dropdown-menu').forEach(m => {
        if (m !== targetMenu) m.classList.remove('show');
      });

      if (targetMenu) {
        targetMenu.classList.toggle('show');
      }
    }

    // Close any column menu when clicking outside
    document.addEventListener('click', (e) => {
      document.querySelectorAll('.columns-dropdown-menu.show').forEach(menu => {
        const wrapper = menu.closest('.columns-picker-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
          menu.classList.remove('show');
        }
      });
    });

    // Column Visibility Toggle for Any Table
    function toggleColumnVisibility(colIndex, isVisible, tableId) {
      const table = tableId ? document.getElementById(tableId) : (document.getElementById('booksDataTable') || document.querySelector('.dense-table'));
      if (!table) return;

      const cells = table.querySelectorAll(`tr > :nth-child(${colIndex})`);
      cells.forEach(cell => {
        cell.style.display = isVisible ? '' : 'none';
      });
    }

    // Reset All Columns
    function resetAllColumns(tableId, menuId) {
      const menu = menuId ? document.getElementById(menuId) : (document.getElementById('columnsDropdownMenu') || document.querySelector('.columns-dropdown-menu'));
      if (menu) {
        const checkboxes = menu.querySelectorAll('input[type="checkbox"]:not(:disabled)');
        checkboxes.forEach(cb => { cb.checked = true; });
      }

      const table = tableId ? document.getElementById(tableId) : (document.getElementById('booksDataTable') || document.querySelector('.dense-table'));
      if (table) {
        const allCells = table.querySelectorAll('th, td');
        allCells.forEach(c => c.style.display = '');
      }
    }

    // Unified View Switcher (جدول / بطاقات) for Any Asset
    function toggleViewMode(asset, mode) {
      const tableView = document.getElementById(asset + 'TableView');
      const gridView = document.getElementById(asset + 'GridView');
      const btnTable = document.getElementById('btnViewTable_' + asset) || document.getElementById('btnViewTable');
      const btnGrid = document.getElementById('btnViewGrid_' + asset) || document.getElementById('btnViewGrid');

      if (mode === 'grid') {
        if (tableView) tableView.style.display = 'none';
        if (gridView) gridView.style.display = 'grid';
        if (btnTable) btnTable.classList.remove('active');
        if (btnGrid) btnGrid.classList.add('active');
      } else {
        if (tableView) tableView.style.display = '';
        if (gridView) gridView.style.display = 'none';
        if (btnTable) btnTable.classList.add('active');
        if (btnGrid) btnGrid.classList.remove('active');
      }
    }

    // Backward compatibility for books
    function toggleBooksView(mode) {
      toggleViewMode('books', mode);
    }

    // Generic Select All
    function toggleSelectAllTable(master, tableId, stripId, countId) {
      const table = document.getElementById(tableId);
      if (!table) return;
      const checkboxes = table.querySelectorAll('tbody .row-checkbox');
      checkboxes.forEach(cb => {
        cb.checked = master.checked;
        const row = cb.closest('tr');
        if (row) {
          row.classList.toggle('row-selected', master.checked);
        }
      });
      updateGenericBulkState(tableId, stripId, countId);
    }

    // Backward compatibility for books
    function toggleSelectAllBooks(master) {
      toggleSelectAllTable(master, 'booksDataTable', 'bulkActionsStrip', 'bulkSelectedCount');
    }

    // Generic Row Checkbox Change
    function onTableRowCheckboxChange(tableId, stripId, countId) {
      const table = document.getElementById(tableId);
      if (!table) return;
      const checkboxes = table.querySelectorAll('tbody .row-checkbox');
      const master = table.querySelector('thead input[type="checkbox"]');
      const allChecked = Array.from(checkboxes).every(cb => cb.checked);
      if (master) master.checked = checkboxes.length > 0 && allChecked;

      checkboxes.forEach(cb => {
        const row = cb.closest('tr');
        if (row) {
          row.classList.toggle('row-selected', cb.checked);
        }
      });
      updateGenericBulkState(tableId, stripId, countId);
    }

    // Backward compatibility for books
    function onBookRowCheckboxChange() {
      onTableRowCheckboxChange('booksDataTable', 'bulkActionsStrip', 'bulkSelectedCount');
    }

    function updateGenericBulkState(tableId, stripId, countId) {
      const table = document.getElementById(tableId);
      if (!table) return;
      const selected = table.querySelectorAll('tbody .row-checkbox:checked').length;
      const strip = document.getElementById(stripId);
      const countEl = document.getElementById(countId);
      if (strip) {
        strip.style.display = selected > 0 ? 'flex' : 'none';
      }
      if (countEl) {
        countEl.textContent = 'المحدد (' + selected + ')';
      }
    }

    // Universal Live Table Filter
    function filterTable(tableId, val) {
      const query = (val || '').trim().toLowerCase();
      const table = document.getElementById(tableId);
      if (!table) return;
      const rows = table.querySelectorAll('tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const match = !query || text.includes(query);
        row.style.display = match ? '' : 'none';
      });
    }

    // Books Filter
    function filterBooksTable(val) {
      filterTable('booksDataTable', val !== undefined ? val : document.getElementById('booksSearchInput')?.value);
    }

onMounted(() => {
  // Expose global methods to window for inline onclick handlers
  window.loadView = loadView;
  window.toggleNavGroup = toggleNavGroup;
  window.expandAllGroups = expandAllGroups;
  window.collapseAllGroups = collapseAllGroups;
  window.toggleSidebarCollapse = toggleSidebarCollapse;
  window.toggleUserDropdown = toggleUserDropdown;
  window.toggleTheme = toggleTheme;
  window.initTheme = initTheme;
  window.setTheme = setTheme;
  window.toggleColumnsDropdown = toggleColumnsDropdown;
  window.toggleColumnVisibility = toggleColumnVisibility;
  window.resetAllColumns = resetAllColumns;
  window.toggleViewMode = toggleViewMode;
  window.toggleBooksView = toggleBooksView;
  window.toggleSelectAllTable = toggleSelectAllTable;
  window.toggleSelectAllBooks = toggleSelectAllBooks;
  window.onTableRowCheckboxChange = onTableRowCheckboxChange;
  window.onBookRowCheckboxChange = onBookRowCheckboxChange;
  window.updateGenericBulkState = updateGenericBulkState;
  window.filterTable = filterTable;
  window.filterBooksTable = filterBooksTable;
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
  delete window.toggleColumnsDropdown;
  delete window.toggleColumnVisibility;
  delete window.resetAllColumns;
  delete window.toggleViewMode;
  delete window.toggleBooksView;
  delete window.toggleSelectAllTable;
  delete window.toggleSelectAllBooks;
  delete window.onTableRowCheckboxChange;
  delete window.onBookRowCheckboxChange;
  delete window.updateGenericBulkState;
  delete window.filterTable;
  delete window.filterBooksTable;
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

    body.light-mode .app-sidebar {
      background: var(--bg-sidebar);
      border-left: 1px solid var(--border-subtle);
      box-shadow: -4px 0 20px rgba(0, 0, 0, 0.04);
    }

    body.light-mode .app-navbar {
      background: var(--bg-navbar);
      border-bottom: 1px solid var(--border-subtle);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    body.light-mode .entity-card,
    body.light-mode .section-card,
    body.light-mode .kpi-card,
    body.light-mode .view-header-banner {
      background: #ffffff;
      border: 1px solid var(--border-subtle);
      box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    }

    body.light-mode .sidebar-title,
    body.light-mode .entity-title,
    body.light-mode .view-title-group h2,
    body.light-mode .section-title,
    body.light-mode .kpi-value,
    body.light-mode .breadcrumbs span.current,
    body.light-mode .timeline-body {
      color: #0f172a !important;
    }

    body.light-mode .nav-item {
      color: var(--text-muted);
    }

    body.light-mode .nav-item:hover {
      background: rgba(0, 0, 0, 0.04);
      color: #0f172a;
    }

    body.light-mode .nav-item.active {
      background: rgba(239, 68, 68, 0.08);
      color: #ef4444;
      border-right: 3px solid #ef4444;
    }

    body.light-mode .nav-group-header:hover {
      background: rgba(0, 0, 0, 0.03);
      color: #0f172a;
    }

    body.light-mode .search-box,
    body.light-mode .nav-btn,
    body.light-mode .meta-chip,
    body.light-mode .badge-count,
    body.light-mode .btn-action-small,
    body.light-mode .filter-pill {
      background: rgba(0, 0, 0, 0.03);
      border-color: var(--border-subtle);
      color: var(--text-muted);
    }

    body.light-mode .search-box input {
      color: #0f172a;
    }

    body.light-mode .search-box input::placeholder {
      color: var(--text-dim);
    }

    body.light-mode .nav-btn:hover,
    body.light-mode .btn-action-small:hover {
      background: rgba(0, 0, 0, 0.07);
      color: #0f172a;
    }

    body.light-mode .filter-pill.active {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.3);
      color: #ef4444;
    }

    body.light-mode .users-table th {
      background: rgba(0, 0, 0, 0.02);
      color: var(--text-dim);
    }

    body.light-mode .users-table td {
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      color: var(--text-main);
    }

    body.light-mode .tree-node {
      background: rgba(0, 0, 0, 0.02);
      border-color: var(--border-subtle);
    }

    body.light-mode .timeline-box {
      background: #f8fafc;
      border-color: var(--border-subtle);
    }

    body.light-mode .funnel-container {
      background: #f8fafc;
      border-color: var(--border-subtle);
    }

    body.light-mode .funnel-step {
      background: #ffffff;
      border-color: var(--border-subtle);
    }

    body.light-mode ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    body.light-mode ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
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

    /* ============================================================
       1. FIXED RIGHT SIDEBAR (ORDERED FROM GENERAL TO SOVEREIGN)
       ============================================================ */
    .app-sidebar {
      position: fixed;
      top: 0;
      right: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background: var(--bg-sidebar);
      border-left: 1px solid var(--border-subtle);
      display: flex;
      flex-direction: column;
      z-index: 50;
      transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-header {
      height: var(--navbar-height);
      display: flex;
      align-items: center;
      padding: 0 1.25rem;
      border-bottom: 1px solid var(--border-subtle);
      flex-shrink: 0;
      transition: padding 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-brand-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
      overflow: hidden;
      cursor: pointer;
    }

    .sidebar-logo {
      width: 32px;
      height: 32px;
      border-radius: 12px;
      background: linear-gradient(135deg, #4f46e5 0%, #9333ea 50%, #ec4899 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 15px -3px rgba(168, 85, 247, 0.25), 0 4px 6px -4px rgba(168, 85, 247, 0.25);
      flex-shrink: 0;
      transition: transform 0.2s ease;
    }

    .sidebar-brand-link:hover .sidebar-logo {
      transform: scale(1.05);
    }

    .sidebar-logo span {
      color: #ffffff;
      font-weight: 900;
      font-size: 0.875rem;
      line-height: 1;
      font-family: 'Outfit', sans-serif;
    }

    .sidebar-title {
      font-size: 1.25rem;
      font-weight: 900;
      letter-spacing: -0.025em;
      color: #ffffff;
      white-space: nowrap;
      font-family: 'Outfit', sans-serif;
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

    .sidebar-nav {
      flex: 1;
      overflow-y: auto;
      padding: 0.75rem 0.6rem 2.5rem 0.6rem;
    }

    /* Collapsible Navigation Groups */
    .nav-group {
      margin-bottom: 0.4rem;
      border-radius: 0.75rem;
      transition: all 0.25s ease;
    }

    .nav-group-header {
      font-size: 0.72rem;
      font-weight: 800;
      color: var(--text-dim);
      padding: 0.5rem 0.65rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      user-select: none;
      border-radius: 0.65rem;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-group-header:hover {
      background: rgba(255, 255, 255, 0.04);
      color: #fff;
    }

    .nav-group-header .header-main {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .nav-group-header .group-title {
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.2px;
    }

    .nav-group-header .group-badge {
      font-size: 0.62rem;
      font-weight: 700;
      background: rgba(255, 255, 255, 0.05);
      padding: 0.1rem 0.45rem;
      border-radius: 9999px;
      color: var(--text-dim);
      font-family: 'Outfit';
    }

    .nav-group-header .chevron-icon {
      width: 14px;
      height: 14px;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      color: var(--text-dim);
      flex-shrink: 0;
      transform: rotate(0deg);
    }

    .nav-group.collapsed .chevron-icon {
      transform: rotate(90deg);
    }

    .nav-group-items {
      display: flex;
      flex-direction: column;
      max-height: 800px;
      opacity: 1;
      overflow: hidden;
      transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease, padding 0.3s ease;
      padding-top: 0.15rem;
    }

    .nav-group.collapsed .nav-group-items {
      max-height: 0 !important;
      opacity: 0;
      pointer-events: none;
      padding-top: 0;
      padding-bottom: 0;
    }

    /* Sovereign group custom styling */
    .nav-group.sovereign-group {
      border-top: 1px solid rgba(239, 68, 68, 0.18);
      padding-top: 0.5rem;
      margin-top: 0.75rem;
    }

    .nav-group.sovereign-group .nav-group-header {
      color: #f87171;
    }

    .nav-group.sovereign-group .nav-group-header:hover {
      background: rgba(239, 68, 68, 0.08);
      color: #fca5a5;
    }

    .nav-group.sovereign-group .group-badge {
      background: rgba(239, 68, 68, 0.15);
      color: #fca5a5;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .nav-group.sovereign-group .chevron-icon {
      color: #f87171;
    }

    /* Sidebar Accordion Micro-Toolbar (Expand/Collapse All) */
    .sidebar-accordion-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.2rem 0.4rem 0.65rem 0.4rem;
      margin-bottom: 0.6rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .toolbar-label {
      font-size: 0.68rem;
      font-weight: 800;
      color: var(--text-dim);
      display: flex;
      align-items: center;
      gap: 0.4rem;
      letter-spacing: 0.3px;
    }

    .toolbar-label svg {
      color: var(--text-muted);
    }

    .pill-segmented-control {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      border-radius: 9999px;
      padding: 2px;
      gap: 2px;
    }

    .seg-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      background: transparent;
      border: none;
      color: var(--text-muted);
      font-size: 0.65rem;
      font-weight: 800;
      padding: 0.2rem 0.55rem;
      border-radius: 9999px;
      cursor: pointer;
      font-family: inherit;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .seg-btn:hover {
      background: rgba(255, 255, 255, 0.07);
      color: #fff;
    }

    .seg-btn.active {
      background: rgba(239, 68, 68, 0.15);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.3);
      box-shadow: 0 0 10px rgba(239, 68, 68, 0.15);
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      padding: 0.5rem 0.65rem;
      border-radius: 0.65rem;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.78rem;
      font-weight: 700;
      transition: all 0.2s;
      margin-bottom: 0.15rem;
      cursor: pointer;
    }

    .nav-item:hover {
      background: rgba(255, 255, 255, 0.04);
      color: #fff;
    }

    .nav-item.active {
      background: rgba(239, 68, 68, 0.12);
      color: #f87171;
      border-right: 3px solid #ef4444;
    }

    .nav-item svg {
      width: 16px;
      height: 16px;
      stroke-width: 2;
      flex-shrink: 0;
    }

    .badge-count {
      margin-right: auto;
      font-size: 0.65rem;
      font-weight: 800;
      background: rgba(255, 255, 255, 0.05);
      padding: 0.1rem 0.4rem;
      border-radius: 6px;
      color: var(--text-dim);
      font-family: 'Outfit';
    }

    /* ============================================================
       2. TOP FIXED NAVBAR
       ============================================================ */
    .app-navbar {
      position: fixed;
      top: 0;
      right: var(--sidebar-width);
      left: 0;
      height: var(--navbar-height);
      background: var(--bg-navbar);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border-subtle);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1.5rem;
      z-index: 40;
      transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar-left, .navbar-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .nav-btn {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      cursor: pointer;
      transition: all 0.2s;
    }

    .nav-btn:hover {
      background: rgba(255, 255, 255, 0.08);
      color: #fff;
    }

    .nav-btn svg { width: 18px; height: 18px; }

    .breadcrumbs {
      display: flex;
      align-items: center;
      gap: 0.45rem;
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--text-dim);
    }

    .breadcrumb-link {
      color: var(--text-dim);
      text-decoration: none;
      transition: color 0.2s;
    }

    .breadcrumb-link:hover {
      color: var(--indigo);
    }

    .breadcrumb-sep {
      width: 13px;
      height: 13px;
      transform: rotate(180deg);
      color: var(--text-dim);
      flex-shrink: 0;
      opacity: 0.7;
    }

    .breadcrumb-group {
      color: var(--text-muted);
      font-weight: 700;
    }

    .breadcrumbs span.current {
      color: #fff;
      font-weight: 800;
    }

    .search-box {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      border-radius: 9999px;
      padding: 0.4rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--text-muted);
      font-size: 0.75rem;
      width: 240px;
    }

    .search-box input {
      background: transparent;
      border: none;
      outline: none;
      color: #fff;
      font-size: 0.75rem;
      width: 100%;
    }

    /* User Avatar and Dropdown (as in Navbar.vue / Dashboard.vue) */
    .user-menu-wrapper {
      position: relative;
    }

    .user-avatar-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      padding: 2px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
    }

    .user-avatar-btn:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.18);
    }

    .user-avatar-inner {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: linear-gradient(135deg, #27272a, #3f3f46);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-weight: 900;
      font-size: 0.85rem;
      line-height: 1;
      text-align: center;
    }

    .user-avatar-inner span {
      display: flex;
      align-items: center;
      justify-content: center;
      line-height: 1;
      transform: translateY(-1.5px);
      user-select: none;
    }

    body.light-mode .user-avatar-btn {
      background: rgba(0, 0, 0, 0.03);
      border-color: var(--border-subtle);
    }

    body.light-mode .user-avatar-btn:hover {
      background: rgba(0, 0, 0, 0.07);
    }

    body.light-mode .user-avatar-inner {
      background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
      color: #0f172a;
    }

    .user-dropdown-menu {
      position: absolute;
      left: 0;
      top: calc(100% + 8px);
      width: 210px;
      background: #121215;
      border: 1px solid var(--border-subtle);
      border-radius: 1rem;
      box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.7);
      padding: 0.5rem;
      z-index: 100;
      backdrop-filter: blur(16px);
    }

    body.light-mode .user-dropdown-menu {
      background: #ffffff;
      box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1);
    }

    .user-dropdown-header {
      padding: 0.5rem 0.75rem 0.7rem 0.75rem;
      border-bottom: 1px solid var(--border-subtle);
      margin-bottom: 0.35rem;
    }

    .user-dropdown-name {
      font-size: 0.8rem;
      font-weight: 800;
      color: var(--text-main);
    }

    .user-dropdown-role {
      font-size: 0.65rem;
      color: var(--text-dim);
      margin-top: 0.15rem;
      font-family: 'Outfit', sans-serif;
    }

    .user-dropdown-item {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.5rem 0.75rem;
      border-radius: 0.5rem;
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--text-muted);
      text-decoration: none;
      transition: all 0.15s;
      cursor: pointer;
    }

    .user-dropdown-item:hover {
      background: rgba(255, 255, 255, 0.05);
      color: var(--text-main);
    }

    body.light-mode .user-dropdown-item:hover {
      background: rgba(0, 0, 0, 0.04);
      color: #0f172a;
    }

    .user-dropdown-item.text-danger {
      color: #f87171;
    }

    .user-dropdown-item.text-danger:hover {
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
    }

    /* ============================================================
       3. MAIN CONTENT VIEWPORT
       ============================================================ */
    .app-main {
      margin-right: var(--sidebar-width);
      padding-top: calc(var(--navbar-height) + 1.5rem);
      padding-left: 2rem;
      padding-right: 2rem;
      padding-bottom: 4rem;
      min-height: 100vh;
      transition: margin-right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .view-header-banner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.25rem 1.5rem;
      background: rgba(18, 18, 21, 0.7);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 1.25rem;
      margin-bottom: 1.5rem;
    }

    .view-title-group h2 {
      font-size: 1.25rem;
      font-weight: 900;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .view-title-group p {
      font-size: 0.75rem;
      color: var(--text-dim);
      font-weight: 600;
      margin-top: 0.2rem;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 0.65rem;
    }

    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0, 0, 0, 0.3);
      border: 1px solid var(--border-subtle);
      border-radius: 1rem;
      padding: 0.6rem 1rem;
      margin-bottom: 1.5rem;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .filter-pills {
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    .filter-pill {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      color: var(--text-muted);
      padding: 0.3rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-pill.active, .filter-pill:hover {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.3);
      color: #fff;
    }

    .catalog-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.25rem;
    }

    .entity-card {
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 1.25rem;
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.3s;
    }

    .entity-card:hover {
      transform: translateY(-3px);
      border-color: rgba(255, 255, 255, 0.18);
      box-shadow: 0 12px 30px -10px rgba(0,0,0,0.6);
    }

    .entity-tag {
      font-size: 0.65rem;
      font-weight: 800;
      padding: 0.15rem 0.5rem;
      border-radius: 6px;
      display: inline-block;
      margin-bottom: 0.5rem;
    }

    .tag-public { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .tag-draft { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
    .tag-scholarly { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }

    .entity-title {
      font-size: 0.95rem;
      font-weight: 800;
      color: #fff;
      margin-bottom: 0.25rem;
    }

    .entity-meta-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 0.35rem;
      margin-bottom: 0.85rem;
    }

    .meta-chip {
      font-size: 0.68rem;
      font-weight: 700;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      padding: 0.1rem 0.45rem;
      color: var(--text-dim);
    }

    .meta-chip.category {
      color: #818cf8;
      background: rgba(99, 102, 241, 0.08);
      border-color: rgba(99, 102, 241, 0.2);
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 0.85rem;
      border-top: 1px solid var(--border-subtle);
    }

    .section-card {
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 1.5rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.25rem;
      padding-bottom: 0.75rem;
      border-bottom: 1px solid var(--border-subtle);
    }

    .section-title {
      font-size: 1rem;
      font-weight: 900;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.25rem;
      margin-bottom: 1.75rem;
    }

    .kpi-card {
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 1.25rem;
      padding: 1.25rem;
      transition: all 0.3s;
    }

    .kpi-title { font-size: 0.75rem; color: var(--text-muted); font-weight: 700; }
    .kpi-value { font-size: 2rem; font-weight: 900; color: #fff; font-family: 'Outfit', sans-serif; margin: 0.5rem 0; }
    .kpi-split-bar { display: flex; height: 5px; width: 100%; border-radius: 9999px; overflow: hidden; margin-bottom: 0.5rem; background: rgba(255, 255, 255, 0.05); }
    .kpi-split-subtext { display: flex; justify-content: space-between; font-size: 0.7rem; font-weight: 700; color: var(--text-dim); }

    .funnel-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.75rem;
      padding: 1rem;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 1rem;
      border: 1px solid var(--border-subtle);
    }

    .funnel-step {
      flex: 1;
      text-align: center;
      padding: 0.6rem 0.5rem;
      border-radius: 0.75rem;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border-subtle);
    }

    .funnel-step-label { font-size: 0.65rem; font-weight: 800; color: var(--text-dim); margin-bottom: 0.2rem; }
    .funnel-step-num { font-size: 1.25rem; font-weight: 900; font-family: 'Outfit', sans-serif; }

    .users-table-wrap {
      overflow-x: auto;
      border-radius: 0.85rem;
      border: 1px solid var(--border-subtle);
    }

    .users-table {
      width: 100%;
      border-collapse: collapse;
      text-align: right;
      font-size: 0.78rem;
    }

    .users-table th {
      background: rgba(255, 255, 255, 0.03);
      padding: 0.75rem 0.85rem;
      color: var(--text-muted);
      font-weight: 800;
      border-bottom: 1px solid var(--border-subtle);
    }

    .users-table td {
      padding: 0.75rem 0.85rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
      color: var(--text-main);
    }

    .btn-action-small {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--border-subtle);
      color: var(--text-main);
      padding: 0.35rem 0.85rem;
      border-radius: 8px;
      font-size: 0.72rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-action-small:hover { background: rgba(255, 255, 255, 0.1); }

    .btn-primary-small {
      background: linear-gradient(135deg, #ef4444, #b91c1c);
      color: #fff;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 800;
      cursor: pointer;
      box-shadow: 0 0 10px var(--crimson-glow);
    }

    .btn-danger-small {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #f87171;
    }

    .role-chip { font-size: 0.62rem; font-weight: 800; padding: 0.15rem 0.4rem; border-radius: 6px; }
    .chip-admin { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
    .chip-studio { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
    .chip-academic { background: rgba(168, 85, 247, 0.1); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.2); }
    .chip-public { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }

    .tree-node {
      padding: 0.5rem 0.85rem;
      border-radius: 8px;
      margin-bottom: 0.35rem;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border-subtle);
      font-size: 0.8rem;
      font-weight: 700;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .tree-node.child { margin-right: 1.5rem; border-right: 2px solid #6366f1; }

    .diff-box {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      background: #000;
      padding: 1rem;
      border-radius: 12px;
      font-family: monospace;
      font-size: 0.78rem;
    }

    /* Live Audit Timeline */
    .timeline-container {
      position: relative;
      padding-right: 1.5rem;
      margin-top: 1rem;
    }

    .timeline-rail {
      position: absolute;
      top: 0;
      bottom: 0;
      right: 7px;
      width: 2px;
      background: linear-gradient(180deg, rgba(239, 68, 68, 0.6) 0%, rgba(255,255,255,0.05) 100%);
    }

    .timeline-item {
      position: relative;
      margin-bottom: 1rem;
      padding-right: 1.25rem;
    }

    .timeline-dot {
      position: absolute;
      right: -1.75rem;
      top: 8px;
      width: 10px;
      height: 10px;
      border-radius: 9999px;
      background: #ef4444;
      border: 2px solid var(--bg-surface);
      box-shadow: 0 0 10px var(--crimson-glow);
    }

    .timeline-box {
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border-subtle);
      border-radius: 1rem;
      padding: 0.85rem 1.15rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
    }

    .timeline-user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 8px;
      background: rgba(239, 68, 68, 0.15);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 900;
      flex-shrink: 0;
    }

    .timeline-body {
      font-size: 0.78rem;
      color: var(--text-main);
    }

    .timeline-body strong {
      color: #f87171;
      margin-left: 0.25rem;
    }

    .timeline-time {
      font-size: 0.68rem;
      color: var(--text-dim);
      font-family: 'Outfit', sans-serif;
      white-space: nowrap;
    }

    /* Extra Utility Styles for Rich Action Triggers & Quick Launchpad */
    .btn-indigo-small {
      background: rgba(99, 102, 241, 0.15);
      border: 1px solid rgba(99, 102, 241, 0.3);
      color: #818cf8;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.72rem;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s;
    }
    .btn-indigo-small:hover {
      background: rgba(99, 102, 241, 0.25);
      color: #a5b4fc;
      transform: translateY(-1px);
    }

    .btn-emerald-small {
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid rgba(16, 185, 129, 0.3);
      color: #34d399;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.72rem;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s;
    }
    .btn-emerald-small:hover {
      background: rgba(16, 185, 129, 0.25);
      color: #6ee7b7;
      transform: translateY(-1px);
    }

    .btn-amber-small {
      background: rgba(245, 158, 11, 0.15);
      border: 1px solid rgba(245, 158, 11, 0.3);
      color: #fbbf24;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.72rem;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s;
    }
    .btn-amber-small:hover {
      background: rgba(245, 158, 11, 0.25);
      color: #fde68a;
      transform: translateY(-1px);
    }

    .btn-purple-small {
      background: rgba(168, 85, 247, 0.15);
      border: 1px solid rgba(168, 85, 247, 0.3);
      color: #c084fc;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.72rem;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s;
    }
    .btn-purple-small:hover {
      background: rgba(168, 85, 247, 0.25);
      color: #e9d5ff;
      transform: translateY(-1px);
    }

    .quick-launch-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
    }

    .quick-launch-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem;
      border-radius: 1.25rem;
      background: rgba(255, 255, 255, 0.02);
      border: 1px solid var(--border-subtle);
      text-decoration: none;
      transition: all 0.25s;
      cursor: pointer;
    }

    .quick-launch-item:hover {
      background: rgba(255, 255, 255, 0.05);
      transform: translateY(-2px);
      border-color: rgba(255, 255, 255, 0.15);
    }

    body.light-mode .quick-launch-item {
      background: #f8fafc;
      border-color: var(--border-subtle);
    }
    body.light-mode .quick-launch-item:hover {
      background: #ffffff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .quick-icon-box {
      width: 44px;
      height: 44px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }

    .card-actions-strip {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      flex-wrap: wrap;
    }

  
    /* ========================================================
       ENTERPRISE HIGH-DENSITY DATA TABLE STYLES
       ======================================================== */
    .enterprise-card {
      background: var(--bg-card);
      border: 1px solid var(--border-subtle);
      border-radius: 14px;
      overflow: hidden;
      backdrop-filter: blur(12px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      margin-bottom: 2rem;
    }

    .table-toolbar {
      padding: 0.25rem 0.75rem;
      border-bottom: 1px solid var(--border-subtle);
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
    }

    .toolbar-row-primary {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .toolbar-search-box {
      position: relative;
      flex: 0 1 210px;
      min-width: 150px;
    }

    .toolbar-search-input {
      width: 100%;
      height: 27px;
      box-sizing: border-box;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      padding: 0 1.85rem 0 0.55rem;
      font-size: 0.73rem;
      color: var(--text-main);
      outline: none;
      transition: all 0.2s ease;
      font-family: inherit;
    }
    body.light-mode .toolbar-search-input {
      background: #f1f5f9;
    }

    .toolbar-search-input:focus {
      border-color: var(--indigo);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    .toolbar-search-icon {
      position: absolute;
      right: 0.55rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-dim);
      font-size: 0.75rem;
      pointer-events: none;
    }

    .toolbar-filters {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      flex-wrap: wrap;
    }

    .toolbar-select {
      height: 27px;
      box-sizing: border-box;
      background-color: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      padding: 0 0.55rem 0 1.45rem;
      font-size: 0.72rem;
      font-weight: 500;
      color: var(--text-main);
      outline: none;
      cursor: pointer;
      font-family: inherit;
      transition: all 0.2s ease;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23a1a1aa' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: left 0.45rem center;
      color-scheme: dark;
    }

    .toolbar-select:hover {
      background-color: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.25);
    }

    .toolbar-select:focus {
      border-color: var(--indigo);
      box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
    }

    .toolbar-select option {
      background-color: #18181b;
      color: #f4f4f5;
      padding: 0.35rem 0.5rem;
    }

    .view-mode-toggle {
      display: inline-flex;
      height: 27px;
      box-sizing: border-box;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      padding: 2px;
      gap: 2px;
    }
    body.light-mode .view-mode-toggle {
      background: #f1f5f9;
    }

    .view-mode-btn {
      background: transparent;
      border: none;
      height: 100%;
      box-sizing: border-box;
      padding: 0 0.45rem;
      font-size: 0.70rem;
      color: var(--text-dim);
      border-radius: 4px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      font-family: inherit;
      font-weight: 700;
      transition: all 0.2s;
    }

    .view-mode-btn.active {
      background: var(--indigo);
      color: #ffffff;
      box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    /* Bulk actions bar */
    .bulk-actions-strip {
      display: none;
      align-items: center;
      justify-content: space-between;
      background: rgba(99, 102, 241, 0.12);
      border: 1px solid rgba(99, 102, 241, 0.35);
      border-radius: 10px;
      padding: 0.55rem 1rem;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .bulk-actions-strip.active {
      display: flex;
    }

    /* Dense Data Table */
    .dense-table-wrapper {
      width: 100%;
      overflow-x: auto;
    }

    .dense-table {
      width: 100%;
      border-collapse: collapse;
      text-align: right;
      font-size: 0.82rem;
      white-space: nowrap;
    }

    .dense-table thead th {
      background: rgba(255, 255, 255, 0.02);
      padding: 0.75rem 0.85rem;
      color: var(--text-dim);
      font-size: 0.74rem;
      font-weight: 700;
      border-bottom: 1px solid var(--border-subtle);
      user-select: none;
    }
    body.light-mode .dense-table thead th {
      background: #f8fafc;
      color: #64748b;
    }

    .dense-table thead th.sortable {
      cursor: pointer;
      transition: color 0.15s;
    }
    .dense-table thead th.sortable:hover {
      color: var(--text-main);
    }

    .dense-table tbody td {
      padding: 0.5rem 0.75rem;
      border-bottom: 1px solid var(--border-subtle);
      color: var(--text-main);
      vertical-align: middle;
      transition: background 0.15s ease;
    }

    .dense-table tbody tr:hover td {
      background: rgba(255, 255, 255, 0.035);
    }
    body.light-mode .dense-table tbody tr:hover td {
      background: #f1f5f9;
    }

    .dense-table tbody tr.row-selected td {
      background: rgba(99, 102, 241, 0.12) !important;
    }

    /* Description cell with smooth 2-line clamp & tooltip */
    .cell-desc {
      max-width: 250px;
      white-space: normal;
      line-height: 1.35;
      font-size: 0.72rem;
      color: var(--text-dim);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      cursor: default;
    }



    .book-title-link {
      color: var(--text-main);
      font-weight: 700;
      text-decoration: none;
      transition: color 0.15s;
    }
    .book-title-link:hover {
      color: var(--indigo);
      text-decoration: underline;
    }

    .book-edition-sub {
      font-size: 0.7rem;
      color: var(--text-dim);
    }

    .table-actions-cell {
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }

    .table-btn-icon {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      border: 1px solid var(--border-subtle);
      background: rgba(255, 255, 255, 0.03);
      color: var(--text-muted);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.15s ease;
    }
    body.light-mode .table-btn-icon {
      background: #f1f5f9;
    }

    .table-btn-icon:hover {
      background: var(--indigo);
      color: #ffffff;
      border-color: var(--indigo);
      transform: translateY(-1px);
    }

    .table-btn-icon.btn-danger:hover {
      background: var(--crimson);
      border-color: var(--crimson);
    }

    /* Enterprise pagination */
    .table-pagination-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.85rem 1.25rem;
      border-top: 1px solid var(--border-subtle);
      font-size: 0.78rem;
      color: var(--text-dim);
      flex-wrap: wrap;
      gap: 1rem;
    }

    .pagination-pages-group {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .page-btn {
      min-width: 30px;
      height: 30px;
      padding: 0 0.4rem;
      border-radius: 6px;
      border: 1px solid var(--border-subtle);
      background: transparent;
      color: var(--text-main);
      font-size: 0.78rem;
      font-family: inherit;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.15s;
    }

    .page-btn:hover:not(:disabled) {
      background: rgba(255, 255, 255, 0.05);
      border-color: var(--indigo);
    }

    .page-btn.active {
      background: var(--indigo);
      border-color: var(--indigo);
      color: #ffffff;
      font-weight: 700;
    }

    .page-btn:disabled {
      opacity: 0.35;
      cursor: not-allowed;
    }

  
    /* ========================================================
       BANNER STATS & ACTIONS STYLES
       ======================================================== */
    .banner-stats-group {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      flex-wrap: wrap;
    }

    .banner-title-inline h2 {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--text-main);
      margin: 0;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    .banner-divider {
      width: 1px;
      height: 32px;
      background: var(--border-subtle);
    }

    .banner-stats-pills {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .stat-pill-card {
      display: flex;
      align-items: center;
      gap: 0.55rem;
      padding: 0.4rem 0.8rem;
      border-radius: 9px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--border-subtle);
      cursor: pointer;
      user-select: none;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    body.light-mode .stat-pill-card {
      background: #f8fafc;
    }

    .stat-pill-card:hover {
      background: rgba(255, 255, 255, 0.06);
      border-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
    }
    body.light-mode .stat-pill-card:hover {
      background: #f1f5f9;
      border-color: rgba(0, 0, 0, 0.15);
    }

    .stat-pill-card.active {
      background: rgba(99, 102, 241, 0.12);
      border-color: var(--indigo);
      box-shadow: 0 0 12px rgba(99, 102, 241, 0.2);
    }

    .stat-pill-label {
      font-size: 0.74rem;
      font-weight: 700;
      color: var(--text-dim);
    }
    .stat-pill-card.active .stat-pill-label {
      color: var(--indigo);
    }

    .stat-pill-value {
      font-size: 0.82rem;
      font-weight: 800;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
    }

    .stat-pill-indicator {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--text-dim);
      flex-shrink: 0;
    }
    .stat-pill-card.stat-published .stat-pill-indicator {
      background: #10b981;
      box-shadow: 0 0 6px #10b981;
    }
    .stat-pill-card.stat-scholarly .stat-pill-indicator {
      background: #6366f1;
      box-shadow: 0 0 6px #6366f1;
    }
    .stat-pill-card.stat-draft .stat-pill-indicator {
      background: #f59e0b;
      box-shadow: 0 0 6px #f59e0b;
    }

  
    /* ========================================================
       MINI KPI CARDS (INSPIRED BY KPI CARDS GRID)
       ======================================================== */
    .kpi-mini-row {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      flex-wrap: wrap;
    }

    .kpi-card-mini {
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 0.95rem;
      padding: 0.7rem 1rem;
      min-width: 140px;
      cursor: pointer;
      user-select: none;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
    }
    body.light-mode .kpi-card-mini {
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .kpi-card-mini:hover {
      border-color: rgba(255, 255, 255, 0.25);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }
    body.light-mode .kpi-card-mini:hover {
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .kpi-card-mini.active {
      border-color: var(--indigo);
      background: rgba(99, 102, 241, 0.1);
      box-shadow: 0 0 16px rgba(99, 102, 241, 0.25);
    }

    .kpi-mini-title {
      font-size: 0.68rem;
      color: var(--text-muted);
      font-weight: 700;
      white-space: nowrap;
    }
    .kpi-card-mini.active .kpi-mini-title {
      color: var(--indigo);
    }

    .kpi-mini-value {
      font-size: 1.35rem;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      margin: 0.25rem 0;
      line-height: 1.1;
    }

    .kpi-mini-bar {
      display: flex;
      height: 4px;
      width: 100%;
      border-radius: 9999px;
      overflow: hidden;
      margin-bottom: 0.35rem;
      background: rgba(255, 255, 255, 0.06);
    }
    body.light-mode .kpi-mini-bar {
      background: rgba(0, 0, 0, 0.06);
    }

    .kpi-mini-subtext {
      display: flex;
      justify-content: space-between;
      font-size: 0.65rem;
      font-weight: 700;
      color: var(--text-dim);
    }

  
    /* ========================================================
       SPLIT SECTIONS: KPI CARDS SECTION + ACTIONS BAR SECTION
       ======================================================== */
    .kpi-section-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1rem;
      margin-bottom: 1.25rem;
    }
    @media (max-width: 1024px) {
      .kpi-section-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 640px) {
      .kpi-section-container {
        grid-template-columns: 1fr;
      }
    }

    .kpi-card-refined {
      background: var(--bg-card);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border-subtle);
      border-radius: 1rem;
      padding: 1rem 1.25rem;
      cursor: pointer;
      user-select: none;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
    }
    body.light-mode .kpi-card-refined {
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .kpi-card-refined:hover {
      border-color: rgba(255, 255, 255, 0.25);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    }
    body.light-mode .kpi-card-refined:hover {
      border-color: rgba(0, 0, 0, 0.15);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .kpi-card-refined.active {
      border-color: var(--indigo);
      background: rgba(99, 102, 241, 0.08);
      box-shadow: 0 0 20px rgba(99, 102, 241, 0.25);
    }
    .kpi-card-refined.active::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      left: 0;
      height: 3px;
      background: var(--indigo);
    }

    .kpi-refined-title {
      font-size: 0.74rem;
      color: var(--text-muted);
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .kpi-card-refined.active .kpi-refined-title {
      color: var(--indigo);
    }

    .kpi-refined-value {
      font-size: 1.75rem;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      margin: 0.4rem 0 0.5rem 0;
      line-height: 1;
    }

    .kpi-refined-bar {
      display: flex;
      height: 4px;
      width: 100%;
      border-radius: 9999px;
      overflow: hidden;
      margin-bottom: 0.4rem;
      background: rgba(255, 255, 255, 0.06);
    }
    body.light-mode .kpi-refined-bar {
      background: rgba(0, 0, 0, 0.06);
    }

    .kpi-refined-subtext {
      display: flex;
      justify-content: space-between;
      font-size: 0.68rem;
      font-weight: 700;
      color: var(--text-dim);
    }

    /* Actions Bar Container (الدِف الثاني للأزرار) */
    .actions-bar-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
      background: var(--bg-card);
      border: 1px solid var(--border-subtle);
      border-radius: 12px;
      padding: 0.85rem 1.25rem;
      margin-bottom: 1.25rem;
      backdrop-filter: blur(12px);
    }
    body.light-mode .actions-bar-container {
      background: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .actions-bar-title {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--text-main);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0;
    }

  
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
      color: var(--text-main);
      padding-left: 0.85rem;
      border-left: 2px solid var(--border-subtle);
      white-space: nowrap;
      margin: 0;
    }

    .kpi-h-card {
      background: rgba(255, 255, 255, 0.025);
      border: 1px solid var(--border-subtle);
      border-radius: 0.75rem;
      padding: 0.5rem 0.85rem;
      min-width: 125px;
      cursor: pointer;
      user-select: none;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
    }
    body.light-mode .kpi-h-card {
      background: #f8fafc;
      border-color: rgba(0, 0, 0, 0.08);
    }

    .kpi-h-card:hover {
      border-color: rgba(255, 255, 255, 0.25);
      transform: translateY(-2px);
      background: rgba(255, 255, 255, 0.05);
    }
    body.light-mode .kpi-h-card:hover {
      background: #f1f5f9;
      border-color: rgba(0, 0, 0, 0.15);
    }

    .kpi-h-card.active {
      border-color: var(--indigo);
      background: rgba(99, 102, 241, 0.1);
      box-shadow: 0 0 14px rgba(99, 102, 241, 0.22);
    }

    .kpi-h-title {
      font-size: 0.68rem;
      color: var(--text-muted);
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .kpi-h-card.active .kpi-h-title {
      color: var(--indigo);
    }

    .kpi-h-value {
      font-size: 1.25rem;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      margin: 0.2rem 0;
      line-height: 1.1;
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
      color: var(--text-dim);
    }

    /* Left Div: Action Buttons */
    .banner-actions-col {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
      flex-shrink: 0;
    }

  
    /* 2x2 Buttons Grid */
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
      color: var(--text-main);
      border: 1px solid var(--border-subtle);
      backdrop-filter: blur(10px);
    }
    body.light-mode .btn-grid-secondary {
      background: #f8fafc;
      border-color: rgba(0, 0, 0, 0.1);
      color: #0f172a;
    }
    .btn-grid-secondary:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
    }
    body.light-mode .btn-grid-secondary:hover {
      background: #f1f5f9;
      border-color: rgba(0, 0, 0, 0.2);
    }

  
    /* Theme Harmony Enhancements for KPI Cards & 2x2 Buttons */
    .kpi-h-card {
      background: rgba(255, 255, 255, 0.025);
      border: 1px solid var(--border-subtle);
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
      border-color: var(--indigo);
      background: rgba(99, 102, 241, 0.1);
      box-shadow: 0 0 14px rgba(99, 102, 241, 0.22);
    }
    body.light-mode .kpi-h-card.active {
      background: rgba(99, 102, 241, 0.06);
      border-color: var(--indigo);
      box-shadow: 0 0 12px rgba(99, 102, 241, 0.15);
    }

    .kpi-h-value {
      font-size: 1.35rem;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      margin: 0.25rem 0;
      line-height: 1.1;
      color: var(--text-main);
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

    body.light-mode .btn-grid-secondary {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.12);
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    body.light-mode .btn-grid-secondary:hover {
      background: #f8fafc;
      border-color: rgba(0, 0, 0, 0.22);
    }

    /* Enterprise card in light mode */
    body.light-mode .enterprise-card {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.08);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

  
    /* ========================================================
       HIGH-CONTRAST LIGHT MODE ENHANCEMENTS FOR TABLE & CHIPS
       ======================================================== */
    body.light-mode .table-toolbar {
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      background: #ffffff;
    }

    body.light-mode .toolbar-search-input {
      background: #f8fafc;
      border: 1px solid rgba(0, 0, 0, 0.12);
      color: #0f172a;
    }
    body.light-mode .toolbar-search-input:focus {
      background: #ffffff;
      border-color: var(--indigo);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }
    body.light-mode .toolbar-search-input::placeholder {
      color: #94a3b8;
    }

    body.light-mode .toolbar-select {
      background-color: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.15);
      color: #0f172a;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      color-scheme: light;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    body.light-mode .toolbar-select:hover {
      background-color: #f8fafc;
      border-color: var(--indigo);
    }

    body.light-mode .toolbar-select:focus {
      background-color: #ffffff;
      border-color: var(--indigo);
      box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }

    body.light-mode .toolbar-select option {
      background-color: #ffffff;
      color: #0f172a;
      padding: 0.35rem 0.5rem;
    }

    body.light-mode .view-mode-toggle {
      background: #f1f5f9;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }
    body.light-mode .view-mode-btn {
      color: #64748b;
    }
    body.light-mode .view-mode-btn.active {
      background: var(--indigo);
      color: #ffffff;
    }

    body.light-mode .dense-table thead th {
      background: #f8fafc;
      color: #475569;
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    body.light-mode .dense-table tbody td {
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      color: #0f172a;
    }

    body.light-mode .dense-table tbody tr:hover td {
      background: #f8fafc;
    }

    body.light-mode .dense-table tbody tr.row-selected td {
      background: rgba(99, 102, 241, 0.06);
    }

    /* Light mode chips contrast */
    body.light-mode .chip-academic {
      background: rgba(168, 85, 247, 0.12);
      color: #7e22ce;
      border: 1px solid rgba(168, 85, 247, 0.3);
    }
    body.light-mode .chip-studio {
      background: rgba(16, 185, 129, 0.12);
      color: #047857;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
    body.light-mode .chip-public {
      background: rgba(59, 130, 246, 0.12);
      color: #1d4ed8;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }
    body.light-mode .chip-editor {
      background: rgba(99, 102, 241, 0.12);
      color: #4338ca;
      border: 1px solid rgba(99, 102, 241, 0.3);
    }
    body.light-mode .chip-super {
      background: rgba(239, 68, 68, 0.12);
      color: #b91c1c;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Light mode tags contrast */
    body.light-mode .tag-public {
      background: rgba(16, 185, 129, 0.12);
      color: #047857;
    }
    body.light-mode .tag-scholarly {
      background: rgba(99, 102, 241, 0.12);
      color: #4338ca;
    }
    body.light-mode .tag-draft {
      background: rgba(245, 158, 11, 0.12);
      color: #b45309;
    }

    /* Light mode table action buttons */
    body.light-mode .table-btn-icon {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.1);
      color: #475569;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }
    body.light-mode .table-btn-icon:hover {
      background: var(--indigo);
      border-color: var(--indigo);
      color: #ffffff;
    }
    body.light-mode .table-btn-icon.btn-danger:hover {
      background: var(--crimson);
      border-color: var(--crimson);
      color: #ffffff;
    }



    body.light-mode .table-pagination-bar {
      border-top: 1px solid rgba(0, 0, 0, 0.08);
      background: #ffffff;
    }
    body.light-mode .page-btn {
      border: 1px solid rgba(0, 0, 0, 0.1);
      color: #0f172a;
    }
    body.light-mode .page-btn:hover:not(:disabled) {
      background: #f1f5f9;
      border-color: var(--indigo);
    }
    body.light-mode .page-btn.active {
      background: var(--indigo);
      color: #ffffff;
    }

  
    /* Column Visibility Picker Dropdown */
    .columns-picker-wrapper {
      position: relative;
      display: inline-block;
    }

    .toolbar-btn {
      height: 27px;
      box-sizing: border-box;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--border-subtle);
      border-radius: 6px;
      padding: 0 0.5rem;
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--text-main);
      outline: none;
      cursor: pointer;
      font-family: inherit;
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      transition: all 0.2s;
    }
    body.light-mode .toolbar-btn {
      background: #f8fafc;
      border-color: rgba(0, 0, 0, 0.12);
      color: #0f172a;
    }
    .toolbar-btn:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: var(--indigo);
    }
    body.light-mode .toolbar-btn:hover {
      background: #ffffff;
      border-color: var(--indigo);
    }

    .columns-dropdown-menu {
      position: absolute;
      top: calc(100% + 4px);
      left: 0;
      min-width: 185px;
      max-height: 260px;
      overflow-y: auto;
      overflow-x: hidden;
      background: rgba(18, 18, 22, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--border-subtle);
      border-radius: 10px;
      box-shadow: 0 12px 36px rgba(0, 0, 0, 0.5);
      padding: 0.45rem;
      z-index: 100;
      display: none;
      flex-direction: column;
      gap: 0.2rem;
      scrollbar-width: thin;
      scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    /* Elegant Custom Scrollbar */
    .columns-dropdown-menu::-webkit-scrollbar {
      width: 5px;
    }
    .columns-dropdown-menu::-webkit-scrollbar-track {
      background: transparent;
    }
    .columns-dropdown-menu::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 4px;
    }
    .columns-dropdown-menu::-webkit-scrollbar-thumb:hover {
      background: var(--indigo);
    }

    body.light-mode .columns-dropdown-menu {
      background: #ffffff;
      border-color: rgba(0, 0, 0, 0.1);
      box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
      scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
    }
    body.light-mode .columns-dropdown-menu::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.2);
    }
    body.light-mode .columns-dropdown-menu::-webkit-scrollbar-thumb:hover {
      background: var(--indigo);
    }

    .columns-dropdown-menu.show {
      display: flex;
    }

    .column-toggle-item {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.4rem 0.6rem;
      border-radius: 6px;
      font-size: 0.78rem;
      font-weight: 600;
      color: var(--text-main);
      cursor: pointer;
      user-select: none;
      transition: background 0.15s;
    }
    .column-toggle-item:hover {
      background: rgba(255, 255, 255, 0.05);
    }
    body.light-mode .column-toggle-item:hover {
      background: #f1f5f9;
    }

    .column-toggle-item input[type="checkbox"] {
      cursor: pointer;
      accent-color: var(--indigo);
      width: 15px;
      height: 15px;
    }

    .columns-menu-divider {
      height: 1px;
      background: var(--border-subtle);
      margin: 0.3rem 0;
    }
    body.light-mode .columns-menu-divider {
      background: rgba(0, 0, 0, 0.08);
    }

    .columns-reset-btn {
      background: none;
      border: none;
      color: var(--indigo);
      font-size: 0.72rem;
      font-weight: 700;
      cursor: pointer;
      padding: 0.25rem 0.6rem;
      text-align: right;
      font-family: inherit;
    }
    .columns-reset-btn:hover {
      text-decoration: underline;
    }
</style>
