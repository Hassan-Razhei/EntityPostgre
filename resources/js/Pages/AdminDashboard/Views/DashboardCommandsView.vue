<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const cmdInputValue = ref('');
const isExecuting = ref(false);

const presetCommands = [
  {
    title: '🗄️ مزامنة التخزين الرقمي',
    chip: 'storage',
    chipClass: 'chip-admin',
    command: 'storage:sync',
    description: 'فحص مجلدات التخزين وربط الملفات المرفوعة وتحديث البيانات الوصفية للمصنفات.',
  },
  {
    title: '📜 مزامنة صفحات المخطوطات',
    chip: 'manuscripts',
    chipClass: 'chip-editor',
    command: 'manuscript:sync',
    description: 'استخراج ومعالجة صفحات المخطوطات تلقائياً من مستندات docx ومطابقتها.',
  },
  {
    title: '📑 استيراد بيانات المخطوطات',
    chip: 'legacy-data',
    chipClass: 'chip-editor',
    command: 'manuscriptsData:sync',
    description: 'استيراد وتحديث بيانات المخطوطات التاريخية من ملفات CSV/Excel إلى المخطط الجديد.',
  },
  {
    title: '🎙️ استيراد التفريغات النصية',
    chip: 'media',
    chipClass: 'chip-user',
    command: 'media:import-transcripts',
    description: 'معالجة واستيراد نصوص docx وتحويلها لقطع زمنية مرتبطة بالصوتيات والمرئيات.',
  },
  {
    title: '🌱 بذر البيانات الواقعية',
    chip: 'database',
    chipClass: 'chip-super',
    command: 'project:seed-realistic',
    description: 'تغذية قاعدة البيانات ببيانات عربية متكاملة لجميع الكيانات لأغراض التطوير.',
  },
  {
    title: '🔗 إعادة توليد المعرفات النصية',
    chip: 'slugs',
    chipClass: 'chip-admin',
    command: 'content:regenerate-slugs',
    description: 'إعادة توليد وتحديث الروابط اللطيفة (Slugs) لكافة العقد والمصنفات في PostgreSQL.',
  },
  {
    title: '🏗️ تحليل معمارية النظام',
    chip: 'architecture',
    chipClass: 'chip-super',
    command: 'analyze:architecture',
    description: 'تحليل معماري شامل واكتشاف التكرار البرمجي وإحصائيات ملفات ودوال النظام.',
  },
];

async function runCmd() {
  const input = document.getElementById('cmdInput');
  const output = document.getElementById('terminalOutput');
  const cmd = (input ? input.value : cmdInputValue.value).trim();
  if (!cmd) return;

  if (output) {
    const userLine = document.createElement('div');
    userLine.style.color = '#fff';
    userLine.style.fontWeight = 'bold';
    userLine.textContent = '$ ' + cmd;
    output.appendChild(userLine);

    const statusLine = document.createElement('div');
    statusLine.style.color = '#fbbf24';
    statusLine.style.fontSize = '0.75rem';
    statusLine.textContent = '⏳ جاري تنفيذ الأمر عبر خادم التطبيق...';
    output.appendChild(statusLine);
    output.scrollTop = output.scrollHeight;

    if (input) input.value = '';
    cmdInputValue.value = '';
    isExecuting.value = true;

    try {
      const response = await axios.post('/api/system/run-command', { command: cmd });
      statusLine.remove();
      const resLine = document.createElement('pre');
      resLine.style.color = '#38bdf8';
      resLine.style.fontFamily = 'monospace';
      resLine.style.whiteSpace = 'pre-wrap';
      resLine.style.margin = '4px 0 10px';
      resLine.textContent = response.data?.output || 'Command executed successfully: [OK]';
      output.appendChild(resLine);
    } catch (err) {
      statusLine.remove();
      const errLine = document.createElement('div');
      errLine.style.color = '#f87171';
      errLine.style.fontWeight = 'bold';
      errLine.style.margin = '4px 0 10px';
      errLine.textContent = '❌ ' + (err.response?.data?.message || err.message || 'خطأ أثناء تنفيذ الأمر');
      output.appendChild(errLine);
    } finally {
      isExecuting.value = false;
      output.scrollTop = output.scrollHeight;
    }
  }
}

async function runPresetCmd(cmd) {
  const input = document.getElementById('cmdInput');
  if (input) {
    input.value = cmd;
  }
  cmdInputValue.value = cmd;
  await runCmd();
}

onMounted(() => {
  if (typeof window !== 'undefined') {
    window.runCmd = runCmd;
    window.runPresetCmd = runPresetCmd;
  }
});

onUnmounted(() => {
  if (typeof window !== 'undefined') {
    if (window.runCmd === runCmd) delete window.runCmd;
    if (window.runPresetCmd === runPresetCmd) delete window.runPresetCmd;
  }
});

defineExpose({
  runCmd,
  runPresetCmd,
});
</script>

<template>
  <div class="dashboard-commands-view">
    <!-- View Header Banner -->
    <div class="view-header-banner" style="border-color: rgba(99, 102, 241, 0.3);">
      <div class="view-title-group">
        <h2><span>💻 الأوامر</span></h2>
        <p>موجه أوامر النظام وتشغيل أوامر Artisan ومهام الصيانة المباشرة</p>
      </div>
      <div class="header-actions">
        <a href="/system/commands" class="btn-indigo-small" style="text-decoration: none;">لوحة الأوامر الكاملة 🖥️</a>
      </div>
    </div>

    <!-- Custom Console Commands Grid -->
    <div class="section-card" style="margin-bottom: 1.25rem;">
      <div class="section-header" style="margin-bottom: 0.85rem;">
        <h3 class="section-title">⚡ أوامر المنظومة المخصصة (Console Commands)</h3>
        <span class="role-chip chip-super">7 أوامر سيادية مخصصة</span>
      </div>
      <p style="font-size: 0.75rem; color: var(--text-dim, #71717a); margin-bottom: 1rem;">
        أوامر Artisan مخصصة في <code>app/Console/Commands</code> لإدارة الأصول والمخطوطات ومزامنة التخزين وبذر البيانات وتحليل المعمارية. اضغط على أي أمر لتشغيله ومتابعة مخرجاته فورياً:
      </p>

      <div class="catalog-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 0.75rem;">
        <div
          v-for="cmd in presetCommands"
          :key="cmd.command"
          class="entity-card"
          style="cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(99, 102, 241, 0.25);"
          @click="runPresetCmd(cmd.command)"
        >
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
              <span style="font-weight: 800; font-size: 0.85rem; color: var(--text-main, #f4f4f5);">{{ cmd.title }}</span>
              <span :class="['role-chip', cmd.chipClass]" style="font-size: 0.65rem;">{{ cmd.chip }}</span>
            </div>
            <code style="font-size: 0.72rem; color: #818cf8; display: block; margin-bottom: 0.35rem;">{{ cmd.command }}</code>
            <p style="font-size: 0.72rem; color: var(--text-dim, #71717a); line-height: 1.4;">{{ cmd.description }}</p>
          </div>
          <div style="margin-top: 0.75rem; text-align: left;">
            <button
              type="button"
              class="btn-primary-small"
              style="font-size: 0.7rem; padding: 0.25rem 0.65rem;"
              @click.stop="runPresetCmd(cmd.command)"
            >
              تشغيل ⚡
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Terminal Screen Output -->
    <div
      id="terminalOutput"
      style="background: #000; border-radius: 12px; padding: 1.25rem; font-family: monospace; font-size: 0.82rem; color: #34d399; height: 320px; overflow-y: auto;"
    >
      <div>[System Core] Authenticated as Super Admin.</div>
      <div>[System Core] Session secure via TLS • Database: PostgreSQL 16 Connected.</div>
      <div style="color: #a1a1aa;">Ready for commands (e.g. 'cache:clear', 'backup:run', 'queue:work', 'migrate:status')...</div>
    </div>

    <!-- Command Input Strip -->
    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
      <input
        type="text"
        id="cmdInput"
        class="form-input"
        style="flex: 1; background: #121215; border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08)); color: #fff; padding: 0.75rem 1rem; border-radius: 10px; font-family: monospace; font-size: 0.8rem;"
        placeholder="اكتب الأمر هنا (مثال: php artisan cache:clear)"
        v-model="cmdInputValue"
        @keydown.enter="runCmd"
      >
      <button
        type="button"
        class="btn-primary-small"
        :disabled="isExecuting"
        @click="runCmd"
      >
        {{ isExecuting ? 'جارِ التنفيذ...' : 'تنفيذ الأمر ⚡' }}
      </button>
    </div>
  </div>
</template>

<style>
/* ========================================================
   DASHBOARD COMMANDS VIEW STYLES
   ======================================================== */
.dashboard-commands-view .view-header-banner {
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
body.light-mode .dashboard-commands-view .view-header-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle, rgba(0, 0, 0, 0.08));
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}

.dashboard-commands-view .catalog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 0.75rem;
}

.dashboard-commands-view .entity-card {
  background: var(--bg-card, rgba(22, 22, 27, 0.7));
  border: 1px solid var(--border-subtle, rgba(255, 255, 255, 0.08));
  border-radius: 1rem;
  padding: 1rem;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.dashboard-commands-view .entity-card:hover {
  border-color: rgba(99, 102, 241, 0.5) !important;
  transform: translateY(-2px);
}
body.light-mode .dashboard-commands-view .entity-card {
  background: #ffffff;
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.dashboard-commands-view .btn-indigo-small {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.45rem 0.9rem;
  border-radius: 8px;
  background: var(--indigo, #6366f1);
  color: #ffffff;
  font-size: 0.78rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s;
}
.dashboard-commands-view .btn-indigo-small:hover {
  background: #4f46e5;
  transform: translateY(-1px);
}
</style>
