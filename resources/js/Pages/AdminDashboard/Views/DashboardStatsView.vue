<script setup>
import { computed } from 'vue';

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['navigate']);

const booksCount = computed(() => (props.stats?.books ?? 0).toLocaleString());
const manuscriptsCount = computed(() => (props.stats?.manuscripts ?? 0).toLocaleString());
const audiosCount = computed(() => (props.stats?.audios ?? 0).toLocaleString());
const videosCount = computed(() => (props.stats?.videos ?? 0).toLocaleString());

const funnelDrafts = computed(() => (props.stats?.funnel_drafts ?? props.stats?.studio_books ?? 0).toLocaleString());
const funnelReviewed = computed(() => (props.stats?.funnel_reviewed ?? props.stats?.manuscripts ?? 0).toLocaleString());
const funnelScholarly = computed(() => (props.stats?.funnel_scholarly ?? 0).toLocaleString());
const funnelPublished = computed(() => (props.stats?.funnel_published ?? props.stats?.books ?? 0).toLocaleString());

function handleNavigate(viewKey) {
  emit('navigate', viewKey);
  if (typeof window !== 'undefined' && typeof window.loadView === 'function') {
    window.loadView(viewKey);
  }
}
</script>

<template>
  <div class="dashboard-stats-view">
    <!-- View Header Banner -->
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
      <div class="kpi-card" style="cursor: pointer;" @click="handleNavigate('books')">
        <div class="kpi-title">إجمالي الكتب والرسائل [Books]</div>
        <div class="kpi-value icon-export">{{ booksCount }}</div>
        <div class="kpi-split-bar">
          <div style="width: 75%; background: #3b82f6;"></div>
          <div style="width: 25%; background: #f59e0b;"></div>
        </div>
        <div class="kpi-split-subtext"><span>75% منشور</span><span>25% مسودة</span></div>
      </div>

      <!-- Manuscripts KPI -->
      <div class="kpi-card" style="cursor: pointer;" @click="handleNavigate('manuscripts')">
        <div class="kpi-title">خزانة المخطوطات النادرة [Manuscripts]</div>
        <div class="kpi-value icon-refresh">{{ manuscriptsCount }}</div>
        <div class="kpi-split-bar">
          <div style="width: 65%; background: #f59e0b;"></div>
          <div style="width: 35%; background: #ef4444;"></div>
        </div>
        <div class="kpi-split-subtext"><span>65% لوحات مرممة</span><span>35% قيد الفحص</span></div>
      </div>

      <!-- Audios KPI -->
      <div class="kpi-card" style="cursor: pointer;" @click="handleNavigate('audios')">
        <div class="kpi-title">التسجيلات الصوتية المفرغة [Audios]</div>
        <div class="kpi-value icon-import">{{ audiosCount }}</div>
        <div class="kpi-split-bar">
          <div style="width: 80%; background: #10b981;"></div>
          <div style="width: 20%; background: #3b82f6;"></div>
        </div>
        <div class="kpi-split-subtext"><span>80% شرائح مفرغة</span><span>20% تسجيل نقي</span></div>
      </div>

      <!-- Videos KPI -->
      <div class="kpi-card" style="cursor: pointer;" @click="handleNavigate('videos')">
        <div class="kpi-title">المرئيات والندوات المصورة [Videos]</div>
        <div class="kpi-value" style="color: #c084fc;">{{ videosCount }}</div>
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
        <span style="font-size: 0.72rem; color: var(--text-dim, #71717a);">روابط مباشرة لأهم مسارات النظام</span>
      </div>
      <div class="quick-launch-grid">
        <a href="/books/create" class="quick-launch-item">
          <div class="quick-icon-box" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">📖</div>
          <div>
            <strong style="display: block; font-size: 0.85rem; color: var(--text-main, #f4f4f5);">كتاب جديد</strong>
            <span style="font-size: 0.7rem; color: var(--text-dim, #71717a);">إدراج مصنف أو عمل مكتبي جديد</span>
          </div>
        </a>

        <a href="/categories/create" class="quick-launch-item">
          <div class="quick-icon-box" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">🏷️</div>
          <div>
            <strong style="display: block; font-size: 0.85rem; color: var(--text-main, #f4f4f5);">تصنيف جديد</strong>
            <span style="font-size: 0.7rem; color: var(--text-dim, #71717a);">إدارة الفئات والشجرة المعرفية</span>
          </div>
        </a>

        <div class="quick-launch-item" @click="handleNavigate('deletions')">
          <div class="quick-icon-box" style="background: rgba(239, 68, 68, 0.15); color: #f87171;">♻️</div>
          <div>
            <strong style="display: block; font-size: 0.85rem; color: var(--text-main, #f4f4f5);">خزنة المهملات</strong>
            <span style="font-size: 0.7rem; color: var(--text-dim, #71717a);">استرجاع الأصول المحذوفة مؤقتاً</span>
          </div>
        </div>

        <div class="quick-launch-item" @click="handleNavigate('commands')">
          <div class="quick-icon-box" style="background: rgba(168, 85, 247, 0.15); color: #c084fc;">💻</div>
          <div>
            <strong style="display: block; font-size: 0.85rem; color: var(--text-main, #f4f4f5);">أوامر النظام</strong>
            <span style="font-size: 0.7rem; color: var(--text-dim, #71717a);">تشغيل أوامر الكونسول وArtisan</span>
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
          <div class="funnel-step-num icon-refresh">{{ funnelDrafts }}</div>
        </div>
        <div style="color: var(--text-dim, #71717a); font-size: 1.25rem;">‹</div>
        <div class="funnel-step">
          <div class="funnel-step-label">التحقيق والمقابلة ✍️</div>
          <div class="funnel-step-num" style="color: #38bdf8;">{{ funnelReviewed }}</div>
        </div>
        <div style="color: var(--text-dim, #71717a); font-size: 1.25rem;">‹</div>
        <div class="funnel-step">
          <div class="funnel-step-label">الاعتماد والتحكيم 🎓</div>
          <div class="funnel-step-num" style="color: #a855f7;">{{ funnelScholarly }}</div>
        </div>
        <div style="color: var(--text-dim, #71717a); font-size: 1.25rem;">‹</div>
        <div class="funnel-step">
          <div class="funnel-step-label">منشور للعامة 🌐</div>
          <div class="funnel-step-num" style="color: #10b981;">{{ funnelPublished }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD STATS VIEW STYLES
   ======================================================== */
.dashboard-stats-view .view-header-banner {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 1.5rem;
  background: rgba(18, 18, 21, 0.7);
  backdrop-filter: blur(12px);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.25rem;
  margin-bottom: 1.5rem;
}
body.light-mode .dashboard-stats-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-stats-view .view-title-group h2 {
  font-size: 1.25rem;
  font-weight: 900;
  color: var(--text-main, #fff);
  display: flex;
  align-items: center;
  gap: 0.6rem;
}
body.light-mode .dashboard-stats-view .view-title-group h2 {
  color: #0f172a;
}

.dashboard-stats-view .view-title-group p {
  font-size: 0.75rem;
  color: var(--text-dim, #71717a);
  font-weight: 600;
  margin-top: 0.2rem;
}

.dashboard-stats-view .header-actions {
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.dashboard-stats-view .health-pill {
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
body.light-mode .dashboard-stats-view .health-pill {
  background: rgba(16, 185, 129, 0.08);
  border: 1px solid rgba(16, 185, 129, 0.25);
  color: #047857;
}

.dashboard-stats-view .pulse-dot-green {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 8px #10b981;
  animation: pulse 1.5s infinite;
  display: inline-block;
}

.dashboard-stats-view .status-pill-db {
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
body.light-mode .dashboard-stats-view .status-pill-db {
  background: rgba(99, 102, 241, 0.08);
  border: 1px solid rgba(99, 102, 241, 0.25);
  color: #4338ca;
}
body.light-mode .dashboard-stats-view .status-pill-db .pulse-dot-emerald {
  background: #6366f1;
  box-shadow: 0 0 8px #6366f1;
}

.dashboard-stats-view .pulse-dot-emerald {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 8px #10b981;
  animation: pulse 1.5s infinite;
  display: inline-block;
}

.dashboard-stats-view .kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.25rem;
  margin-bottom: 1.75rem;
}

.dashboard-stats-view .kpi-card {
  background: var(--bg-card, rgba(22, 22, 27, 0.7));
  backdrop-filter: blur(12px);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.25rem;
  padding: 1.25rem;
  transition: all 0.3s;
}
body.light-mode .dashboard-stats-view .kpi-card {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-stats-view .kpi-title {
  font-size: 0.75rem;
  color: var(--text-muted, #a1a1aa);
  font-weight: 700;
}
body.light-mode .dashboard-stats-view .kpi-title {
  color: #475569;
}

.dashboard-stats-view .kpi-value {
  font-size: 2rem;
  font-weight: 900;
  color: var(--text-main, #fff);
  font-family: 'Outfit', sans-serif;
  margin: 0.5rem 0;
}
body.light-mode .dashboard-stats-view .kpi-value {
  color: #0f172a;
}

.dashboard-stats-view .kpi-split-bar {
  display: flex;
  height: 5px;
  width: 100%;
  border-radius: 9999px;
  overflow: hidden;
  margin-bottom: 0.5rem;
  background: rgba(255, 255, 255, 0.05);
}
body.light-mode .dashboard-stats-view .kpi-split-bar {
  background: rgba(0, 0, 0, 0.06);
}

.dashboard-stats-view .kpi-split-subtext {
  display: flex;
  justify-content: space-between;
  font-size: 0.7rem;
  font-weight: 700;
  color: var(--text-dim, #71717a);
}

.dashboard-stats-view .section-card {
  background: var(--bg-card, rgba(22, 22, 27, 0.7));
  backdrop-filter: blur(12px);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.5rem;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
}
body.light-mode .dashboard-stats-view .section-card {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-stats-view .section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.25rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-stats-view .section-header {
  border-bottom-color: rgba(0, 0, 0, 0.08);
}

.dashboard-stats-view .section-title {
  font-size: 1rem;
  font-weight: 900;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--text-main, #f4f4f5);
}
body.light-mode .dashboard-stats-view .section-title {
  color: #0f172a;
}

.dashboard-stats-view .quick-launch-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1rem;
}

.dashboard-stats-view .quick-launch-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  border-radius: 1.25rem;
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  text-decoration: none;
  transition: all 0.25s;
  cursor: pointer;
}
.dashboard-stats-view .quick-launch-item:hover {
  background: rgba(255, 255, 255, 0.05);
  transform: translateY(-2px);
  border-color: rgba(255, 255, 255, 0.15);
}
body.light-mode .dashboard-stats-view .quick-launch-item {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.08);
}
body.light-mode .dashboard-stats-view .quick-launch-item:hover {
  background: #ffffff;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.dashboard-stats-view .quick-icon-box {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.dashboard-stats-view .funnel-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  padding: 1rem;
  background: rgba(0, 0, 0, 0.25);
  border-radius: 1rem;
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-stats-view .funnel-container {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.08);
}

.dashboard-stats-view .funnel-step {
  flex: 1;
  text-align: center;
  padding: 0.6rem 0.5rem;
  border-radius: 0.75rem;
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-stats-view .funnel-step {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
}

.dashboard-stats-view .funnel-step-label {
  font-size: 0.65rem;
  font-weight: 800;
  color: var(--text-dim, #71717a);
  margin-bottom: 0.2rem;
}
.dashboard-stats-view .funnel-step-num {
  font-size: 1.25rem;
  font-weight: 900;
  font-family: 'Outfit', sans-serif;
  color: var(--text-main, #f4f4f5);
}
body.light-mode .dashboard-stats-view .funnel-step-num {
  color: #0f172a;
}
</style>
