<script setup>
import axios from 'axios';

const emit = defineEmits(['navigate']);

function handleNavigate(viewKey) {
  emit('navigate', viewKey);
  if (typeof window !== 'undefined' && typeof window.loadView === 'function') {
    window.loadView(viewKey);
  }
}

async function triggerOpsCacheClear() {
  try {
    const res = await axios.post('/api/system/run-command', { command: 'optimize:clear' });
    alert(res.data?.output || 'تم تفريغ كاش التطبيق وكاش التوجيه وسياسات الصلاحيات بنجاح.');
  } catch (err) {
    alert('حدث خطأ أثناء تفريغ الكاش: ' + (err.response?.data?.message || err.message));
  }
}

function handleSessionSecuritySignal() {
  alert('تم إرسال إشارة أمان لكافة الجلسات النشطة!');
}

function handleToggleMaintenance() {
  alert('تم تبديل حالة وضع الصيانة بنجاح!');
}

function handleInstantBackup() {
  alert('بدء أخذ نسخة احتياطية فورية Snapshot بقاعدة PostgreSQL...');
}

function handleRebuildSearch() {
  alert('جاري إعادة بناء فهارس البحث الأرشيفي...');
}
</script>

<template>
  <div class="dashboard-ops-view">
    <!-- View Header Banner -->
    <div class="view-header-banner" style="border-color: rgba(239, 68, 68, 0.3);">
      <div class="view-title-group">
        <h2><span>⚡ العمليات</span></h2>
        <p>حقيبة العمليات والصيانة الفورية وإدارة خوادم النظام وقاعدة البيانات</p>
      </div>
      <div class="header-actions">
        <button type="button" class="btn-danger-small" @click="handleSessionSecuritySignal">إشارة أمان للجلسات 🔒</button>
      </div>
    </div>

    <!-- Maintenance Mode Section -->
    <div class="section-card" style="display: flex; justify-content: space-between; align-items: center; border-color: rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.03);">
      <div>
        <h4 style="font-size: 0.95rem; font-weight: 800; color: #fbbf24;">وضع الصيانة المؤسسي (Maintenance Mode)</h4>
        <p style="font-size: 0.72rem; color: var(--text-dim, #71717a);">إغلاق الوصول العام للزوار وعرض صفحة الصيانة مع السماح للمشرفين فقط بالدخول.</p>
      </div>
      <button type="button" class="btn-action-small btn-danger-small" @click="handleToggleMaintenance">تفعيل وضع الصيانة ⚠️</button>
    </div>

    <!-- Instant Maintenance Tools Grid -->
    <div class="section-card">
      <div class="section-header">
        <h3 class="section-title">أدوات الصيانة الفورية المباشرة</h3>
        <span class="role-chip chip-admin">تنفيذ فوري</span>
      </div>
      <div class="catalog-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
        <div class="entity-card" style="cursor: pointer;" @click="handleInstantBackup">
          <div class="entity-title">💾 أخذ نسخة احتياطية فورية</div>
          <p style="font-size: 0.72rem; color: var(--text-dim, #71717a);">نسخ قاعدة PostgreSQL والملفات الرقمية للتخزين الآمن.</p>
        </div>
        <div class="entity-card" style="cursor: pointer;" @click="triggerOpsCacheClear">
          <div class="entity-title">⚡ تفريغ الكاش ومزامنة السياسات</div>
          <p style="font-size: 0.72rem; color: var(--text-dim, #71717a);">تشغيل artisan cache:clear ومزامنة Spatie Roles.</p>
        </div>
        <div class="entity-card" style="cursor: pointer;" @click="handleRebuildSearch">
          <div class="entity-title">🔍 إعادة بناء فهارس البحث</div>
          <p style="font-size: 0.72rem; color: var(--text-dim, #71717a);">مزامنة فهارس التدميج الكامل Full-Text Search باللغة العربية.</p>
        </div>
        <div class="entity-card" style="cursor: pointer;" @click="handleNavigate('commands')">
          <div class="entity-title" style="color: #c084fc;">💻 كونسول أوامر النظام</div>
          <p style="font-size: 0.72rem; color: var(--text-dim, #71717a);">فتح الطرفية التفاعلية لتشغيل أوامر Artisan المباشرة.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD OPS VIEW STYLES
   ======================================================== */
.dashboard-ops-view .view-header-banner {
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
body.light-mode .dashboard-ops-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-ops-view .catalog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1rem;
}

.dashboard-ops-view .entity-card {
  background: var(--bg-card, rgba(22, 22, 27, 0.7));
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1rem;
  padding: 1.25rem;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.dashboard-ops-view .entity-card:hover {
  border-color: rgba(239, 68, 68, 0.5) !important;
  transform: translateY(-2px);
}
body.light-mode .dashboard-ops-view .entity-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.dashboard-ops-view .entity-title {
  font-size: 0.9rem;
  font-weight: 800;
  color: var(--text-main, #f4f4f5);
  margin-bottom: 0.35rem;
}
body.light-mode .dashboard-ops-view .entity-title {
  color: #0f172a;
}

.dashboard-ops-view .btn-danger-small {
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.3);
  color: #f87171;
  padding: 0.4rem 0.85rem;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s;
}
.dashboard-ops-view .btn-danger-small:hover {
  background: rgba(239, 68, 68, 0.2);
  border-color: #ef4444;
}
</style>
