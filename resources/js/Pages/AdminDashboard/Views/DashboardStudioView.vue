<script setup>
import { computed } from 'vue';

const props = defineProps({
  studioType: {
    type: String,
    default: 'studio-books',
  },
  items: {
    type: Array,
    default: () => [],
  },
  versions: {
    type: Array,
    default: () => [],
  },
});

const config = computed(() => {
  switch (props.studioType) {
    case 'studio-manuscripts':
      return {
        title: 'استوديو المخطوطات',
        icon: '📜',
        desc: 'منصة مقارنة اللوحات الخطية وفك الطلاسم وتفريغ النصوص المسندة',
        actionLabel: '⚡ استئناف العمل',
        actionUrl: '/studio/resume',
      };
    case 'studio-audios':
      return {
        title: 'استوديو الصوتيات',
        icon: '🎙️',
        desc: 'منصة تجزئة المسارات الصوتية وتوليد الشرائح وتفريغ النصوص بدقة',
        actionLabel: '',
        actionUrl: '',
      };
    case 'studio-videos':
      return {
        title: 'استوديو المرئيات',
        icon: '🎬',
        desc: 'منصة تقسيم المحاضرات والندوات المصورة وربط الفصول التفاعلية',
        actionLabel: '',
        actionUrl: '',
      };
    case 'versions':
      return {
        title: 'الإصدارات والنسخ المقارنة',
        icon: '🗂️',
        desc: 'مقارنة النسخ والمطابقة النصية وتتبع تاريخ التعديلات',
        actionLabel: '',
        actionUrl: '',
      };
    default:
      return {
        title: 'استوديو تحرير الكتب',
        icon: '✍️',
        desc: 'متابعة مسار التحرير، المقابلة، ونسبة الإنجاز في المصنفات النشطة',
        actionLabel: '⚡ استئناف التحرير',
        actionUrl: '/studio/resume',
      };
  }
});
</script>

<template>
  <div class="dashboard-studio-view">
    <!-- View Header Banner -->
    <div class="view-header-banner">
      <div class="view-title-group">
        <h2><span>{{ config.icon }} {{ config.title }}</span></h2>
        <p>{{ config.desc }}</p>
      </div>
      <div v-if="config.actionUrl" class="header-actions">
        <a :href="config.actionUrl" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
          <span>{{ config.actionLabel }}</span>
        </a>
      </div>
    </div>

    <!-- 1. Studio Books -->
    <div v-if="studioType === 'studio-books'" class="section-card">
      <div class="users-table-wrap">
        <table class="users-table">
          <thead>
            <tr>
              <th>المصنف</th>
              <th>العقدة الحالية</th>
              <th>نسبة الإنجاز</th>
              <th>المحقق</th>
              <th>التحديث</th>
              <th>الإجراء</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="b in items" :key="b.id || b.slug">
              <td><strong>{{ b.title }}</strong></td>
              <td>{{ b.current_node || 'الباب الأول: المقدمة التمهيدية' }}</td>
              <td>
                <div class="kpi-split-bar" style="height: 6px; width: 120px;">
                  <div :style="{ width: (b.progress_percent || 75) + '%', background: '#10b981' }"></div>
                </div>
                <span style="font-size: 0.65rem; color: #10b981; font-weight: 800;">{{ b.progress_percent || 75 }}%</span>
              </td>
              <td>{{ b.editor_name || 'فريق التحقيق الأكاديمي' }}</td>
              <td>{{ b.updated_at_human || 'مؤخراً' }}</td>
              <td>
                <a :href="b.studio_url || `/studio/book/${b.slug}`" class="btn-emerald-small"><span>فتح المحرر ✍️</span></a>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="6" style="text-align: center; color: var(--text-dim, #71717a); padding: 2rem;">لا توجد كتب قيد التحقيق حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 2. Studio Manuscripts -->
    <div v-else-if="studioType === 'studio-manuscripts'" class="section-card">
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
            <tr v-for="(m, idx) in items.slice(0, 10)" :key="m.id || idx">
              <td><strong>{{ m.title }}</strong></td>
              <td>{{ m.folio_count || `لوحة رقم ${(idx * 12 + 14)} (الوجه أ)` }}</td>
              <td>
                <span :class="['role-chip', idx % 2 === 0 ? 'chip-studio' : 'chip-academic']">
                  {{ idx % 2 === 0 ? 'مطابق بنسبة 100%' : 'قيد فك الطلاسم' }}
                </span>
              </td>
              <td>{{ m.author || 'د. طارق الحارثي' }}</td>
              <td>
                <a :href="m.studio_url || `/studio/manuscript/${m.slug}`" class="btn-emerald-small"><span>متابعة التحقيق ✍️</span></a>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="5" style="text-align: center; color: var(--text-dim, #71717a); padding: 2rem;">لا توجد مخطوطات قيد المقابلة حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 3. Studio Audios -->
    <div v-else-if="studioType === 'studio-audios'" class="section-card">
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
            <tr v-for="(a, idx) in items.slice(0, 10)" :key="a.id || idx">
              <td><strong>{{ a.title }}</strong></td>
              <td>{{ a.duration || '01:15:30' }}</td>
              <td>{{ (idx * 8 + 14) }} شريحة</td>
              <td><span style="color: #34d399; font-weight: 800;">{{ (98.5 + (idx % 2)).toFixed(1) }}%</span></td>
              <td>
                <a :href="a.studio_url || `/studio/audio/${a.slug}`" class="btn-emerald-small"><span>فتح محرر الشرائح ✍️</span></a>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="5" style="text-align: center; color: var(--text-dim, #71717a); padding: 2rem;">لا توجد جلسات صوتية قيد التقطيع حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 4. Studio Videos -->
    <div v-else-if="studioType === 'studio-videos'" class="section-card">
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
            <tr v-for="(v, idx) in items.slice(0, 10)" :key="v.id || idx">
              <td><strong>{{ v.title }}</strong></td>
              <td>{{ v.duration || '02:15:00' }}</td>
              <td>{{ (idx + 4) }} فصول رئيسية</td>
              <td>
                <a :href="v.studio_url || `/studio/video/${v.slug}`" class="btn-purple-small"><span>تقطيع الفصول 🎬</span></a>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="4" style="text-align: center; color: var(--text-dim, #71717a); padding: 2rem;">لا توجد تسجيلات مرئية قيد التقطيع حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 5. Versions View -->
    <div v-else-if="studioType === 'versions'" class="section-card">
      <div class="users-table-wrap">
        <table class="users-table">
          <thead>
            <tr>
              <th>عنوان النسخة</th>
              <th>الكيان التابع</th>
              <th>الناشر / المحرر</th>
              <th>الحجم والصيغة</th>
              <th>التاريخ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="v in (versions.length ? versions : items)" :key="v.id">
              <td><strong>{{ v.title }}</strong></td>
              <td>{{ v.versionable_title || 'الأصل المعتمد' }}</td>
              <td>{{ v.publisher_name || 'فريق التدقيق' }}</td>
              <td>
                <span class="icon-import">{{ v.file_size_human || '2.4 MB' }}</span> / 
                <span style="color: #38bdf8;">{{ v.format || 'PDF' }}</span>
              </td>
              <td>{{ v.created_at_human || 'مؤخراً' }}</td>
            </tr>
            <tr v-if="!items.length && !versions.length">
              <td colspan="5" style="text-align: center; color: var(--text-dim, #71717a); padding: 2rem;">لا توجد نسخ أو إصدارات مقارنة حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD STUDIO VIEW STYLES
   ======================================================== */
.dashboard-studio-view .view-header-banner {
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
body.light-mode .dashboard-studio-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-studio-view .btn-purple-small {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.35rem 0.75rem;
  border-radius: 6px;
  background: rgba(168, 85, 247, 0.15);
  color: #c084fc;
  border: 1px solid rgba(168, 85, 247, 0.3);
  font-size: 0.75rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.15s;
}
.dashboard-studio-view .btn-purple-small:hover {
  background: #a855f7;
  color: #ffffff;
}
</style>
