<template>
  <header class="app-navbar" id="appNavbar">
    <div class="navbar-right">
      <button class="nav-btn" @click="handleToggleSidebar" title="طي/فرد القائمة الجانبية">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
      </button>

      <!-- Theme Toggle (Dark / Light Theme Toggle) -->
      <button class="nav-btn" id="themeToggleBtn" @click="handleToggleTheme" title="تبديل المظهر النهاري / الليلي">
        <!-- Sun icon (shown in Dark mode to switch to Light) -->
        <svg id="themeIconSun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <!-- Moon icon (shown in Light mode to switch to Dark) -->
        <svg id="themeIconMoon" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      </button>

      <div class="breadcrumbs">
        <a href="javascript:void(0)" @click="handleNavClick('stats')" class="breadcrumb-link" title="نظرة عامة على النظام">الرئيسية</a>
        <svg class="breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="breadcrumb-group" id="breadcrumbGroup">{{ currentGroupTitle || 'المكتبة' }}</span>
        <svg class="breadcrumb-sep" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="current" id="breadcrumbCurrent">{{ currentViewTitle || 'الكتب' }}</span>
      </div>
    </div>

    <div class="navbar-left">
      <div class="search-box">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" placeholder="بحث سريع..." @input="$emit('search', $event.target.value)">
      </div>

      <button class="nav-btn" @click="handleNotifications" title="التنبيهات">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
      </button>

      <!-- User Avatar / Profile Menu -->
      <div class="user-menu-wrapper">
        <button class="user-avatar-btn" id="userAvatarBtn" @click="handleToggleUserDropdown" title="الملف الشخصي وحساب المستخدم">
          <div class="user-avatar-inner">
            <span>{{ userInitial }}</span>
          </div>
        </button>

        <div id="userDropdownMenu" class="user-dropdown-menu" style="display: none;">
          <div class="user-dropdown-header">
            <p class="user-dropdown-name">{{ userName }}</p>
            <p class="user-dropdown-role">{{ userEmail }}</p>
          </div>
          <a href="/superadmin/dashboard" class="user-dropdown-item">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>لوحة التحكم الرئيسية</span>
          </a>
          <div class="user-dropdown-item text-danger" @click="handleLogout">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span>تسجيل الخروج</span>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  currentGroupTitle: {
    type: String,
    default: 'المكتبة'
  },
  currentViewTitle: {
    type: String,
    default: 'الكتب'
  },
  user: {
    type: Object,
    default: () => null
  }
});

const emit = defineEmits([
  'toggleSidebar',
  'toggleTheme',
  'toggleUserDropdown',
  'loadView',
  'search',
  'notifications',
  'logout'
]);

let authUser = null;
try {
  const page = usePage();
  authUser = page?.props?.auth?.user || null;
} catch (e) {
  authUser = null;
}

const userName = computed(() => props.user?.name || authUser?.name || 'د. إبراهيم الفاسي');
const userEmail = computed(() => props.user?.email || authUser?.email || 'super_admin@archive.org');
const userInitial = computed(() => (userName.value ? userName.value.charAt(0) : 'م'));

function handleToggleSidebar() {
  emit('toggleSidebar');
  if (typeof window !== 'undefined' && typeof window.toggleSidebarCollapse === 'function') {
    window.toggleSidebarCollapse();
  }
}

function handleToggleTheme() {
  emit('toggleTheme');
  if (typeof window !== 'undefined' && typeof window.toggleTheme === 'function') {
    window.toggleTheme();
  }
}

function handleToggleUserDropdown() {
  emit('toggleUserDropdown');
  if (typeof window !== 'undefined' && typeof window.toggleUserDropdown === 'function') {
    window.toggleUserDropdown();
  }
}

function handleNavClick(viewKey) {
  emit('loadView', viewKey);
  if (typeof window !== 'undefined' && typeof window.loadView === 'function') {
    window.loadView(viewKey);
  }
}

function handleNotifications() {
  emit('notifications');
  if (typeof alert === 'function') {
    alert('تنبيهات النظام: الحالة مثالية، لا توجد مخاطر.');
  }
}

function handleLogout() {
  emit('logout');
  if (typeof alert === 'function') {
    alert('تم تسجيل الخروج بنجاح.');
  }
  if (typeof location !== 'undefined' && typeof location.reload === 'function') {
    location.reload();
  }
}
</script>
