<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, inject, onMounted, onUnmounted } from 'vue';
import { route } from 'ziggy-js';
import { useAuth } from '@/Composables/useAuth';

defineProps({
    title: {
        type: String,
        default: ''
    },
    group: {
        type: String,
        default: ''
    },
    isSidebarOpen: {
        type: Boolean,
        default: true
    }
});

defineEmits(['toggleSidebar']);

const { isDark, toggleDarkMode } = inject('themeContext', {
    isDark: ref(false),
    toggleDarkMode: () => {}
});

const isUserMenuOpen = ref(false);
const navbarSearch = ref('');
const { user, isGuest } = useAuth();

const performSearch = () => {
    if (navbarSearch.value.trim()) {
        try {
            router.get(route('search'), { q: navbarSearch.value });
        } catch {
            router.get('/search', { q: navbarSearch.value });
        }
    }
};

const handleDocumentClick = (e) => {
    const wrapper = document.querySelector('.user-menu-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        isUserMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
});

onUnmounted(() => {
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<template>
  <nav class="app-navbar h-16 sticky top-0 z-40 bg-white/90 dark:bg-[#0d0d10]/85 backdrop-blur-md border-b border-gray-100 dark:border-white/10 flex items-center justify-between px-6 transition-all duration-300">

    <!-- Navbar Right: Sidebar Toggle, Theme Toggle & 3-Tier Breadcrumbs -->
    <div class="navbar-right flex items-center gap-3">
      <!-- Toggle Sidebar Button -->
      <button
        type="button"
        id="sidebarToggleBtn"
        class="nav-btn w-9 h-9 rounded-xl bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 flex items-center justify-center text-gray-500 dark:text-zinc-400 hover:bg-gray-200 dark:hover:bg-white/10 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer"
        title="طي/فرد القائمة الجانبية"
        @click="$emit('toggleSidebar')"
      >
        <svg
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16m-7 6h7"
          />
        </svg>
      </button>

      <!-- Theme Toggle (Dark / Light) -->
      <button
        type="button"
        id="themeToggleBtn"
        class="nav-btn w-9 h-9 rounded-xl bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 flex items-center justify-center text-gray-500 dark:text-zinc-400 hover:bg-gray-200 dark:hover:bg-white/10 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer"
        title="تبديل المظهر النهاري / الليلي"
        @click="toggleDarkMode"
      >
        <!-- Sun icon (shown in Dark mode to switch to Light) -->
        <svg
          v-if="isDark"
          id="themeIconSun"
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
        <!-- Moon icon (shown in Light mode to switch to Dark) -->
        <svg
          v-else
          id="themeIconMoon"
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
          />
        </svg>
      </button>

      <!-- 3-Tier Breadcrumbs: الرئيسية ‹ المجموعة ‹ الصفحة -->
      <div class="breadcrumbs flex items-center gap-1.5 text-xs font-bold text-gray-400 dark:text-zinc-500 mr-1">
        <Link
          href="/dashboard"
          class="breadcrumb-link text-gray-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
          title="الرئيسية"
        >
          الرئيسية
        </Link>

        <!-- Optional Group Tier -->
        <template v-if="group">
          <svg
            class="breadcrumb-sep w-3.5 h-3.5 rotate-180 text-gray-400 dark:text-zinc-600 shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
          <span class="breadcrumb-group text-gray-600 dark:text-zinc-400 font-bold">{{ group }}</span>
        </template>

        <!-- Current Page Title -->
        <template v-if="title">
          <svg
            class="breadcrumb-sep w-3.5 h-3.5 rotate-180 text-gray-400 dark:text-zinc-600 shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
          <span class="current text-gray-900 dark:text-white font-extrabold">{{ title }}</span>
        </template>
      </div>
    </div>

    <!-- Navbar Left: Search Box, Alerts & User Menu -->
    <div class="navbar-left flex items-center gap-3">

      <!-- Quick Search Bubble -->
      <div class="search-box hidden sm:flex items-center bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-full px-3 py-1.5 gap-2 text-xs text-gray-500 w-52 focus-within:w-60 focus-within:border-indigo-500 focus-within:bg-white dark:focus-within:bg-black transition-all">
        <svg
          class="w-3.5 h-3.5 text-gray-400 shrink-0"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
        <input
          id="navbar-search"
          v-model="navbarSearch"
          type="text"
          placeholder="بحث سريع..."
          class="bg-transparent border-none outline-none text-xs w-full text-gray-900 dark:text-white placeholder-gray-400 focus:ring-0 p-0"
          @keyup.enter="performSearch"
        >
      </div>

      <!-- System Notifications Button -->
      <button
        type="button"
        id="notificationsBtn"
        class="nav-btn w-9 h-9 rounded-xl bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 flex items-center justify-center text-gray-500 dark:text-zinc-400 hover:bg-gray-200 dark:hover:bg-white/10 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer"
        title="التنبيهات"
        @click="alert('حالة النظام: مثالية ومستقرة.')"
      >
        <svg
          class="w-4 h-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          />
        </svg>
      </button>

      <!-- User Menu Wrapper (Avatar & Dropdown) -->
      <div v-if="!isGuest && user" class="user-menu-wrapper relative flex items-center gap-3">
        <!-- Adaptive Persona Chips (for responsive desktop) -->
        <div class="hidden md:flex flex-col items-start leading-none">
          <span class="text-xs font-extrabold text-gray-900 dark:text-white">{{ user.name }}</span>
          <span
            class="text-[9px] mt-1 font-bold px-1.5 py-0.5 rounded border"
            :class="user.badge_color || 'bg-red-500/10 text-red-500 border-red-500/20'"
          >
            {{ user.role_label || 'مدير النظام' }}
          </span>
        </div>

        <!-- Avatar Button -->
        <button
          id="userAvatarBtn"
          type="button"
          class="user-avatar-btn w-9 h-9 rounded-full bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 p-0.5 flex items-center justify-center cursor-pointer hover:border-indigo-500/40 transition-all"
          title="الملف الشخصي"
          @click="isUserMenuOpen = !isUserMenuOpen"
        >
          <div class="w-full h-full rounded-full bg-linear-to-tr from-zinc-700 to-zinc-900 flex items-center justify-center text-white font-extrabold text-xs font-mono">
            {{ user.name?.charAt(0) || 'م' }}
          </div>
        </button>

        <!-- Dropdown Menu -->
        <div
          v-if="isUserMenuOpen"
          id="userDropdownMenu"
          class="user-dropdown-menu absolute left-0 top-12 w-52 bg-white dark:bg-[#121215] border border-gray-200 dark:border-white/10 rounded-2xl shadow-2xl p-1.5 z-50 backdrop-blur-xl animate-in fade-in duration-200"
        >
          <!-- Dropdown Header -->
          <div class="user-dropdown-header px-3 py-2 border-b border-gray-100 dark:border-white/5 mb-1">
            <p class="user-dropdown-name text-xs font-extrabold text-gray-900 dark:text-white truncate">{{ user.name }}</p>
            <p class="user-dropdown-role text-[10px] text-gray-400 dark:text-zinc-500 font-mono truncate mt-0.5">{{ user.email || 'user@archive.org' }}</p>
          </div>

          <!-- Menu Items -->
          <Link
            href="/dashboard"
            class="user-dropdown-item flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-gray-600 dark:text-zinc-300 hover:bg-gray-100 dark:hover:bg-white/5 transition-all"
            @click="isUserMenuOpen = false"
          >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>لوحة التحكم الرئيسية</span>
          </Link>

          <!-- Logout Link -->
          <Link
            href="/logout"
            method="post"
            as="button"
            class="user-dropdown-item text-danger w-full text-right flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-red-500 hover:bg-red-500/10 transition-all cursor-pointer"
            @click="isUserMenuOpen = false"
          >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span>تسجيل الخروج</span>
          </Link>
        </div>
      </div>

      <!-- Guest Actions -->
      <div v-else class="flex items-center gap-2">
        <Link
          href="/login"
          class="px-3 py-1.5 text-xs font-bold text-gray-700 dark:text-zinc-200 hover:text-indigo-600 transition-colors"
        >
          تسجيل الدخول
        </Link>
        <Link
          href="/register"
          class="px-3 py-1.5 text-xs font-bold bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition-colors shadow-sm"
        >
          إنشاء حساب
        </Link>
      </div>

    </div>

  </nav>
</template>
