<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    activities: {
        type: Array,
        default: () => [],
    },
    total: {
        type: Number,
        default: 0,
    },
});

const searchQuery = ref('');

const sampleActivities = [
    {
        id: 1,
        user_name: 'د. عبد الله المنصور',
        user_avatar_char: 'ع',
        activity_type: 'إنشاء وتوثيق',
        description: 'إضافة مخطوطة نفيسة في الفقه المقارن',
        entity_title: 'صحيح البخاري - نسخة كوبريلي',
        created_at: 'منذ 15 دقيقة',
    },
    {
        id: 2,
        user_name: 'أ. طارق الحارثي',
        user_avatar_char: 'ط',
        activity_type: 'معالجة صوتية',
        description: 'رفع تسجيل جديد بدقة 320 kbps',
        entity_title: 'شرح كتاب التوحيد - المجلس الأول',
        created_at: 'منذ ساعة',
    },
    {
        id: 3,
        user_name: 'م. سارة القحطاني',
        user_avatar_char: 'س',
        activity_type: 'مراجعة واعتماد',
        description: 'اعتماد سيرة المؤلف وإدراج المصنفات',
        entity_title: 'الإمام الذهبي',
        created_at: 'منذ 3 ساعات',
    },
];

const activeList = computed(() => {
    return props.activities && props.activities.length ? props.activities : sampleActivities;
});

const filteredActivities = computed(() => {
    if (!searchQuery.value.trim()) return activeList.value;
    const q = searchQuery.value.toLowerCase();
    return activeList.value.filter(act => {
        return (
            (act.user_name && act.user_name.toLowerCase().includes(q)) ||
            (act.description && act.description.toLowerCase().includes(q)) ||
            (act.entity_title && act.entity_title.toLowerCase().includes(q)) ||
            (act.activity_type && act.activity_type.toLowerCase().includes(q))
        );
    });
});
</script>

<template>
  <div class="activities-timeline-view">
    <!-- View Header Banner (Cycle 9 Fidelity) -->
    <div class="view-header-banner">
      <div class="view-title-group">
        <h2><span>🕒 النشاطات</span></h2>
        <p>سجل التدقيق الحي ورصد تحركات المستخدمين وتعديلات الكيانات لحظياً من PostgreSQL ({{ (total || activeList.length).toLocaleString() }} نشاطاً)</p>
      </div>
      <div class="header-actions">
        <a href="/activities" class="btn-action-small" style="text-decoration: none;">السجل الكامل 🔍</a>
      </div>
    </div>

    <!-- Section Card with Live Timeline -->
    <div class="section-card" style="padding: 1.5rem;">
      <!-- Quick Filter Bar -->
      <div style="margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="بحث في سجل النشاطات الحية..."
          style="background: rgba(0, 0, 0, 0.25); border: 1px solid var(--border-subtle); border-radius: 8px; padding: 0.45rem 0.85rem; color: var(--text-main); font-size: 0.78rem; min-width: 260px; outline: none;"
        >
        <span style="font-size: 0.72rem; color: var(--text-dim); font-family: 'Outfit';">
          عرض {{ filteredActivities.length }} من أصل {{ activeList.length }}
        </span>
      </div>

      <!-- Timeline Rail & Items -->
      <div class="timeline-container">
        <div class="timeline-rail" />

        <div
          v-for="act in filteredActivities"
          :key="act.id"
          class="timeline-item"
        >
          <div class="timeline-dot" />
          <div class="timeline-box">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
              <div class="timeline-user-avatar">
                {{ act.user_avatar_char || 'م' }}
              </div>
              <div class="timeline-body">
                <strong>{{ act.user_name }}</strong> قام بـ <span style="color: #34d399; font-weight: 800;">{{ act.description || act.activity_type }}</span>: <span style="color: var(--text-main); font-weight: 800;">{{ act.entity_title || 'النظام' }}</span>
              </div>
            </div>
            <time class="timeline-time">{{ act.created_at }}</time>
          </div>
        </div>

        <!-- Empty State -->
        <div
          v-if="!filteredActivities.length"
          class="timeline-item"
        >
          <div class="timeline-dot" />
          <div class="timeline-box">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
              <div class="timeline-user-avatar">
                ✓
              </div>
              <div class="timeline-body">
                لا توجد نشاطات مسجلة تطابق معايير البحث حالياً.
              </div>
            </div>
            <time class="timeline-time">الآن</time>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* View Header Banner */
.activities-timeline-view .view-header-banner {
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

body.light-mode .activities-timeline-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.activities-timeline-view .view-title-group h2 {
  font-size: 1.25rem;
  font-weight: 900;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}

body.light-mode .activities-timeline-view .view-title-group h2 {
  color: #0f172a !important;
}

.activities-timeline-view .view-title-group p {
  font-size: 0.75rem;
  color: var(--text-dim, #71717a);
  font-weight: 600;
  margin-top: 0.2rem;
}

.activities-timeline-view .header-actions {
  display: flex;
  align-items: center;
  gap: 0.65rem;
}

.activities-timeline-view .section-card {
  background: var(--bg-card, rgba(22, 22, 27, 0.7));
  backdrop-filter: blur(12px);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.5rem;
  margin-bottom: 1.5rem;
}

body.light-mode .activities-timeline-view .section-card {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.activities-timeline-view .btn-action-small {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  color: var(--text-main, #f4f4f5);
  padding: 0.35rem 0.85rem;
  border-radius: 8px;
  font-size: 0.72rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}

.activities-timeline-view .btn-action-small:hover {
  background: rgba(255, 255, 255, 0.1);
}

body.light-mode .activities-timeline-view .btn-action-small {
  background: rgba(0, 0, 0, 0.03);
  border-color: var(--border-subtle, rgba(0, 0, 0, 0.08));
  color: var(--text-muted, #475569);
}

body.light-mode .activities-timeline-view .btn-action-small:hover {
  background: rgba(0, 0, 0, 0.07);
  color: #0f172a;
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
  border: 2px solid var(--bg-surface, #121215);
  box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
}

.timeline-box {
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1rem;
  padding: 0.85rem 1.15rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

body.light-mode .timeline-box {
  background: #f8fafc;
  border-color: var(--border-subtle, rgba(0, 0, 0, 0.08));
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
  color: var(--text-main, #f4f4f5);
}

body.light-mode .timeline-body {
  color: #0f172a !important;
}

.timeline-body strong {
  color: #f87171;
  margin-left: 0.25rem;
}

.timeline-time {
  font-size: 0.68rem;
  color: var(--text-dim, #71717a);
  font-family: 'Outfit', sans-serif;
  white-space: nowrap;
}
</style>
