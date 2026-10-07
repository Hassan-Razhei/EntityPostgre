<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';
import { useAuth } from '@/Composables/useAuth';

defineProps({
    isOpen: {
        type: Boolean,
        default: true
    }
});

const { can } = useAuth();

// Navigation Groups matching super_admin_dashboard_preview.html 1:1
const navigationGroups = [
    {
        id: 'group-library',
        name: 'المكتبة',
        icon: '📚',
        badge: '4',
        items: [
            { name: 'الكتب', route: 'books.index', count: '1,482', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' },
            { name: 'المخطوطات', route: 'manuscripts.index', count: '428', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
            { name: 'الصوتيات', route: 'audios.index', count: '650', icon: 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3' },
            { name: 'المرئيات', route: 'videos.index', count: '185', icon: 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z' },
        ]
    },
    {
        id: 'group-entities',
        name: 'الأشخاص',
        icon: '👥',
        badge: '2',
        items: [
            { name: 'المؤلفون', route: 'authors.index', count: '340', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
            { name: 'الناشرون', route: 'publishers.index', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' },
        ]
    },
    {
        id: 'group-taxonomy',
        name: 'التنظيم',
        icon: '🏷️',
        badge: '2',
        items: [
            { name: 'التصنيفات', route: 'categories.index', icon: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm5-3a2 2 0 100 4 2 2 0 000-4z' },
            { name: 'الأوسمة', route: 'tags.index', icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z' },
        ]
    },
    {
        id: 'group-studio',
        name: 'الاستوديو',
        icon: '✍️',
        badge: '5',
        permission: 'access_studio',
        items: [
            { name: 'الكتب', route: 'studio.resume', count: '386 مسودة', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253' },
            { name: 'المخطوطات', route: 'studio.resume', count: '114 لوحة', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
            { name: 'الصوتيات', route: 'studio.resume', count: '92 شريحة', icon: 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3' },
            { name: 'المرئيات', route: 'studio.resume', count: '45 مشهد', icon: 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z' },
            { name: 'الإصدارات', route: 'studio.resume', count: '842', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
        ]
    },
    {
        id: 'group-sovereignty',
        name: 'النظام',
        icon: '👑',
        badge: '6',
        isSovereign: true,
        items: [
            { name: 'الإحصائيات', route: 'dashboard', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' },
            { name: 'العمليات', route: 'dashboard', icon: 'M13 10V3L4 14h7v7l9-11h-7z' },
            { name: 'المستخدمون', route: 'superadmin.dashboard', count: '124', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' },
            { name: 'النشاطات', route: 'activities.index', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
            { name: 'المهملات', route: 'deletions.index', count: '18', icon: 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' },
            { name: 'أوامر النظام', route: 'system.commands', permission: 'system_commands', icon: 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z' },
        ]
    }
];

// Collapsible state for each group
const collapsedGroups = ref(new Set());

const toggleNavGroup = (groupId) => {
    if (collapsedGroups.value.has(groupId)) {
        collapsedGroups.value.delete(groupId);
    } else {
        collapsedGroups.value.add(groupId);
    }
};

const expandAllGroups = () => {
    collapsedGroups.value.clear();
};

const collapseAllGroups = () => {
    navigationGroups.forEach(g => collapsedGroups.value.add(g.id));
};

const checkActive = (routeName) => {
    try {
        return route().current(routeName) || (routeName.includes('.index') && route().current(routeName.replace('.index', '.*')));
    } catch {
        return false;
    }
};
</script>

<template>
  <aside
    :class="[
      'fixed top-0 right-0 z-50 h-screen transition-all duration-300 border-l border-gray-200 dark:border-white/5 bg-white dark:bg-[#0a0a0a] flex flex-col',
      isOpen ? 'w-64' : 'w-20'
    ]"
  >
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center px-6 border-b border-gray-100 dark:border-white/5 shrink-0">
      <Link
        href="/"
        class="flex items-center gap-3 overflow-hidden"
      >
        <div class="w-8 h-8 rounded-xl bg-linear-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center shadow-lg shadow-purple-500/20 shrink-0">
          <span class="text-white font-black text-sm">E</span>
        </div>
        <span
          v-show="isOpen"
          class="font-black text-xl tracking-tight dark:text-white whitespace-nowrap"
        >Entity</span>
      </Link>
    </div>

    <!-- Sidebar Content -->
    <div class="overflow-y-auto flex-1 custom-scrollbar py-3 px-2.5">

      <!-- Accordion Micro-Toolbar (Expand / Collapse All) -->
      <div
        v-if="isOpen"
        id="sidebarAccordionToolbar"
        class="sidebar-accordion-toolbar flex items-center justify-between px-2 py-1.5 mb-2.5 border-b border-gray-100 dark:border-white/5"
      >
        <span class="toolbar-label text-[11px] font-extrabold text-gray-400 dark:text-zinc-500 flex items-center gap-1.5">
          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
          خريطة المجموعات
        </span>
        <div class="pill-segmented-control flex items-center bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-full p-0.5 gap-0.5">
          <button
            type="button"
            id="btnExpandAll"
            class="seg-btn inline-flex items-center gap-1 bg-transparent border-0 text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white text-[10px] font-extrabold py-0.5 px-2 rounded-full cursor-pointer transition-all"
            title="توسيع كافة المجموعات"
            @click="expandAllGroups"
          >
            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
            <span>توسيع</span>
          </button>
          <button
            type="button"
            id="btnCollapseAll"
            class="seg-btn inline-flex items-center gap-1 bg-transparent border-0 text-gray-500 dark:text-zinc-400 hover:text-gray-900 dark:hover:text-white text-[10px] font-extrabold py-0.5 px-2 rounded-full cursor-pointer transition-all"
            title="طي كافة المجموعات"
            @click="collapseAllGroups"
          >
            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"/></svg>
            <span>طي</span>
          </button>
        </div>
      </div>

      <!-- Navigation Groups -->
      <template v-for="group in navigationGroups" :key="group.id">
        <div
          v-if="!group.permission || can(group.permission)"
          :id="group.id"
          :class="[
            'nav-group mb-1.5 rounded-xl transition-all',
            group.isSovereign ? 'sovereign-group border-t border-red-500/20 pt-2 mt-2.5' : '',
            collapsedGroups.has(group.id) ? 'collapsed' : ''
          ]"
        >
          <!-- Group Header -->
          <div
            v-if="isOpen"
            class="nav-group-header text-xs font-bold text-gray-500 dark:text-zinc-400 py-1.5 px-2 flex items-center justify-between cursor-pointer select-none rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 transition-all"
            @click="toggleNavGroup(group.id)"
          >
            <div class="header-main flex items-center gap-1.5">
              <span>{{ group.icon }}</span>
              <span class="group-title text-[11px] font-extrabold">{{ group.name }}</span>
              <span class="group-badge text-[10px] font-bold bg-gray-100 dark:bg-white/5 px-1.5 py-0.5 rounded-full text-gray-400 dark:text-zinc-500 font-mono">{{ group.badge }}</span>
            </div>
            <svg
              :class="['chevron-icon w-3.5 h-3.5 text-gray-400 transition-transform duration-300', collapsedGroups.has(group.id) ? 'rotate-90' : '']"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>

          <!-- Group Items -->
          <div
            :class="[
              'nav-group-items flex flex-col transition-all duration-300 overflow-hidden',
              collapsedGroups.has(group.id) && isOpen ? 'max-h-0 opacity-0 py-0' : 'max-h-[800px] opacity-100 pt-1'
            ]"
          >
            <template v-for="item in group.items" :key="item.name">
              <Link
                v-if="!item.permission || can(item.permission)"
                v-tooltip="!isOpen ? item.name : ''"
                :href="route(item.route)"
                :class="[
                  'nav-item flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg transition-all text-xs font-bold relative mb-0.5',
                  checkActive(item.route)
                    ? 'bg-red-500/10 text-red-500 dark:text-red-400 border-r-2 border-red-500'
                    : 'text-gray-600 dark:text-zinc-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white'
                ]"
              >
                <svg
                  class="w-4 h-4 shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    :d="item.icon"
                  />
                </svg>
                <span
                  v-show="isOpen"
                  class="text-[12px] font-bold truncate"
                >{{ item.name }}</span>

                <span
                  v-if="isOpen && item.count"
                  class="badge-count mr-auto text-[10px] font-bold bg-gray-100 dark:bg-white/5 px-1.5 py-0.5 rounded text-gray-400 dark:text-zinc-500 font-mono"
                >
                  {{ item.count }}
                </span>
              </Link>
            </template>
          </div>
        </div>
      </template>

    </div>
  </aside>
</template>

<style scoped>
.sovereign-group .nav-group-header {
  color: #f87171 !important;
}
.sovereign-group .group-badge {
  background: rgba(239, 68, 68, 0.15) !important;
  color: #fca5a5 !important;
  border: 1px solid rgba(239, 68, 68, 0.3);
}
</style>
