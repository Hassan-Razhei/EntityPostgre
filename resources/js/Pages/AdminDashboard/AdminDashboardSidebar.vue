<template>
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header">
      <a href="javascript:void(0)" @click="handleNavClick('stats')" class="sidebar-brand-link" title="Entity Dashboard">
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
          <button type="button" class="seg-btn" id="btnExpandAll" @click="handleExpandAll" title="توسيع كافة المجموعات دفعة واحدة">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
            <span>توسيع</span>
          </button>
          <button type="button" class="seg-btn" id="btnCollapseAll" @click="handleCollapseAll" title="طي كافة المجموعات دفعة واحدة">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"/></svg>
            <span>طي</span>
          </button>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 1: 📚 المكتبة الرقمية العامة (General Assets)
           ======================================================== -->
      <div class="nav-group" id="group-library">
        <div class="nav-group-header" @click="handleToggleGroup('group-library')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>📚</span>
            <span class="group-title">المكتبة</span>
            <span class="group-badge">4</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" :class="{ active: currentViewKey === 'books' }" id="nav-books" @click="handleNavClick('books')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>الكتب</span>
            <span class="badge-count">{{ (stats?.books ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'manuscripts' }" id="nav-manuscripts" @click="handleNavClick('manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">{{ (stats?.manuscripts ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'audios' }" id="nav-audios" @click="handleNavClick('audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">{{ (stats?.audios ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'videos' }" id="nav-videos" @click="handleNavClick('videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">{{ (stats?.videos ?? 0).toLocaleString() }}</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 2: 👥 الأشخاص والجهات (Biographies & Publishers)
           ======================================================== -->
      <div class="nav-group" id="group-entities">
        <div class="nav-group-header" @click="handleToggleGroup('group-entities')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>👥</span>
            <span class="group-title">الأشخاص</span>
            <span class="group-badge">2</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" :class="{ active: currentViewKey === 'authors' }" id="nav-authors" @click="handleNavClick('authors')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>المؤلفون</span>
            <span class="badge-count">{{ (stats?.authors ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'publishers' }" id="nav-publishers" @click="handleNavClick('publishers')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span>الناشرون</span>
            <span class="badge-count">{{ (stats?.publishers ?? 0).toLocaleString() }}</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 3: 🏷️ البيانات والتنظيم المعرفي (Taxonomies)
           ======================================================== -->
      <div class="nav-group" id="group-taxonomy">
        <div class="nav-group-header" @click="handleToggleGroup('group-taxonomy')" title="طي / توسيع المجموعة">
          <div class="header-main">
            <span>🏷️</span>
            <span class="group-title">التنظيم</span>
            <span class="group-badge">5</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" :class="{ active: currentViewKey === 'categories' }" id="nav-categories" @click="handleNavClick('categories')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm5-3a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span>التصنيفات</span>
            <span class="badge-count">{{ (stats?.categories ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'tags' }" id="nav-tags" @click="handleNavClick('tags')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span>الأوسمة</span>
            <span class="badge-count">{{ (stats?.tags ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'collections' }" id="nav-collections" @click="handleNavClick('collections')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span>المجموعات</span>
            <span class="badge-count">{{ (stats?.collections ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'series' }" id="nav-series" @click="handleNavClick('series')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            <span>السلاسل</span>
            <span class="badge-count">{{ (stats?.series ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'topics' }" id="nav-topics" @click="handleNavClick('topics')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            <span>الموضوعات</span>
            <span class="badge-count">{{ (stats?.topics ?? 0).toLocaleString() }}</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 4: ✍️ استوديو الكيانات والتحقيق (Entity Studio - 4 Models)
           ======================================================== -->
      <div class="nav-group" id="group-studio">
        <div class="nav-group-header" @click="handleToggleGroup('group-studio')" title="طي / توسيع استوديو الكيانات">
          <div class="header-main">
            <span>✍️</span>
            <span class="group-title">الاستوديو</span>
            <span class="group-badge">5</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" :class="{ active: currentViewKey === 'studio-books' }" id="nav-studio-books" @click="handleNavClick('studio-books')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>الكتب</span>
            <span class="badge-count">{{ (stats?.studio_books ?? 0).toLocaleString() }} مسودة</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'studio-manuscripts' }" id="nav-studio-manuscripts" @click="handleNavClick('studio-manuscripts')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>المخطوطات</span>
            <span class="badge-count">{{ (stats?.studio_manuscripts ?? 0).toLocaleString() }} لوحة</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'studio-audios' }" id="nav-studio-audios" @click="handleNavClick('studio-audios')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            <span>الصوتيات</span>
            <span class="badge-count">{{ (stats?.studio_audios ?? 0).toLocaleString() }} شريحة</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'studio-videos' }" id="nav-studio-videos" @click="handleNavClick('studio-videos')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>المرئيات</span>
            <span class="badge-count">{{ (stats?.studio_videos ?? 0).toLocaleString() }} مشهد</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'versions' }" id="nav-versions" @click="handleNavClick('versions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>الإصدارات</span>
            <span class="badge-count" style="color: #38bdf8;">{{ (stats?.versions ?? 0).toLocaleString() }}</span>
          </div>
        </div>
      </div>

      <!-- ========================================================
           المجموعة 5: 👑 الإدارة والحوكمة (Super Admin)
           ======================================================== -->
      <div class="nav-group sovereign-group" id="group-sovereignty">
        <div class="nav-group-header" @click="handleToggleGroup('group-sovereignty')" title="طي / توسيع مجموعة الإدارة والحوكمة">
          <div class="header-main">
            <span>👑</span>
            <span class="group-title">النظام</span>
            <span class="group-badge">6</span>
          </div>
          <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
        </div>
        <div class="nav-group-items">
          <div class="nav-item" :class="{ active: currentViewKey === 'stats' }" id="nav-stats" @click="handleNavClick('stats')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>الإحصائيات</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'ops' }" id="nav-ops" @click="handleNavClick('ops')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>العمليات</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'users' }" id="nav-users" @click="handleNavClick('users')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>المستخدمون</span>
            <span class="badge-count">{{ (stats?.users ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'activities' }" id="nav-activities" @click="handleNavClick('activities')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>النشاطات</span>
            <span class="badge-count">{{ (stats?.activities ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'deletions' }" id="nav-deletions" @click="handleNavClick('deletions')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span>المهملات</span>
            <span class="badge-count icon-refresh">{{ (stats?.deletions ?? 0).toLocaleString() }}</span>
          </div>
          <div class="nav-item" :class="{ active: currentViewKey === 'commands' }" id="nav-commands" @click="handleNavClick('commands')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>الأوامر</span>
          </div>
        </div>
      </div>
    </nav>
  </aside>
</template>

<script setup>
const props = defineProps({
  stats: {
    type: Object,
    default: () => ({})
  },
  currentViewKey: {
    type: String,
    default: 'stats'
  }
});

const emit = defineEmits(['loadView', 'toggleGroup', 'expandAll', 'collapseAll']);

function handleNavClick(viewKey) {
  emit('loadView', viewKey);
  if (typeof window !== 'undefined' && typeof window.loadView === 'function') {
    window.loadView(viewKey);
  }
}

function handleToggleGroup(groupId) {
  emit('toggleGroup', groupId);
  if (typeof window !== 'undefined' && typeof window.toggleNavGroup === 'function') {
    window.toggleNavGroup(groupId);
  }
}

function handleExpandAll() {
  emit('expandAll');
  if (typeof window !== 'undefined' && typeof window.expandAllGroups === 'function') {
    window.expandAllGroups();
  }
}

function handleCollapseAll() {
  emit('collapseAll');
  if (typeof window !== 'undefined' && typeof window.collapseAllGroups === 'function') {
    window.collapseAllGroups();
  }
}
</script>
