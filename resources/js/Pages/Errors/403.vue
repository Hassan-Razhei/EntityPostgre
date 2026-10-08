<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useAuth } from '@/Composables/useAuth';

/**
 * شاشة الحظر الزمردية الفاخرة (403 Informative Denial Page)
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الخامس: تغذية حسية فاخرة)
 */
const props = defineProps({
    status: {
        type: Number,
        default: 403,
    },
    message: {
        type: String,
        default: 'عذراً، ليس لديك الصلاحية الكافية للوصول إلى هذا القسم.',
    },
});

const { user, roleLabel, badgeColor } = useAuth();

const homeUrl = computed(() => {
    try {
        if (typeof route === 'function') {
            return user.value ? route('superadmin.dashboard') : route('home');
        }
    } catch (e) {
        // Fallback إذا كان المسار غير معرف
    }
    return user.value ? '/superadmin/dashboard' : '/';
});

const logoutUrl = computed(() => {
    try {
        if (typeof route === 'function') {
            return route('logout');
        }
    } catch (e) {
        // Fallback
    }
    return '/logout';
});

const loginUrl = computed(() => {
    try {
        if (typeof route === 'function') {
            return route('login');
        }
    } catch (e) {
        // Fallback
    }
    return '/login';
});
</script>

<template>
  <Head title="403 - وصول محظور | الأرشيف الرقمي الموحد" />

  <div
    class="min-h-screen bg-[#060c08] text-slate-100 flex items-center justify-center p-6 relative overflow-hidden font-sans selection:bg-emerald-500/30 selection:text-emerald-200"
    dir="rtl"
  >
    <!-- توهج زمردي محيطي في الخلفية (Ambient Glow) -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-600/15 rounded-full blur-[130px] pointer-events-none" />
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-[130px] pointer-events-none" />
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-950/20 rounded-full blur-[150px] pointer-events-none" />

    <!-- البطاقة الزجاجية الفاخرة (Emerald Glassmorphism Card) -->
    <div class="relative w-full max-w-xl backdrop-blur-2xl bg-slate-900/80 border border-emerald-500/20 rounded-3xl p-8 md:p-10 shadow-2xl shadow-emerald-950/60 text-center">
      <!-- أيقونة الدرع الأمني مع وميض زمردي -->
      <div class="mx-auto w-20 h-20 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shadow-xl shadow-emerald-500/10 mb-6">
        <svg
          class="w-10 h-10"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.75"
            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
          />
        </svg>
      </div>

      <!-- رقم الخطأ والتسمية -->
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold tracking-wider uppercase mb-3">
        <span>رمز الاستجابة الأمني</span>
        <span class="w-1 h-1 rounded-full bg-emerald-400" />
        <span class="font-mono text-emerald-300 font-bold">{{ status }}</span>
      </div>

      <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight bg-gradient-to-r from-white via-slate-100 to-emerald-200 bg-clip-text text-transparent">
        تصريح الوصول غير كافٍ
      </h1>

      <!-- رسالة الردع التفسيرية (Informative Denial Message) -->
      <div class="mt-5 p-4 rounded-2xl bg-emerald-950/40 border border-emerald-500/25 text-emerald-200/90 text-sm leading-relaxed text-right">
        <div class="flex items-start gap-3">
          <svg
            class="w-5 h-5 text-emerald-400 shrink-0 mt-0.5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <p class="font-normal">{{ message }}</p>
        </div>
      </div>

      <!-- بطاقة هوية المستخدم الحالية (Identity Context) -->
      <div
        v-if="user"
        class="mt-6 p-4 rounded-2xl bg-white/[0.03] border border-white/10 flex items-center justify-between gap-4 text-right"
      >
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-300 font-bold text-sm shadow-inner">
            {{ user.name ? user.name.charAt(0) : '؟' }}
          </div>
          <div>
            <div class="font-semibold text-white text-sm">{{ user.name }}</div>
            <div
              v-if="user.email"
              class="text-xs text-slate-400 font-mono"
            >
              {{ user.email }}
            </div>
          </div>
        </div>

        <span :class="['px-3 py-1 text-xs font-semibold rounded-full border', user.badge_color || badgeColor || 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20']">
          {{ user.role_label || roleLabel }}
        </span>
      </div>

      <!-- أزرار التوجيه والملاحة (Navigation Actions) -->
      <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
        <Link
          :href="homeUrl"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-medium text-sm transition-all duration-200 shadow-lg shadow-emerald-950/40 hover:shadow-emerald-900/60"
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
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
            />
          </svg>
          العودة إلى الصفحة الرئيسية
        </Link>

        <Link
          v-if="user"
          method="post"
          as="button"
          :href="logoutUrl"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-medium text-sm transition-colors"
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
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
            />
          </svg>
          تسجيل الخروج
        </Link>

        <Link
          v-else
          :href="loginUrl"
          class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 hover:text-white font-medium text-sm transition-colors"
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
              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
            />
          </svg>
          تسجيل الدخول
        </Link>
      </div>

      <!-- تذييل المنظومة -->
      <div class="mt-8 pt-6 border-t border-white/5 text-xs text-slate-500">
        منظومة الأرشيف الرقمي الموحد &bull; الإدارة الأمنية وحوكمة الصلاحيات
      </div>
    </div>
  </div>
</template>
