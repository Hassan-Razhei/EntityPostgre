<template>
  <div class="admin-dashboard-container">
<!-- ============================================================
       1. FIXED RIGHT SIDEBAR (ORDERED FROM GENERAL TO SOVEREIGN)
       ============================================================ -->
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header">
      <a href="javascript:void(0)" onclick="loadView('stats')" class="sidebar-brand-link" title="Entity Dashboard">
        <div class="sidebar-logo">
          <span>E</span>
        </div>
        <span class="sidebar-title">Entity</span>
      </a>
    </div>

    <nav class="sidebar-nav">

      <!-- شريط التحكم الفني: توسيع وطي كافة المجموعات -->
      <div class="sidebar-accordion-toolbar" id="sidebarAccordionToolbar">
        <span class="toolbar-label">
          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
          خريطة المجموعات
        </span>
        <div class="pill-segmented-control">
          <button type="button" class="seg-btn" id="btnExpandAll" onclick="expandAllGroups()" title="توسيع كافة المجموعات دفعة واحدة">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
            <span>توسيع</span>
          </button>
          <button type="button" class="seg-btn" id="btnCollapseAll" onclick="collapseAllGroups()" title="طي كافة المجموعات دفعة واحدة">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"/></svg>
            <span>طي</span>
          </button>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 1: 📚 المكتبة الرقمية العامة (General Assets)
           ======================================================== -->
      <div class="nav-group" id="group-library">
        <div class="nav-group-header" onclick="toggleNavGroup('group-library')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>📚</span>
            <span class="group-title">المكتبة</span>
            <span class="group-badge">4</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item active" id="nav-books" onclick="loadView('books')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>الكتب</span>
            <span class="badge-count">1,482</span>
          </div>
          <div class="nav-item" id="nav-manuscripts" onclick="loadView('manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">428</span>
          </div>
          <div class="nav-item" id="nav-audios" onclick="loadView('audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">650</span>
          </div>
          <div class="nav-item" id="nav-videos" onclick="loadView('videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">185</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 2: 👥 الأشخاص والجهات (Biographies & Publishers)
           ======================================================== -->
      <div class="nav-group" id="group-entities">
        <div class="nav-group-header" onclick="toggleNavGroup('group-entities')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>👥</span>
            <span class="group-title">الأشخاص</span>
            <span class="group-badge">2</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" id="nav-authors" onclick="loadView('authors')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>المؤلفون</span>
            <span class="badge-count">340</span>
          </div>
          <div class="nav-item" id="nav-publishers" onclick="loadView('publishers')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span>الناشرون</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 3: 🏷️ البيانات والتنظيم المعرفي (Taxonomies)
           ======================================================== -->
      <div class="nav-group" id="group-taxonomy">
        <div class="nav-group-header" onclick="toggleNavGroup('group-taxonomy')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>🏷️</span>
            <span class="group-title">التنظيم</span>
            <span class="group-badge">2</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" id="nav-categories" onclick="loadView('categories')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm5-3a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span>التصنيفات</span>
          </div>
          <div class="nav-item" id="nav-tags" onclick="loadView('tags')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span>الأوسمة</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 4: ✍️ استوديو الكيانات والتحقيق (Entity Studio - 4 Models)
           ======================================================== -->
      <div class="nav-group" id="group-studio">
        <div class="nav-group-header" onclick="toggleNavGroup('group-studio')" title="طي / توسيع استوديو الكيانات">
          <div class="header-main">
            <span>✍️</span>
            <span class="group-title">الاستوديو</span>
            <span class="group-badge">5</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" id="nav-studio-books" onclick="loadView('studio-books')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>الكتب</span>
            <span class="badge-count">386 مسودة</span>
          </div>
          <div class="nav-item" id="nav-studio-manuscripts" onclick="loadView('studio-manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">114 لوحة</span>
          </div>
          <div class="nav-item" id="nav-studio-audios" onclick="loadView('studio-audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">92 شريحة</span>
          </div>
          <div class="nav-item" id="nav-studio-videos" onclick="loadView('studio-videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">45 مشهد</span>
          </div>
          <div class="nav-item" id="nav-versions" onclick="loadView('versions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>الإصدارات</span>
            <span class="badge-count" style="color: #38bdf8;">842</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 5: 👑 الإدارة والحوكمة (Super Admin)
           ======================================================== -->
      <div class="nav-group sovereign-group" id="group-sovereignty">
        <div class="nav-group-header" onclick="toggleNavGroup('group-sovereignty')" title="طي / توسيع مجموعة الإدارة والحوكمة">
          <div class="header-main">
            <span>👑</span>
            <span class="group-title">النظام</span>
            <span class="group-badge">6</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" id="nav-stats" onclick="loadView('stats')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>الإحصائيات</span>
          </div>
          <div class="nav-item" id="nav-ops" onclick="loadView('ops')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>العمليات</span>
          </div>
          <div class="nav-item" id="nav-users" onclick="loadView('users')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>المستخدمون</span>
            <span class="badge-count">124</span>
          </div>
          <div class="nav-item" id="nav-activities" onclick="loadView('activities')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>النشاطات</span>
          </div>
          <div class="nav-item" id="nav-deletions" onclick="loadView('deletions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span>المهملات</span>
            <span class="badge-count icon-refresh">18</span>
          </div>
          <div class="nav-item" id="nav-commands" onclick="loadView('commands')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>الأوامر</span>
          </div>
        </div>
      </div>

    </nav>
  </aside>

  <!-- ============================================================
       2. TOP FIXED NAVBAR
       ============================================================ -->
  <header class="app-navbar" id="appNavbar">
    <div class="navbar-right">
      <button class="nav-btn" onclick="toggleSidebarCollapse()" title="طي/فرد القائمة الجانبية">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
      </button>

      <!-- Theme Toggle (Dark / Light Theme Toggle as in Navbar.vue) -->
      <button class="nav-btn" id="themeToggleBtn" onclick="toggleTheme()" title="تبديل المظهر النهاري / الليلي">
        <!-- Sun icon (shown in Dark mode to switch to Light) -->
        <svg id="themeIconSun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <!-- Moon icon (shown in Light mode to switch to Dark) -->
        <svg id="themeIconMoon" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      </button>

      <div class="breadcrumbs">
        <a href="javascript:void(0)" onclick="loadView('stats')" class="breadcrumb-link" title="نظرة عامة على النظام">الرئيسية</a>
        <svg class="breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="breadcrumb-group" id="breadcrumbGroup">المكتبة</span>
        <svg class="breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="current" id="breadcrumbCurrent">الكتب</span>
      </div>
    </div>

    <div class="navbar-left">
      <div class="search-box">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="بحث سريع...">
      </div>

      <button class="nav-btn" onclick="alert('تنبيهات النظام: الحالة مثالية، لا توجد مخاطر.')" title="التنبيهات">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
      </button>

      <!-- User Avatar / Profile Menu (as in Navbar.vue / Dashboard.vue) -->
      <div class="user-menu-wrapper">
        <button class="user-avatar-btn" id="userAvatarBtn" onclick="toggleUserDropdown()" title="الملف الشخصي وحساب المستخدم">
          <div class="user-avatar-inner">
            <span>م</span>
          </div>
        </button>

        <div id="userDropdownMenu" class="user-dropdown-menu" style="display: none;">
          <div class="user-dropdown-header">
            <p class="user-dropdown-name">د. إبراهيم الفاسي</p>
            <p class="user-dropdown-role">super_admin@archive.org</p>
          </div>
          <a href="/dashboard" class="user-dropdown-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>لوحة التحكم الرئيسية</span>
          </a>
          <div class="user-dropdown-item text-danger" onclick="alert('تم تسجيل الخروج بنجاح.'); location.reload();">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span>تسجيل الخروج</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- ============================================================
       3. DYNAMIC CONTENT CONTAINER (SPA Router Driven)
       ============================================================ -->
  <main class="app-main" id="appMain">
    <div id="dynamicContentArea">
      <!-- Populated dynamically via loadView() -->
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
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      books: 1482,
      manuscripts: 428,
      audios: 650,
      videos: 185,
      authors: 340,
      publishers: 85,
      categories: 42,
      tags: 156,
      users: 124,
      deletions: 18,
      versions: 842,
    })
  },
  recentActivities: {
    type: Array,
    default: () => []
  }
});

const viewCatalog = {
      // ========================================================
      // 1. BOOKS VIEW (المكتبة -> الكتب)
      // ========================================================
      books: {
        title: 'الكتب',
        group: 'المكتبة',
        render: () => `
          <!-- HORIZONTAL SPLIT BANNER (دِف في اليمين للبطاقات، ودِف في اليسار للأزرار) -->
          <div class="horizontal-header-banner">
            
            <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع (بدون عنوان) -->
            <div class="banner-kpi-col">
              
              <!-- Card 1: الكل -->
              <div class="kpi-h-card active" onclick="setQuickStatusFilter('', this)" title="عرض كامل الأرشيف">
                <div class="kpi-h-title">
                  <span>الكل</span>
                  <span style="font-size: 0.75rem;">📚</span>
                </div>
                <div class="kpi-h-value">248,510</div>
                <div class="kpi-h-bar"><div style="width: 100%; background: #6366f1;"></div></div>
                <div class="kpi-h-subtext"><span>الأرشيف</span><span>100%</span></div>
              </div>

              <!-- Card 2: منشور -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('منشور', this)" title="عرض الكتب المنشورة">
                <div class="kpi-h-title">
                  <span>منشور</span>
                  <span style="font-size: 0.75rem;">🌐</span>
                </div>
                <div class="kpi-h-value val-published">184,200</div>
                <div class="kpi-h-bar"><div style="width: 74%; background: #10b981;"></div></div>
                <div class="kpi-h-subtext"><span>متاح</span><span>74%</span></div>
              </div>

              <!-- Card 3: محكّم -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('محكّم', this)" title="عرض الكتب المحكّمة">
                <div class="kpi-h-title">
                  <span>محكّم</span>
                  <span style="font-size: 0.75rem;">🎓</span>
                </div>
                <div class="kpi-h-value val-scholarly">42,150</div>
                <div class="kpi-h-bar"><div style="width: 17%; background: #3b82f6;"></div></div>
                <div class="kpi-h-subtext"><span>معتمد</span><span>17%</span></div>
              </div>

              <!-- Card 4: مسودات -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('مسودة', this)" title="عرض المسودات">
                <div class="kpi-h-title">
                  <span>مسودات</span>
                  <span style="font-size: 0.75rem;">✍️</span>
                </div>
                <div class="kpi-h-value val-draft">18,630</div>
                <div class="kpi-h-bar"><div style="width: 9%; background: #f59e0b;"></div></div>
                <div class="kpi-h-subtext"><span>الاستوديو</span><span>9%</span></div>
              </div>

            </div>

            <!-- دِف اليسار: أزرار الإجراءات التنفيذية (2 × 2 متناسقة تماماً مع ارتفاع البطاقات) -->
            <div class="banner-actions-col">
              
              <!-- 1. إضافة كتاب (Primary) -->
              <a href="/books/create" class="btn-grid-item btn-grid-primary" title="إضافة كتاب جديد (+)" aria-label="إضافة كتاب">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
              </a>

              <!-- 2. تصدير الفهرس -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تصدير بيانات 248,510 كتاب إلى ملف CSV / Excel...')" title="تصدير الفهرس (CSV/Excel)" aria-label="تصدير">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-export">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                  <polyline points="7 10 12 15 17 10"></polyline>
                  <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
              </button>

              <!-- 3. استيراد جماعي -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('استيراد جماعي للمصنفات (CSV / MARC21 / JSON)...')" title="استيراد ملفات مصنفات" aria-label="استيراد">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-import">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                  <polyline points="17 8 12 3 7 8"></polyline>
                  <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
              </button>

              <!-- 4. تحديث الفهرس -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('جاري تحديث وإعادة فهرسة كتب الأرشيف...')" title="تحديث الفهرس العام" aria-label="تحديث">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
                  <polyline points="23 4 23 10 17 10"></polyline>
                  <polyline points="1 20 1 14 7 14"></polyline>
                  <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
              </button>

            </div>

          </div>

          <!-- Enterprise High-Density Table Card -->
          <div class="enterprise-card">
            
            <!-- Toolbar -->
            <div class="table-toolbar">
              <div class="toolbar-row-primary">
                
                <!-- Instant Search Box (بحث...) -->
                <div class="toolbar-search-box">
                  <span class="toolbar-search-icon">🔍</span>
                  <input type="text" id="booksSearchInput" class="toolbar-search-input" placeholder="بحث..." oninput="filterBooksTable(this.value)">
                </div>

                <!-- Filters & View Switcher (قاعدة الكلمة الواحدة وحذف التكرار) -->
                <div class="toolbar-filters">
                  
                  <!-- فلتر التصنيف -->
                  <select class="toolbar-select" id="booksCategoryFilter" onchange="filterBooksTable()">
                    <option value="">التصنيف</option>
                    <option value="الحديث">الحديث</option>
                    <option value="الأصول">الأصول</option>
                    <option value="العقيدة">العقيدة</option>
                    <option value="التراجم">التراجم</option>
                    <option value="اللغة">اللغة</option>
                    <option value="التفسير">التفسير</option>
                    <option value="الفقه">الفقه</option>
                    <option value="المقاصد">المقاصد</option>
                  </select>

                  <!-- فلتر الترتيب -->
                  <select class="toolbar-select">
                    <option>الترتيب</option>
                    <option>الأحدث</option>
                    <option>الأقدم</option>
                    <option>أبجدياً</option>
                    <option>الصفحات</option>
                  </select>

                  <!-- زر وقائمة تحديد الأعمدة المعروضة (مطابقة تماماً لحقول مايجريشن books) -->
                  <div class="columns-picker-wrapper">
                    <button class="toolbar-btn" id="btnToggleColumns" onclick="toggleColumnsDropdown(event)" title="تحديد الأعمدة الظاهرة المستمدة من المايجريشن">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"/>
                      </svg>
                      <span>الأعمدة</span>
                    </button>

                    <div id="columnsDropdownMenu" class="columns-dropdown-menu">
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(2, this.checked)">
                        <span>الرقم</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked disabled title="عمود أساسي">
                        <span>العنوان</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(4, this.checked)">
                        <span>المعرف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(5, this.checked)">
                        <span>المؤلف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(6, this.checked)">
                        <span>الرقم الدولي</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(7, this.checked)">
                        <span>الوصف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(8, this.checked)">
                        <span>الملفات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(9, this.checked)">
                        <span>التاريخ</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(10, this.checked)">
                        <span>الإجراءات</span>
                      </label>
                      <div class="columns-menu-divider"></div>
                      <button type="button" class="columns-reset-btn" onclick="resetAllColumns()">إظهار الكل</button>
                    </div>
                  </div>

                  <!-- View Mode Toggle (جدول / بطاقات) -->
                  <div class="view-mode-toggle">
                    <button class="view-mode-btn active" id="btnViewTable" onclick="toggleBooksView('table')" title="عرض الجدول المدمج">
                      <span>جدول</span>
                    </button>
                    <button class="view-mode-btn" id="btnViewGrid" onclick="toggleBooksView('grid')" title="عرض البطاقات">
                      <span>بطاقات</span>
                    </button>
                  </div>
                </div>

              </div>

              <!-- Bulk Actions Strip -->
              <div id="bulkActionsStrip" class="bulk-actions-strip">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; color: var(--indigo);">
                  <span>✓</span>
                  <span id="bulkSelectedCount">المحدد (0)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                  <button class="btn-action-small" onclick="alert('تصدير المحدد...')">تصدير</button>
                  <button class="btn-action-small" style="color: var(--crimson); border-color: rgba(239, 68, 68, 0.3);" onclick="alert('حذف المحدد للمهملات...')">حذف</button>
                </div>
              </div>

            </div>

            <!-- 1. HIGH-DENSITY DATA TABLE VIEW (مطابقة تامة لجدول books في المايجريشن) -->
            <div id="booksTableView" class="dense-table-wrapper">
              <table class="dense-table" id="booksDataTable">
                <thead>
                  <tr>
                    <th style="width: 36px; text-align: center;">
                      <input type="checkbox" id="masterCheckbox" onchange="toggleSelectAllBooks(this)" style="cursor: pointer;">
                    </th>
                    <th style="width: 70px;" class="sortable">الرقم ⇅</th>
                    <th class="sortable">العنوان ⇅</th>
                    <th style="width: 110px;" class="sortable">المعرف ⇅</th>
                    <th class="sortable">المؤلف ⇅</th>
                    <th style="width: 120px;" class="sortable">الرقم الدولي ⇅</th>
                    <th class="sortable">الوصف</th>
                    <th style="width: 90px; text-align: center;">الملفات</th>
                    <th style="width: 85px;" class="sortable">التاريخ ⇅</th>
                    <th style="width: 110px; text-align: center;">الإجراءات</th>
                  </tr>
                </thead>
                <tbody id="booksTableBody">

                  <!-- Row 1 -->
                  <tr data-title="فتح الباري شرح صحيح البخاري" data-author="ابن حجر العسقلاني" data-isbn="978-977-256-401-2">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10401</td>
                    <td>
                      <a href="/books/fath-al-bari/reader" class="book-title-link">فتح الباري شرح صحيح البخاري</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">fath-al-bari</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">ابن حجر العسقلاني</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-977-256-401-2</td>
                    <td><div class="cell-desc" title="أعظم شروح صحيح البخاري وأجمعها، ضبط ألفاظه واستنباط أحكامه الفقهية والحديثية.">أعظم شروح صحيح البخاري وأجمعها، ضبط ألفاظه واستنباط أحكامه الفقهية والحديثية.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ ساعتين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/fath-al-bari/reader" class="table-btn-icon" title="فتح القارئ التفاعلي">📖</a>
                        <a href="/studio/book/fath-al-bari" class="table-btn-icon" title="فتح محرر الاستوديو">✍️</a>
                        <a href="/books/1/edit" class="table-btn-icon" title="تعديل بيانات المصنف">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="نقل لسلة المهملات" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 2 -->
                  <tr data-title="المستصفى من علم الأصول" data-author="الإمام الغزالي" data-isbn="978-9953-34-118-0">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10402</td>
                    <td>
                      <a href="/books/al-mustasfa/reader" class="book-title-link">المستصفى من علم الأصول</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">al-mustasfa</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">الإمام الغزالي</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-9953-34-118-0</td>
                    <td><div class="cell-desc" title="من أمهات كتب أصول الفقه الشافعي والمقارن، وتقسيم مدارك الأحكام ومراتب الأدلة.">من أمهات كتب أصول الفقه الشافعي والمقارن، وتقسيم مدارك الأحكام ومراتب الأدلة.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">أمس</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/al-mustasfa/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/al-mustasfa" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/2/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 3 -->
                  <tr data-title="مجموع الفتاوى لشيخ الإسلام" data-author="ابن تيمية" data-isbn="978-603-500-025-4">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10403</td>
                    <td>
                      <a href="/books/majmu-al-fatawa/reader" class="book-title-link">مجموع الفتاوى لشيخ الإسلام</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">majmu-al-fatawa</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">ابن تيمية</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-603-500-025-4</td>
                    <td><div class="cell-desc" title="الفتاوى الكبرى الجامعة في التوحيد والعقيدة وأصول الفقه والتفسير والحديث والسلوك.">الفتاوى الكبرى الجامعة في التوحيد والعقيدة وأصول الفقه والتفسير والحديث والسلوك.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ يومين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/majmu-al-fatawa/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/majmu-al-fatawa" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/3/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 4 -->
                  <tr data-title="سير أعلام النبلاء" data-author="الإمام الذهبي" data-isbn="978-9953-417-01-1">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10404</td>
                    <td>
                      <a href="/books/siyar-a-lam/reader" class="book-title-link">سير أعلام النبلاء</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">siyar-a-lam</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">الإمام الذهبي</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-9953-417-01-1</td>
                    <td><div class="cell-desc" title="موسوعة تراجم كبرى جامعة لسير الصحابة والتابعين والأئمة والحفاظ والخلفاء عبر التاريخ.">موسوعة تراجم كبرى جامعة لسير الصحابة والتابعين والأئمة والحفاظ والخلفاء عبر التاريخ.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ 3 أيام</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/siyar-a-lam/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/siyar-a-lam" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/4/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 5 -->
                  <tr data-title="لسان العرب المحيط" data-author="ابن منظور الإفريقي" data-isbn="978-27451-1407-5">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10405</td>
                    <td>
                      <a href="/books/lisan-al-arab/reader" class="book-title-link">لسان العرب المحيط</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">lisan-al-arab</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">ابن منظور الإفريقي</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-27451-1407-5</td>
                    <td><div class="cell-desc" title="معجم لغوي تراثي موسوعي جمع متن لغة العرب واستشهد بآيات القرآن والحديث والشعر.">معجم لغوي تراثي موسوعي جمع متن لغة العرب واستشهد بآيات القرآن والحديث والشعر.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوع</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/lisan-al-arab/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/lisan-al-arab" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/5/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 6 -->
                  <tr data-title="جامع البيان عن تأويل آي القرآن (تفسير الطبري)" data-author="ابن جرير الطبري" data-isbn="978-977-342-890-4">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10406</td>
                    <td>
                      <a href="/books/tafsir-al-tabari/reader" class="book-title-link">جامع البيان عن تأويل آي القرآن (تفسير الطبري)</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">tafsir-al-tabari</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">ابن جرير الطبري</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-977-342-890-4</td>
                    <td><div class="cell-desc" title="عمدة كتب التفسير بالمأثور، يجمع الآثار المسندة عن الصحابة والتابعين والوجوه الإعرابية.">عمدة كتب التفسير بالمأثور، يجمع الآثار المسندة عن الصحابة والتابعين والوجوه الإعرابية.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوع</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/tafsir-al-tabari/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/tafsir-al-tabari" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/6/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 7 -->
                  <tr data-title="المغني في فقه الإمام أحمد بن حنبل" data-author="ابن قدامة المقدسي" data-isbn="978-977-205-045-8">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10407</td>
                    <td>
                      <a href="/books/al-mughni/reader" class="book-title-link">المغني في فقه الإمام أحمد بن حنبل</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">al-mughni</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">ابن قدامة المقدسي</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-977-205-045-8</td>
                    <td><div class="cell-desc" title="أشمل كتب الفقه الحنبلي المقارن بمذاهب فقهاء الأمصار مع إيراد أدلة الأحكام والمناظرة.">أشمل كتب الفقه الحنبلي المقارن بمذاهب فقهاء الأمصار مع إيراد أدلة الأحكام والمناظرة.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوعين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/books/al-mughni/reader" class="table-btn-icon" title="فتح القارئ">📖</a>
                        <a href="/studio/book/al-mughni" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/books/7/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 8 -->
                  <tr data-title="الموافقات في أصول الشريعة" data-author="الإمام الشاطبي" data-isbn="978-9957-65-102-3">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onBookRowCheckboxChange(this)"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#10408</td>
                    <td>
                      <a href="/books/al-muwafaqat/reader" class="book-title-link">الموافقات في أصول الشريعة</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">al-muwafaqat</td>
                    <td>
                      <div style="font-weight: 700;"><a href="/authors" style="color: var(--text-main); text-decoration: none;">الإمام الشاطبي</a></div>
                    </td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-muted); font-size: 0.75rem;">978-9957-65-102-3</td>
                    <td><div class="cell-desc" title="التأصيل العلمي لفقه مقاصد الشريعة الإسلامية ورعاية مصالح العباد الكلية والجزئية.">التأصيل العلمي لفقه مقاصد الشريعة الإسلامية ورعاية مصالح العباد الكلية والجزئية.</div></td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="cover_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="file_path متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📄 PDF</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: #fbbf24; font-family: 'Outfit';">نشط الآن</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/studio/book/al-muwafaqat" class="table-btn-icon" style="background: rgba(16,185,129,0.15); color: #34d399; border-color: rgba(16,185,129,0.3);" title="استكمال في الاستوديو">✍️</a>
                        <a href="/books/8/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الكتاب للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>

            <!-- 2. CARDS VIEW (ALTERNATIVE OPTION) -->
            <div id="booksGridView" class="catalog-grid" style="display: none; padding: 1.25rem;">
              <!-- Book Card 1 -->
              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-public">منشور 🌐</span>
                  <h3 class="entity-title">فتح الباري شرح صحيح البخاري</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">ابن حجر العسقلاني</span>
                    <span class="meta-chip category">شروح الحديث</span>
                    <span class="meta-chip">13 مجلد</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">أعظم شروح صحيح البخاري وأجمعها، محقق ومفهرس على 13 مجلداً.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/books/fath-al-bari/reader" class="btn-indigo-small">📖 القارئ</a>
                    <a href="/studio/book/fath-al-bari" class="btn-emerald-small">✍️ الاستوديو</a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">منذ ساعتين</span>
                </div>
              </div>

              <!-- Book Card 2 -->
              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-scholarly">محكّم علمياً 🎓</span>
                  <h3 class="entity-title">المستصفى من علم الأصول</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">الإمام الغزالي</span>
                    <span class="meta-chip category">أصول الفقه</span>
                    <span class="meta-chip">2 مجلد</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">من أمهات كتب أصول الفقه، تم تدقيقه ومطابقته على نسختين خطيتين.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/books/al-mustasfa/reader" class="btn-indigo-small">📖 القارئ</a>
                    <a href="/studio/book/al-mustasfa" class="btn-emerald-small">✍️ الاستوديو</a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">أمس</span>
                </div>
              </div>
            </div>

            <!-- Enterprise Pagination Bar -->
            <div class="table-pagination-bar">
              <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                <div>
                  <span>عرض </span>
                  <strong style="color: var(--text-main); font-family: 'Outfit';">1 - 8</strong>
                  <span> من أصل </span>
                  <strong style="color: var(--text-main); font-family: 'Outfit';">248,510</strong>
                  <span> كتاب</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <span>عرض:</span>
                  <select class="toolbar-select" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">
                    <option>25 في الصفحة</option>
                    <option>50 في الصفحة</option>
                    <option>100 في الصفحة</option>
                    <option>250 في الصفحة</option>
                  </select>
                </div>
              </div>

              <!-- Page navigation numbers -->
              <div class="pagination-pages-group">
                <button class="page-btn" disabled title="الصفحة الأولى">««</button>
                <button class="page-btn" disabled title="السابق">‹ السابق</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <span style="color: var(--text-dim); padding: 0 0.2rem;">...</span>
                <button class="page-btn">9,940</button>
                <button class="page-btn" title="التالي">التالي ›</button>
                <button class="page-btn" title="الصفحة الأخيرة">»»</button>
              </div>

              <!-- Quick jump to page -->
              <div style="display: flex; align-items: center; gap: 0.4rem;">
                <span>الانتقال لصفحة:</span>
                <input type="number" min="1" max="9940" value="1" style="width: 55px; background: rgba(255,255,255,0.04); border: 1px solid var(--border-subtle); border-radius: 6px; padding: 0.2rem 0.4rem; color: var(--text-main); text-align: center; font-size: 0.75rem; font-family: 'Outfit'; outline: none;">
                <button class="btn-action-small" style="padding: 0.2rem 0.6rem; font-size: 0.72rem;">انتقال</button>
              </div>

            </div>

          </div>
        `
      },

      // ========================================================
      // 2. MANUSCRIPTS VIEW (المكتبة -> المخطوطات)
      // ========================================================
      manuscripts: {
        title: 'المخطوطات',
        group: 'المكتبة',
        render: () => `
          <!-- HORIZONTAL SPLIT BANNER (المخطوطات) -->
          <div class="horizontal-header-banner">
            
            <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع -->
            <div class="banner-kpi-col">
              
              <!-- Card 1: الكل -->
              <div class="kpi-h-card active" onclick="setQuickStatusFilter('', this)" title="عرض كامل خزانة المخطوطات">
                <div class="kpi-h-title">
                  <span>الكل</span>
                  <span style="font-size: 0.75rem;">📜</span>
                </div>
                <div class="kpi-h-value">48,920</div>
                <div class="kpi-h-bar"><div style="width: 100%; background: #6366f1;"></div></div>
                <div class="kpi-h-subtext"><span>الخزانة</span><span>100%</span></div>
              </div>

              <!-- Card 2: مرمم -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('مرمم', this)" title="عرض المخطوطات المرممة">
                <div class="kpi-h-title">
                  <span>مرمم</span>
                  <span style="font-size: 0.75rem;">🏛️</span>
                </div>
                <div class="kpi-h-value val-published">32,450</div>
                <div class="kpi-h-bar"><div style="width: 66%; background: #10b981;"></div></div>
                <div class="kpi-h-subtext"><span>متاح</span><span>66%</span></div>
              </div>

              <!-- Card 3: محكّم -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('محكّم', this)" title="عرض المخطوطات المحكّمة">
                <div class="kpi-h-title">
                  <span>محكّم</span>
                  <span style="font-size: 0.75rem;">🎓</span>
                </div>
                <div class="kpi-h-value val-scholarly">11,200</div>
                <div class="kpi-h-bar"><div style="width: 23%; background: #3b82f6;"></div></div>
                <div class="kpi-h-subtext"><span>معتمد</span><span>23%</span></div>
              </div>

              <!-- Card 4: مسودات -->
              <div class="kpi-h-card" onclick="setQuickStatusFilter('مسودة', this)" title="عرض المخطوطات قيد الترميم">
                <div class="kpi-h-title">
                  <span>مسودات</span>
                  <span style="font-size: 0.75rem;">✍️</span>
                </div>
                <div class="kpi-h-value val-draft">5,270</div>
                <div class="kpi-h-bar"><div style="width: 11%; background: #f59e0b;"></div></div>
                <div class="kpi-h-subtext"><span>الاستوديو</span><span>11%</span></div>
              </div>

            </div>

            <!-- دِف اليسار: أزرار الإجراءات التنفيذية (2 × 2 أيقونات فقط) -->
            <div class="banner-actions-col">
              
              <!-- 1. إضافة مخطوطة (Primary) -->
              <a href="/manuscripts/create" class="btn-grid-item btn-grid-primary" title="إضافة مخطوطة جديدة (+)" aria-label="إضافة مخطوطة">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
              </a>

              <!-- 2. تصدير الفهرس -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تصدير بيانات المخطوطات إلى ملف CSV / Excel...')" title="تصدير الفهرس (CSV/Excel)" aria-label="تصدير">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-export">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                  <polyline points="7 10 12 15 17 10"></polyline>
                  <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
              </button>

              <!-- 3. استيراد جماعي -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('استيراد لوحات ومخطوطات رقمية...')" title="استيراد لوحات مخطوطات" aria-label="استيراد">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-import">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                  <polyline points="17 8 12 3 7 8"></polyline>
                  <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
              </button>

              <!-- 4. تحديث الفهرس -->
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('جاري تحديث وإعادة فهرسة خزانة المخطوطات...')" title="تحديث الفهرس العام" aria-label="تحديث">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
                  <polyline points="23 4 23 10 17 10"></polyline>
                  <polyline points="1 20 1 14 7 14"></polyline>
                  <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
              </button>

            </div>

          </div>

          <!-- Enterprise High-Density Table Card (المخطوطات) -->
          <div class="enterprise-card">
            
            <!-- Toolbar -->
            <div class="table-toolbar">
              <div class="toolbar-row-primary">
                
                <!-- Instant Search Box -->
                <div class="toolbar-search-box">
                  <span class="toolbar-search-icon">🔍</span>
                  <input type="text" id="manuscriptsSearchInput" class="toolbar-search-input" placeholder="بحث..." oninput="filterTable('manuscriptsDataTable', this.value)">
                </div>

                <!-- Filters & View Switcher (قاعدة الكلمة الواحدة) -->
                <div class="toolbar-filters">
                  
                  <!-- فلتر الخط -->
                  <select class="toolbar-select">
                    <option value="">الخط</option>
                    <option>نسخ أندلسي</option>
                    <option>كوفي مشرقي</option>
                    <option>ثلث قديم</option>
                  </select>

                  <!-- فلتر الترتيب -->
                  <select class="toolbar-select">
                    <option>الترتيب</option>
                    <option>الأحدث</option>
                    <option>الأوراق</option>
                    <option>القرن</option>
                  </select>

                  <!-- زر وقائمة تحديد الأعمدة المعروضة (مايجريشن manuscripts) -->
                  <div class="columns-picker-wrapper">
                    <button class="toolbar-btn" id="btnToggleColumns_manuscripts" onclick="toggleColumnsDropdown(event, 'columnsDropdownMenu_manuscripts')" title="تحديد الأعمدة">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"/>
                      </svg>
                      <span>الأعمدة</span>
                    </button>

                    <div id="columnsDropdownMenu_manuscripts" class="columns-dropdown-menu">
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(2, this.checked, 'manuscriptsDataTable')">
                        <span>الرقم</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(3, this.checked, 'manuscriptsDataTable')">
                        <span>الكود</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked disabled title="عمود أساسي">
                        <span>العنوان</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(5, this.checked, 'manuscriptsDataTable')">
                        <span>العنوان الأصلي</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(6, this.checked, 'manuscriptsDataTable')">
                        <span>الفهرس</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(7, this.checked, 'manuscriptsDataTable')">
                        <span>الأجزاء</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(8, this.checked, 'manuscriptsDataTable')">
                        <span>بخطه</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(9, this.checked, 'manuscriptsDataTable')">
                        <span>الناسخ</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(10, this.checked, 'manuscriptsDataTable')">
                        <span>تاريخ النسخ</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(11, this.checked, 'manuscriptsDataTable')">
                        <span>القرن</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(12, this.checked, 'manuscriptsDataTable')">
                        <span>الخط</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(13, this.checked, 'manuscriptsDataTable')">
                        <span>الأبعاد</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(14, this.checked, 'manuscriptsDataTable')">
                        <span>الأسطر</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(15, this.checked, 'manuscriptsDataTable')">
                        <span>الأوراق</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(16, this.checked, 'manuscriptsDataTable')">
                        <span>الخزانة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(17, this.checked, 'manuscriptsDataTable')">
                        <span>الوصف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(18, this.checked, 'manuscriptsDataTable')">
                        <span>التقييدات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(19, this.checked, 'manuscriptsDataTable')">
                        <span>الفاتحة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(20, this.checked, 'manuscriptsDataTable')">
                        <span>الخاتمة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(21, this.checked, 'manuscriptsDataTable')">
                        <span>الملاحظات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(22, this.checked, 'manuscriptsDataTable')">
                        <span>الملفات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(23, this.checked, 'manuscriptsDataTable')">
                        <span>تاريخ الإضافة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(24, this.checked, 'manuscriptsDataTable')">
                        <span>الإجراءات</span>
                      </label>
                      <div class="columns-menu-divider"></div>
                      <button type="button" class="columns-reset-btn" onclick="resetAllColumns('manuscriptsDataTable', 'columnsDropdownMenu_manuscripts')">إظهار الكل</button>
                    </div>
                  </div>

                  <!-- View Mode Toggle (جدول / بطاقات) -->
                  <div class="view-mode-toggle">
                    <button class="view-mode-btn active" id="btnViewTable_manuscripts" onclick="toggleViewMode('manuscripts', 'table')" title="عرض الجدول">
                      <span>جدول</span>
                    </button>
                    <button class="view-mode-btn" id="btnViewGrid_manuscripts" onclick="toggleViewMode('manuscripts', 'grid')" title="عرض البطاقات">
                      <span>بطاقات</span>
                    </button>
                  </div>
                </div>

              </div>

              <!-- Bulk Actions Strip -->
              <div id="bulkActionsStrip_manuscripts" class="bulk-actions-strip">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; color: var(--indigo);">
                  <span>✓</span>
                  <span id="bulkSelectedCount_manuscripts">المحدد (0)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                  <button class="btn-action-small" onclick="alert('تصدير المحدد...')">تصدير</button>
                  <button class="btn-action-small" style="color: var(--crimson); border-color: rgba(239, 68, 68, 0.3);" onclick="alert('حذف المحدد...')">حذف</button>
                </div>
              </div>

            </div>

            <!-- 1. HIGH-DENSITY DATA TABLE VIEW -->
            <div id="manuscriptsTableView" class="dense-table-wrapper">
              <table class="dense-table" id="manuscriptsDataTable">
                <thead>
                  <tr>
                    <th style="width: 36px; text-align: center;">
                      <input type="checkbox" onchange="toggleSelectAllTable(this, 'manuscriptsDataTable', 'bulkActionsStrip_manuscripts', 'bulkSelectedCount_manuscripts')" style="cursor: pointer;">
                    </th>
                    <th style="width: 70px;" class="sortable">الرقم ⇅</th>
                    <th style="width: 90px;" class="sortable">الكود ⇅</th>
                    <th class="sortable">العنوان ⇅</th>
                    <th class="sortable">العنوان الأصلي ⇅</th>
                    <th style="width: 90px;" class="sortable">الفهرس ⇅</th>
                    <th style="width: 75px;" class="sortable">الأجزاء ⇅</th>
                    <th style="width: 85px; text-align: center;" class="sortable">بخطه ⇅</th>
                    <th style="width: 120px;" class="sortable">الناسخ ⇅</th>
                    <th style="width: 85px;" class="sortable">تاريخ النسخ ⇅</th>
                    <th style="width: 80px;" class="sortable">القرن ⇅</th>
                    <th style="width: 90px;" class="sortable">الخط ⇅</th>
                    <th style="width: 85px;" class="sortable">الأبعاد ⇅</th>
                    <th style="width: 70px;" class="sortable">الأسطر ⇅</th>
                    <th style="width: 75px;" class="sortable">الأوراق ⇅</th>
                    <th style="width: 110px;" class="sortable">الخزانة ⇅</th>
                    <th class="sortable">الوصف</th>
                    <th class="sortable">التقييدات</th>
                    <th class="sortable">الفاتحة</th>
                    <th class="sortable">الخاتمة</th>
                    <th class="sortable">الملاحظات</th>
                    <th style="width: 85px; text-align: center;">الملفات</th>
                    <th style="width: 85px;" class="sortable">تاريخ الإضافة ⇅</th>
                    <th style="width: 110px; text-align: center;">الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Row 1 -->
                  <tr data-title="صحيح البخاري - المجلد الرابع (نسخة كوبريلي)" data-scribe="شرف الدين اليونيني" data-cat="KOP-4820">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('manuscriptsDataTable', 'bulkActionsStrip_manuscripts', 'bulkSelectedCount_manuscripts')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#20101</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 600;">MS-KOP-01</td>
                    <td>
                      <a href="/dev/manuscripter/sahih-bukhari-koprulu" class="book-title-link">صحيح البخاري - المجلد الرابع</a>
                    </td>
                    <td style="font-size: 0.78rem; color: var(--text-muted);">الجامع المسند الصحيح المختصر</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">KOP-4820</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">المجلد 4</td>
                    <td style="text-align: center;"><span style="color: var(--text-dim); font-size: 0.7rem;">مقابلة</span></td>
                    <td>
                      <div style="font-weight: 700;">شرف الدين اليونيني</div>
                    </td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem; color: var(--text-muted);">698هـ</td>
                    <td style="font-size: 0.75rem;">القرن 7هـ</td>
                    <td><span class="role-chip chip-editor">نسخ أندلسي</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">29 × 21 سم</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">25 سطر</td>
                    <td style="font-family: 'Outfit'; font-weight: 600;">342 ورقة</td>
                    <td>مكتبة كوبريلي</td>
                    <td>
                      <div class="cell-desc" title="نسخة خزائنية متقنة قوبلت وصُححت على أصل الحافظ اليونيني مع حواشٍ وضوابط نادرة.">
                        نسخة خزائنية متقنة قوبلت وصُححت على أصل الحافظ اليونيني مع حواشٍ وضوابط نادرة.
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="سماعات ومقابلات بخط اليونيني وابن مالك النحوي ومحمد بن أبي الفتح البعلي">
                        سماعات ومقابلات بخط اليونيني وابن مالك النحوي ومحمد بن أبي الفتح البعلي
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="أخبرنا الشيخ الإمام الحافظ شرف الدين أبو الحسين علي بن أحمد المقدسي قراءة عليه ونحن نسمع...">
                        أخبرنا الشيخ الإمام الحافظ شرف الدين أبو الحسين علي بن أحمد المقدسي قراءة عليه ونحن نسمع...
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="آخر كتاب الصوم من تجزئة سبعة، والحمد لله رب العالمين وصلواته على سيدنا محمد وآله وصحبه وسلم...">
                        آخر كتاب الصوم من تجزئة سبعة، والحمد لله رب العالمين وصلواته على سيدنا محمد وآله وصحبه وسلم...
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="أصل عمدة المقابلة اليونينية المعتمدة في ضبط ألفاظ وروايات الجامع الصحيح">
                        أصل عمدة المقابلة اليونينية المعتمدة في ضبط ألفاظ وروايات الجامع الصحيح
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="342 لوحة متوفرة" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📜 لوحات</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوع</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/manuscripter/sahih-bukhari-koprulu" class="table-btn-icon" title="معمل الفحص">🔬</a>
                        <a href="/studio/manuscript/sahih-bukhari-koprulu" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/manuscripts/1/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المخطوط للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 2 -->
                  <tr data-title="ديوان الحماسة لأبي تمام" data-scribe="يحيى بن محمود الواسطي" data-cat="BNF-1140">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('manuscriptsDataTable', 'bulkActionsStrip_manuscripts', 'bulkSelectedCount_manuscripts')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#20102</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 600;">MS-BNF-02</td>
                    <td>
                      <a href="/dev/manuscripter/diwan-al-hamasa" class="book-title-link">ديوان الحماسة لأبي تمام</a>
                    </td>
                    <td style="font-size: 0.78rem; color: var(--text-muted);">كتاب الحماسة المختارة من أشعار العرب</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">BNF-1140</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">كامل</td>
                    <td style="text-align: center;"><span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; font-weight: 700; padding: 0.12rem 0.35rem; border-radius: 4px; font-size: 0.68rem;">✍️ أوتوغراف</span></td>
                    <td>
                      <div style="font-weight: 700;">يحيى الواسطي</div>
                    </td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem; color: var(--text-muted);">634هـ</td>
                    <td style="font-size: 0.75rem;">القرن 7هـ</td>
                    <td><span class="role-chip chip-editor">كوفي مشرقي</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">25 × 18 سم</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">17 سطر</td>
                    <td style="font-family: 'Outfit'; font-weight: 600;">128 ورقة</td>
                    <td>خزانة باريس</td>
                    <td>
                      <div class="cell-desc" title="مخطوط نادر مزخرف ومذهب يحوي نماذج من روائع الشعر العربي مع رسوم توضيحية فريدة.">
                        مخطوط نادر مزخرف ومذهب يحوي نماذج من روائع الشعر العربي مع رسوم توضيحية فريدة.
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="قيود تملك خزائنية لخزانة المستعصم بالله العباسي وقيد شراء بدمشق">
                        قيود تملك خزائنية لخزانة المستعصم بالله العباسي وقيد شراء بدمشق
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="باب الحماسة، قال ظفر بن الحارث الكلابي: لعمرك ما خشيت على قريش...">
                        باب الحماسة، قال ظفر بن الحارث الكلابي: لعمرك ما خشيت على قريش...
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="تم الديوان بحمد الله وعونه على يد مصوره وكاتبه يحيى بن محمود الواسطي سنة 634هـ">
                        تم الديوان بحمد الله وعونه على يد مصوره وكاتبه يحيى بن محمود الواسطي سنة 634هـ
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="تحفة المدرسة البغدادية النادرة في التصوير الإسلامي والمنمنمات">
                        تحفة المدرسة البغدادية النادرة في التصوير الإسلامي والمنمنمات
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="128 لوحة متوفرة" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📜 لوحات</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوعين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/manuscripter/diwan-al-hamasa" class="table-btn-icon" title="معمل الفحص">🔬</a>
                        <a href="/studio/manuscript/diwan-al-hamasa" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/manuscripts/2/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المخطوط للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 3 -->
                  <tr data-title="الرسالة للإمام الشافعي" data-scribe="الربيع بن سليمان" data-cat="DKT-0891">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('manuscriptsDataTable', 'bulkActionsStrip_manuscripts', 'bulkSelectedCount_manuscripts')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#20103</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 600;">MS-DKT-03</td>
                    <td>
                      <a href="/dev/manuscripter/al-risala-shafii" class="book-title-link">الرسالة للإمام الشافعي</a>
                    </td>
                    <td style="font-size: 0.78rem; color: var(--text-muted);">كتاب الرسالة في أصول الفقه</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">DKT-0891</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">جزء واحد</td>
                    <td style="text-align: center;"><span style="background: rgba(16, 185, 129, 0.15); color: #10b981; font-weight: 700; padding: 0.12rem 0.35rem; border-radius: 4px; font-size: 0.68rem;">✍️ بخط التلميذ</span></td>
                    <td>
                      <div style="font-weight: 700;">الربيع بن سليمان</div>
                    </td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem; color: var(--text-muted);">260هـ</td>
                    <td style="font-size: 0.75rem;">القرن 3هـ</td>
                    <td><span class="role-chip chip-editor">نسخي قديم</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">26 × 19 سم</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">19 سطر</td>
                    <td style="font-family: 'Outfit'; font-weight: 600;">210 ورقة</td>
                    <td>دار الكتب المصرية</td>
                    <td>
                      <div class="cell-desc" title="أقدم أصل أصولي مقروء على المصنف، يمثل الركيزة الأولى في علم أصول الفقه وتدوينه.">
                        أقدم أصل أصولي مقروء على المصنف، يمثل الركيزة الأولى في علم أصول الفقه وتدوينه.
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="سماع بقراءة الربيع بن سليمان على الإمام محمد بن إدريس الشافعي بفسطاط مصر سنة 204هـ">
                        سماع بقراءة الربيع بن سليمان على الإمام محمد بن إدريس الشافعي بفسطاط مصر سنة 204هـ
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="الحمد لله الذي لا يؤدى شكر نعمة من نعمه إلا بنعمة منه توجب على مؤدي ماض شكرها...">
                        الحمد لله الذي لا يؤدى شكر نعمة من نعمه إلا بنعمة منه توجب على مؤدي ماض شكرها...
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="آخر كتاب الرسالة، والحمد لله رب العالمين وصلى الله على سيدنا محمد وآله وصحبه وسلم كثيراً">
                        آخر كتاب الرسالة، والحمد لله رب العالمين وصلى الله على سيدنا محمد وآله وصحبه وسلم كثيراً
                      </div>
                    </td>
                    <td>
                      <div class="cell-desc" title="أقدم وثيقة ومخطوط فقهي أصولي أصيل متاح في العالم الإسلامي">
                        أقدم وثيقة ومخطوط فقهي أصولي أصيل متاح في العالم الإسلامي
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="210 لوحة متوفرة" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">📜 لوحات</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ شهر</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/manuscripter/al-risala-shafii" class="table-btn-icon" title="معمل الفحص">🔬</a>
                        <a href="/studio/manuscript/al-risala-shafii" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/manuscripts/3/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المخطوط للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- 2. CARDS VIEW (ALTERNATIVE) -->
            <div id="manuscriptsGridView" class="catalog-grid" style="display: none; padding: 1.25rem;">
              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-scholarly">نسخة كوبريلي 🏛️</span>
                  <h3 class="entity-title">صحيح البخاري - المجلد الرابع</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">خط نسخ أندلسي</span>
                    <span class="meta-chip category">342 لوحة عالية الدقة</span>
                    <span class="meta-chip">القرن السابع الهجري</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">نسخة نفيسة مقابلة على أصل الإمام اليونيني مع حواشٍ مضبوطة بالشكل التام.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/manuscripter/sahih-bukhari-koprulu" class="btn-amber-small" title="معمل الفحص"><span>🔬 معمل الفحص</span></a>
                    <a href="/studio/manuscript/sahih-bukhari-koprulu" class="btn-emerald-small" title="الاستوديو"><span>✍️ الاستوديو</span></a>
                    <a href="/manuscripts/1/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">342 لوحة</span>
                </div>
              </div>

              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-public">خزانة باريس 🏛️</span>
                  <h3 class="entity-title">ديوان الحماسة لأبي تمام</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">خط كوفي مشرقي</span>
                    <span class="meta-chip category">128 لوحة ملونة</span>
                    <span class="meta-chip">مذهبة ومزخرفة</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">نسخة تراثية فريدة تتميز بعناوين الأبواب المذهبة وهوامش التفسير اللغوي.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/manuscripter/diwan-al-hamasa" class="btn-amber-small"><span>🔬 معمل الفحص</span></a>
                    <a href="/studio/manuscript/diwan-al-hamasa" class="btn-emerald-small"><span>✍️ الاستوديو</span></a>
                    <a href="/manuscripts/2/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">128 لوحة</span>
                </div>
              </div>

              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-draft">دار الكتب المصرية 🏛️</span>
                  <h3 class="entity-title">الرسالة للإمام الشافعي</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">خط الربيع بن سليمان</span>
                    <span class="meta-chip category">210 لوحات</span>
                    <span class="meta-chip">أقدم أصل أصولي</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">النسخة المقروءة على المصنف، جاري تفريغ نصوصها ومطابقتها حرفياً بالأستوديو.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/manuscripter/al-risala-shafii" class="btn-amber-small"><span>🔬 معمل الفحص</span></a>
                    <a href="/studio/manuscript/al-risala-shafii" class="btn-emerald-small"><span>✍️ الاستوديو</span></a>
                    <a href="/manuscripts/3/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: #fbbf24; font-family: 'Outfit';">تحت الترميم</span>
                </div>
              </div>
            </div>

            <!-- Pagination Bar -->
            <div class="table-pagination-bar">
              <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                <div><span>عرض </span><strong style="color: var(--text-main); font-family: 'Outfit';">1 - 3</strong><span> من أصل </span><strong style="color: var(--text-main); font-family: 'Outfit';">48,920</strong><span> مخطوطة</span></div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <span>عرض:</span>
                  <select class="toolbar-select" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">
                    <option>25 في الصفحة</option><option>50 في الصفحة</option><option>100 في الصفحة</option>
                  </select>
                </div>
              </div>
              <div class="pagination-pages-group">
                <button class="page-btn" disabled>««</button><button class="page-btn" disabled>‹</button>
                <button class="page-btn active">1</button><button class="page-btn">2</button><button class="page-btn">3</button>
                <button class="page-btn">›</button><button class="page-btn">»»</button>
              </div>
            </div>

          </div>
        `
      },// ========================================================
      // 3. AUDIOS VIEW (المكتبة -> الصوتيات)
      // ========================================================
      audios: {
        title: 'الصوتيات',
        group: 'المكتبة',
        render: () => `
          <!-- HORIZONTAL SPLIT BANNER (الصوتيات) -->
          <div class="horizontal-header-banner">
            
            <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع -->
            <div class="banner-kpi-col">
              <div class="kpi-h-card active" onclick="setQuickStatusFilter('', this)" title="عرض كامل التسجيلات الصوتية">
                <div class="kpi-h-title"><span>الكل</span><span style="font-size: 0.75rem;">🎙️</span></div>
                <div class="kpi-h-value">14,680</div>
                <div class="kpi-h-bar"><div style="width: 100%; background: #6366f1;"></div></div>
                <div class="kpi-h-subtext"><span>الأرشيف</span><span>100%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('منشور', this)" title="عرض التسجيلات المنشورة">
                <div class="kpi-h-title"><span>منشور</span><span style="font-size: 0.75rem;">🌐</span></div>
                <div class="kpi-h-value val-published">11,820</div>
                <div class="kpi-h-bar"><div style="width: 81%; background: #10b981;"></div></div>
                <div class="kpi-h-subtext"><span>متاح</span><span>81%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('محكّم', this)" title="عرض التسجيلات المفرغة نصياً">
                <div class="kpi-h-title"><span>مفرّغ</span><span style="font-size: 0.75rem;">📝</span></div>
                <div class="kpi-h-value val-scholarly">2,140</div>
                <div class="kpi-h-bar"><div style="width: 15%; background: #3b82f6;"></div></div>
                <div class="kpi-h-subtext"><span>متزامن</span><span>15%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('مسودة', this)" title="عرض التسجيلات قيد المزامنة">
                <div class="kpi-h-title"><span>مسودات</span><span style="font-size: 0.75rem;">✍️</span></div>
                <div class="kpi-h-value val-draft">720</div>
                <div class="kpi-h-bar"><div style="width: 4%; background: #f59e0b;"></div></div>
                <div class="kpi-h-subtext"><span>الاستوديو</span><span>4%</span></div>
              </div>
            </div>

            <!-- دِف اليسار: أزرار الإجراءات التنفيذية -->
            <div class="banner-actions-col">
              <a href="/audios/create" class="btn-grid-item btn-grid-primary" title="إضافة تسجيل جديد (+)" aria-label="إضافة صوتي">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
              </a>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تصدير بيانات الصوتيات...')" title="تصدير (CSV/Excel)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-export">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
              </button>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('استيراد تسجيلات صوتية...')" title="استيراد صوتيات">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-import">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
              </button>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تحديث فهرس الصوتيات...')" title="تحديث">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
                  <polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
              </button>
            </div>

          </div>

          <!-- Enterprise High-Density Table Card (الصوتيات) -->
          <div class="enterprise-card">
            
            <!-- Toolbar -->
            <div class="table-toolbar">
              <div class="toolbar-row-primary">
                <div class="toolbar-search-box">
                  <span class="toolbar-search-icon">🔍</span>
                  <input type="text" id="audiosSearchInput" class="toolbar-search-input" placeholder="بحث..." oninput="filterTable('audiosDataTable', this.value)">
                </div>

                <div class="toolbar-filters">
                  <select class="toolbar-select">
                    <option value="">الصيغة</option>
                    <option>MP3</option><option>FLAC</option><option>WAV</option>
                  </select>
                  <select class="toolbar-select">
                    <option>الترتيب</option><option>الأحدث</option><option>المدة</option><option>الحجم</option>
                  </select>

                  <!-- Columns Picker -->
                  <div class="columns-picker-wrapper">
                    <button class="toolbar-btn" id="btnToggleColumns_audios" onclick="toggleColumnsDropdown(event, 'columnsDropdownMenu_audios')" title="تحديد الأعمدة">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"/>
                      </svg>
                      <span>الأعمدة</span>
                    </button>

                    <div id="columnsDropdownMenu_audios" class="columns-dropdown-menu">
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(2, this.checked, 'audiosDataTable')">
                        <span>الرقم</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked disabled title="عمود أساسي">
                        <span>العنوان</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(4, this.checked, 'audiosDataTable')">
                        <span>الكود</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(5, this.checked, 'audiosDataTable')">
                        <span>المعرف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(6, this.checked, 'audiosDataTable')">
                        <span>المدة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(7, this.checked, 'audiosDataTable')">
                        <span>الصيغة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(8, this.checked, 'audiosDataTable')">
                        <span>معدل البت</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(9, this.checked, 'audiosDataTable')">
                        <span>التردد</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(10, this.checked, 'audiosDataTable')">
                        <span>الحجم</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(11, this.checked, 'audiosDataTable')">
                        <span>الوصف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(12, this.checked, 'audiosDataTable')">
                        <span>الملفات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(13, this.checked, 'audiosDataTable')">
                        <span>التاريخ</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(14, this.checked, 'audiosDataTable')">
                        <span>الإجراءات</span>
                      </label>
                      <div class="columns-menu-divider"></div>
                      <button type="button" class="columns-reset-btn" onclick="resetAllColumns('audiosDataTable', 'columnsDropdownMenu_audios')">إظهار الكل</button>
                    </div>
                  </div>

                  <!-- View Mode Toggle -->
                  <div class="view-mode-toggle">
                    <button class="view-mode-btn active" id="btnViewTable_audios" onclick="toggleViewMode('audios', 'table')" title="عرض الجدول">
                      <span>جدول</span>
                    </button>
                    <button class="view-mode-btn" id="btnViewGrid_audios" onclick="toggleViewMode('audios', 'grid')" title="عرض البطاقات">
                      <span>بطاقات</span>
                    </button>
                  </div>
                </div>
              </div>

              <div id="bulkActionsStrip_audios" class="bulk-actions-strip">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; color: var(--indigo);">
                  <span>✓</span><span id="bulkSelectedCount_audios">المحدد (0)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                  <button class="btn-action-small" onclick="alert('تصدير المحدد...')">تصدير</button>
                  <button class="btn-action-small" style="color: var(--crimson); border-color: rgba(239, 68, 68, 0.3);" onclick="alert('حذف المحدد...')">حذف</button>
                </div>
              </div>
            </div>

            <!-- Table View -->
            <div id="audiosTableView" class="dense-table-wrapper">
              <table class="dense-table" id="audiosDataTable">
                <thead>
                  <tr>
                    <th style="width: 36px; text-align: center;">
                      <input type="checkbox" onchange="toggleSelectAllTable(this, 'audiosDataTable', 'bulkActionsStrip_audios', 'bulkSelectedCount_audios')" style="cursor: pointer;">
                    </th>
                    <th style="width: 70px;" class="sortable">الرقم ⇅</th>
                    <th class="sortable">العنوان ⇅</th>
                    <th style="width: 95px;" class="sortable">الكود ⇅</th>
                    <th style="width: 120px;" class="sortable">المعرف ⇅</th>
                    <th style="width: 80px;" class="sortable">المدة ⇅</th>
                    <th style="width: 75px;" class="sortable">الصيغة ⇅</th>
                    <th style="width: 85px;" class="sortable">معدل البت ⇅</th>
                    <th style="width: 85px;" class="sortable">التردد ⇅</th>
                    <th style="width: 75px;" class="sortable">الحجم ⇅</th>
                    <th class="sortable">الوصف</th>
                    <th style="width: 85px; text-align: center;">الملفات</th>
                    <th style="width: 85px;" class="sortable">التاريخ ⇅</th>
                    <th style="width: 110px; text-align: center;">الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Row 1 -->
                  <tr data-title="مجلس سنن أبي داود - باب الطهارة" data-code="AUD-ABD-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('audiosDataTable', 'bulkActionsStrip_audios', 'bulkSelectedCount_audios')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#30101</td>
                    <td>
                      <a href="/dev/player/audio/sunan-abi-dawud-01" class="book-title-link">مجلس سنن أبي داود - باب الطهارة</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">AUD-ABD-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">sunan-abi-dawud-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">01:24:15</td>
                    <td><span class="role-chip chip-editor">MP3</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">320 kbps</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">44.1 kHz</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">115 MB</td>
                    <td>
                      <div class="cell-desc" title="تسجيل صوتي عالي النقاء لمجلس السنن مع ضبط الروايات والتعليق على الأحاديث.">
                        تسجيل صوتي عالي النقاء لمجلس السنن مع ضبط الروايات والتعليق على الأحاديث.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="ملف صوتي MP3" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎵 MP3</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ 3 أيام</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/audio/sunan-abi-dawud-01" class="table-btn-icon" title="المشغل">🎧</a>
                        <a href="/studio/audio/sunan-abi-dawud-01" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/audios/1/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الملف الصوتي للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 2 -->
                  <tr data-title="شرح كتاب التوحيد - المجلس الأول" data-code="AUD-TWH-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('audiosDataTable', 'bulkActionsStrip_audios', 'bulkSelectedCount_audios')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#30102</td>
                    <td>
                      <a href="/dev/player/audio/sharh-kitab-tawhid-01" class="book-title-link">شرح كتاب التوحيد - المجلس الأول</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">AUD-TWH-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">sharh-kitab-tawhid-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">00:58:30</td>
                    <td><span class="role-chip chip-editor">MP3</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">320 kbps</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">48.0 kHz</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">82 MB</td>
                    <td>
                      <div class="cell-desc" title="مقدمة تمهيدية في بيان أصول العقيدة وأهمية تجريد التوحيد ودلائل ذلك من الكتاب والسنة.">
                        مقدمة تمهيدية في بيان أصول العقيدة وأهمية تجريد التوحيد ودلائل ذلك من الكتاب والسنة.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="ملف صوتي MP3" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎵 MP3</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوع</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/audio/sharh-kitab-tawhid-01" class="table-btn-icon" title="المشغل">🎧</a>
                        <a href="/studio/audio/sharh-kitab-tawhid-01" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/audios/2/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الملف الصوتي للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 3 -->
                  <tr data-title="مقدمة في علوم القرآن والقراءات" data-code="AUD-QRN-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('audiosDataTable', 'bulkActionsStrip_audios', 'bulkSelectedCount_audios')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#30103</td>
                    <td>
                      <a href="/dev/player/audio/ulum-al-quran-01" class="book-title-link">مقدمة في علوم القرآن والقراءات</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">AUD-QRN-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">ulum-al-quran-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">01:05:20</td>
                    <td><span class="role-chip chip-editor">MP3</span></td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">256 kbps</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">44.1 kHz</td>
                    <td style="font-family: 'Outfit'; font-size: 0.75rem;">75 MB</td>
                    <td>
                      <div class="cell-desc" title="محاضرة منهجية في نشأة علوم القرآن وتاريخ تدوين المصحف الشريف وضبط أحرفه.">
                        محاضرة منهجية في نشأة علوم القرآن وتاريخ تدوين المصحف الشريف وضبط أحرفه.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="ملف صوتي MP3" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎵 MP3</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوعين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/audio/ulum-al-quran-01" class="table-btn-icon" title="المشغل">🎧</a>
                        <a href="/studio/audio/ulum-al-quran-01" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/audios/3/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل الملف الصوتي للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Cards View -->
            <div id="audiosGridView" class="catalog-grid" style="display: none; padding: 1.25rem;">
              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-public">مفرغ ومتزامن 🎙️</span>
                  <h3 class="entity-title">مجلس سنن أبي داود - باب الطهارة</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">د. طارق الحارثي</span>
                    <span class="meta-chip category">01:24:15</span>
                    <span class="meta-chip">42 شريحة مفرغة</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">تسجيل نقي عالي الجودة مع شريط زمني تفاعلي يربط الصوت بالنص المكتوب لحظة بلحظة.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/player/audio/sunan-abi-dawud-01" class="btn-indigo-small"><span>🎧 المشغل</span></a>
                    <a href="/studio/audio/sunan-abi-dawud-01" class="btn-emerald-small"><span>✍️ تفريغ الشرائح</span></a>
                    <a href="/audios/1/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">320 kbps</span>
                </div>
              </div>

              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-scholarly">محاضرة معتمدة 🎓</span>
                  <h3 class="entity-title">شرح كتاب التوحيد - المجلس الأول</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">أ.د. عبد الرحمن السليمان</span>
                    <span class="meta-chip category">00:58:30</span>
                    <span class="meta-chip">28 شريحة مفرغة</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">تسجيل مكتمل التدقيق اللغوي ومطابق للنص المقروء مع فهارس الآيات والأحاديث.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/player/audio/sharh-kitab-tawhid-01" class="btn-indigo-small"><span>🎧 المشغل</span></a>
                    <a href="/studio/audio/sharh-kitab-tawhid-01" class="btn-emerald-small"><span>✍️ تفريغ الشرائح</span></a>
                    <a href="/audios/2/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">320 kbps</span>
                </div>
              </div>
            </div>

            <!-- Pagination Bar -->
            <div class="table-pagination-bar">
              <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                <div><span>عرض </span><strong style="color: var(--text-main); font-family: 'Outfit';">1 - 2</strong><span> من أصل </span><strong style="color: var(--text-main); font-family: 'Outfit';">14,680</strong><span> تسجيلاً</strong></div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <span>عرض:</span>
                  <select class="toolbar-select" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">
                    <option>25 في الصفحة</option><option>50 في الصفحة</option><option>100 في الصفحة</option>
                  </select>
                </div>
              </div>
              <div class="pagination-pages-group">
                <button class="page-btn" disabled>««</button><button class="page-btn" disabled>‹</button>
                <button class="page-btn active">1</button><button class="page-btn">2</button><button class="page-btn">3</button>
                <button class="page-btn">›</button><button class="page-btn">»»</button>
              </div>
            </div>

          </div>
        `
      },// ========================================================
      // 4. VIDEOS VIEW (المكتبة -> المرئيات)
      // ========================================================
      videos: {
        title: 'المرئيات',
        group: 'المكتبة',
        render: () => `
          <!-- HORIZONTAL SPLIT BANNER (المرئيات) -->
          <div class="horizontal-header-banner">
            
            <!-- دِف اليمين: بطاقات الـ KPI الإحصائية الأربع -->
            <div class="banner-kpi-col">
              <div class="kpi-h-card active" onclick="setQuickStatusFilter('', this)" title="عرض كامل المحاضرات المرئية">
                <div class="kpi-h-title"><span>الكل</span><span style="font-size: 0.75rem;">🎬</span></div>
                <div class="kpi-h-value">8,420</div>
                <div class="kpi-h-bar"><div style="width: 100%; background: #6366f1;"></div></div>
                <div class="kpi-h-subtext"><span>الأرشيف</span><span>100%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('منشور', this)" title="عرض المرئيات المنشورة">
                <div class="kpi-h-title"><span>منشور</span><span style="font-size: 0.75rem;">🌐</span></div>
                <div class="kpi-h-value val-published">6,950</div>
                <div class="kpi-h-bar"><div style="width: 83%; background: #10b981;"></div></div>
                <div class="kpi-h-subtext"><span>متاح</span><span>83%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('محكّم', this)" title="عرض المرئيات المفهرسة">
                <div class="kpi-h-title"><span>مفهرس</span><span style="font-size: 0.75rem;">🎓</span></div>
                <div class="kpi-h-value val-scholarly">1,120</div>
                <div class="kpi-h-bar"><div style="width: 13%; background: #3b82f6;"></div></div>
                <div class="kpi-h-subtext"><span>معتمد</span><span>13%</span></div>
              </div>
              <div class="kpi-h-card" onclick="setQuickStatusFilter('مسودة', this)" title="عرض المرئيات قيد المونتاج">
                <div class="kpi-h-title"><span>مسودات</span><span style="font-size: 0.75rem;">✍️</span></div>
                <div class="kpi-h-value val-draft">350</div>
                <div class="kpi-h-bar"><div style="width: 4%; background: #f59e0b;"></div></div>
                <div class="kpi-h-subtext"><span>الاستوديو</span><span>4%</span></div>
              </div>
            </div>

            <!-- دِف اليسار: أزرار الإجراءات التنفيذية -->
            <div class="banner-actions-col">
              <a href="/videos/create" class="btn-grid-item btn-grid-primary" title="إضافة فيديو جديد (+)" aria-label="إضافة مرئية">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
              </a>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تصدير بيانات المرئيات...')" title="تصدير">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-export">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
              </button>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('استيراد ملفات مرئية...')" title="استيراد">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-import">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
              </button>
              <button class="btn-grid-item btn-grid-secondary" onclick="alert('تحديث فهرس المرئيات...')" title="تحديث">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
                  <polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
              </button>
            </div>

          </div>

          <!-- Enterprise High-Density Table Card (المرئيات) -->
          <div class="enterprise-card">
            
            <!-- Toolbar -->
            <div class="table-toolbar">
              <div class="toolbar-row-primary">
                <div class="toolbar-search-box">
                  <span class="toolbar-search-icon">🔍</span>
                  <input type="text" id="videosSearchInput" class="toolbar-search-input" placeholder="بحث..." oninput="filterTable('videosDataTable', this.value)">
                </div>

                <div class="toolbar-filters">
                  <select class="toolbar-select">
                    <option value="">الجودة</option>
                    <option>4K UHD</option><option>1080p FHD</option><option>720p HD</option>
                  </select>
                  <select class="toolbar-select">
                    <option>الترتيب</option><option>الأحدث</option><option>المدة</option>
                  </select>

                  <!-- Columns Picker -->
                  <div class="columns-picker-wrapper">
                    <button class="toolbar-btn" id="btnToggleColumns_videos" onclick="toggleColumnsDropdown(event, 'columnsDropdownMenu_videos')" title="تحديد الأعمدة">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"/>
                      </svg>
                      <span>الأعمدة</span>
                    </button>

                    <div id="columnsDropdownMenu_videos" class="columns-dropdown-menu">
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(2, this.checked, 'videosDataTable')">
                        <span>الرقم</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked disabled title="عمود أساسي">
                        <span>العنوان</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(4, this.checked, 'videosDataTable')">
                        <span>الكود</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(5, this.checked, 'videosDataTable')">
                        <span>المعرف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(6, this.checked, 'videosDataTable')">
                        <span>المدة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(7, this.checked, 'videosDataTable')">
                        <span>الصيغة</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(8, this.checked, 'videosDataTable')">
                        <span>الوصف</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(9, this.checked, 'videosDataTable')">
                        <span>الملفات</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(10, this.checked, 'videosDataTable')">
                        <span>التاريخ</span>
                      </label>
                      <label class="column-toggle-item">
                        <input type="checkbox" checked onchange="toggleColumnVisibility(11, this.checked, 'videosDataTable')">
                        <span>الإجراءات</span>
                      </label>
                      <div class="columns-menu-divider"></div>
                      <button type="button" class="columns-reset-btn" onclick="resetAllColumns('videosDataTable', 'columnsDropdownMenu_videos')">إظهار الكل</button>
                    </div>
                  </div>

                  <!-- View Mode Toggle -->
                  <div class="view-mode-toggle">
                    <button class="view-mode-btn active" id="btnViewTable_videos" onclick="toggleViewMode('videos', 'table')" title="عرض الجدول">
                      <span>جدول</span>
                    </button>
                    <button class="view-mode-btn" id="btnViewGrid_videos" onclick="toggleViewMode('videos', 'grid')" title="عرض البطاقات">
                      <span>بطاقات</span>
                    </button>
                  </div>
                </div>
              </div>

              <div id="bulkActionsStrip_videos" class="bulk-actions-strip">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; font-weight: 700; color: var(--indigo);">
                  <span>✓</span><span id="bulkSelectedCount_videos">المحدد (0)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                  <button class="btn-action-small" onclick="alert('تصدير المحدد...')">تصدير</button>
                  <button class="btn-action-small" style="color: var(--crimson); border-color: rgba(239, 68, 68, 0.3);" onclick="alert('حذف المحدد...')">حذف</button>
                </div>
              </div>
            </div>

            <!-- Table View -->
            <div id="videosTableView" class="dense-table-wrapper">
              <table class="dense-table" id="videosDataTable">
                <thead>
                  <tr>
                    <th style="width: 36px; text-align: center;">
                      <input type="checkbox" onchange="toggleSelectAllTable(this, 'videosDataTable', 'bulkActionsStrip_videos', 'bulkSelectedCount_videos')" style="cursor: pointer;">
                    </th>
                    <th style="width: 70px;" class="sortable">الرقم ⇅</th>
                    <th class="sortable">العنوان ⇅</th>
                    <th style="width: 95px;" class="sortable">الكود ⇅</th>
                    <th style="width: 120px;" class="sortable">المعرف ⇅</th>
                    <th style="width: 80px;" class="sortable">المدة ⇅</th>
                    <th style="width: 75px;" class="sortable">الصيغة ⇅</th>
                    <th class="sortable">الوصف</th>
                    <th style="width: 85px; text-align: center;">الملفات</th>
                    <th style="width: 85px;" class="sortable">التاريخ ⇅</th>
                    <th style="width: 110px; text-align: center;">الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Row 1 -->
                  <tr data-title="ندوة تحقيق المخطوطات والتحول الرقمي" data-code="VID-NDW-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('videosDataTable', 'bulkActionsStrip_videos', 'bulkSelectedCount_videos')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#40101</td>
                    <td>
                      <a href="/dev/player/video/nadwat-tahqiq-makhtutat" class="book-title-link">ندوة تحقيق المخطوطات والتحول الرقمي</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">VID-NDW-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">nadwat-tahqiq-makhtutat</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">02:15:00</td>
                    <td><span class="role-chip chip-super">MP4 4K</span></td>
                    <td>
                      <div class="cell-desc" title="تسجيل كامل للندوة العلمية السنوية مع دعم الفصول الذكية والانتقال المباشر للنقاط.">
                        تسجيل كامل للندوة العلمية السنوية مع دعم الفصول الذكية والانتقال المباشر للنقاط.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="فيديو MP4 متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎬 MP4</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ يومين</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/video/nadwat-tahqiq-makhtutat" class="table-btn-icon" title="المشغل">▶️</a>
                        <a href="/studio/video/nadwat-tahqiq-makhtutat" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/videos/1/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المرئية للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 2 -->
                  <tr data-title="قراءة منهجية في معجم الأدباء" data-code="VID-UDM-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('videosDataTable', 'bulkActionsStrip_videos', 'bulkSelectedCount_videos')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#40102</td>
                    <td>
                      <a href="/dev/player/video/mujam-al-udaba-01" class="book-title-link">قراءة منهجية في معجم الأدباء</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">VID-UDM-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">mujam-al-udaba-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">01:10:45</td>
                    <td><span class="role-chip chip-editor">MP4 1080p</span></td>
                    <td>
                      <div class="cell-desc" title="استعراض لأبرز معالم المعجم ومنهج ياقوت الحموي في التوثيق التاريخي للأعلام.">
                        استعراض لأبرز معالم المعجم ومنهج ياقوت الحموي في التوثيق التاريخي للأعلام.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="فيديو MP4 متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎬 MP4</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ 5 أيام</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/video/mujam-al-udaba-01" class="table-btn-icon" title="المشغل">▶️</a>
                        <a href="/studio/video/mujam-al-udaba-01" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/videos/2/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المرئية للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>

                  <!-- Row 3 -->
                  <tr data-title="المقدمة الحضرمية - فقه الشافعية" data-code="VID-HMD-01">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" onchange="onTableRowCheckboxChange('videosDataTable', 'bulkActionsStrip_videos', 'bulkSelectedCount_videos')"></td>
                    <td style="font-family: 'Outfit', monospace; color: var(--text-dim); font-size: 0.75rem;">#40103</td>
                    <td>
                      <a href="/dev/player/video/al-muqaddimah-al-hadramiyyah" class="book-title-link">المقدمة الحضرمية - فقه الشافعية</a>
                    </td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">VID-HMD-01</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo);">al-muqaddimah-al-hadramiyyah</td>
                    <td style="font-family: 'Outfit', monospace; font-size: 0.75rem; color: var(--indigo); font-weight: 700;">00:45:10</td>
                    <td><span class="role-chip chip-editor">MP4 1080p</span></td>
                    <td>
                      <div class="cell-desc" title="شرح مرئي مبسط للمتن الفقهي مع خرائط ذهنية ورسوم توضيحية للمسائل والأحكام.">
                        شرح مرئي مبسط للمتن الفقهي مع خرائط ذهنية ورسوم توضيحية للمسائل والأحكام.
                      </div>
                    </td>
                    <td style="text-align: center;">
                      <div style="display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem;">
                        <span title="غلاف متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; font-weight: 700;">🖼️ غلاف</span>
                        <span title="فيديو MP4 متوفر" style="padding: 0.12rem 0.35rem; border-radius: 4px; background: rgba(99, 102, 241, 0.15); color: #818cf8; font-weight: 700;">🎬 MP4</span>
                      </div>
                    </td>
                    <td style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">منذ أسبوع</td>
                    <td>
                      <div class="table-actions-cell" style="justify-content: center;">
                        <a href="/dev/player/video/al-muqaddimah-al-hadramiyyah" class="table-btn-icon" title="المشغل">▶️</a>
                        <a href="/studio/video/al-muqaddimah-al-hadramiyyah" class="table-btn-icon" title="الاستوديو">✍️</a>
                        <a href="/videos/3/edit" class="table-btn-icon" title="تعديل">⚙️</a>
                        <button class="table-btn-icon btn-danger" title="حذف" onclick="alert('تم نقل المرئية للمهملات')">🗑️</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Cards View -->
            <div id="videosGridView" class="catalog-grid" style="display: none; padding: 1.25rem;">
              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-public">4K UHD 🎬</span>
                  <h3 class="entity-title">ندوة تحقيق المخطوطات والتحول الرقمي</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">نخبة من المحققين</span>
                    <span class="meta-chip category">02:15:00</span>
                    <span class="meta-chip">8 فصول مقسمة</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">تسجيل كامل للندوة العلمية السنوية مع دعم الفصول الذكية والانتقال المباشر للنقاط.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/player/video/nadwat-tahqiq-makhtutat" class="btn-purple-small"><span>▶️ المشغل</span></a>
                    <a href="/studio/video/nadwat-tahqiq-makhtutat" class="btn-emerald-small"><span>✍️ استوديو المشاهد</span></a>
                    <a href="/videos/1/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">4K 60fps</span>
                </div>
              </div>

              <div class="entity-card">
                <div>
                  <span class="entity-tag tag-public">1080p Full HD 🎬</span>
                  <h3 class="entity-title">قراءة منهجية في معجم الأدباء</h3>
                  <div class="entity-meta-tags">
                    <span class="meta-chip">د. إبراهيم الفاسي</span>
                    <span class="meta-chip category">01:10:45</span>
                    <span class="meta-chip">5 فصول</span>
                  </div>
                  <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">استعراض لأبرز معالم المعجم ومنهج ياقوت الحموي في التوثيق التاريخي للأعلام.</p>
                </div>
                <div class="card-footer">
                  <div class="card-actions-strip">
                    <a href="/dev/player/video/mujam-al-udaba-01" class="btn-purple-small"><span>▶️ المشغل</span></a>
                    <a href="/studio/video/mujam-al-udaba-01" class="btn-emerald-small"><span>✍️ استوديو المشاهد</span></a>
                    <a href="/videos/2/edit" class="btn-action-small"><span>⚙️</span></a>
                  </div>
                  <span style="font-size: 0.65rem; color: var(--text-dim); font-family: 'Outfit';">1080p</span>
                </div>
              </div>
            </div>

            <!-- Pagination Bar -->
            <div class="table-pagination-bar">
              <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                <div><span>عرض </span><strong style="color: var(--text-main); font-family: 'Outfit';">1 - 2</strong><span> من أصل </span><strong style="color: var(--text-main); font-family: 'Outfit';">8,420</strong><span> فيديو</strong></div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                  <span>عرض:</span>
                  <select class="toolbar-select" style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">
                    <option>25 في الصفحة</option><option>50 في الصفحة</option><option>100 في الصفحة</option>
                  </select>
                </div>
              </div>
              <div class="pagination-pages-group">
                <button class="page-btn" disabled>««</button><button class="page-btn" disabled>‹</button>
                <button class="page-btn active">1</button><button class="page-btn">2</button><button class="page-btn">3</button>
                <button class="page-btn">›</button><button class="page-btn">»»</button>
              </div>
            </div>

          </div>
        `
      },// ========================================================
      // 5. AUTHORS VIEW (الأشخاص -> المؤلفون)
      // ========================================================
      authors: {
        title: 'المؤلفون',
        group: 'الأشخاص',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>👥 المؤلفون</span></h2>
              <p>دليل الأعلام والتراجم والشخصيات العلمية وأصحاب المصنفات</p>
            </div>
            <div class="header-actions">
              <a href="/authors/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>+ مؤلف جديد</span>
              </a>
              <button class="btn-action-small" onclick="alert('ترتيب زمني حسب قرون الوفاة...')">الترتيب الزمني ⏳</button>
            </div>
          </div>

          <div class="catalog-grid">
            <div class="entity-card">
              <div>
                <span class="entity-tag tag-scholarly">أمير المؤمنين في الحديث 🏛️</span>
                <h3 class="entity-title">ابن حجر العسقلاني</h3>
                <div class="entity-meta-tags">
                  <span class="meta-chip">773 - 852 هـ</span>
                  <span class="meta-chip category">48 مصنفاً بالأرشيف</span>
                  <span class="meta-chip">القاهرة</span>
                </div>
                <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">أحمد بن علي بن حجر العسقلاني، الإمام الحافظ المحدث، صاحب فتح الباري والإصابة وبلوغ المرام.</p>
              </div>
              <div class="card-footer">
                <a href="/authors/1" class="btn-indigo-small"><span>تصفح المؤلفات 📚</span></a>
                <a href="/authors/1/edit" class="btn-action-small"><span>تعديل السيرة ✏️</span></a>
              </div>
            </div>

            <div class="entity-card">
              <div>
                <span class="entity-tag tag-scholarly">صاحب الصحيح 🏛️</span>
                <h3 class="entity-title">الإمام البخاري</h3>
                <div class="entity-meta-tags">
                  <span class="meta-chip">194 - 256 هـ</span>
                  <span class="meta-chip category">12 مصنفاً ومخطوطاً</span>
                  <span class="meta-chip">بخارى</span>
                </div>
                <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">محمد بن إسماعيل بن إبراهيم البخاري، إمام الحديث والعلل، صاحب الجامع الصحيح والتاريخ الكبير.</p>
              </div>
              <div class="card-footer">
                <a href="/authors/2" class="btn-indigo-small"><span>تصفح المؤلفات 📚</span></a>
                <a href="/authors/2/edit" class="btn-action-small"><span>تعديل السيرة ✏️</span></a>
              </div>
            </div>

            <div class="entity-card">
              <div>
                <span class="entity-tag tag-scholarly">إمام أهل الحديث 🏛️</span>
                <h3 class="entity-title">شمس الدين الذهبي</h3>
                <div class="entity-meta-tags">
                  <span class="meta-chip">673 - 748 هـ</span>
                  <span class="meta-chip category">35 مصنفاً بالأرشيف</span>
                  <span class="meta-chip">دمشق</span>
                </div>
                <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">محمد بن أحمد بن عثمان الذهبي، إمام التاريخ والتراجم، صاحب سير أعلام النبلاء وتاريخ الإسلام وميزان الاعتدال.</p>
              </div>
              <div class="card-footer">
                <a href="/authors/3" class="btn-indigo-small"><span>تصفح المؤلفات 📚</span></a>
                <a href="/authors/3/edit" class="btn-action-small"><span>تعديل السيرة ✏️</span></a>
              </div>
            </div>
          </div>
        `
      },

      // ========================================================
      // 6. PUBLISHERS VIEW (الأشخاص -> الناشرون)
      // ========================================================
      publishers: {
        title: 'الناشرون',
        group: 'الأشخاص',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🏢 الناشرون</span></h2>
              <p>فهرس المطابع ودور النشر والمؤسسات الأكاديمية الراعية لإصدارات الأرشيف</p>
            </div>
            <div class="header-actions">
              <a href="/publishers/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>+ دار نشر</span>
              </a>
            </div>
          </div>

          <div class="catalog-grid">
            <div class="entity-card">
              <div>
                <span class="entity-tag tag-public">ناشر معتمد 🏢</span>
                <h3 class="entity-title">دار الرسالة العالمية</h3>
                <div class="entity-meta-tags">
                  <span class="meta-chip">بيروت - لبنان</span>
                  <span class="meta-chip category">412 مطبوعة مؤرشفة</span>
                </div>
                <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">مؤسسة متخصصة في طباعة وتحقيق التراث الإسلامي وكتب السنة والفقه والعقيدة بأعلى معايير الطباعة الفاخرة.</p>
              </div>
              <div class="card-footer">
                <a href="/publishers/1" class="btn-indigo-small"><span>عرض المنشورات 📖</span></a>
                <span style="font-size: 0.68rem; color: var(--text-dim);">منذ 1970</span>
              </div>
            </div>

            <div class="entity-card">
              <div>
                <span class="entity-tag tag-public">ناشر معتمد 🏢</span>
                <h3 class="entity-title">دار المنهاج للنشر والتوزيع</h3>
                <div class="entity-meta-tags">
                  <span class="meta-chip">جدة - السعودية</span>
                  <span class="meta-chip category">280 مطبوعة مؤرشفة</span>
                </div>
                <p style="font-size: 0.72rem; color: var(--text-dim); margin-bottom: 1rem;">متخصصة في إخراج كتب المذاهب الفقهية المحققة على أمهات النسخ الخطية النفيسة مع العناية الفائقة بالإخراج.</p>
              </div>
              <div class="card-footer">
                <a href="/publishers/2" class="btn-indigo-small"><span>عرض المنشورات 📖</span></a>
                <span style="font-size: 0.68rem; color: var(--text-dim);">منذ 1999</span>
              </div>
            </div>
          </div>
        `
      },

      // ========================================================
      // 7. CATEGORIES VIEW (التنظيم -> التصنيفات)
      // ========================================================
      categories: {
        title: 'التصنيفات',
        group: 'التنظيم',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🌳 التصنيفات</span></h2>
              <p>شجرة العلوم والتصنيفات الهرمية متعددة المستويات لتنظيم المعرفة</p>
            </div>
            <div class="header-actions">
              <a href="/categories/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>+ تصنيف جديد</span>
              </a>
              <button class="btn-action-small" onclick="alert('إعادة فرز الفروع التصنيفية...')">إعادة الفرز 🔄</button>
            </div>
          </div>

          <div class="section-card">
            <div class="tree-node">
              <span>📂 العلوم الشرعية الإسلامية (الجذر الأساسي)</span>
              <span class="badge-count">2,150 كياناً</span>
            </div>
            <div class="tree-node child">
              <span>📜 الحديث الشريف وعلومه</span>
              <span class="badge-count">640 مصنفاً</span>
            </div>
            <div class="tree-node child" style="margin-right: 3rem; border-right-color: #a855f7;">
              <span>📖 شروح الحديث ومتونه</span>
              <span class="badge-count">312 مصنفاً</span>
            </div>
            <div class="tree-node child">
              <span>⚖️ الفقه وأصوله وقواعده</span>
              <span class="badge-count">580 مصنفاً</span>
            </div>
            <div class="tree-node child">
              <span>🏛️ السيرة والتاريخ والتراجم</span>
              <span class="badge-count">420 مصنفاً</span>
            </div>
          </div>
        `
      },

      // ========================================================
      // 8. TAGS VIEW (التنظيم -> الأوسمة)
      // ========================================================
      tags: {
        title: 'الأوسمة',
        group: 'التنظيم',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🏷️ الأوسمة</span></h2>
              <p>فهرس الأوسمة والدلالات الموضوعية وسحابة الكلمات المفتاحية</p>
            </div>
            <div class="header-actions">
              <a href="/tags/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>+ وسم جديد</span>
              </a>
            </div>
          </div>

          <div class="section-card">
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
              <span class="entity-tag tag-public" style="font-size: 0.95rem; padding: 0.4rem 0.85rem;">#صحيح_البخاري (142)</span>
              <span class="entity-tag tag-scholarly" style="font-size: 0.9rem; padding: 0.35rem 0.8rem;">#أصول_الفقه (98)</span>
              <span class="entity-tag tag-draft" style="font-size: 0.85rem; padding: 0.3rem 0.75rem;">#مخطوط_نادر (84)</span>
              <span class="entity-tag tag-public" style="font-size: 0.82rem; padding: 0.3rem 0.7rem;">#تحقيق_حديث (65)</span>
              <span class="entity-tag tag-scholarly" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;">#سير_النبلاء (52)</span>
              <span class="entity-tag tag-public" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">#تفريغ_صوتي (45)</span>
              <span class="entity-tag tag-draft" style="font-size: 0.72rem; padding: 0.2rem 0.55rem;">#خط_أندلسي (38)</span>
              <span class="entity-tag tag-public" style="font-size: 0.7rem; padding: 0.2rem 0.5rem;">#علم_الرجال (29)</span>
            </div>
          </div>
        `
      },

      // ========================================================
      // 9. STUDIO BOOKS (الاستوديو -> الكتب)
      // ========================================================
      'studio-books': {
        title: 'الكتب',
        group: 'الاستوديو',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>📚 استوديو الكتب</span></h2>
              <p>منصة التحقيق والتحرير النصي الحي ومقابلة النسخ لمصنفات الكتب</p>
            </div>
            <div class="header-actions">
              <a href="/studio/resume" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>⚡ استئناف آخر جلسة</span>
              </a>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>المصنف قيد التحقيق</th>
                    <th>العقدة / الباب الحالي</th>
                    <th>نسبة الإنجاز</th>
                    <th>المحقق المسؤول</th>
                    <th>آخر تعديل</th>
                    <th>الإجراء المباشر</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>تذكرة السامع والمتكلم</strong></td>
                    <td>الباب الثالث: أدب المتعلم مع شيخه</td>
                    <td>
                      <div class="kpi-split-bar" style="height: 6px; width: 120px;"><div style="width: 78%; background: #10b981;"></div></div>
                      <span style="font-size: 0.65rem; color: #10b981; font-weight: 800;">78%</span>
                    </td>
                    <td>د. طارق الحارثي</td>
                    <td>منذ 14 دقيقة</td>
                    <td>
                      <a href="/studio/book/tadhkirat-al-sami" class="btn-emerald-small"><span>فتح المحرر ✍️</span></a>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>زاد المعاد في هدي خير العباد</strong></td>
                    <td>فصل في هديه صلى الله عليه وسلم في الصوم</td>
                    <td>
                      <div class="kpi-split-bar" style="height: 6px; width: 120px;"><div style="width: 95%; background: #3b82f6;"></div></div>
                      <span style="font-size: 0.65rem; color: #3b82f6; font-weight: 800;">95%</span>
                    </td>
                    <td>أ. مريم السعيد</td>
                    <td>منذ ساعتين</td>
                    <td>
                      <a href="/studio/book/zad-al-maad" class="btn-emerald-small"><span>فتح المحرر ✍️</span></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 10. STUDIO MANUSCRIPTS (الاستوديو -> المخطوطات)
      // ========================================================
      'studio-manuscripts': {
        title: 'المخطوطات',
        group: 'الاستوديو',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>📜 استوديو المخطوطات</span></h2>
              <p>منصة مقارنة اللوحات الخطية وفك الطلاسم وتفريغ النصوص المسندة</p>
            </div>
            <div class="header-actions">
              <a href="/studio/resume" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <span>⚡ استئناف العمل</span>
              </a>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>المخطوطة</th>
                    <th>اللوحة الحالية</th>
                    <th>المقابلة النصية</th>
                    <th>المحقق</th>
                    <th>الإجراء المباشر</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>صحيح البخاري - نسخة كوبريلي</strong></td>
                    <td>لوحة رقم 84 (الوجه أ)</td>
                    <td><span class="role-chip chip-studio">مطابق بنسبة 100%</span></td>
                    <td>د. طارق الحارثي</td>
                    <td>
                      <a href="/studio/manuscript/sahih-bukhari-koprulu" class="btn-emerald-small"><span>متابعة التحقيق ✍️</span></a>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>ديوان الحماسة لأبي تمام</strong></td>
                    <td>لوحة رقم 42 (الوجه ب)</td>
                    <td><span class="role-chip chip-academic">قيد فك الطلاسم</span></td>
                    <td>أ.د. عبد الرحمن السليمان</td>
                    <td>
                      <a href="/studio/manuscript/diwan-al-hamasa" class="btn-emerald-small"><span>متابعة التحقيق ✍️</span></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 11. STUDIO AUDIOS (الاستوديو -> الصوتيات)
      // ========================================================
      'studio-audios': {
        title: 'الصوتيات',
        group: 'الاستوديو',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🎙️ استوديو الصوتيات</span></h2>
              <p>منصة تجزئة المسارات الصوتية وتوليد الشرائح وتفريغ النصوص بدقة</p>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>المجلس الصوتي</th>
                    <th>مدة التسجيل</th>
                    <th>الشرائح المنجزة</th>
                    <th>دقة المطابقة</th>
                    <th>الإجراء</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>مجلس سنن أبي داود - المجلس الثاني</strong></td>
                    <td>01:15:30</td>
                    <td>58 شريحة</td>
                    <td><span style="color: #34d399; font-weight: 800;">99.2%</span></td>
                    <td><a href="/studio/audio/sunan-abi-dawud-02" class="btn-emerald-small"><span>فتح محرر الشرائح ✍️</span></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 12. STUDIO VIDEOS (الاستوديو -> المرئيات)
      // ========================================================
      'studio-videos': {
        title: 'المرئيات',
        group: 'الاستوديو',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🎬 استوديو المرئيات</span></h2>
              <p>منصة تقسيم المحاضرات والندوات المصورة وربط الفصول التفاعلية</p>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>التسجيل المرئي</th>
                    <th>المدة</th>
                    <th>الفصول الحالية</th>
                    <th>الإجراء</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>ندوة تحقيق المخطوطات والتحول الرقمي</strong></td>
                    <td>02:15:00</td>
                    <td>8 فصول رئيسية</td>
                    <td><a href="/studio/video/nadwat-tahqiq-makhtutat" class="btn-purple-small"><span>تقطيع الفصول 🎬</span></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 13. VERSIONS VIEW (الاستوديو -> الإصدارات)
      // ========================================================
      versions: {
        title: 'الإصدارات',
        group: 'الاستوديو',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>📜 الإصدارات</span></h2>
              <p>محرك تاريخ التعديلات ومقارنة الفروق اللحظية للنسخ مع إمكانية الاسترجاع</p>
            </div>
          </div>

          <div class="section-card">
            <div class="section-header">
              <h3 class="section-title">مقارنة النسخة v1.4 مع النسخة السابقة v1.3</h3>
              <span class="role-chip chip-studio">تذكرة السامع والمتكلم</span>
            </div>
            <div class="diff-box" style="margin-bottom: 1.5rem;">
              <div style="color: #f87171;">
                <span style="opacity: 0.5;">- السطر 48:</span> [حذف نص قديم: واختلف العلماء في تأويل هذا القول على وجهين]
              </div>
              <div class="icon-import">
                <span style="opacity: 0.5;">+ السطر 48:</span> [تصويب محقق: واختلف أهل الأثر في تأويل هذا القول على ثلاثة أوجه مسندة]
              </div>
            </div>

            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>الإصدار</th>
                    <th>الكيان التابع</th>
                    <th>المحرر</th>
                    <th>الفروق النصية</th>
                    <th>التاريخ</th>
                    <th>إجراء الاسترجاع</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>v1.4 (الحالي)</strong></td>
                    <td>تذكرة السامع والمتكلم</td>
                    <td>د. طارق الحارثي</td>
                    <td><span class="icon-import">+42 سطر</span> / <span style="color: #f87171;">-15 سطر</span></td>
                    <td>منذ 14 دقيقة</td>
                    <td><span class="role-chip chip-studio">النسخة النشطة</span></td>
                  </tr>
                  <tr>
                    <td><strong>v1.3</strong></td>
                    <td>تذكرة السامع والمتكلم</td>
                    <td>أ. مريم السعيد</td>
                    <td><span class="icon-import">+18 سطر</span> / <span style="color: #f87171;">-4 أسطر</span></td>
                    <td>أمس 18:30</td>
                    <td>
                      <button class="btn-action-small" onclick="alert('تم استرجاع النسخة v1.3 بنجاح عبر مسار studio.restore!')">استرجاع النسخة ↩️</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 14. STATS VIEW (النظام -> الإحصائيات - Overview)
      // ========================================================
      stats: {
        title: 'الإحصائيات',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner" style="border-color: rgba(99, 102, 241, 0.3); background: rgba(99, 102, 241, 0.05);">
            <div class="view-title-group">
              <h2><span>📊 لوحة المؤشرات والإحصائيات المركزية</span></h2>
              <p>رصد فوري لكافة قطاعات الأرشيف الرقمي، مسار النشر، ونشاط المحققين</p>
            </div>
                        <div class="header-actions">
              <div class="health-pill">
                <span class="pulse-dot-green"></span>
                <span>النظام يعمل بكفاءة</span>
              </div>
              <div class="status-pill-db">
                <span class="pulse-dot-emerald"></span>
                <span>قاعدة البيانات متصلة ومستقرة</span>
              </div>
            </div>
          </div>

          <!-- KPI Cards Grid -->
          <div class="kpi-grid">
            <!-- Books KPI -->
            <div class="kpi-card" style="cursor: pointer;" onclick="loadView('books')">
              <div class="kpi-title">إجمالي الكتب والرسائل [Books]</div>
              <div class="kpi-value icon-export">' + (props.stats?.books ?? 1482).toLocaleString() + '</div>
              <div class="kpi-split-bar">
                <div style="width: 75%; background: #3b82f6;"></div>
                <div style="width: 25%; background: #f59e0b;"></div>
              </div>
              <div class="kpi-split-subtext"><span>75% منشور</span><span>25% مسودة</span></div>
            </div>

            <!-- Manuscripts KPI -->
            <div class="kpi-card" style="cursor: pointer;" onclick="loadView('manuscripts')">
              <div class="kpi-title">خزانة المخطوطات النادرة [Manuscripts]</div>
              <div class="kpi-value icon-refresh">' + (props.stats?.manuscripts ?? 428).toLocaleString() + '</div>
              <div class="kpi-split-bar">
                <div style="width: 65%; background: #f59e0b;"></div>
                <div style="width: 35%; background: #ef4444;"></div>
              </div>
              <div class="kpi-split-subtext"><span>65% لوحات مرممة</span><span>35% قيد الفحص</span></div>
            </div>

            <!-- Audios KPI -->
            <div class="kpi-card" style="cursor: pointer;" onclick="loadView('audios')">
              <div class="kpi-title">التسجيلات الصوتية المفرغة [Audios]</div>
              <div class="kpi-value icon-import">' + (props.stats?.audios ?? 650).toLocaleString() + '</div>
              <div class="kpi-split-bar">
                <div style="width: 80%; background: #10b981;"></div>
                <div style="width: 20%; background: #3b82f6;"></div>
              </div>
              <div class="kpi-split-subtext"><span>80% شرائح مفرغة</span><span>20% تسجيل نقي</span></div>
            </div>

            <!-- Videos KPI -->
            <div class="kpi-card" style="cursor: pointer;" onclick="loadView('videos')">
              <div class="kpi-title">المرئيات والندوات المصورة [Videos]</div>
              <div class="kpi-value" style="color: #c084fc;">' + (props.stats?.videos ?? 185).toLocaleString() + '</div>
              <div class="kpi-split-bar">
                <div style="width: 90%; background: #a855f7;"></div>
                <div style="width: 10%; background: #10b981;"></div>
              </div>
              <div class="kpi-split-subtext"><span>90% 4K UHD</span><span>10% HD</span></div>
            </div>
          </div>

          <!-- Quick Launchpad Section -->
          <div class="section-card">
            <div class="section-header">
              <h3 class="section-title">⚡ منصة الإطلاق والإجراءات السريعة</h3>
              <span style="font-size: 0.72rem; color: var(--text-dim);">روابط مباشرة لأهم مسارات النظام</span>
            </div>
            <div class="quick-launch-grid">
              <a href="/books/create" class="quick-launch-item">
                <div class="quick-icon-box" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">📖</div>
                <div>
                  <strong style="display: block; font-size: 0.85rem; color: var(--text-main);">كتاب جديد</strong>
                  <span style="font-size: 0.7rem; color: var(--text-dim);">إدراج مصنف أو عمل مكتبي جديد</span>
                </div>
              </a>

              <a href="/categories/create" class="quick-launch-item">
                <div class="quick-icon-box" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">🏷️</div>
                <div>
                  <strong style="display: block; font-size: 0.85rem; color: var(--text-main);">تصنيف جديد</strong>
                  <span style="font-size: 0.7rem; color: var(--text-dim);">إدارة الفئات والشجرة المعرفية</span>
                </div>
              </a>

              <div class="quick-launch-item" onclick="loadView('deletions')">
                <div class="quick-icon-box" style="background: rgba(239, 68, 68, 0.15); color: #f87171;">♻️</div>
                <div>
                  <strong style="display: block; font-size: 0.85rem; color: var(--text-main);">خزنة المهملات</strong>
                  <span style="font-size: 0.7rem; color: var(--text-dim);">استرجاع الأصول المحذوفة مؤقتاً</span>
                </div>
              </div>

              <div class="quick-launch-item" onclick="loadView('commands')">
                <div class="quick-icon-box" style="background: rgba(168, 85, 247, 0.15); color: #c084fc;">💻</div>
                <div>
                  <strong style="display: block; font-size: 0.85rem; color: var(--text-main);">أوامر النظام</strong>
                  <span style="font-size: 0.7rem; color: var(--text-dim);">تشغيل أوامر الكونسول وArtisan</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Editorial Lifecycle Funnel & Content Breakdown -->
          <div class="section-card">
            <div class="section-header">
              <h3 class="section-title">مسار تدفق النشر والتحقيق (Editorial Lifecycle)</h3>
              <span class="role-chip chip-studio">توزيع الكيانات</span>
            </div>
            <div class="funnel-container">
              <div class="funnel-step">
                <div class="funnel-step-label">مسودة قيد الإدخال 🔒</div>
                <div class="funnel-step-num icon-refresh">386</div>
              </div>
              <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
              <div class="funnel-step">
                <div class="funnel-step-label">التحقيق والمقابلة ✍️</div>
                <div class="funnel-step-num" style="color: #38bdf8;">512</div>
              </div>
              <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
              <div class="funnel-step">
                <div class="funnel-step-label">الاعتماد والتحكيم 🎓</div>
                <div class="funnel-step-num" style="color: #a855f7;">240</div>
              </div>
              <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
              <div class="funnel-step">
                <div class="funnel-step-label">منشور للعامة 🌐</div>
                <div class="funnel-step-num" style="color: #10b981;">1,607</div>
              </div>
            </div>
          </div>
        `
      },

      // ========================================================
      // 15. OPS VIEW (النظام -> العمليات)
      // ========================================================
      ops: {
        title: 'العمليات',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner" style="border-color: rgba(239, 68, 68, 0.3);">
            <div class="view-title-group">
              <h2><span>⚡ العمليات</span></h2>
              <p>حقيبة العمليات والصيانة الفورية وإدارة خوادم النظام وقاعدة البيانات</p>
            </div>
            <div class="header-actions">
              <button class="btn-danger-small" onclick="alert('تم إرسال إشارة أمان لكافة الجلسات النشطة!')">إشارة أمان للجلسات 🔒</button>
            </div>
          </div>

          <div class="section-card" style="display: flex; justify-content: space-between; align-items: center; border-color: rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.03);">
            <div>
              <h4 style="font-size: 0.95rem; font-weight: 800; color: #fbbf24;">وضع الصيانة المؤسسي (Maintenance Mode)</h4>
              <p style="font-size: 0.72rem; color: var(--text-dim);">إغلاق الوصول العام للزوار وعرض صفحة الصيانة مع السماح للمشرفين فقط بالدخول.</p>
            </div>
            <button class="btn-action-small btn-danger-small" onclick="alert('تم تبديل حالة وضع الصيانة بنجاح!')">تفعيل وضع الصيانة ⚠️</button>
          </div>

          <div class="section-card">
            <div class="section-header">
              <h3 class="section-title">أدوات الصيانة الفورية المباشرة</h3>
              <span class="role-chip chip-admin">تنفيذ فوري</span>
            </div>
            <div class="catalog-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
              <div class="entity-card" style="cursor: pointer;" onclick="alert('بدء أخذ نسخة احتياطية فورية Snapshot بقاعدة PostgreSQL...')">
                <div class="entity-title">💾 أخذ نسخة احتياطية فورية</div>
                <p style="font-size: 0.72rem; color: var(--text-dim);">نسخ قاعدة PostgreSQL والملفات الرقمية للتخزين الآمن.</p>
              </div>
              <div class="entity-card" style="cursor: pointer;" onclick="alert('تم تفريغ كاش التطبيق وكاش التوجيه وسياسات الصلاحيات بنجاح.')">
                <div class="entity-title">⚡ تفريغ الكاش ومزامنة السياسات</div>
                <p style="font-size: 0.72rem; color: var(--text-dim);">تشغيل artisan cache:clear ومزامنة Spatie Roles.</p>
              </div>
              <div class="entity-card" style="cursor: pointer;" onclick="alert('جاري إعادة بناء فهارس البحث الأرشيفي...')">
                <div class="entity-title">🔍 إعادة بناء فهارس البحث</div>
                <p style="font-size: 0.72rem; color: var(--text-dim);">مزامنة فهارس التدميج الكامل Full-Text Search باللغة العربية.</p>
              </div>
              <div class="entity-card" style="cursor: pointer;" onclick="loadView('commands')">
                <div class="entity-title" style="color: #c084fc;">💻 كونسول أوامر النظام</div>
                <p style="font-size: 0.72rem; color: var(--text-dim);">فتح الطرفية التفاعلية لتشغيل أوامر Artisan المباشرة.</p>
              </div>
            </div>
          </div>
        `
      },

      // ========================================================
      // 16. USERS VIEW (النظام -> المستخدمون)
      // ========================================================
      users: {
        title: 'المستخدمون',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>👥 المستخدمون</span></h2>
              <p>دليل المستخدمين ومصفوفة رتب الصلاحيات المعتمدة في النظام</p>
            </div>
            <div class="header-actions">
              <button class="btn-primary-small" onclick="alert('إرسال دعوة لعضو جديد...')">+ إضافة مستخدم</button>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الرتبة المؤسسية</th>
                    <th>مستوى الصلاحية</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>د. إبراهيم الفاسي</strong></td>
                    <td>super_admin@archive.org</td>
                    <td><span class="role-chip chip-admin">مدير النظام الشامل</span></td>
                    <td><span class="role-chip chip-admin">صلاحيات كاملة</span></td>
                    <td><span class="icon-import">نشط</span></td>
                    <td><button class="btn-action-small" disabled style="opacity: 0.5;">مدير النظام</button></td>
                  </tr>
                  <tr>
                    <td><strong>د. طارق الحارثي</strong></td>
                    <td>chief_editor@archive.org</td>
                    <td><span class="role-chip chip-studio">رئيس التحرير والاعتماد</span></td>
                    <td><span class="role-chip chip-studio">اعتماد ونشر</span></td>
                    <td><span class="icon-import">نشط</span></td>
                    <td><button class="btn-action-small" onclick="alert('تعديل صلاحيات رئيس التحرير')">تعديل الصلاحية ✏️</button></td>
                  </tr>
                  <tr>
                    <td><strong>أ. مريم السعيد</strong></td>
                    <td>editor@archive.org</td>
                    <td><span class="role-chip chip-studio">محرر وسائط واستوديو</span></td>
                    <td><span class="role-chip chip-studio">إدارة المحتوى</span></td>
                    <td><span class="icon-import">نشط</span></td>
                    <td><button class="btn-action-small" onclick="alert('تعديل صلاحيات المحرر')">تعديل الصلاحية ✏️</button></td>
                  </tr>
                  <tr>
                    <td><strong>أ.د. عبد الرحمن السليمان</strong></td>
                    <td>academic_reviewer@archive.org</td>
                    <td><span class="role-chip chip-academic">مُحكّم ومراجع علمي</span></td>
                    <td><span class="role-chip chip-academic">تحكيم علمي</span></td>
                    <td><span class="icon-import">نشط</span></td>
                    <td><button class="btn-action-small" onclick="alert('تعديل صلاحيات المراجع')">تعديل الصلاحية ✏️</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 17. ACTIVITIES VIEW (النظام -> النشاطات)
      // ========================================================
      activities: {
        title: 'النشاطات',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner">
            <div class="view-title-group">
              <h2><span>🕒 النشاطات</span></h2>
              <p>سجل التدقيق الحي ورصد تحركات المستخدمين وتعديلات الكيانات لحظياً</p>
            </div>
            <div class="header-actions">
              <a href="/activities" class="btn-action-small" style="text-decoration: none;">السجل الكامل 🔍</a>
            </div>
          </div>

          <div class="section-card">
            <div class="timeline-container">
              <div class="timeline-rail"></div>

              <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-box">
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="timeline-user-avatar">ط</div>
                    <div class="timeline-body">
                      <strong>د. طارق الحارثي</strong> قام بـ <span style="color: #34d399; font-weight: 800;">إجازة نشر</span>: <a href="/books/tadhkirat-al-sami/reader" style="color: var(--text-main); font-weight: 800; text-decoration: underline;">تذكرة السامع والمتكلم في أدب العالم والمتعلم</a>
                    </div>
                  </div>
                  <time class="timeline-time">منذ 14 دقيقة</time>
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot" style="background: #3b82f6;"></div>
                <div class="timeline-box">
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="timeline-user-avatar" style="background: rgba(59,130,246,0.15); color: #60a5fa; border-color: rgba(59,130,246,0.3);">م</div>
                    <div class="timeline-body">
                      <strong>أ. مريم السعيد</strong> قامت بـ <span style="color: #60a5fa; font-weight: 800;">حفظ مسودة</span> في استوديو المخطوطات: <a href="/dev/manuscripter/diwan-al-hamasa" style="color: var(--text-main); font-weight: 800; text-decoration: underline;">ديوان الحماسة</a>
                    </div>
                  </div>
                  <time class="timeline-time">منذ 45 دقيقة</time>
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot" style="background: #f59e0b;"></div>
                <div class="timeline-box">
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="timeline-user-avatar" style="background: rgba(245,158,11,0.15); color: #fbbf24; border-color: rgba(245,158,11,0.3);">ع</div>
                    <div class="timeline-body">
                      <strong>أ.د. عبد الرحمن السليمان</strong> قام بـ <span style="color: #fbbf24; font-weight: 800;">تحكيم علمي</span>: <a href="/books/al-mustasfa/reader" style="color: var(--text-main); font-weight: 800; text-decoration: underline;">كتاب الرسالة للإمام الشافعي</a>
                    </div>
                  </div>
                  <time class="timeline-time">منذ ساعتين</time>
                </div>
              </div>

              <div class="timeline-item">
                <div class="timeline-dot" style="background: #10b981;"></div>
                <div class="timeline-box">
                  <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div class="timeline-user-avatar" style="background: rgba(16,185,129,0.15); color: #34d399; border-color: rgba(16,185,129,0.3);">أ</div>
                    <div class="timeline-body">
                      <strong>م. أنس خليل</strong> قام بـ <span style="color: #34d399; font-weight: 800;">مزامنة وتفريغ شرائح</span>: <a href="/dev/player/audio/sunan-abi-dawud-01" style="color: var(--text-main); font-weight: 800; text-decoration: underline;">مجلس سنن أبي داود</a>
                    </div>
                  </div>
                  <time class="timeline-time">منذ 4 ساعات</time>
                </div>
              </div>
            </div>
          </div>
        `
      },

      // ========================================================
      // 18. DELETIONS VIEW (النظام -> المهملات)
      // ========================================================
      deletions: {
        title: 'المهملات',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner" style="border-color: rgba(245, 158, 11, 0.3);">
            <div class="view-title-group">
              <h2><span>♻️ المهملات</span></h2>
              <p>خزنة استرجاع المحذوفات المؤقتة لمنع الفقد العرضي للبيانات التراثية</p>
            </div>
            <div class="header-actions">
              <a href="/deletions" class="btn-action-small" style="text-decoration: none;">إدارة سلة المهملات 🗑️</a>
            </div>
          </div>

          <div class="section-card">
            <div class="users-table-wrap">
              <table class="users-table">
                <thead>
                  <tr>
                    <th>الكيان المحذوف</th>
                    <th>النوع الأصلي</th>
                    <th>تاريخ الحذف</th>
                    <th>المدة المتبقية</th>
                    <th>إجراء الاستعادة المباشر</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><strong>مسودة معجم الأنساب القديم (طبعة تجريبية)</strong></td>
                    <td><span class="role-chip chip-studio">كتاب / Book</span></td>
                    <td>أمس 14:20</td>
                    <td><span class="icon-refresh">باقي 29 يوماً</span></td>
                    <td>
                      <button class="btn-action-small" style="color: #34d399; border-color: rgba(16, 185, 129, 0.3);" onclick="alert('تمت استعادة الكيان وإعادته للمكتبة بنجاح!')">استعادة الكيان ♻️</button>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>تسجيل صوتي تجريبي لمجلس السنن</strong></td>
                    <td><span class="role-chip chip-academic">صوتي / Audio</span></td>
                    <td>منذ 4 أيام</td>
                    <td><span class="icon-refresh">باقي 26 يوماً</span></td>
                    <td>
                      <button class="btn-action-small" style="color: #34d399; border-color: rgba(16, 185, 129, 0.3);" onclick="alert('تمت استعادة الكيان بنجاح!')">استعادة الكيان ♻️</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        `
      },

      // ========================================================
      // 19. COMMANDS VIEW (النظام -> الأوامر)
      // ========================================================
      commands: {
        title: 'الأوامر',
        group: 'النظام',
        render: () => `
          <div class="view-header-banner" style="border-color: rgba(99, 102, 241, 0.3);">
            <div class="view-title-group">
              <h2><span>💻 الأوامر</span></h2>
              <p>موجه أوامر النظام وتشغيل أوامر Artisan ومهام الصيانة المباشرة</p>
            </div>
            <div class="header-actions">
              <a href="/system/commands" class="btn-indigo-small" style="text-decoration: none;">لوحة الأوامر الكاملة 🖥️</a>
            </div>
          </div>
          <div style="background: #000; border-radius: 12px; padding: 1.25rem; font-family: monospace; font-size: 0.82rem; color: #34d399; height: 320px; overflow-y: auto;" id="terminalOutput">
            <div>[System Core] Authenticated as Super Admin.</div>
            <div>[System Core] Session secure via TLS • Database: PostgreSQL 16 Connected.</div>
            <div style="color: #a1a1aa;">Ready for commands (e.g. 'cache:clear', 'backup:run', 'queue:work', 'migrate:status')...</div>
          </div>
          <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
            <input type="text" class="form-input" style="flex: 1; background: #121215; border: 1px solid var(--border-subtle); color: #fff; padding: 0.75rem 1rem; border-radius: 10px; font-family: monospace; font-size: 0.8rem;" id="cmdInput" placeholder="اكتب الأمر هنا (مثال: php artisan cache:clear)" onkeydown="if(event.key === 'Enter') runCmd()">
            <button class="btn-primary-small" onclick="runCmd()">تنفيذ الأمر ⚡</button>
          </div>
        `
      }
    };

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
      const view = viewCatalog[viewKey] || viewCatalog.books;

      // Update active sidebar item
      document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
      const activeNav = document.getElementById('nav-' + viewKey);
      
      let groupName = 'المكتبة الرقمية';
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

      // Render content
      const contentArea = document.getElementById('dynamicContentArea');
      contentArea.style.opacity = '0';
      contentArea.style.transform = 'translateY(6px)';
      contentArea.style.transition = 'all 0.2s ease-out';

      setTimeout(() => {
        contentArea.innerHTML = view.render();
        contentArea.style.opacity = '1';
        contentArea.style.transform = 'translateY(0)';
      }, 60);

      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function runCmd() {
      const input = document.getElementById('cmdInput');
      const output = document.getElementById('terminalOutput');
      const cmd = input.value.trim();
      if (!cmd) return;

      const userLine = document.createElement('div');
      userLine.style.color = '#fff';
      userLine.textContent = '$ ' + cmd;
      output.appendChild(userLine);

      const resLine = document.createElement('div');
      resLine.style.color = '#38bdf8';
      resLine.textContent = 'Command executed successfully: [OK]';
      output.appendChild(resLine);

      input.value = '';
      output.scrollTop = output.scrollHeight;
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
        localStorage.setItem('theme', 'dark');
        if (sunIcon) sunIcon.style.display = 'block';
        if (moonIcon) moonIcon.style.display = 'none';
        if (toggleBtn) toggleBtn.title = 'تفعيل الوضع النهاري (Light Mode)';
      } else {
        document.body.classList.add('light-mode');
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

  initTheme();
  loadView('books');
  updateToolbarState();
});

onUnmounted(() => {
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

    /* Adaptive System Health Pills (Dark & Light Mode Harmony) */
    .health-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      padding: 0.32rem 0.75rem;
      border-radius: 9999px;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #f4f4f5;
      font-size: 0.72rem;
      font-weight: 800;
      letter-spacing: 0.02em;
      transition: all 0.2s ease;
    }
    body.light-mode .health-pill {
      background: rgba(16, 185, 129, 0.08);
      border: 1px solid rgba(16, 185, 129, 0.25);
      color: #047857;
    }
    .pulse-dot-green {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #10b981;
      box-shadow: 0 0 8px #10b981;
      animation: pulse 1.5s infinite;
      display: inline-block;
    }
    .status-pill-db {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      padding: 0.32rem 0.75rem;
      border-radius: 9999px;
      background: rgba(16, 185, 129, 0.1);
      border: 1px solid rgba(16, 185, 129, 0.25);
      color: #34d399;
      font-size: 0.72rem;
      font-weight: 800;
      transition: all 0.2s ease;
    }
    body.light-mode .status-pill-db {
      background: rgba(99, 102, 241, 0.08);
      border: 1px solid rgba(99, 102, 241, 0.25);
      color: #4338ca;
    }
    body.light-mode .status-pill-db .pulse-dot-emerald {
      background: #6366f1;
      box-shadow: 0 0 8px #6366f1;
    }
    .pulse-dot-emerald {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #10b981;
      box-shadow: 0 0 8px #10b981;
      animation: pulse 1.5s infinite;
      display: inline-block;
    }
</style>
