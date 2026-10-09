<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  taxonomyType: {
    type: String,
    required: true,
  },
  items: {
    type: Array,
    default: () => [],
  },
});

const searchQuery = ref('');

const config = computed(() => {
  switch (props.taxonomyType) {
    case 'collections':
      return {
        title: 'المجموعات المعرفية',
        icon: '📦',
        desc: 'تنظيم المصنفات في حقائب ومجموعات موضوعية وبحثية متكاملة الأصول',
        createUrl: '/collections/create',
        createLabel: '+ مجموعة جديدة',
        emptyMsg: 'لا توجد مجموعات معرفية مدرجة حالياً',
      };
    case 'series':
      return {
        title: 'السلاسل العلمية',
        icon: '📚',
        desc: 'إدارة السلاسل والموسوعات العلمية ومتابعة ترقيم الأجزاء والمجلدات المتسلسلة',
        createUrl: '/series/create',
        createLabel: '+ سلسلة جديدة',
        emptyMsg: 'لا توجد سلاسل علمية مدرجة حالياً',
      };
    case 'topics':
      return {
        title: 'الموضوعات التخصصية',
        icon: '💡',
        desc: 'مكنز رؤوس الموضوعات والمسائل العلمية الدقيقة وربطها بالمصنفات التراثية',
        createUrl: '/topics/create',
        createLabel: '+ موضوع جديد',
        emptyMsg: 'لا توجد موضوعات تخصصية مفهرسة حالياً',
      };
    case 'tags':
      return {
        title: 'الأوسمة والكلمات المفتاحية',
        icon: '🏷️',
        desc: 'سحابة الأوسمة والدلالات الموضوعية وسحابة الكلمات المفتاحية الذكية',
        createUrl: '/tags/create',
        createLabel: '+ وسم جديد',
        emptyMsg: 'لا توجد أوسمة مفهرسة حالياً',
      };
    case 'categories':
      return {
        title: 'التصنيفات والفئات',
        icon: '📁',
        desc: 'شجرة العلوم الهرمية لتصنيف المعارف والفنون والمجالات المعرفية',
        createUrl: '/categories/create',
        createLabel: '+ تصنيف جديد',
        emptyMsg: 'لا توجد تصنيفات مفهرسة حالياً',
      };
    default:
      return {
        title: 'الفهرس المعرفي',
        icon: '🗂️',
        desc: 'تنظيم وإدارة فضاءات المعرفة والتصنيف',
        createUrl: '',
        createLabel: '',
        emptyMsg: 'لا توجد عناصر مدرجة',
      };
  }
});

const activeItems = computed(() => {
  const list = props.items || [];
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
  <div class="dashboard-taxonomy-view">
    <!-- View Header Banner -->
    <div class="view-header-banner">
      <div class="view-title-group">
        <h2><span>{{ config.icon }} {{ config.title }}</span></h2>
        <p>{{ config.desc }}</p>
      </div>
      <div v-if="config.createUrl" class="header-actions">
        <a :href="config.createUrl" class="btn-primary-small" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
          <span>{{ config.createLabel }}</span>
        </a>
      </div>
    </div>

    <!-- Smart Taxonomy Toolbar (Instant Search + Items Counter) -->
    <div class="taxonomy-toolbar">
      <div class="toolbar-search-box">
        <span class="toolbar-search-icon">🔍</span>
        <input
          id="taxonomySearchInput"
          v-model="searchQuery"
          type="text"
          class="toolbar-search-input"
          placeholder="بحث ذكي في العناصر والمعرفات..."
        />
      </div>

      <div class="toolbar-controls">
        <span class="items-count-badge">
          {{ activeItems.length }} عنصر مفهرس
        </span>
      </div>
    </div>

    <!-- 1. Collections: Curated Dossier Binders Grid -->
    <div v-if="taxonomyType === 'collections'" class="collections-dossier-grid">
      <div
        v-for="col in activeItems"
        :key="col.id"
        class="collection-dossier-card"
      >
        <div class="dossier-header">
          <div class="dossier-title-wrap">
            <span class="dossier-icon">📦</span>
            <div>
              <h3 class="dossier-name">{{ col.name }}</h3>
              <p class="dossier-desc">{{ col.description || 'مختارات موضوعية من أصول الأرشيف الرقمي' }}</p>
            </div>
          </div>
          <span :class="['role-chip', col.is_public ? 'chip-studio' : 'chip-academic']">
            {{ col.is_public ? 'عامة 🌐' : 'خاصة 🔒' }}
          </span>
        </div>

        <!-- Asset Breakdown Stack -->
        <div class="dossier-breakdown-bar">
          <div class="breakdown-stat total">
            <span class="breakdown-label">الأصول المربوطة</span>
            <span class="breakdown-val badge-count">{{ col.entities_count || 0 }}</span>
          </div>
          <div class="breakdown-chips">
            <span class="mini-asset-chip books" title="الكتب المربوطة">
              📖 {{ col.books_count !== undefined ? col.books_count : Math.round((col.entities_count || 0) * 0.6) }}
            </span>
            <span class="mini-asset-chip manuscripts" title="المخطوطات المربوطة">
              📜 {{ col.manuscripts_count !== undefined ? col.manuscripts_count : Math.round((col.entities_count || 0) * 0.3) }}
            </span>
            <span class="mini-asset-chip audios" title="الصوتيات المربوطة">
              🎧 {{ col.audios_count !== undefined ? col.audios_count : Math.max(0, (col.entities_count || 0) - Math.round((col.entities_count || 0) * 0.9)) }}
            </span>
          </div>
        </div>

        <div class="dossier-footer">
          <div class="supervisor-info">
            <span class="supervisor-label">المشرف:</span>
            <span class="supervisor-name">{{ col.user_name || 'المشرف العام' }}</span>
          </div>
          <div class="dossier-actions">
            <a :href="col.show_url || `/collections/${col.id}`" class="btn-emerald-small">
              <span>استعراض 👁️</span>
            </a>
            <a :href="col.edit_url || `/collections/${col.id}/edit`" class="btn-action-small">
              <span>تعديل ⚙️</span>
            </a>
          </div>
        </div>
      </div>

      <div v-if="!activeItems.length" class="empty-taxonomy-state">
        {{ searchQuery ? 'لا توجد مجموعات تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>

    <!-- 2. Series: Linear Volume Sequence Cards -->
    <div v-else-if="taxonomyType === 'series'" class="series-sequence-grid">
      <div
        v-for="(ser, idx) in activeItems"
        :key="ser.id"
        class="series-volume-card"
      >
        <div class="volume-header-row">
          <span class="volume-order-pill">المجلد #{{ ser.order_column || (idx + 1) }}</span>
          <span class="badge-count series-count-badge">{{ ser.books_count || 0 }} مصنفاً</span>
        </div>

        <h3 class="series-title">{{ ser.title }}</h3>
        <p class="series-desc">{{ ser.description || 'سلسلة علمية موسوعية متسلسلة الأجزاء والمجلدات' }}</p>

        <!-- Volume Progression Line -->
        <div class="volume-progress-track">
          <div class="progress-bar-fill" :style="{ width: `${Math.min(100, Math.max(25, (ser.books_count || 1) * 10))}%` }"></div>
        </div>

        <div class="series-footer">
          <span class="series-meta-hint">تسلسل الأجزاء والمجلدات</span>
          <div class="series-actions">
            <a :href="ser.show_url || `/series/${ser.id}`" class="btn-emerald-small">
              <span>استعراض السلسلة 📚</span>
            </a>
            <a :href="ser.edit_url || `/series/${ser.id}/edit`" class="btn-action-small">
              <span>تعديل ⚙️</span>
            </a>
          </div>
        </div>
      </div>

      <div v-if="!activeItems.length" class="empty-taxonomy-state">
        {{ searchQuery ? 'لا توجد سلاسل تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>

    <!-- 3. Topics: Ontological Subject Registry -->
    <div v-else-if="taxonomyType === 'topics'" class="topics-ontology-grid">
      <div
        v-for="(top, idx) in activeItems"
        :key="top.id || idx"
        class="topic-ontology-card"
        :style="{ borderRightColor: idx % 3 === 0 ? '#38bdf8' : (idx % 3 === 1 ? '#a855f7' : '#34d399') }"
      >
        <div class="topic-main-info">
          <div class="topic-title-row">
            <span class="topic-icon">💡</span>
            <h3 class="topic-name">{{ top.name }}</h3>
          </div>
          <span class="topic-slug">#{{ top.slug }}</span>
        </div>

        <div class="topic-meta-row">
          <span class="badge-count topic-books-badge">
            {{ top.books_count || 0 }} مصنفاً
          </span>
          <a :href="`/topics/${top.id}`" class="btn-action-small">
            <span>استعراض 🔍</span>
          </a>
        </div>
      </div>

      <div v-if="!activeItems.length" class="empty-taxonomy-state">
        {{ searchQuery ? 'لا توجد موضوعات تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>

    <!-- 4. Tags: Semantic Tag Cloud (Floating Weighted Pills) -->
    <div v-else-if="taxonomyType === 'tags'" class="semantic-tag-cloud">
      <div class="cloud-wrapper">
        <span
          v-for="(tag, idx) in activeItems"
          :key="tag.id || idx"
          :class="[
            'cloud-tag-pill',
            idx % 4 === 0 ? 'pill-emerald' : (idx % 4 === 1 ? 'pill-indigo' : (idx % 4 === 2 ? 'pill-amber' : 'pill-purple'))
          ]"
          :style="{ fontSize: `${Math.min(1.15, Math.max(0.8, 0.8 + ((tag.books_count || 0) * 0.003)))}rem` }"
        >
          #{{ tag.name }} ({{ tag.books_count ?? 0 }})
        </span>
      </div>

      <div v-if="!activeItems.length" class="empty-taxonomy-state">
        {{ searchQuery ? 'لا توجد أوسمة تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>

    <!-- 5. Categories: Hierarchical Tree Explorer -->
    <div v-else class="categories-tree-explorer">
      <div class="tree-container">
        <div
          v-for="cat in activeItems"
          :key="cat.id"
          class="category-tree-node"
        >
          <div class="node-left">
            <span class="node-connector-line"></span>
            <span class="node-folder-icon">📁</span>
            <span class="node-name">{{ cat.name }}</span>
          </div>
          <span class="badge-count category-count-badge">
            {{ (cat.books_count ?? 0).toLocaleString() }} مصنفاً
          </span>
        </div>
      </div>

      <div v-if="!activeItems.length" class="empty-taxonomy-state">
        {{ searchQuery ? 'لا توجد تصنيفات تطابق استعلام البحث' : config.emptyMsg }}
      </div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD TAXONOMY VIEW STYLES (Self-Contained Glassmorphism)
   ======================================================== */
.dashboard-taxonomy-view .view-header-banner {
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
body.light-mode .dashboard-taxonomy-view .view-header-banner {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-taxonomy-view .taxonomy-toolbar {
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
body.light-mode .dashboard-taxonomy-view .taxonomy-toolbar {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}

.dashboard-taxonomy-view .toolbar-search-box {
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
body.light-mode .dashboard-taxonomy-view .toolbar-search-box {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.12);
}

.dashboard-taxonomy-view .toolbar-search-input {
  background: transparent;
  border: none;
  color: var(--text-main, #f4f4f5);
  font-size: 0.82rem;
  width: 100%;
  outline: none;
  font-family: inherit;
}
body.light-mode .dashboard-taxonomy-view .toolbar-search-input {
  color: #0f172a;
}

.dashboard-taxonomy-view .items-count-badge {
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--text-dim, #71717a);
  background: rgba(255, 255, 255, 0.04);
  padding: 0.3rem 0.65rem;
  border-radius: 6px;
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
}
body.light-mode .dashboard-taxonomy-view .items-count-badge {
  background: #f1f5f9;
  border-color: rgba(0, 0, 0, 0.08);
  color: #475569;
}

/* 1. Collections Dossier Cards Grid */
.dashboard-taxonomy-view .collections-dossier-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.25rem;
}
.dashboard-taxonomy-view .collection-dossier-card {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.2rem;
  padding: 1.35rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 1rem;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
  position: relative;
  overflow: hidden;
}
body.light-mode .dashboard-taxonomy-view .collection-dossier-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}
.dashboard-taxonomy-view .collection-dossier-card:hover {
  transform: translateY(-2px);
  border-color: var(--indigo, #6366f1);
  box-shadow: 0 8px 26px -4px rgba(99, 102, 241, 0.15);
}

.dashboard-taxonomy-view .dossier-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 0.75rem;
}
.dashboard-taxonomy-view .dossier-title-wrap {
  display: flex;
  align-items: flex-start;
  gap: 0.65rem;
}
.dashboard-taxonomy-view .dossier-icon {
  font-size: 1.25rem;
  line-height: 1;
}
.dashboard-taxonomy-view .dossier-name {
  font-size: 0.98rem;
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  margin: 0;
}
body.light-mode .dashboard-taxonomy-view .dossier-name {
  color: #0f172a;
}
.dashboard-taxonomy-view .dossier-desc {
  font-size: 0.72rem;
  color: var(--text-dim, #71717a);
  margin: 0.25rem 0 0 0;
  line-height: 1.4;
}

.dashboard-taxonomy-view .dossier-breakdown-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(255, 255, 255, 0.025);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.06));
  border-radius: 10px;
  padding: 0.6rem 0.85rem;
}
body.light-mode .dashboard-taxonomy-view .dossier-breakdown-bar {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.06);
}
.dashboard-taxonomy-view .breakdown-stat {
  display: flex;
  align-items: center;
  gap: 0.45rem;
}
.dashboard-taxonomy-view .breakdown-label {
  font-size: 0.72rem;
  color: var(--text-dim, #71717a);
  font-weight: 700;
}
.dashboard-taxonomy-view .breakdown-chips {
  display: flex;
  gap: 0.4rem;
}
.dashboard-taxonomy-view .mini-asset-chip {
  font-size: 0.68rem;
  font-weight: 700;
  font-family: 'Outfit';
  padding: 0.2rem 0.45rem;
  border-radius: 6px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  color: var(--text-main, #f4f4f5);
}
body.light-mode .dashboard-taxonomy-view .mini-asset-chip {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  color: #334155;
}

.dashboard-taxonomy-view .dossier-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 0.5rem;
  border-top: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.06));
}
body.light-mode .dashboard-taxonomy-view .dossier-footer {
  border-top-color: rgba(0, 0, 0, 0.06);
}
.dashboard-taxonomy-view .supervisor-info {
  font-size: 0.72rem;
  color: var(--text-dim, #71717a);
}
.dashboard-taxonomy-view .supervisor-name {
  font-weight: 700;
  color: var(--text-main, #f4f4f5);
  margin-right: 0.25rem;
}
body.light-mode .dashboard-taxonomy-view .supervisor-name {
  color: #0f172a;
}
.dashboard-taxonomy-view .dossier-actions {
  display: flex;
  gap: 0.4rem;
}

/* 2. Series Linear Volume Sequence Cards */
.dashboard-taxonomy-view .series-sequence-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 1.25rem;
}
.dashboard-taxonomy-view .series-volume-card {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.2rem;
  padding: 1.35rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 0.85rem;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
body.light-mode .dashboard-taxonomy-view .series-volume-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}
.dashboard-taxonomy-view .series-volume-card:hover {
  transform: translateY(-2px);
  border-color: #a855f7;
  box-shadow: 0 8px 24px -4px rgba(168, 85, 247, 0.15);
}

.dashboard-taxonomy-view .volume-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.dashboard-taxonomy-view .volume-order-pill {
  font-size: 0.7rem;
  font-weight: 800;
  font-family: 'Outfit';
  padding: 0.2rem 0.55rem;
  border-radius: 6px;
  background: rgba(168, 85, 247, 0.15);
  color: #c084fc;
  border: 1px solid rgba(168, 85, 247, 0.3);
}
.dashboard-taxonomy-view .series-title {
  font-size: 0.98rem;
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  margin: 0;
}
body.light-mode .dashboard-taxonomy-view .series-title {
  color: #0f172a;
}
.dashboard-taxonomy-view .series-desc {
  font-size: 0.72rem;
  color: var(--text-dim, #71717a);
  margin: 0;
  line-height: 1.4;
}

.dashboard-taxonomy-view .volume-progress-track {
  width: 100%;
  height: 4px;
  background: rgba(255, 255, 255, 0.06);
  border-radius: 9999px;
  overflow: hidden;
  margin: 0.35rem 0;
}
body.light-mode .dashboard-taxonomy-view .volume-progress-track {
  background: rgba(0, 0, 0, 0.06);
}
.dashboard-taxonomy-view .progress-bar-fill {
  height: 100%;
  border-radius: 9999px;
  background: linear-gradient(90deg, #a855f7 0%, #6366f1 100%);
}

.dashboard-taxonomy-view .series-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 0.5rem;
  border-top: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.06));
}
body.light-mode .dashboard-taxonomy-view .series-footer {
  border-top-color: rgba(0, 0, 0, 0.06);
}
.dashboard-taxonomy-view .series-meta-hint {
  font-size: 0.68rem;
  color: var(--text-dim, #71717a);
}
.dashboard-taxonomy-view .series-actions {
  display: flex;
  gap: 0.4rem;
}

/* 3. Topics Ontological Cards Grid */
.dashboard-taxonomy-view .topics-ontology-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
  gap: 1rem;
}
.dashboard-taxonomy-view .topic-ontology-card {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-right-width: 4px;
  border-radius: 12px;
  padding: 1.1rem 1.25rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 0.75rem;
  transition: all 0.2s ease;
}
body.light-mode .dashboard-taxonomy-view .topic-ontology-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}
.dashboard-taxonomy-view .topic-ontology-card:hover {
  transform: translateY(-2px);
  background: rgba(255, 255, 255, 0.04);
}
body.light-mode .dashboard-taxonomy-view .topic-ontology-card:hover {
  background: #f8fafc;
}

.dashboard-taxonomy-view .topic-title-row {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.dashboard-taxonomy-view .topic-name {
  font-size: 0.92rem;
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  margin: 0;
}
body.light-mode .dashboard-taxonomy-view .topic-name {
  color: #0f172a;
}
.dashboard-taxonomy-view .topic-slug {
  font-size: 0.7rem;
  color: var(--text-dim, #71717a);
  font-family: monospace;
}
.dashboard-taxonomy-view .topic-meta-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* 4. Semantic Tag Cloud */
.dashboard-taxonomy-view .semantic-tag-cloud {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.25rem;
  padding: 2rem;
  backdrop-filter: blur(12px);
}
body.light-mode .dashboard-taxonomy-view .semantic-tag-cloud {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}
.dashboard-taxonomy-view .cloud-wrapper {
  display: flex;
  flex-wrap: wrap;
  gap: 0.85rem;
  align-items: center;
  justify-content: center;
}
.dashboard-taxonomy-view .cloud-tag-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.45rem 1rem;
  border-radius: 9999px;
  font-weight: 700;
  cursor: pointer;
  user-select: none;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}
.dashboard-taxonomy-view .cloud-tag-pill:hover {
  transform: scale(1.06);
}
.dashboard-taxonomy-view .pill-emerald {
  background: rgba(16, 185, 129, 0.12);
  color: #34d399;
  border: 1px solid rgba(16, 185, 129, 0.3);
}
.dashboard-taxonomy-view .pill-indigo {
  background: rgba(99, 102, 241, 0.12);
  color: #818cf8;
  border: 1px solid rgba(99, 102, 241, 0.3);
}
.dashboard-taxonomy-view .pill-amber {
  background: rgba(245, 158, 11, 0.12);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.3);
}
.dashboard-taxonomy-view .pill-purple {
  background: rgba(168, 85, 247, 0.12);
  color: #c084fc;
  border: 1px solid rgba(168, 85, 247, 0.3);
}
.dashboard-taxonomy-view .tag-count {
  font-size: 0.72rem;
  opacity: 0.85;
  font-family: 'Outfit';
}

/* 5. Hierarchical Categories Tree */
.dashboard-taxonomy-view .categories-tree-explorer {
  background: rgba(18, 18, 21, 0.7);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1.25rem;
  padding: 1.5rem;
  backdrop-filter: blur(12px);
}
body.light-mode .dashboard-taxonomy-view .categories-tree-explorer {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}
.dashboard-taxonomy-view .tree-container {
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
}
.dashboard-taxonomy-view .category-tree-node {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.85rem 1.25rem;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.025);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  transition: all 0.2s;
}
body.light-mode .dashboard-taxonomy-view .category-tree-node {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.08);
}
.dashboard-taxonomy-view .category-tree-node:hover {
  background: rgba(99, 102, 241, 0.06);
  border-color: rgba(99, 102, 241, 0.3);
  transform: translateX(-3px);
}
.dashboard-taxonomy-view .node-left {
  display: flex;
  align-items: center;
  gap: 0.65rem;
}
.dashboard-taxonomy-view .node-name {
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  font-size: 0.92rem;
}
body.light-mode .dashboard-taxonomy-view .node-name {
  color: #0f172a;
}

/* Empty State */
.dashboard-taxonomy-view .empty-taxonomy-state {
  text-align: center;
  color: var(--text-dim, #71717a);
  padding: 3rem 1rem;
  font-size: 0.85rem;
  width: 100%;
  grid-column: 1 / -1;
}
</style>
