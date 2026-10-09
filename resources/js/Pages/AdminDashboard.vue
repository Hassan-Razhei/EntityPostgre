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
          <div class="nav-item" id="nav-books" onclick="loadView('books')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>الكتب</span>
            <span class="badge-count">{{ (props.stats?.books ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-manuscripts" onclick="loadView('manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">{{ (props.stats?.manuscripts ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-audios" onclick="loadView('audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">{{ (props.stats?.audios ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-videos" onclick="loadView('videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">{{ (props.stats?.videos ?? 0).toLocaleString() }}</span>
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
            <span class="badge-count">{{ (props.stats?.authors ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-publishers" onclick="loadView('publishers')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span>الناشرون</span>
            <span class="badge-count">{{ (props.stats?.publishers ?? 0).toLocaleString() }}</span>
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
            <span class="group-badge">5</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" id="nav-categories" onclick="loadView('categories')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm5-3a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span>التصنيفات</span>
            <span class="badge-count">{{ (props.stats?.categories ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-tags" onclick="loadView('tags')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span>الأوسمة</span>
            <span class="badge-count">{{ (props.stats?.tags ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-collections" onclick="loadView('collections')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>المجموعات</span>
            <span class="badge-count">{{ (props.stats?.collections ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-series" onclick="loadView('series')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>السلاسل</span>
            <span class="badge-count">{{ (props.stats?.series ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-topics" onclick="loadView('topics')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            <span>الموضوعات</span>
            <span class="badge-count">{{ (props.stats?.topics ?? 0).toLocaleString() }}</span>
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
            <span class="badge-count">{{ (props.stats?.studio_books ?? 0).toLocaleString() }} مسودة</span>
          </div>
          <div class="nav-item" id="nav-studio-manuscripts" onclick="loadView('studio-manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">{{ (props.stats?.studio_manuscripts ?? 0).toLocaleString() }} لوحة</span>
          </div>
          <div class="nav-item" id="nav-studio-audios" onclick="loadView('studio-audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">{{ (props.stats?.studio_audios ?? 0).toLocaleString() }} شريحة</span>
          </div>
          <div class="nav-item" id="nav-studio-videos" onclick="loadView('studio-videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">{{ (props.stats?.studio_videos ?? 0).toLocaleString() }} مشهد</span>
          </div>
          <div class="nav-item" id="nav-versions" onclick="loadView('versions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>الإصدارات</span>
            <span class="badge-count" style="color: #38bdf8;">{{ (props.stats?.versions ?? 0).toLocaleString() }}</span>
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
          <div class="nav-item active" id="nav-stats" onclick="loadView('stats')">
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
            <span class="badge-count">{{ (props.stats?.users ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-activities" onclick="loadView('activities')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>النشاطات</span>
            <span class="badge-count">{{ (props.stats?.activities ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" id="nav-deletions" onclick="loadView('deletions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span>المهملات</span>
            <span class="badge-count icon-refresh">{{ (props.stats?.deletions ?? 0).toLocaleString() }}</span>
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
          <a href="/superadmin/dashboard" class="user-dropdown-item">
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
      <!-- 1. Books Asset Table -->
      <AssetTableView
        v-if="currentViewKey === 'books'"
        asset-title="الكتب"
        asset-type="books"
        :stats="booksKpiStats"
        :columns="booksColumns"
        :rows="activeBooksRows"
        :total="props.stats?.books || activeBooksRows.length"
        create-url="/books/create"
      />
      <!-- 2. Manuscripts Asset Table -->
      <AssetTableView
        v-else-if="currentViewKey === 'manuscripts'"
        asset-title="المخطوطات"
        asset-type="manuscripts"
        :stats="manuscriptsKpiStats"
        :columns="manuscriptsColumns"
        :rows="activeManuscriptsRows"
        :total="props.stats?.manuscripts || activeManuscriptsRows.length"
        create-url="/manuscripts/create"
      />
      <!-- 3. Audios Asset Table -->
      <AssetTableView
        v-else-if="currentViewKey === 'audios'"
        asset-title="الصوتيات"
        asset-type="audios"
        :stats="audiosKpiStats"
        :columns="audiosColumns"
        :rows="activeAudiosRows"
        :total="props.stats?.audios || activeAudiosRows.length"
        create-url="/audios/create"
      />
      <!-- 4. Videos Asset Table -->
      <AssetTableView
        v-else-if="currentViewKey === 'videos'"
        asset-title="المرئيات"
        asset-type="videos"
        :stats="videosKpiStats"
        :columns="videosColumns"
        :rows="activeVideosRows"
        :total="props.stats?.videos || activeVideosRows.length"
        create-url="/videos/create"
      />
      <!-- 5. Authors Asset Table (قطاع الأشخاص -> المؤلفون) -->
      <AssetTableView
        v-else-if="currentViewKey === 'authors'"
        asset-title="المؤلفون"
        asset-type="authors"
        initial-view-mode="cards"
        :stats="authorsKpiStats"
        :columns="authorsColumns"
        :rows="activeAuthorsRows"
        :total="props.stats?.authors || activeAuthorsRows.length"
        create-url="/authors/create"
      />
      <!-- 6. Publishers Asset Table (قطاع الأشخاص -> الناشرون) -->
      <AssetTableView
        v-else-if="currentViewKey === 'publishers'"
        asset-title="الناشرون"
        asset-type="publishers"
        initial-view-mode="cards"
        :stats="publishersKpiStats"
        :columns="publishersColumns"
        :rows="activePublishersRows"
        :total="props.stats?.publishers || activePublishersRows.length"
        create-url="/publishers/create"
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
      <!-- 10. Dynamic Viewport for other views -->
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

const viewCatalog = {
      // ========================================================
      // 1. BOOKS VIEW (المكتبة -> الكتب)
      // ========================================================
      books: {
        title: 'الكتب',
        group: 'المكتبة',
      },

      // ========================================================
      // 2. MANUSCRIPTS VIEW (المكتبة -> المخطوطات)
      // ========================================================
      manuscripts: {
        title: 'المخطوطات',
        group: 'المكتبة',
      },

      // ========================================================
      // 3. AUDIOS VIEW (المكتبة -> الصوتيات)
      // ========================================================
      audios: {
        title: 'الصوتيات',
        group: 'المكتبة',
      },

      // ========================================================
      // 4. VIDEOS VIEW (المكتبة -> المرئيات)
      // ========================================================
      videos: {
        title: 'المرئيات',
        group: 'المكتبة',
      },

      // ========================================================
      // 5. AUTHORS VIEW (الأشخاص -> المؤلفون)
      // ========================================================
      authors: {
        title: 'المؤلفون',
        group: 'الأشخاص',
      },

      // ========================================================
      // 6. PUBLISHERS VIEW (الأشخاص -> دور النشر)
      // ========================================================
      publishers: {
        title: 'الناشرون',
        group: 'الأشخاص',
      },

      // ========================================================
      // 7. CATEGORIES VIEW (التنظيم -> التصنيفات)
      // ========================================================
      categories: {
        title: 'التصنيفات',
        group: 'التنظيم',
        render: () => {
          const catNodes = props.categories && props.categories.length > 0
            ? props.categories.map((cat, idx) => `
              <div class="tree-node ${idx > 0 ? 'child' : ''}" style="${idx > 0 ? 'margin-right: ' + Math.min(idx * 0.75 + 1, 3) + 'rem; border-right-color: ' + (idx % 2 === 0 ? '#a855f7' : '#3b82f6') + ';' : ''}">
                <span>${idx === 0 ? '📂' : (idx % 2 === 0 ? '📜' : '⚖️')} ${cat.name}</span>
                <span class="badge-count">${(cat.books_count ?? 0).toLocaleString()} مصنفاً</span>
              </div>
            `).join('')
            : `
              <div class="tree-node">
                <span>📂 شجرة التصنيفات العامة</span>
                <span class="badge-count">0 مصنفاً</span>
              </div>
            `;

          return `
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
              ${catNodes}
            </div>
          `;
        }
      },

      // ========================================================
      // 8. TAGS VIEW (التنظيم -> الأوسمة)
      // ========================================================
      tags: {
        title: 'الأوسمة',
        group: 'التنظيم',
        render: () => {
          const tagChips = props.tags && props.tags.length > 0
            ? props.tags.map((tag, idx) => {
              const chipClass = idx % 3 === 0 ? 'tag-public' : (idx % 3 === 1 ? 'tag-scholarly' : 'tag-draft');
              const count = tag.books_count ?? 0;
              const size = Math.max(0.72, Math.min(0.95, 0.72 + (count / 100) * 0.2)).toFixed(2);
              return `<span class="entity-tag ${chipClass}" style="font-size: ${size}rem; padding: 0.35rem 0.75rem;">#${tag.name} (${count})</span>`;
            }).join('')
            : '<span style="color: var(--text-dim); font-size: 0.85rem;">لا توجد أوسمة مفهرسة حالياً</span>';

          return `
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
                ${tagChips}
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 8b. COLLECTIONS VIEW (التنظيم -> المجموعات)
      // ========================================================
      collections: {
        title: 'المجموعات',
        group: 'التنظيم',
        render: () => {
          const rows = props.collections && props.collections.length > 0
            ? props.collections.map((col) => `
              <tr>
                <td>
                  <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">${col.name}</div>
                  <div style="font-size: 0.72rem; color: var(--text-dim); margin-top: 0.2rem;">${col.description || 'لا يوجد وصف للمجموعة'}</div>
                </td>
                <td>
                  <span class="role-chip ${col.is_public ? 'chip-studio' : 'chip-academic'}">
                    ${col.is_public ? 'عامة 🌐' : 'خاصة 🔒'}
                  </span>
                </td>
                <td>
                  <span class="badge-count" style="font-size: 0.8rem; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                    ${col.entities_count || 0}
                  </span>
                </td>
                <td>
                  <div style="font-size: 0.8rem; color: var(--text-main);">${col.user_name || 'المشرف العام'}</div>
                </td>
                <td>
                  <div style="display: flex; gap: 0.4rem; align-items: center;">
                    <a href="${col.show_url || '/collections/' + col.id}" class="btn-emerald-small" style="text-decoration: none;">
                      <span>استعراض 👁️</span>
                    </a>
                    <a href="${col.edit_url || '/collections/' + col.id + '/edit'}" class="btn-action-small" style="text-decoration: none;">
                      <span>تعديل ⚙️</span>
                    </a>
                  </div>
                </td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="5" style="text-align: center; color: var(--text-dim); padding: 2.5rem;">لا توجد مجموعات معرفية منشأة حالياً</td>
              </tr>
            `;

          return `
            <div class="view-header-banner">
              <div class="view-title-group">
                <h2><span>📦 المجموعات المختارة</span></h2>
                <p>إدارة المجموعات المعرفية والأصول البوليمورفية المتعددة (كتب، مخطوطات، صوتيات، ومرئيات)</p>
              </div>
              <div class="header-actions">
                <a href="/collections/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                  <span>+ مجموعة جديدة</span>
                </a>
              </div>
            </div>

            <div class="section-card">
              <div class="users-table-wrap">
                <table class="users-table">
                  <thead>
                    <tr>
                      <th>اسم المجموعة والوصف</th>
                      <th>حالة الرؤية</th>
                      <th>إجمالي الأصول المرتبطة</th>
                      <th>المنشئ / المنسق</th>
                      <th>الإجراءات</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 8c. SERIES VIEW (التنظيم -> السلاسل)
      // ========================================================
      series: {
        title: 'السلاسل',
        group: 'التنظيم',
        render: () => {
          const rows = props.series && props.series.length > 0
            ? props.series.map((ser, idx) => `
              <tr>
                <td>
                  <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">${ser.title}</div>
                  <div style="font-size: 0.72rem; color: var(--text-dim); margin-top: 0.2rem;">${ser.description || 'سلسلة علمية متسلسلة'}</div>
                </td>
                <td>
                  <span class="badge-count" style="font-size: 0.8rem; background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3);">
                    ${ser.books_count || 0} مصنفاً
                  </span>
                </td>
                <td>
                  <span class="role-chip chip-studio">ترتيب #${ser.order_column || (idx + 1)}</span>
                </td>
                <td>
                  <div style="display: flex; gap: 0.4rem; align-items: center;">
                    <a href="${ser.show_url || '/series/' + ser.id}" class="btn-emerald-small" style="text-decoration: none;">
                      <span>استعراض السلسلة 📚</span>
                    </a>
                    <a href="${ser.edit_url || '/series/' + ser.id + '/edit'}" class="btn-action-small" style="text-decoration: none;">
                      <span>تعديل ⚙️</span>
                    </a>
                  </div>
                </td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="4" style="text-align: center; color: var(--text-dim); padding: 2.5rem;">لا توجد سلاسل علمية مدرجة حالياً</td>
              </tr>
            `;

          return `
            <div class="view-header-banner">
              <div class="view-title-group">
                <h2><span>📚 السلاسل العلمية</span></h2>
                <p>إدارة السلاسل والموسوعات العلمية ومتابعة ترقيم الأجزاء والمصنفات المتسلسلة</p>
              </div>
              <div class="header-actions">
                <a href="/series/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                  <span>+ سلسلة جديدة</span>
                </a>
              </div>
            </div>

            <div class="section-card">
              <div class="users-table-wrap">
                <table class="users-table">
                  <thead>
                    <tr>
                      <th>عنوان السلسلة والبيان</th>
                      <th>عدد المصنفات والأجزاء</th>
                      <th>الترتيب العام</th>
                      <th>الإجراءات المباشرة</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 8d. TOPICS VIEW (التنظيم -> الموضوعات)
      // ========================================================
      topics: {
        title: 'الموضوعات',
        group: 'التنظيم',
        render: () => {
          const cards = props.topics && props.topics.length > 0
            ? props.topics.map((top, idx) => `
              <div class="tree-node" style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1.1rem; border-right: 4px solid ${idx % 3 === 0 ? '#38bdf8' : (idx % 3 === 1 ? '#a855f7' : '#34d399')};">
                <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                  <span style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">💡 ${top.name}</span>
                  <span style="font-size: 0.7rem; color: var(--text-dim); font-family: monospace;">#${top.slug}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.6rem;">
                  <span class="badge-count" style="font-size: 0.78rem; background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3);">
                    ${top.books_count || 0} مصنفاً
                  </span>
                  <a href="/topics/${top.id}" class="btn-action-small" style="text-decoration: none; font-size: 0.72rem;">استعراض 🔍</a>
                </div>
              </div>
            `).join('')
            : `
              <div style="text-align: center; color: var(--text-dim); padding: 2.5rem;">لا توجد موضوعات تخصصية مفهرسة حالياً</div>
            `;

          return `
            <div class="view-header-banner">
              <div class="view-title-group">
                <h2><span>💡 الموضوعات التخصصية</span></h2>
                <p>فهرسة رؤوس الموضوعات والمسائل العلمية الدقيقة وربطها بالمصنفات التراثية</p>
              </div>
              <div class="header-actions">
                <a href="/topics/create" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                  <span>+ موضوع جديد</span>
                </a>
              </div>
            </div>

            <div class="section-card">
              <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 0.85rem;">
                ${cards}
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 9. STUDIO BOOKS (الاستوديو -> الكتب)
      // ========================================================
      'studio-books': {
        title: 'الكتب',
        group: 'الاستوديو',
        render: () => {
          const rows = props.studioBooks && props.studioBooks.length > 0
            ? props.studioBooks.map(b => `
              <tr>
                <td><strong>${b.title}</strong></td>
                <td>${b.current_node || 'الباب الأول: المقدمة التمهيدية'}</td>
                <td>
                  <div class="kpi-split-bar" style="height: 6px; width: 120px;"><div style="width: ${b.progress_percent || 75}%; background: #10b981;"></div></div>
                  <span style="font-size: 0.65rem; color: #10b981; font-weight: 800;">${b.progress_percent || 75}%</span>
                </td>
                <td>${b.editor_name || 'فريق التحقيق الأكاديمي'}</td>
                <td>${b.updated_at_human || 'مؤخراً'}</td>
                <td>
                  <a href="${b.studio_url || '/studio/book/' + b.slug}" class="btn-emerald-small"><span>فتح المحرر ✍️</span></a>
                </td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="6" style="text-align: center; color: var(--text-dim); padding: 2rem;">لا توجد مسودات كتب قيد التحرير حالياً</td>
              </tr>
            `;

          return `
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
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 10. STUDIO MANUSCRIPTS (الاستوديو -> المخطوطات)
      // ========================================================
      'studio-manuscripts': {
        title: 'المخطوطات',
        group: 'الاستوديو',
        render: () => {
          const rows = props.manuscripts && props.manuscripts.length > 0
            ? props.manuscripts.slice(0, 10).map((m, idx) => `
              <tr>
                <td><strong>${m.title}</strong></td>
                <td>${m.folio_count || 'لوحة رقم ' + (idx * 12 + 14) + ' (الوجه أ)'}</td>
                <td><span class="role-chip ${idx % 2 === 0 ? 'chip-studio' : 'chip-academic'}">${idx % 2 === 0 ? 'مطابق بنسبة 100%' : 'قيد فك الطلاسم'}</span></td>
                <td>${m.author || 'د. طارق الحارثي'}</td>
                <td>
                  <a href="${m.studio_url || '/studio/manuscript/' + m.slug}" class="btn-emerald-small"><span>متابعة التحقيق ✍️</span></a>
                </td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="5" style="text-align: center; color: var(--text-dim); padding: 2rem;">لا توجد مخطوطات قيد المقابلة حالياً</td>
              </tr>
            `;

          return `
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
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 11. STUDIO AUDIOS (الاستوديو -> الصوتيات)
      // ========================================================
      'studio-audios': {
        title: 'الصوتيات',
        group: 'الاستوديو',
        render: () => {
          const rows = props.audios && props.audios.length > 0
            ? props.audios.slice(0, 10).map((a, idx) => `
              <tr>
                <td><strong>${a.title}</strong></td>
                <td>${a.duration || '01:15:30'}</td>
                <td>${(idx * 8 + 14)} شريحة</td>
                <td><span style="color: #34d399; font-weight: 800;">${(98.5 + (idx % 2)).toFixed(1)}%</span></td>
                <td><a href="${a.studio_url || '/studio/audio/' + a.slug}" class="btn-emerald-small"><span>فتح محرر الشرائح ✍️</span></a></td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="5" style="text-align: center; color: var(--text-dim); padding: 2rem;">لا توجد جلسات صوتية قيد التقطيع حالياً</td>
              </tr>
            `;

          return `
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
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 12. STUDIO VIDEOS (الاستوديو -> المرئيات)
      // ========================================================
      'studio-videos': {
        title: 'المرئيات',
        group: 'الاستوديو',
        render: () => {
          const rows = props.videos && props.videos.length > 0
            ? props.videos.slice(0, 10).map((v, idx) => `
              <tr>
                <td><strong>${v.title}</strong></td>
                <td>${v.duration || '02:15:00'}</td>
                <td>${(idx + 4)} فصول رئيسية</td>
                <td><a href="${v.studio_url || '/studio/video/' + v.slug}" class="btn-purple-small"><span>تقطيع الفصول 🎬</span></a></td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="4" style="text-align: center; color: var(--text-dim); padding: 2rem;">لا توجد تسجيلات مرئية قيد التقطيع حالياً</td>
              </tr>
            `;

          return `
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
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 13. VERSIONS VIEW (الاستوديو -> الإصدارات)
      // ========================================================
      versions: {
        title: 'الإصدارات',
        group: 'الاستوديو',
        render: () => {
          const versionsList = props.versions && props.versions.length > 0 ? props.versions : [];
          const topVersion = versionsList[0];
          const prevVersion = versionsList[1] || versionsList[0];

          const diffHeaderTitle = topVersion
            ? `مقارنة النسخة ${topVersion.title} مع ${versionsList.length > 1 ? 'النسخة السابقة ' + prevVersion.title : 'الأصل المعتمد'}`
            : 'مقارنة النسخ والمطابقة النصية';
          const diffHeaderChip = topVersion ? topVersion.versionable_title : 'الأرشيف الموحد';

          const rows = versionsList.length > 0
            ? versionsList.map((v, idx) => `
              <tr>
                <td><strong>${v.title}</strong></td>
                <td>${v.versionable_title}</td>
                <td>${v.publisher_name}</td>
                <td><span class="icon-import">${v.file_size_human}</span> / <span style="color: #38bdf8;">${v.format}</span></td>
                <td>${v.created_at_human}</td>
                <td>
                  ${idx === 0
                    ? '<span class="role-chip chip-studio">النسخة النشطة</span>'
                    : `<button class="btn-action-small" onclick="alert('تم استرجاع النسخة #${v.id} بنجاح عبر مسار studio.restore!')">استرجاع النسخة ↩️</button>`
                  }
                </td>
              </tr>
            `).join('')
            : `
              <tr>
                <td colspan="6" style="text-align: center; color: var(--text-dim); padding: 2rem;">لا توجد إصدارات مؤرشفة حالياً</td>
              </tr>
            `;

          return `
            <div class="view-header-banner">
              <div class="view-title-group">
                <h2><span>📜 الإصدارات</span></h2>
                <p>محرك تاريخ التعديلات ومقارنة الفروق اللحظية للنسخ مع إمكانية الاسترجاع</p>
              </div>
            </div>

            <div class="section-card">
              <div class="section-header">
                <h3 class="section-title">${diffHeaderTitle}</h3>
                <span class="role-chip chip-studio">${diffHeaderChip}</span>
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
                      <th>الناشر / المحرر</th>
                      <th>الحجم والصيغة</th>
                      <th>التاريخ</th>
                      <th>إجراء الاسترجاع</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${rows}
                  </tbody>
                </table>
              </div>
            </div>
          `;
        }
      },

      // ========================================================
      // 14. STATS VIEW (النظام -> الإحصائيات - Overview)
      // ========================================================
      stats: {
        title: 'الإحصائيات',
        group: 'النظام',
        render: () => {
          const booksCount = (props.stats?.books ?? 0).toLocaleString();
          const manuscriptsCount = (props.stats?.manuscripts ?? 0).toLocaleString();
          const audiosCount = (props.stats?.audios ?? 0).toLocaleString();
          const videosCount = (props.stats?.videos ?? 0).toLocaleString();

          const funnelDrafts = (props.stats?.funnel_drafts ?? props.stats?.studio_books ?? 0).toLocaleString();
          const funnelReviewed = (props.stats?.funnel_reviewed ?? props.stats?.manuscripts ?? 0).toLocaleString();
          const funnelScholarly = (props.stats?.funnel_scholarly ?? 0).toLocaleString();
          const funnelPublished = (props.stats?.funnel_published ?? props.stats?.books ?? 0).toLocaleString();

          return `
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
                <div class="kpi-value icon-export">${booksCount}</div>
                <div class="kpi-split-bar">
                  <div style="width: 75%; background: #3b82f6;"></div>
                  <div style="width: 25%; background: #f59e0b;"></div>
                </div>
                <div class="kpi-split-subtext"><span>75% منشور</span><span>25% مسودة</span></div>
              </div>

              <!-- Manuscripts KPI -->
              <div class="kpi-card" style="cursor: pointer;" onclick="loadView('manuscripts')">
                <div class="kpi-title">خزانة المخطوطات النادرة [Manuscripts]</div>
                <div class="kpi-value icon-refresh">${manuscriptsCount}</div>
                <div class="kpi-split-bar">
                  <div style="width: 65%; background: #f59e0b;"></div>
                  <div style="width: 35%; background: #ef4444;"></div>
                </div>
                <div class="kpi-split-subtext"><span>65% لوحات مرممة</span><span>35% قيد الفحص</span></div>
              </div>

              <!-- Audios KPI -->
              <div class="kpi-card" style="cursor: pointer;" onclick="loadView('audios')">
                <div class="kpi-title">التسجيلات الصوتية المفرغة [Audios]</div>
                <div class="kpi-value icon-import">${audiosCount}</div>
                <div class="kpi-split-bar">
                  <div style="width: 80%; background: #10b981;"></div>
                  <div style="width: 20%; background: #3b82f6;"></div>
                </div>
                <div class="kpi-split-subtext"><span>80% شرائح مفرغة</span><span>20% تسجيل نقي</span></div>
              </div>

              <!-- Videos KPI -->
              <div class="kpi-card" style="cursor: pointer;" onclick="loadView('videos')">
                <div class="kpi-title">المرئيات والندوات المصورة [Videos]</div>
                <div class="kpi-value" style="color: #c084fc;">${videosCount}</div>
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
                  <div class="funnel-step-num icon-refresh">${funnelDrafts}</div>
                </div>
                <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
                <div class="funnel-step">
                  <div class="funnel-step-label">التحقيق والمقابلة ✍️</div>
                  <div class="funnel-step-num" style="color: #38bdf8;">${funnelReviewed}</div>
                </div>
                <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
                <div class="funnel-step">
                  <div class="funnel-step-label">الاعتماد والتحكيم 🎓</div>
                  <div class="funnel-step-num" style="color: #a855f7;">${funnelScholarly}</div>
                </div>
                <div style="color: var(--text-dim); font-size: 1.25rem;">‹</div>
                <div class="funnel-step">
                  <div class="funnel-step-label">منشور للعامة 🌐</div>
                  <div class="funnel-step-num" style="color: #10b981;">${funnelPublished}</div>
                </div>
              </div>
            </div>
          `;
        }
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
              <div class="entity-card" style="cursor: pointer;" onclick="triggerOpsCacheClear()">
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
      // ========================================================
      // 16. USERS VIEW (النظام -> المستخدمون)
      // ========================================================
      users: {
        title: 'المستخدمون',
        group: 'النظام',
      },

      // ========================================================
      // 17. ACTIVITIES VIEW (النظام -> النشاطات)
      // ========================================================
      activities: {
        title: 'النشاطات',
        group: 'النظام',
      },

      // ========================================================
      // 18. DELETIONS VIEW (النظام -> المهملات)
      // ========================================================
      deletions: {
        title: 'المهملات',
        group: 'النظام',
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

          <div class="section-card" style="margin-bottom: 1.25rem;">
            <div class="section-header" style="margin-bottom: 0.85rem;">
              <h3 class="section-title">⚡ أوامر المنظومة المخصصة (Console Commands)</h3>
              <span class="role-chip chip-super">7 أوامر سيادية مخصصة</span>
            </div>
            <p style="font-size: 0.75rem; color: var(--text-dim); margin-bottom: 1rem;">
              أوامر Artisan مخصصة في <code>app/Console/Commands</code> لإدارة الأصول والمخطوطات ومزامنة التخزين وبذر البيانات وتحليل المعمارية. اضغط على أي أمر لتشغيله ومتابعة مخرجاته فورياً:
            </p>
            <div class="catalog-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 0.75rem;">
              
              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('storage:sync')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">🗄️ مزامنة التخزين الرقمي</span>
                    <span class="role-chip chip-admin" style="font-size: 0.65rem;">storage</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">storage:sync</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">فحص مجلدات التخزين وربط الملفات المرفوعة وتحديث البيانات الوصفية للمصنفات.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('storage:sync')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('manuscript:sync')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">📜 مزامنة صفحات المخطوطات</span>
                    <span class="role-chip chip-editor" style="font-size: 0.65rem;">manuscripts</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">manuscript:sync</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">استخراج ومعالجة صفحات المخطوطات تلقائياً من مستندات docx ومطابقتها.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('manuscript:sync')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('manuscriptsData:sync')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">📑 استيراد بيانات المخطوطات</span>
                    <span class="role-chip chip-editor" style="font-size: 0.65rem;">legacy-data</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">manuscriptsData:sync</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">استيراد وتحديث بيانات المخطوطات التاريخية من ملفات CSV/Excel إلى المخطط الجديد.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('manuscriptsData:sync')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('media:import-transcripts')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">🎙️ استيراد التفريغات النصية</span>
                    <span class="role-chip chip-user" style="font-size: 0.65rem;">media</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">media:import-transcripts</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">معالجة واستيراد نصوص docx وتحويلها لقطع زمنية مرتبطة بالصوتيات والمرئيات.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('media:import-transcripts')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('project:seed-realistic')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">🌱 بذر البيانات الواقعية</span>
                    <span class="role-chip chip-super" style="font-size: 0.65rem;">database</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">project:seed-realistic</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">تغذية قاعدة البيانات ببيانات عربية متكاملة لجميع الكيانات لأغراض التطوير.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('project:seed-realistic')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('content:regenerate-slugs')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">🔗 إعادة توليد المعرفات النصية</span>
                    <span class="role-chip chip-admin" style="font-size: 0.65rem;">slugs</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">content:regenerate-slugs</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">إعادة توليد وتحديث الروابط اللطيفة (Slugs) لكافة العقد والمصنفات في PostgreSQL.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('content:regenerate-slugs')">تشغيل ⚡</button>
                </div>
              </div>

              <div class="entity-card" style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);" onclick="runPresetCmd('analyze:architecture')">
                <div>
                  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main);">🏗️ تحليل معمارية النظام</span>
                    <span class="role-chip chip-super" style="font-size: 0.65rem;">architecture</span>
                  </div>
                  <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">analyze:architecture</code>
                  <p style="font-size: 0.72rem; color: var(--text-dim); line-height: 1.4;">تحليل معماري شامل واكتشاف التكرار البرمجي وإحصائيات ملفات ودوال النظام.</p>
                </div>
                <div style="margin-top: 0.75rem; text-align: left;">
                  <button type="button" class="btn-primary-small" style="font-size: 0.7rem; padding: 0.25rem 0.65rem;" onclick="event.stopPropagation(); runPresetCmd('analyze:architecture')">تشغيل ⚡</button>
                </div>
              </div>

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

        const vueComponentViews = ['books', 'manuscripts', 'audios', 'videos', 'authors', 'publishers', 'users', 'deletions', 'activities'];
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
  const vueComponentViews = ['books', 'manuscripts', 'audios', 'videos', 'authors', 'publishers', 'users', 'deletions', 'activities'];
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
