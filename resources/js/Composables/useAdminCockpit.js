import { ref, computed, onMounted, onUnmounted, getCurrentInstance } from 'vue';

export const viewCatalog = {
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

/**
 * Composable لإدارة حالة وقمرة القيادة والتوجيه الداخلي للمشرف العام
 * @param {Object} props
 */
export function useAdminCockpit(props = {}) {
  const currentViewKey = ref(typeof window !== 'undefined' && (window.location.hash || "").replace("#", "") || "stats");
  const currentViewHtml = ref('');
  const isSidebarCollapsed = ref(false);
  const isDarkMode = ref(true);

  // Sector Data Resolvers
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

  const getStudioItems = (viewKey) => {
    switch (viewKey) {
      case 'studio-books': return props.studioBooks || props.books || [];
      case 'studio-manuscripts': return props.manuscripts || [];
      case 'studio-audios': return props.audios || [];
      case 'studio-videos': return props.videos || [];
      case 'versions': return props.versions || [];
      default: return [];
    }
  };

  const getTaxonomyItems = (viewKey) => {
    switch (viewKey) {
      case 'collections': return props.collections || [];
      case 'series': return props.series || [];
      case 'topics': return props.topics || [];
      case 'tags': return props.tags || [];
      case 'categories': return props.categories || [];
      default: return [];
    }
  };

  const currentGroupTitle = computed(() => {
    return viewCatalog[currentViewKey.value]?.group || 'النظام';
  });

  const currentViewTitle = computed(() => {
    return viewCatalog[currentViewKey.value]?.title || 'الإحصائيات';
  });

  // DOM Navigation & Toolbar Handlers
  function toggleNavGroup(groupId) {
    if (isSidebarCollapsed.value) return;
    const group = typeof document !== 'undefined' ? document.getElementById(groupId) : null;
    if (group) {
      group.classList.toggle('collapsed');
      updateToolbarState();
    }
  }

  function expandAllGroups() {
    if (isSidebarCollapsed.value || typeof document === 'undefined') return;
    document.querySelectorAll('.nav-group').forEach(group => {
      group.classList.remove('collapsed');
    });
    updateToolbarState();
  }

  function collapseAllGroups() {
    if (isSidebarCollapsed.value || typeof document === 'undefined') return;
    document.querySelectorAll('.nav-group').forEach(group => {
      group.classList.add('collapsed');
    });
    updateToolbarState();
  }

  function updateToolbarState() {
    if (typeof document === 'undefined') return;
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

    if (typeof document !== 'undefined') {
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
    }

    if (typeof window !== 'undefined' && window.location.hash !== '#' + viewKey) {
      history.replaceState(null, '', '#' + viewKey);
    }

    // Render content with smooth transition
    if (typeof document !== 'undefined') {
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
    }

    if (typeof window !== 'undefined' && typeof window.scrollTo === 'function') {
      try { window.scrollTo({ top: 0, behavior: 'smooth' }); } catch(e) {}
    }
  }

  function toggleSidebarCollapse() {
    if (typeof document === 'undefined') return;
    const sidebar = document.getElementById('appSidebar');
    const navbar = document.getElementById('appNavbar');
    const main = document.getElementById('appMain');
    const toolbar = document.getElementById('sidebarAccordionToolbar');

    if (!isSidebarCollapsed.value) {
      if (sidebar) sidebar.style.width = '70px';
      if (navbar) navbar.style.right = '70px';
      if (main) main.style.marginRight = '70px';
      if (toolbar) toolbar.style.display = 'none';
      const header = document.querySelector('.sidebar-header');
      if (header) {
        header.style.justifyContent = 'center';
        header.style.padding = '0';
      }
      document.querySelectorAll('.sidebar-title, .group-title, .group-badge, .chevron-icon, .nav-item span, .badge-count').forEach(el => el.style.display = 'none');
      document.querySelectorAll('.nav-group-items').forEach(el => el.style.maxHeight = '1000px');
      document.querySelectorAll('.nav-group-header').forEach(el => el.style.justifyContent = 'center');
      isSidebarCollapsed.value = true;
    } else {
      if (sidebar) sidebar.style.width = '270px';
      if (navbar) navbar.style.right = '270px';
      if (main) main.style.marginRight = '270px';
      if (toolbar) toolbar.style.display = 'flex';
      const header = document.querySelector('.sidebar-header');
      if (header) {
        header.style.justifyContent = '';
        header.style.padding = '0 1.25rem';
      }
      document.querySelectorAll('.sidebar-title, .group-title, .group-badge, .chevron-icon, .nav-item span, .badge-count').forEach(el => el.style.display = '');
      document.querySelectorAll('.nav-group.collapsed .nav-group-items').forEach(el => el.style.maxHeight = '0');
      document.querySelectorAll('.nav-group-header').forEach(el => el.style.justifyContent = 'space-between');
      isSidebarCollapsed.value = false;
    }
  }

  function toggleUserDropdown() {
    if (typeof document === 'undefined') return;
    const menu = document.getElementById('userDropdownMenu');
    if (menu) {
      menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
  }

  function initTheme() {
    if (typeof localStorage === 'undefined') return;
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
      setTheme(false);
    } else {
      setTheme(true);
    }
  }

  function toggleTheme() {
    setTheme(!isDarkMode.value);
  }

  function setTheme(dark) {
    isDarkMode.value = dark;
    if (typeof document === 'undefined') return;
    const sunIcon = document.getElementById('themeIconSun');
    const moonIcon = document.getElementById('themeIconMoon');
    const toggleBtn = document.getElementById('themeToggleBtn');

    if (dark) {
      document.body?.classList.remove('light-mode');
      document.documentElement?.classList.add('dark');
      if (typeof localStorage !== 'undefined') localStorage.setItem('theme', 'dark');
      if (sunIcon) sunIcon.style.display = 'block';
      if (moonIcon) moonIcon.style.display = 'none';
      if (toggleBtn) toggleBtn.title = 'تفعيل الوضع النهاري (Light Mode)';
    } else {
      document.body?.classList.add('light-mode');
      document.documentElement?.classList.remove('dark');
      if (typeof localStorage !== 'undefined') localStorage.setItem('theme', 'light');
      if (sunIcon) sunIcon.style.display = 'none';
      if (moonIcon) moonIcon.style.display = 'block';
      if (toggleBtn) toggleBtn.title = 'تفعيل الوضع الليلي (Dark Mode)';
    }
  }

  const handleDocumentClick = (e) => {
    if (typeof document === 'undefined') return;
    const wrapper = document.querySelector('.user-menu-wrapper');
    const menu = document.getElementById('userDropdownMenu');
    if (wrapper && menu && !wrapper.contains(e.target)) {
      menu.style.display = 'none';
    }
  };

  // Mount lifecycle only if executing within an active Vue component instance
  if (getCurrentInstance()) {
    onMounted(() => {
      if (typeof window !== 'undefined') {
        window.loadView = loadView;
        window.toggleNavGroup = toggleNavGroup;
        window.expandAllGroups = expandAllGroups;
        window.collapseAllGroups = collapseAllGroups;
        window.toggleSidebarCollapse = toggleSidebarCollapse;
        window.toggleUserDropdown = toggleUserDropdown;
        window.toggleTheme = toggleTheme;
        window.initTheme = initTheme;
        window.setTheme = setTheme;
      }

      if (typeof document !== 'undefined') {
        document.addEventListener('click', handleDocumentClick);
      }

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
      if (typeof window !== 'undefined') {
        window.addEventListener('hashchange', handleHashChange);
        window.__adminDashboardHashHandler = handleHashChange;
      }
    });

    onUnmounted(() => {
      if (typeof document !== 'undefined') {
        document.removeEventListener('click', handleDocumentClick);
      }
      if (typeof window !== 'undefined' && window.__adminDashboardHashHandler) {
        window.removeEventListener('hashchange', window.__adminDashboardHashHandler);
        delete window.__adminDashboardHashHandler;
      }
      // Cleanup window attachments
      if (typeof window !== 'undefined') {
        delete window.loadView;
        delete window.toggleNavGroup;
        delete window.expandAllGroups;
        delete window.collapseAllGroups;
        delete window.toggleSidebarCollapse;
        delete window.toggleUserDropdown;
        delete window.toggleTheme;
        delete window.initTheme;
        delete window.setTheme;
      }
    });
  }

  return {
    currentViewKey,
    currentViewHtml,
    isSidebarCollapsed,
    isDarkMode,
    currentGroupTitle,
    currentViewTitle,
    viewCatalog,
    getLibraryItems,
    getPeopleItems,
    getStudioItems,
    getTaxonomyItems,
    loadView,
    toggleNavGroup,
    expandAllGroups,
    collapseAllGroups,
    updateToolbarState,
    toggleSidebarCollapse,
    toggleUserDropdown,
    initTheme,
    toggleTheme,
    setTheme,
  };
}
