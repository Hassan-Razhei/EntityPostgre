<script setup>
import { computed } from 'vue';

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

const config = computed(() => {
  switch (props.taxonomyType) {
    case 'collections':
      return {
        title: 'المجموعات المعرفية',
        icon: '📦',
        desc: 'تنظيم المصنفات في حقائب ومجموعات موضوعية وبحثية',
        createUrl: '/collections/create',
        createLabel: '+ مجموعة جديدة',
      };
    case 'series':
      return {
        title: 'السلاسل العلمية',
        icon: '📚',
        desc: 'إدارة السلاسل والموسوعات العلمية ومتابعة ترقيم الأجزاء والمصنفات المتسلسلة',
        createUrl: '/series/create',
        createLabel: '+ سلسلة جديدة',
      };
    case 'topics':
      return {
        title: 'الموضوعات التخصصية',
        icon: '💡',
        desc: 'فهرسة رؤوس الموضوعات والمسائل العلمية الدقيقة وربطها بالمصنفات التراثية',
        createUrl: '/topics/create',
        createLabel: '+ موضوع جديد',
      };
    case 'tags':
      return {
        title: 'الأوسمة والكلمات المفتاحية',
        icon: '🏷️',
        desc: 'فهرس الأوسمة والدلالات الموضوعية وسحابة الكلمات المفتاحية',
        createUrl: '/tags/create',
        createLabel: '+ وسم جديد',
      };
    case 'categories':
      return {
        title: 'التصنيفات والفئات',
        icon: '📁',
        desc: 'الهيكل الشجري لتصنيف العلوم والفنون والمجالات المعرفية',
        createUrl: '/categories/create',
        createLabel: '+ تصنيف جديد',
      };
    default:
      return {
        title: 'الفهرس المعرفي',
        icon: '🗂️',
        desc: 'تنظيم وإدارة عناصر المنظومة',
        createUrl: '',
        createLabel: '',
      };
  }
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

    <!-- 1. Collections View Table -->
    <div v-if="taxonomyType === 'collections'" class="section-card">
      <div class="users-table-wrap">
        <table class="users-table">
          <thead>
            <tr>
              <th>اسم المجموعة وبيانها</th>
              <th>النوع</th>
              <th>العناصر المربوطة</th>
              <th>المشرف</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="col in items" :key="col.id">
              <td>
                <div style="font-weight: 700; color: var(--text-main, #f4f4f5); font-size: 0.9rem;">{{ col.name }}</div>
                <div style="font-size: 0.72rem; color: var(--text-dim, #71717a); margin-top: 0.2rem;">{{ col.description || 'لا يوجد وصف للمجموعة' }}</div>
              </td>
              <td>
                <span :class="['role-chip', col.is_public ? 'chip-studio' : 'chip-academic']">
                  {{ col.is_public ? 'عامة 🌐' : 'خاصة 🔒' }}
                </span>
              </td>
              <td>
                <span class="badge-count" style="font-size: 0.8rem; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                  {{ col.entities_count || 0 }}
                </span>
              </td>
              <td>
                <div style="font-size: 0.8rem; color: var(--text-main, #f4f4f5);">{{ col.user_name || 'المشرف العام' }}</div>
              </td>
              <td>
                <div style="display: flex; gap: 0.4rem; align-items: center;">
                  <a :href="col.show_url || `/collections/${col.id}`" class="btn-emerald-small" style="text-decoration: none;">
                    <span>استعراض 👁️</span>
                  </a>
                  <a :href="col.edit_url || `/collections/${col.id}/edit`" class="btn-action-small" style="text-decoration: none;">
                    <span>تعديل ⚙️</span>
                  </a>
                </div>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="5" style="text-align: center; color: var(--text-dim, #71717a); padding: 2.5rem;">لا توجد مجموعات معرفية مدرجة حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 2. Series View Table -->
    <div v-else-if="taxonomyType === 'series'" class="section-card">
      <div class="users-table-wrap">
        <table class="users-table">
          <thead>
            <tr>
              <th>عنوان السلسلة والبيان</th>
              <th>عدد المصنفات والأجزاء</th>
              <th>الترتيب العام</th>
              <th>الإجراءات المباشرة</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(ser, idx) in items" :key="ser.id">
              <td>
                <div style="font-weight: 700; color: var(--text-main, #f4f4f5); font-size: 0.9rem;">{{ ser.title }}</div>
                <div style="font-size: 0.72rem; color: var(--text-dim, #71717a); margin-top: 0.2rem;">{{ ser.description || 'سلسلة علمية متسلسلة' }}</div>
              </td>
              <td>
                <span class="badge-count" style="font-size: 0.8rem; background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3);">
                  {{ ser.books_count || 0 }} مصنفاً
                </span>
              </td>
              <td>
                <span class="role-chip chip-studio">ترتيب #{{ ser.order_column || (idx + 1) }}</span>
              </td>
              <td>
                <div style="display: flex; gap: 0.4rem; align-items: center;">
                  <a :href="ser.show_url || `/series/${ser.id}`" class="btn-emerald-small" style="text-decoration: none;">
                    <span>استعراض السلسلة 📚</span>
                  </a>
                  <a :href="ser.edit_url || `/series/${ser.id}/edit`" class="btn-action-small" style="text-decoration: none;">
                    <span>تعديل ⚙️</span>
                  </a>
                </div>
              </td>
            </tr>
            <tr v-if="!items || !items.length">
              <td colspan="4" style="text-align: center; color: var(--text-dim, #71717a); padding: 2.5rem;">لا توجد سلاسل علمية مدرجة حالياً</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- 3. Topics View Cards -->
    <div v-else-if="taxonomyType === 'topics'" class="section-card">
      <div v-if="items && items.length" style="display: flex; flex-direction: column; gap: 0.5rem;">
        <div
          v-for="(top, idx) in items"
          :key="top.id || idx"
          class="tree-node"
          :style="{ borderRight: `4px solid ${idx % 3 === 0 ? '#38bdf8' : (idx % 3 === 1 ? '#a855f7' : '#34d399')}` }"
          style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1.1rem;"
        >
          <div style="display: flex; flex-direction: column; gap: 0.2rem;">
            <span style="font-weight: 700; color: var(--text-main, #f4f4f5); font-size: 0.9rem;">💡 {{ top.name }}</span>
            <span style="font-size: 0.7rem; color: var(--text-dim, #71717a); font-family: monospace;">#{{ top.slug }}</span>
          </div>
          <div style="display: flex; align-items: center; gap: 0.6rem;">
            <span class="badge-count" style="font-size: 0.78rem; background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3);">
              {{ top.books_count || 0 }} مصنفاً
            </span>
            <a :href="`/topics/${top.id}`" class="btn-action-small" style="text-decoration: none; font-size: 0.72rem;">استعراض 🔍</a>
          </div>
        </div>
      </div>
      <div v-else style="text-align: center; color: var(--text-dim, #71717a); padding: 2.5rem;">لا توجد موضوعات تخصصية مفهرسة حالياً</div>
    </div>

    <!-- 4. Tags View Chips Cloud -->
    <div v-else-if="taxonomyType === 'tags'" class="section-card">
      <div v-if="items && items.length" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
        <span
          v-for="(tag, idx) in items"
          :key="tag.id || idx"
          :class="['entity-tag', idx % 3 === 0 ? 'tag-public' : (idx % 3 === 1 ? 'tag-scholarly' : 'tag-draft')]"
          style="padding: 0.35rem 0.75rem; border-radius: 9999px; font-weight: 700;"
        >
          #{{ tag.name }} ({{ tag.books_count ?? 0 }})
        </span>
      </div>
      <div v-else style="color: var(--text-dim, #71717a); font-size: 0.85rem; text-align: center; padding: 2rem;">لا توجد أوسمة مفهرسة حالياً</div>
    </div>

    <!-- 5. Categories View Tree -->
    <div v-else class="section-card">
      <div v-if="items && items.length" style="display: flex; flex-direction: column; gap: 0.5rem;">
        <div
          v-for="cat in items"
          :key="cat.id"
          class="tree-node"
          style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1.1rem;"
        >
          <span style="font-weight: 700; color: var(--text-main, #f4f4f5);">📁 {{ cat.name }}</span>
          <span class="badge-count">{{ (cat.books_count ?? 0).toLocaleString() }} مصنفاً</span>
        </div>
      </div>
      <div v-else style="color: var(--text-dim, #71717a); font-size: 0.85rem; text-align: center; padding: 2rem;">لا توجد تصنيفات مفهرسة حالياً</div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD TAXONOMY VIEW STYLES
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
  margin-bottom: 1.5rem;
}
body.light-mode .dashboard-taxonomy-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-taxonomy-view .tree-node {
  padding: 0.5rem 0.85rem;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  font-size: 0.8rem;
  font-weight: 700;
  transition: all 0.2s;
}
body.light-mode .dashboard-taxonomy-view .tree-node {
  background: #f8fafc;
  border-color: rgba(0, 0, 0, 0.08);
}

.dashboard-taxonomy-view .entity-tag {
  font-size: 0.8rem;
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.1));
}
.dashboard-taxonomy-view .tag-public { background: rgba(16, 185, 129, 0.1); color: #34d399; }
.dashboard-taxonomy-view .tag-scholarly { background: rgba(59, 130, 246, 0.1); color: #60a5fa; }
.dashboard-taxonomy-view .tag-draft { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
</style>
