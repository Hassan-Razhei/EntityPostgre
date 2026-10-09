<script setup>
import { ref, computed } from 'vue';

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

const searchQuery = ref('');
const viewMode = ref('table'); // 'table' | 'cards'

const config = computed(() => {
  switch (props.studioType) {
    case 'studio-manuscripts':
      return {
        title: 'استوديو المخطوطات',
        icon: '📜',
        desc: 'منصة مقارنة اللوحات الخطية وفك الطلاسم وتفريغ النصوص المسندة',
        actionLabel: '⚡ استئناف العمل',
        actionUrl: '/studio/resume',
        emptyMsg: 'لا توجد مخطوطات قيد المقابلة حالياً',
      };
    case 'studio-audios':
      return {
        title: 'استوديو الصوتيات',
        icon: '🎙️',
        desc: 'منصة تجزئة المسارات الصوتية وتوليد الشرائح وتفريغ النصوص بدقة',
        actionLabel: '',
        actionUrl: '',
        emptyMsg: 'لا توجد جلسات صوتية قيد التقطيع حالياً',
      };
    case 'studio-videos':
      return {
        title: 'استوديو المرئيات',
        icon: '🎬',
        desc: 'منصة تقسيم المحاضرات والندوات المصورة وربط الفصول التفاعلية',
        actionLabel: '',
        actionUrl: '',
        emptyMsg: 'لا توجد تسجيلات مرئية قيد التقطيع حالياً',
      };
    case 'versions':
      return {
        title: 'الإصدارات والنسخ المقارنة',
        icon: '🗂️',
        desc: 'مقارنة النسخ والمطابقة النصية وتتبع تاريخ التعديلات',
        actionLabel: '',
        actionUrl: '',
        emptyMsg: 'لا توجد نسخ أو إصدارات مقارنة حالياً',
      };
    default:
      return {
        title: 'استوديو تحرير الكتب',
        icon: '✍️',
        desc: 'متابعة مسار التحرير، المقابلة، ونسبة الإنجاز في المصنفات النشطة',
        actionLabel: '⚡ استئناف التحرير',
        actionUrl: '/studio/resume',
        emptyMsg: 'لا توجد كتب قيد التحقيق حالياً',
      };
  }
});

const rawItems = computed(() => {
  if (props.studioType === 'versions') {
    return (props.versions && props.versions.length) ? props.versions : props.items;
  }
  return props.items || [];
});

const activeItems = computed(() => {
  let list = rawItems.value;
  if (!searchQuery.value || !searchQuery.value.trim()) {
    return list;
  }
  const q = searchQuery.value.trim().toLowerCase();
  return list.filter(item => {
    return Object.values(item).some(val =>
      String(val || '').toLowerCase().includes(q)
    );
  });
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

    <!-- Smart Studio Toolbar (Search + View Switcher) -->
    <div class="studio-toolbar">
      <div class="toolbar-search-box">
        <span class="toolbar-search-icon">🔍</span>
        <input
          id="studioSearchInput"
          v-model="searchQuery"
          type="text"
          class="toolbar-search-input"
          placeholder="بحث فوري في مصنفات الاستوديو..."
        />
      </div>

      <div class="toolbar-controls">
        <span class="items-count-badge">
          {{ activeItems.length }} عنصر نشط
        </span>
        <div class="view-mode-toggle">
          <button
            id="btnStudioViewTable"
            type="button"
            class="view-mode-btn"
            :class="{ active: viewMode === 'table' }"
            title="عرض الجدول المدمج"
            @click="viewMode = 'table'"
          >
            <span>جدول مدمج</span>
          </button>
          <button
            id="btnStudioViewCards"
            type="button"
            class="view-mode-btn"
            :class="{ active: viewMode === 'cards' }"
            title="عرض بطاقات الاستوديو"
            @click="viewMode = 'cards'"
          >
            <span>بطاقات</span>
          </button>
        </div>
      </div>
    </div>

    <!-- 1. Table View Mode (High Density Table) -->
    <div v-show="viewMode === 'table'" class="enterprise-card">
      <div class="dense-table-wrapper">
        <table class="dense-table">
          <!-- 1. Books Columns -->
          <thead v-if="studioType === 'studio-books'">
            <tr>
              <th>المصنف</th>
              <th>العقدة الحالية</th>
              <th>نسبة الإنجاز</th>
              <th>المحقق</th>
              <th>التحديث</th>
              <th style="text-align: center;">الإجراء</th>
            </tr>
          </thead>

          <!-- 2. Manuscripts Columns -->
          <thead v-else-if="studioType === 'studio-manuscripts'">
            <tr>
              <th>المخطوطة</th>
              <th>اللوحة الحالية</th>
              <th>المقابلة النصية</th>
              <th>المحقق</th>
              <th style="text-align: center;">الإجراء المباشر</th>
            </tr>
          </thead>

          <!-- 3. Audios Columns -->
          <thead v-else-if="studioType === 'studio-audios'">
            <tr>
              <th>المجلس الصوتي</th>
              <th>مدة التسجيل</th>
              <th>الشرائح المنجزة</th>
              <th>دقة المطابقة</th>
              <th style="text-align: center;">الإجراء</th>
            </tr>
          </thead>

          <!-- 4. Videos Columns -->
          <thead v-else-if="studioType === 'studio-videos'">
            <tr>
              <th>التسجيل المرئي</th>
              <th>المدة</th>
              <th>الفصول الحالية</th>
              <th style="text-align: center;">الإجراء</th>
            </tr>
          </thead>

          <!-- 5. Versions Columns -->
          <thead v-else-if="studioType === 'versions'">
            <tr>
              <th>عنوان النسخة</th>
              <th>الكيان التابع</th>
              <th>الناشر / المحرر</th>
              <th>الحجم والصيغة</th>
              <th>التاريخ</th>
            </tr>
          </thead>

          <!-- Body Content -->
          <tbody>
            <!-- A. Studio Books Rows -->
            <template v-if="studioType === 'studio-books'">
              <tr v-for="b in activeItems" :key="b.id || b.slug">
                <td>
                  <strong class="book-title-link">{{ b.title }}</strong>
                </td>
                <td style="color: var(--text-dim, #a1a1aa);">
                  {{ b.current_node || 'الباب الأول: المقدمة التمهيدية' }}
                </td>
                <td>
                  <div style="display: flex; align-items: center; gap: 0.6rem;">
                    <div class="kpi-split-bar" style="height: 6px; width: 110px;">
                      <div :style="{ width: `${b.progress_percent || 75}%`, background: '#10b981' }"></div>
                    </div>
                    <span style="font-size: 0.72rem; color: #10b981; font-weight: 800; font-family: 'Outfit';">
                      {{ b.progress_percent || 75 }}%
                    </span>
                  </div>
                </td>
                <td>
                  <span class="role-chip chip-editor">{{ b.editor_name || 'فريق التحقيق الأكاديمي' }}</span>
                </td>
                <td style="font-size: 0.72rem; color: var(--text-dim, #71717a); font-family: 'Outfit';">
                  {{ b.updated_at_human || 'مؤخراً' }}
                </td>
                <td style="text-align: center;">
                  <a :href="b.studio_url || `/studio/book/${b.slug}`" class="btn-emerald-small">
                    <span>فتح المحرر ✍️</span>
                  </a>
                </td>
              </tr>
            </template>

            <!-- B. Studio Manuscripts Rows -->
            <template v-else-if="studioType === 'studio-manuscripts'">
              <tr v-for="(m, idx) in activeItems" :key="m.id || idx">
                <td>
                  <strong class="book-title-link">{{ m.title }}</strong>
                </td>
                <td>
                  <span class="meta-chip">{{ m.folio_count || `لوحة رقم ${(idx * 12 + 14)} (الوجه أ)` }}</span>
                </td>
                <td>
                  <span :class="['role-chip', idx % 2 === 0 ? 'chip-studio' : 'chip-academic']">
                    {{ idx % 2 === 0 ? 'مطابق بنسبة 100%' : 'قيد فك الطلاسم' }}
                  </span>
                </td>
                <td>{{ m.author || 'د. طارق الحارثي' }}</td>
                <td style="text-align: center;">
                  <a :href="m.studio_url || `/studio/manuscript/${m.slug}`" class="btn-emerald-small">
                    <span>متابعة التحقيق ✍️</span>
                  </a>
                </td>
              </tr>
            </template>

            <!-- C. Studio Audios Rows -->
            <template v-else-if="studioType === 'studio-audios'">
              <tr v-for="(a, idx) in activeItems" :key="a.id || idx">
                <td>
                  <strong class="book-title-link">{{ a.title }}</strong>
                </td>
                <td style="font-family: 'Outfit'; font-size: 0.75rem;">{{ a.duration || '01:15:30' }}</td>
                <td>
                  <span class="meta-chip">{{ (idx * 8 + 14) }} شريحة</span>
                </td>
                <td>
                  <span style="color: #34d399; font-weight: 800; font-family: 'Outfit';">
                    {{ (98.5 + (idx % 2)).toFixed(1) }}%
                  </span>
                </td>
                <td style="text-align: center;">
                  <a :href="a.studio_url || `/studio/audio/${a.slug}`" class="btn-emerald-small">
                    <span>فتح محرر الشرائح ✍️</span>
                  </a>
                </td>
              </tr>
            </template>

            <!-- D. Studio Videos Rows -->
            <template v-else-if="studioType === 'studio-videos'">
              <tr v-for="(v, idx) in activeItems" :key="v.id || idx">
                <td>
                  <strong class="book-title-link">{{ v.title }}</strong>
                </td>
                <td style="font-family: 'Outfit'; font-size: 0.75rem;">{{ v.duration || '02:15:00' }}</td>
                <td>
                  <span class="meta-chip">{{ (idx + 4) }} فصول رئيسية</span>
                </td>
                <td style="text-align: center;">
                  <a :href="v.studio_url || `/studio/video/${v.slug}`" class="btn-purple-small">
                    <span>تقطيع الفصول 🎬</span>
                  </a>
                </td>
              </tr>
            </template>

            <!-- E. Versions Rows -->
            <template v-else-if="studioType === 'versions'">
              <tr v-for="v in activeItems" :key="v.id">
                <td><strong class="book-title-link">{{ v.title }}</strong></td>
                <td>{{ v.versionable_title || 'الأصل المعتمد' }}</td>
                <td>
                  <span class="role-chip chip-public">{{ v.publisher_name || 'فريق التدقيق' }}</span>
                </td>
                <td>
                  <span class="icon-import" style="font-family: 'Outfit'; font-weight: 700;">{{ v.file_size_human || '2.4 MB' }}</span> / 
                  <span style="color: #38bdf8; font-weight: 700;">{{ v.format || 'PDF' }}</span>
                </td>
                <td style="font-size: 0.72rem; color: var(--text-dim, #71717a); font-family: 'Outfit';">
                  {{ v.created_at_human || 'مؤخراً' }}
                </td>
              </tr>
            </template>

            <!-- Empty Rows State -->
            <tr v-if="!activeItems.length">
              <td colspan="6" style="text-align: center; color: var(--text-dim, #71717a); padding: 2.5rem 1rem;">
                {{ searchQuery ? 'لا توجد نتائج تطابق استعلام البحث' : config.emptyMsg }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 2. Cards View Mode (Studio Cards Grid) -->
    <div v-show="viewMode === 'cards'" class="studio-cards-grid">
      <div
        v-for="(item, idx) in activeItems"
        :key="item.id || idx"
        class="studio-entity-card"
      >
        <div class="card-header-row">
          <span class="role-chip chip-studio">{{ config.title }}</span>
          <span v-if="item.progress_percent" class="progress-badge">
            {{ item.progress_percent }}% إنجاز
          </span>
        </div>

        <h3 class="entity-title">{{ item.title }}</h3>

        <div class="entity-meta-tags">
          <span v-if="item.current_node" class="meta-chip">📍 {{ item.current_node }}</span>
          <span v-if="item.editor_name || item.author" class="meta-chip">👤 {{ item.editor_name || item.author }}</span>
          <span v-if="item.folio_count" class="meta-chip">📜 {{ item.folio_count }}</span>
          <span v-if="item.duration" class="meta-chip">⏱️ {{ item.duration }}</span>
          <span v-if="item.versionable_title" class="meta-chip">📚 {{ item.versionable_title }}</span>
          <span v-if="item.file_size_human" class="meta-chip">{{ item.file_size_human }}</span>
        </div>

        <div v-if="item.progress_percent" class="card-progress-bar">
          <div :style="{ width: `${item.progress_percent}%`, background: '#10b981' }"></div>
        </div>

        <div class="card-footer">
          <a
            v-if="item.studio_url"
            :href="item.studio_url"
            class="btn-emerald-small"
          >
            <span>فتح الجلسة التحريرية ✍️</span>
          </a>
          <span class="card-date">{{ item.updated_at_human || item.created_at_human || 'مؤخراً' }}</span>
        </div>
      </div>

      <div v-if="!activeItems.length" style="grid-column: 1 / -1; text-align: center; color: var(--text-dim, #71717a); padding: 3rem 1rem;">
        {{ searchQuery ? 'لا توجد نتائج تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD STUDIO VIEW STYLES (Self-Contained Glassmorphism)
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
  margin-bottom: 1.25rem;
}
body.light-mode .dashboard-studio-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-studio-view .studio-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  padding: 0.85rem 1.25rem;
  background: rgba(18, 18, 21, 0.6);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1rem;
  margin-bottom: 1.25rem;
  backdrop-filter: blur(10px);
}
body.light-mode .dashboard-studio-view .studio-toolbar {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}

.dashboard-studio-view .toolbar-search-box {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.1));
  border-radius: 8px;
  padding: 0.4rem 0.75rem;
  flex: 1;
  max-width: 380px;
}
body.light-mode .dashboard-studio-view .toolbar-search-box {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.12);
}

.dashboard-studio-view .toolbar-search-input {
  background: transparent;
  border: none;
  color: var(--text-main, #f4f4f5);
  font-size: 0.82rem;
  width: 100%;
  outline: none;
  font-family: inherit;
}
body.light-mode .dashboard-studio-view .toolbar-search-input {
  color: #0f172a;
}

.dashboard-studio-view .toolbar-controls {
  display: flex;
  align-items: center;
  gap: 0.85rem;
}

.dashboard-studio-view .items-count-badge {
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--text-dim, #71717a);
  background: rgba(255, 255, 255, 0.04);
  padding: 0.3rem 0.65rem;
  border-radius: 6px;
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-studio-view .items-count-badge {
  background: #f1f5f9;
  border-color: rgba(0, 0, 0, 0.08);
  color: #475569;
}

/* Enterprise Card Wrapper */
.dashboard-studio-view .enterprise-card {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.25rem;
  overflow: hidden;
  backdrop-filter: blur(12px);
}
body.light-mode .dashboard-studio-view .enterprise-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}

/* Dense Table */
.dashboard-studio-view .dense-table-wrapper {
  width: 100%;
  overflow-x: auto;
}
.dashboard-studio-view .dense-table {
  width: 100%;
  border-collapse: collapse;
  text-align: right;
  font-size: 0.82rem;
  white-space: nowrap;
}
.dashboard-studio-view .dense-table thead th {
  background: rgba(255, 255, 255, 0.02);
  padding: 0.75rem 0.85rem;
  color: var(--text-dim, #71717a);
  font-size: 0.74rem;
  font-weight: 700;
  border-bottom: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-studio-view .dense-table thead th {
  background: #f8fafc;
  color: #475569;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}
.dashboard-studio-view .dense-table tbody td {
  padding: 0.6rem 0.85rem;
  border-bottom: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  color: var(--text-main, #f4f4f5);
  vertical-align: middle;
}
body.light-mode .dashboard-studio-view .dense-table tbody td {
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  color: #0f172a;
}
.dashboard-studio-view .dense-table tbody tr:hover td {
  background: rgba(255, 255, 255, 0.035);
}
body.light-mode .dashboard-studio-view .dense-table tbody tr:hover td {
  background: #f8fafc;
}

/* Cards Grid */
.dashboard-studio-view .studio-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 1.25rem;
}
.dashboard-studio-view .studio-entity-card {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1rem;
  padding: 1.25rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 0.85rem;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
body.light-mode .dashboard-studio-view .studio-entity-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
}
.dashboard-studio-view .studio-entity-card:hover {
  transform: translateY(-2px);
  border-color: var(--indigo, #6366f1);
}

.dashboard-studio-view .card-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.dashboard-studio-view .progress-badge {
  font-size: 0.7rem;
  font-weight: 800;
  color: #10b981;
  font-family: 'Outfit';
}
.dashboard-studio-view .card-progress-bar {
  width: 100%;
  height: 4px;
  background: rgba(255, 255, 255, 0.06);
  border-radius: 9999px;
  overflow: hidden;
}
body.light-mode .dashboard-studio-view .card-progress-bar {
  background: rgba(0, 0, 0, 0.06);
}
.dashboard-studio-view .card-progress-bar div {
  height: 100%;
  border-radius: 9999px;
}

.dashboard-studio-view .card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 0.5rem;
  border-top: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.06));
}
body.light-mode .dashboard-studio-view .card-footer {
  border-top-color: rgba(0, 0, 0, 0.06);
}
.dashboard-studio-view .card-date {
  font-size: 0.65rem;
  color: var(--text-dim, #71717a);
  font-family: 'Outfit';
}

/* Action Buttons */
.dashboard-studio-view .btn-emerald-small {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.32rem 0.75rem;
  border-radius: 6px;
  background: rgba(16, 185, 129, 0.12);
  color: #34d399;
  border: 1px solid rgba(16, 185, 129, 0.25);
  font-size: 0.75rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.15s;
}
body.light-mode .dashboard-studio-view .btn-emerald-small {
  background: rgba(16, 185, 129, 0.1);
  color: #047857;
  border-color: rgba(16, 185, 129, 0.3);
}
.dashboard-studio-view .btn-emerald-small:hover {
  background: #10b981;
  color: #ffffff;
}

.dashboard-studio-view .btn-purple-small {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.32rem 0.75rem;
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
