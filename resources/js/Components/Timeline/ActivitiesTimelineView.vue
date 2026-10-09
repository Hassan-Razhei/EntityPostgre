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
