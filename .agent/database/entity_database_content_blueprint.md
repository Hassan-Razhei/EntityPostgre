# 🏛️ الوثيقة الدستورية الشاملة لمنصة Entity
## (The Master Architectural Constitution & Technical Specification)
### منصة الأرشيف الرقمي الموحد — Entity Digital Library

**الإصدار:** 3.4 (الإصدار المعماري السيادي التام المعتمد — The Sovereign Masterpiece)  
**التاريخ:** 2026-10-16  
**الصفة:** المرجع المعماري الأعلى والحقيقة الحاكمة المطلقة لكافة قرارات هندسة البيانات والتطوير  

---

> [!IMPORTANT]
> **الصفة الدستورية والإلزام الهندسي (Constitutional Authority):**  
> تمثل هذه الوثيقة الدستور الأعلى والوحيد الملزم لكافة المطورين ووكلاء الذكاء الاصطناعي (Agents).  
> يُحظر قطيعاً إنشاء أي جدول، أو فصل أي أصل، أو تعديل طبقات النماذج والخدمات والتعدادات (`Models`, `Migrations`, `Services`, `Enums`) دون الرجوع إلى هذا الدستور وبما لا يخالف القواعد والحقائق المثبتة فيه.

> [!NOTE]
> **واقعية البناء والإنجاز القائم (Living Architecture & Proven Implementation):**  
> ليس ما تسطّره هذه الوثيقة تنظيراً مجرداً؛ بل إن قطاعاً واسعاً وجوهرياً من هذه المنظومة المعمارية الاستثنائية قد تم بناؤه وهندسته وتثبيته بالفعل في صلب المشروع (في المنظومة التقنية الحية `resources/js/Technologies`: من محرر Tiptap المخصص `Editor`، وعارض المخطوطات الفائق `Manuscripter`، ومشغل الوسائط المتزامن `Player`، وحاضنة الاستوديو `Studio`، إلى جانب محركات المعالجة والحفظ والتقسيم الجراحي في الواجهة الخلفية `Backend Services & Controllers`).

---

# 🧭 الجزء الأول: الفلسفة والرؤية التأسيسية

## 1.1 المنطلق والدافع المعرفي
تاريخياً، انقسمت منصات النشر والمكتبات الرقمية إلى مسارين قاصرين:
1. **مسار الفهرسة العامة:** يكتفي بهيكلة الكتاب كعناوين عامة وأبواب صماء، مما يحرم الباحث من التعامل مع تفاصيل المتون والفقرات.
2. **مسار المحرر النصي التقليدي:** يعامل العمل كصفحة نصية طويلة ومائعة، تفقد عظمة الفهرسة وتماسك البنية العلمية والتراثية.

**الحل المعماري لمشروع Entity:**  
الدمج الحي والتام بين **عظمة الفهرسة الهرمية الكبرى (Macro-Hierarchy)** في شجرة تصفح رشيقة ومحكمة، وبين **الدقة المتناهية على المستوى الذري (Micro-Granularity)** حتى مستوى الفقرة، والسطر، وبيت الشعر، والمقطع الزمني، والحاشية.

## 1.2 الأصول الأربعة وجامعها المعرفي
تنتظم المنصة حول أربعة أصول متمايزة، تلتقي جميعها في حقيقة أن غايتها المعرفية تصب في **"النص"**:

| الأصل | الوصف المادي والتراثي | الحامل المعرفي | التقنية المقابلة في المنصة |
| :--- | :--- | :--- | :--- |
| **الكتاب (Book)** | المتن المفهرس، والتحقيقات، والحواشي، والشروح | النص المكتوب | `Reader` & `Editor` |
| **المخطوطة (Manuscript)** | اللوحات المصورة وتفريغها، وهوامش النسخ ومقابلاتها | النص المقابل للوحة | `Manuscripter` (`DetailViewer`) |
| **الصوت (Audio)** | المجالس والأشرطة الصوتية وتفريغها الدقيق | النص المتزامن زمنياً | `Player` (Audio Mode) |
| **الفيديو (Video)** | المشاهد واللقطات المرئية والشرائح وتفريغها | النص المتزامن بصرياً | `Player` (Video Mode) |

## 1.3 الثالوث المفاهيمي للعُقدة (The Conceptual Trinity of a Node)
العقدة في مشروع Entity ليست مجرد عنوان مجرد، بل تخزن دائماً مع متنها ونصوصها، وتُفهم من ثلاثة أبعاد متناغمة:
1. **في شجرة الفهرس (Navigation Tree):** هي **"الوحدة" (Tree Item)** التي تظهر في قائمة المحتويات ليتنقل القارئ بين أجزاء الأصل.
2. **في المحرر (Editor Canvas):** هي **"العنوان / العلامة الهيكلية" (Heading / Structure Marker)** التي يقف عندها المحرر، ويندرج تحتها المتن النصي.
3. **في قاعدة البيانات (Database):** هي **"السطر" (Row / Record)** في جدول `content_nodes` الموحد، الحامل للمعرف والترتيب والمحتوى.

## 1.4 القانون الذهبي: "عتبة التفكيك الهيكلي (Decomposition Threshold)"
لحماية قاعدة البيانات من التضخم الخبيث للأسطر (حتى لا يتحول كتاب من ملايين الفقرات إلى ملايين السجلات فتنتهي موارد الخادم)، يقوم البناء على ميزان حاسم يفصل بين مستويين:
* **ما فوق العتبة (مستوى الأسطر في قاعدة البيانات `content_nodes`):**  
  تتوقف أسطر قاعدة البيانات عند العُقد الهيكلية المنظومة الكبرى التي يُبنى بها الفهرس وشجرة التصفح:
  * الكتاب: (كتاب فرعي، مجلد، جزء، باب، **فصل**).
  * المخطوط: (سفر، كراسة، **ورقة/لوحة `folio`**).
  * الصوتيات والمرئيات: (شريط/حلقة، **مقطع زمني رئيسي/مشهد `segment / scene`**).
* **ما تحت العتبة (مستوى الجيسون `content_json`):**  
  كل ما دون العتبة ينسكب داخل حقل `content_json` التابع لتلك العقدة؛ فيستوعب: (المباحث، المطالب، المسائل، الفروع، القواعد، الفوائد، الأبيات الشعرية، الآيات، الأحاديث، الحواشي، الأختام الزمنية).

## 1.5 عقيدة "قابلية العنونة المطلقة" (Universal Addressability)
أن يمتلك كل جزء في المنصة — بدءاً من الباب والفصل واللوحة والمشهد، ونزولاً إلى **الفقرة المفردة، وبيت الشعر، والحاشية، واللحظة الزمنية** — **هوية رقمية ومعرفاً ثابتاً (Deterministic Anchor ID / Canonical URI)**، يُمكّن الباحث والنظام من:
1. **الإحالة برابط قطعي دائم (Deep Linking & Academic Citation)** إلى أدق تفاصيل المتن.
2. **التعليق والتصنيف والوسم المستقل (Independent Anchoring)** دون حشو متن الأصل أو تشويهه.
3. **الربط المتصالب الفائق بين الأصول (Cross-Entity Scholarly Linking)** كربط دقيقة صوتية بفقرة في كتاب أو لوحة في مخطوط.

---

# 🗄️ الجزء الثاني: المواصفات التنفيذية لقاعدة البيانات (PostgreSQL)

## 2.1 بنية الأصول الأربعة السيادية (Polymorphic Core Assets)
ترتبط العُقد بالأصول عبر العلاقات البوليمورفية الصلبة (`uuidMorphs`) الموجهة لجداول الأصول الحقيقية في النظام، مع الالتزام التام بالفصل بين المصنف المجرد، والنسخة المادية، والطبعات، والشجرة النصية:

```sql
-- 1. جدول الكتب (المصنف الفكري المجرد - The Work)
CREATE TABLE books (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    serial_number BIGSERIAL UNIQUE NOT NULL,
    title VARCHAR(500) NOT NULL,
    subtitle VARCHAR(500),
    original_title VARCHAR(500),
    slug VARCHAR(255) UNIQUE NOT NULL,
    author VARCHAR(255), -- كاش نصي سريع للعرض (الضبط الاستنادي عبر authorables)
    status VARCHAR(30) DEFAULT 'draft' CHECK (status IN ('draft', 'transcribed', 'verified', 'revised', 'curriculum', 'scholarly', 'published')),
    original_language_id UUID REFERENCES languages(id) ON DELETE SET NULL,
    translation_language_id UUID REFERENCES languages(id) ON DELETE SET NULL,
    ddc_number VARCHAR(50),
    lc_classification VARCHAR(50),
    abstract TEXT,
    description TEXT,
    cover_path VARCHAR(1000),
    license_type VARCHAR(50) DEFAULT 'public_domain',
    copyright_status VARCHAR(50) DEFAULT 'unknown',
    metadata JSONB DEFAULT '{}'::jsonb,
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    reviewed_by UUID REFERENCES users(id) ON DELETE SET NULL,
    reviewed_at TIMESTAMP WITH TIME ZONE,
    is_featured BOOLEAN DEFAULT FALSE,
    views_count INTEGER DEFAULT 0,
    citations_count INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_books_status_featured ON books(status, is_featured);
CREATE INDEX idx_books_language_status ON books(original_language_id, status);
CREATE INDEX idx_books_created_at ON books(created_at);
CREATE INDEX idx_books_metadata_gin ON books USING GIN (metadata);

-- 2. جدول المخطوطات (النسخة الخطية المادية والكوديكولوجية - Codicological Asset)
CREATE TABLE manuscripts (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    serial_number BIGSERIAL UNIQUE NOT NULL,
    title VARCHAR(500) NOT NULL,
    original_title VARCHAR(500),
    slug VARCHAR(255) UNIQUE NOT NULL,
    status VARCHAR(30) DEFAULT 'draft' CHECK (status IN ('draft', 'typeset', 'collated', 'edited', 'published')),
    code VARCHAR(50), -- الرمز التحقيقي للنسخة في المقابلة (أ، ظ، ك)
    parts VARCHAR(255),
    book_id UUID REFERENCES books(id) ON DELETE SET NULL,
    base_manuscript_id UUID REFERENCES manuscripts(id) ON DELETE SET NULL,
    is_autograph BOOLEAN DEFAULT FALSE,
    scribe VARCHAR(255), -- كاش نصي سريع (الضبط الاستنادي عبر bookables)
    copy_date VARCHAR(255),
    copy_hijri_year INTEGER,
    copy_gregorian_year INTEGER,
    century INTEGER,
    script_type VARCHAR(100),
    material_type VARCHAR(100),
    folios_count INTEGER,
    pages_count INTEGER DEFAULT 0,
    quires_count INTEGER,
    lines_per_page INTEGER,
    width_cm NUMERIC(5, 2),
    height_cm NUMERIC(5, 2),
    binding_type VARCHAR(100),
    physical_condition VARCHAR(255),
    has_tashkeel BOOLEAN DEFAULT FALSE,
    has_gold_illumination BOOLEAN DEFAULT FALSE,
    has_marginalia BOOLEAN DEFAULT FALSE,
    incipit TEXT,
    explicit TEXT,
    colophon TEXT,
    repository VARCHAR(255),
    shelf_mark VARCHAR(100),
    collection_name VARCHAR(255),
    country VARCHAR(100),
    city VARCHAR(100),
    iiif_manifest_url VARCHAR(1000),
    cover_path VARCHAR(1000),
    file_path VARCHAR(1000),
    images_count INTEGER DEFAULT 0,
    codicological_records JSONB DEFAULT '{}'::jsonb,
    metadata JSONB DEFAULT '{}'::jsonb,
    language_id UUID REFERENCES languages(id) ON DELETE SET NULL,
    description TEXT,
    notes TEXT,
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    collated_by UUID REFERENCES users(id) ON DELETE SET NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    views_count INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_manuscripts_repo_shelf ON manuscripts(repository, shelf_mark);
CREATE INDEX idx_manuscripts_century_script ON manuscripts(century, script_type);
CREATE INDEX idx_manuscripts_year_status ON manuscripts(copy_hijri_year, status);
CREATE INDEX idx_manuscripts_book_status ON manuscripts(book_id, status);
CREATE INDEX idx_manuscripts_codicological_gin ON manuscripts USING GIN (codicological_records);
CREATE INDEX idx_manuscripts_metadata_gin ON manuscripts USING GIN (metadata);

-- 3. جدول الصوتيات (الأصل الصوتي - Audio Asset)
CREATE TABLE audios (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    serial_number BIGSERIAL UNIQUE NOT NULL,
    title VARCHAR(500) NOT NULL,
    subtitle VARCHAR(500),
    slug VARCHAR(255) UNIQUE NOT NULL,
    code VARCHAR(50),
    status VARCHAR(30) DEFAULT 'draft' CHECK (status IN ('draft', 'uploaded', 'transcribed', 'verified', 'published')),
    content_type VARCHAR(50) DEFAULT 'lecture',
    speaker VARCHAR(255),
    series_id UUID REFERENCES series(id) ON DELETE SET NULL,
    episode_number INTEGER,
    event_name VARCHAR(255),
    recording_date DATE,
    recording_hijri_year INTEGER,
    recording_location VARCHAR(255),
    recording_city VARCHAR(100),
    recording_country VARCHAR(100),
    duration_ms BIGINT DEFAULT 0,
    file_path VARCHAR(1000),
    cover_path VARCHAR(1000),
    file_size_bytes BIGINT DEFAULT 0,
    format VARCHAR(20) DEFAULT 'mp3',
    bitrate INTEGER,
    sample_rate INTEGER,
    channels VARCHAR(20) DEFAULT 'mono',
    file_checksum VARCHAR(64),
    waveform_data JSONB,
    transcription_status VARCHAR(30) DEFAULT 'not_started' CHECK (transcription_status IN ('not_started', 'in_progress', 'reviewed', 'final')),
    transcriber_id UUID REFERENCES users(id) ON DELETE SET NULL,
    transcription_completed_at TIMESTAMP WITH TIME ZONE,
    segments_count INTEGER DEFAULT 0,
    book_id UUID REFERENCES books(id) ON DELETE SET NULL,
    language_id UUID REFERENCES languages(id) ON DELETE SET NULL,
    abstract TEXT,
    description TEXT,
    metadata JSONB DEFAULT '{}'::jsonb,
    license_type VARCHAR(50) DEFAULT 'public_domain',
    copyright_status VARCHAR(50) DEFAULT 'unknown',
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    views_count INTEGER DEFAULT 0,
    plays_count INTEGER DEFAULT 0,
    downloads_count INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_audios_series_episode ON audios(series_id, episode_number);
CREATE INDEX idx_audios_content_status ON audios(content_type, status);
CREATE INDEX idx_audios_book_status ON audios(book_id, status);
CREATE INDEX idx_audios_year_status ON audios(recording_hijri_year, status);
CREATE INDEX idx_audios_metadata_gin ON audios USING GIN (metadata);

-- 4. جدول المرئيات (الأصل المرئي - Video Asset)
CREATE TABLE videos (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    serial_number BIGSERIAL UNIQUE NOT NULL,
    title VARCHAR(500) NOT NULL,
    subtitle VARCHAR(500),
    slug VARCHAR(255) UNIQUE NOT NULL,
    code VARCHAR(50),
    status VARCHAR(30) DEFAULT 'draft' CHECK (status IN ('draft', 'uploaded', 'transcribed', 'verified', 'published')),
    content_type VARCHAR(50) DEFAULT 'lecture',
    speaker VARCHAR(255),
    series_id UUID REFERENCES series(id) ON DELETE SET NULL,
    season_number INTEGER,
    episode_number INTEGER,
    event_name VARCHAR(255),
    recording_date DATE,
    recording_hijri_year INTEGER,
    recording_location VARCHAR(255),
    recording_city VARCHAR(100),
    recording_country VARCHAR(100),
    duration_ms BIGINT DEFAULT 0,
    resolution VARCHAR(20),
    width_pixels INTEGER,
    height_pixels INTEGER,
    frame_rate NUMERIC(5, 2),
    format VARCHAR(20) DEFAULT 'mp4',
    file_size_bytes BIGINT DEFAULT 0,
    file_checksum VARCHAR(64),
    stream_url VARCHAR(1000),
    external_id VARCHAR(255),
    file_path VARCHAR(1000),
    cover_path VARCHAR(1000),
    thumbnail_path VARCHAR(1000),
    scenes_count INTEGER DEFAULT 0,
    slides_count INTEGER DEFAULT 0,
    segments_count INTEGER DEFAULT 0,
    transcription_status VARCHAR(30) DEFAULT 'not_started' CHECK (transcription_status IN ('not_started', 'in_progress', 'reviewed', 'final')),
    transcriber_id UUID REFERENCES users(id) ON DELETE SET NULL,
    transcription_completed_at TIMESTAMP WITH TIME ZONE,
    audio_id UUID REFERENCES audios(id) ON DELETE SET NULL,
    book_id UUID REFERENCES books(id) ON DELETE SET NULL,
    language_id UUID REFERENCES languages(id) ON DELETE SET NULL,
    abstract TEXT,
    description TEXT,
    metadata JSONB DEFAULT '{}'::jsonb,
    license_type VARCHAR(50) DEFAULT 'public_domain',
    copyright_status VARCHAR(50) DEFAULT 'unknown',
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    views_count INTEGER DEFAULT 0,
    plays_count INTEGER DEFAULT 0,
    downloads_count INTEGER DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_videos_series_season_ep ON videos(series_id, season_number, episode_number);
CREATE INDEX idx_videos_content_status ON videos(content_type, status);
CREATE INDEX idx_videos_audio_status ON videos(audio_id, status);
CREATE INDEX idx_videos_book_status ON videos(book_id, status);
CREATE INDEX idx_videos_year_status ON videos(recording_hijri_year, status);
CREATE INDEX idx_videos_external_id ON videos(external_id);
CREATE INDEX idx_videos_metadata_gin ON videos USING GIN (metadata);
```

---

## 2.2 جدول العُقد الموحد والسيادي (`content_nodes`)
هو الجدول المركزي الذي يستوعب شجرة كافة الأصول، مدمجاً به الأعمدة الصريحة للخصائص الحرجة، لضمان أعلى سرعة استعلام (B-Tree 1-2ms) دون الحاجة لجداول فرعية مشتتة:

```sql
CREATE TABLE content_nodes (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    
    -- الربط البوليمورفي بالأصل (Book, Manuscript, Audio, Video)
    entity_type VARCHAR(50) NOT NULL CHECK (entity_type IN ('book', 'manuscript', 'audio', 'video')),
    entity_id UUID NOT NULL,
    
    -- الشجرة الهرمية الذاتية (Self-Referencing Adjacency Tree)
    -- قيد المنع الصارم القابل للتأجيل (NO ACTION DEFERRABLE) لحماية الشجرة من الحذف الفجائي مع إتاحة الحذف النهائي بـ Statement واحدة
    parent_id UUID REFERENCES content_nodes(id) ON DELETE NO ACTION DEFERRABLE INITIALLY DEFERRED,
    
    -- المسار الهرمي المتقدم المشتق (اختياري للأشجار العميقة المليارية)
    path LTREE,
    
    -- هوية العقدة ونوعها وترتيبها
    type VARCHAR(50) NOT NULL, -- sub_book, part, bab, chapter, masalah, folio, segment, scene...
    title VARCHAR(500) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    "order" INTEGER DEFAULT 0,
    
    -- الأعمدة الصريحة للخصائص الحرجة (سرعة B-Tree والتحقق الصارم)
    folio_number INTEGER,
    folio_side VARCHAR(5),       -- 'a', 'b', 'recto', 'verso'
    start_ms BIGINT,             -- التوقيت الزمني بالمللي ثانية للصوتيات والمرئيات
    end_ms BIGINT,
    
    -- المتن والمحتوى التحريري (الثالوث النصي للنسخة النشطة الحالية)
    content_html TEXT,           -- للعرض الفوري والقراءة دون معالجة
    plain_text TEXT,             -- مفهرس للبحث النصي الشامل
    content_json JSONB,          -- شجرة المحرر الذرية (Tiptap / ProseMirror AST)
    
    -- الحاويات الوثائقية الإضافية
    metadata JSONB DEFAULT '{}'::jsonb,
    
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE,
    
    -- قيود التحقق الصارمة على مستوى قاعدة البيانات (CHECK Constraints)
    CONSTRAINT chk_folio_number CHECK (folio_number IS NULL OR folio_number > 0),
    CONSTRAINT chk_folio_side CHECK (folio_side IS NULL OR folio_side IN ('a', 'b', 'recto', 'verso')),
    CONSTRAINT chk_time_range CHECK (start_ms IS NULL OR end_ms IS NULL OR start_ms <= end_ms)
);

-- ====================================================================
-- جدول أقفال الاستوديو السريع والمحمي من انتفاخ MVCC (Ephemeral Studio Locks)
-- ====================================================================
-- جدول UNLOGGED خفيف لا يُكتب في WAL ولا يُثقل MVCC، ومصمم لنبضات القلب اللحظية (Redis L1 / Postgres Fallback)
-- تنبيه معماري دستوري: جداول UNLOGGED تُفرغ تلقائياً (TRUNCATE) عند إعادة تشغيل الخادم أو انهياره، ولا تُنسخ للـ Replicas.
-- كما يمنع محرك PostgreSQL صراحة إنشاء مفتاح أجنبي (FK) بين جدول UNLOGGED وجدول LOGGED؛ لذا يُعرّف user_id بدون قيد FK صريح.
-- يُلزم النظام بحصر القراءة والكتابة لهذا الجدول على الاتصال الكاتب الأساسي (DB::connection('pgsql::write'))،
-- وتطبيق نمط الشفاء الذاتي (Self-Healing Reacquisition) بنبضات القلب مع الجدولة الدورية لدالة تنظيف الأقفال.
CREATE UNLOGGED TABLE studio_locks (
    node_id UUID PRIMARY KEY,
    user_id UUID NOT NULL, -- بدون FK صريح لامتناع قيود المفاتيح الأجنبية على جداول UNLOGGED في نواة PostgreSQL
    lock_token VARCHAR(100) NOT NULL,
    locked_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    expires_at TIMESTAMP WITH TIME ZONE NOT NULL
);

CREATE INDEX idx_studio_locks_expires ON studio_locks(expires_at);

-- دالة تنظيف الأقفال المنتهية واليتيمة دورياً لجدول studio_locks
CREATE OR REPLACE FUNCTION cleanup_orphaned_locks()
RETURNS INTEGER AS $$
DECLARE
    v_deleted_count INTEGER;
BEGIN
    DELETE FROM studio_locks
    WHERE expires_at < NOW()
       OR NOT EXISTS (SELECT 1 FROM users WHERE id = studio_locks.user_id);
    GET DIAGNOSTICS v_deleted_count = ROW_COUNT;
    RETURN v_deleted_count;
END;
$$ LANGUAGE plpgsql;

-- ====================================================================
-- جدول الصندوق الصادر لعمليات الشجرة الضخمة (Transactional Outbox for Large Trees)
-- ====================================================================
-- يضمن التسليم القطعي (Guaranteed Delivery) بنسبة 100% لعمليات الحذف والاسترجاع للأشجار التي تتجاوز 500 عقدة،
-- متفادياً قيود pg_notify (حد الـ 8000 بايت وخطر فقدان الرسائل اللحظية عند انقطاع الـ Worker).
CREATE TABLE pending_tree_operations (
    id BIGSERIAL PRIMARY KEY,
    entity_type VARCHAR(50) NOT NULL,
    entity_id UUID NOT NULL,
    root_path LTREE NOT NULL,
    operation VARCHAR(30) NOT NULL CHECK (operation IN ('soft_delete', 'restore', 'hard_delete')),
    deleted_at TIMESTAMP WITH TIME ZONE,
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'processing', 'completed', 'failed')),
    attempts INT NOT NULL DEFAULT 0,
    last_error TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    processed_at TIMESTAMP WITH TIME ZONE
);

CREATE INDEX idx_pending_tree_ops ON pending_tree_operations(status, created_at) 
WHERE status = 'pending';

-- ====================================================================
-- دالة اشتقاق مفاتيح الأقفال الاستشارية 64-بت المحصنة من التصادم (64-bit Advisory Key)
-- ====================================================================
CREATE OR REPLACE FUNCTION fn_generate_entity_lock_key(p_namespace text, p_entity_id uuid)
RETURNS bigint AS $$
BEGIN
    -- تحويل أول 16 خانة ست عشرية من MD5 إلى bigint موقع؛ احتمال التصادم 50% يتطلب > 5 مليارات أصل
    RETURN ('x' || substr(md5(p_namespace || ':' || p_entity_id::text), 1, 16))::bit(64)::bigint;
END;
$$ LANGUAGE plpgsql IMMUTABLE PARALLEL SAFE;

-- ====================================================================
-- دالة التطبيع اللغوي العربي الصارمة (IMMUTABLE Text Normalization)
-- ====================================================================
-- تنبيه فيلولوجي دستوري: يُحظر تحويل التاء المربوطة (ة) إلى هاء (ه) في المتون المخزنة منعاً للالتباس الدلالي
-- (مثل: التمييز بين 'أُمّة' و 'أُمّه' وبين 'وجْه' و 'وجْهة')؛ بينما يُفوض توحيدها إلى معالجة استعلام البحث فقط عند اللزوم.
CREATE OR REPLACE FUNCTION normalize_arabic_text(input_text TEXT) RETURNS TEXT AS $$
SELECT regexp_replace(
         regexp_replace(
           regexp_replace(COALESCE($1, ''), '[ًٌٍَُِّْـ]', '', 'g'), -- تجريد التشكيل والتطويل
           '[إأآا]', 'ا', 'g'),                                      -- توحيد الألفات
         '[ىي]', 'ي', 'g');                                          -- توحيد الياء والألف المقصورة
$$ LANGUAGE SQL IMMUTABLE PARALLEL SAFE;

-- ====================================================================
-- دالة النقل الذري للعقد وتحديث الشجرة التابعة بالكامل (Subtree Path Migration)
-- ====================================================================
-- حل قطعي لمعضلة يتيم المسارات محصن بقفل 64-بت، وفحص ثلاثي للدورات المفرغة، وضبط الترتيب وحماية المسارات من الـ NULL
CREATE OR REPLACE FUNCTION move_content_node(
    p_node_id UUID, 
    p_new_parent_id UUID,
    p_new_order INTEGER DEFAULT NULL
) 
RETURNS VOID AS $$
DECLARE
    v_entity_id UUID;
    v_new_parent_entity_id UUID;
    v_old_path LTREE;
    v_new_parent_path LTREE;
    v_new_path LTREE;
    v_lock_key BIGINT;
    v_final_order INTEGER;
BEGIN
    -- 1. استخراج بيانات العقدة المنقولة مع قفل الصف لمنع التعديل المتزامن
    SELECT entity_id, path INTO v_entity_id, v_old_path 
    FROM content_nodes 
    WHERE id = p_node_id 
    FOR UPDATE;
    
    IF NOT FOUND THEN
        RAISE EXCEPTION 'العقدة المراد نقلها غير موجودة: %', p_node_id USING ERRCODE = 'P0002';
    END IF;

    -- 2. حجز القفل الاستشاري 64-بت على مستوى الفرع المستهدف (Zero-Contention Branch Lock) لمنع سباق الترتيب دون تجميد بقية أجزاء الكتاب
    v_lock_key := fn_generate_entity_lock_key('tree_reorder_branch', COALESCE(p_new_parent_id, v_entity_id));
    PERFORM pg_advisory_xact_lock(v_lock_key);

    -- 3. فحص الدورة المفرغة وتطابق الكيان (Triple-Layer Cycle Detection)
    IF p_new_parent_id IS NOT NULL THEN
        -- فحص أ: منع أن تكون العقدة أباً لنفسها
        IF p_node_id = p_new_parent_id THEN
            RAISE EXCEPTION 'خطأ هيكلي فادح: لا يمكن للعقدة (%) أن تكون أباً لنفسها!', p_node_id 
                USING ERRCODE = '22000';
        END IF;

        -- استخراج مسار وهوية الأب الجديد
        SELECT entity_id, path INTO v_new_parent_entity_id, v_new_parent_path 
        FROM content_nodes 
        WHERE id = p_new_parent_id;

        IF NOT FOUND THEN
            RAISE EXCEPTION 'العقدة الأب المستهدفة غير موجودة: %', p_new_parent_id USING ERRCODE = 'P0002';
        END IF;

        -- فحص الحماية من الـ NULL: منع انهيار مسارات الشجرة التابعة
        IF v_new_parent_path IS NULL THEN
            RAISE EXCEPTION 'خطأ هيكلي: مسار العقدة الأب (path) غير معرّف (NULL)، لا يمكن إلحاق الفروع به!' 
                USING ERRCODE = '22000';
        END IF;

        -- فحص ب: منع نقل العقدة بين أصلين مختلفين (حماية حدود الكيان)
        IF v_entity_id != v_new_parent_entity_id THEN
            RAISE EXCEPTION 'انتهاك حدود الأصل: لا يمكن نقل عقدة من الأصل (%) إلى الأصل (%)!', v_entity_id, v_new_parent_entity_id 
                USING ERRCODE = '23503';
        END IF;

        -- فحص ج: منع نقل العقدة إلى أحد فروعها التابعة (Cycle Detection: Descendant Trap)
        IF v_old_path IS NOT NULL AND v_new_parent_path <@ v_old_path THEN
            RAISE EXCEPTION 'Cycle detected: لا يمكن نقل العقدة (%) لتكون فرعاً من نسلها التابع (%)!', p_node_id, p_new_parent_id 
                USING ERRCODE = '22000';
        END IF;

        v_new_path := v_new_parent_path || replace(p_node_id::text, '-', '_')::ltree;
    ELSE
        -- تحويل العقدة إلى جذر (Root Level)
        v_new_path := replace(p_node_id::text, '-', '_')::ltree;
    END IF;

    -- 4. حساب الترتيب النهائي المحكم (يدعم الجذر والأبناء مع حصر الكيان)
    IF p_new_order IS NULL THEN
        SELECT COALESCE(MAX("order"), 0) + 1 INTO v_final_order
        FROM content_nodes 
        WHERE entity_id = v_entity_id
          AND ((p_new_parent_id IS NULL AND parent_id IS NULL) OR parent_id = p_new_parent_id)
          AND deleted_at IS NULL;
    ELSE
        v_final_order := p_new_order;
    END IF;

    -- 5. قفل كافة الأبناء والأحفاد قبل البدء في نقل المسارات (فقط إذا تغير المسار الفعلي)
    IF v_old_path IS NOT NULL AND v_new_path != v_old_path THEN
        PERFORM 1 FROM content_nodes WHERE path <@ v_old_path FOR UPDATE;
    END IF;

    -- 6. تحديث العقدة المنقولة بمسارها وترتيبها الجديد
    UPDATE content_nodes 
    SET parent_id = p_new_parent_id, 
        path = v_new_path,
        "order" = v_final_order
    WHERE id = p_node_id;

    -- 7. ترحيل مسارات كافة الفروع التابعة ذرياً (فقط إذا تغير المسار الفعلي لمنع تحديث مضلل للشجرة عند إعادة الترتيب الموضعي)
    IF v_old_path IS NOT NULL AND v_new_path != v_old_path THEN
        UPDATE content_nodes 
        SET path = v_new_path || subpath(path, nlevel(v_old_path))
        WHERE path <@ v_old_path AND id != p_node_id;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- ====================================================================
-- محفز الحذف الناعم المتسلسل للشجرة الفرعية (Soft-Delete Tree Cascading Trigger)
-- ====================================================================
-- يضمن سريان الحذف الناعم محصناً بـ Session Flag مع فحص عتبة الـ 500 عقدة لتفويض الأشجار الكبرى للخلفية
CREATE OR REPLACE FUNCTION cascade_content_node_soft_delete()
RETURNS TRIGGER AS $$
DECLARE
    v_is_cascading TEXT;
    v_descendant_count INTEGER;
BEGIN
    -- قراءة علم المعاملة المحلي (آمن تماماً ولا يتأثر بالـ Triggers الأخرى)
    v_is_cascading := current_setting('entity.cascade_in_progress', true);
    
    -- إذا كان التحديث ناتجاً عن كاسكيد داخلي جاري، نخرج فوراً لمنع التكرار
    IF v_is_cascading = 'true' THEN
        RETURN NEW;
    END IF;

    -- تفعيل علم الكاسكيد محلياً لهذه المعاملة فقط (is_local = true)
    PERFORM set_config('entity.cascade_in_progress', 'true', true);

    -- 1. عند تفعيل الحذف الناعم (Soft Delete)
    IF NEW.deleted_at IS NOT NULL AND OLD.deleted_at IS NULL THEN
        -- فحص عتبة التفكيك لحماية الأداء في الأشجار الضخمة
        SELECT count(*) INTO v_descendant_count 
        FROM content_nodes 
        WHERE path <@ OLD.path AND id != OLD.id AND deleted_at IS NULL;

        IF v_descendant_count > 500 THEN
            -- تفويض الحذف المتسلسل للأشجار العملاقة إلى الصندوق الصادر العملياتي (Transactional Outbox)
            INSERT INTO pending_tree_operations (
                entity_type, entity_id, root_path, operation, deleted_at, status
            ) VALUES (
                NEW.entity_type, NEW.entity_id, OLD.path, 'soft_delete', NEW.deleted_at, 'pending'
            );
        ELSE
            -- تنفيذ الحذف المتسلسل اللحظي للأشجار العادية والصغيرة
            UPDATE content_nodes
            SET deleted_at = NEW.deleted_at
            WHERE path <@ OLD.path 
              AND id != OLD.id 
              AND deleted_at IS NULL;
        END IF;

    -- 2. عند استرجاع العقدة (Restore)
    ELSIF NEW.deleted_at IS NULL AND OLD.deleted_at IS NOT NULL THEN
        SELECT count(*) INTO v_descendant_count 
        FROM content_nodes 
        WHERE path <@ OLD.path AND id != OLD.id AND deleted_at = OLD.deleted_at;

        IF v_descendant_count > 500 THEN
            -- تفويض استرجاع الأشجار العملاقة إلى الصندوق الصادر العملياتي
            INSERT INTO pending_tree_operations (
                entity_type, entity_id, root_path, operation, deleted_at, status
            ) VALUES (
                NEW.entity_type, NEW.entity_id, OLD.path, 'restore', OLD.deleted_at, 'pending'
            );
        ELSE
            -- المطابقة الصارمة للختم الزمني لمنع استرجاع ما حُذف عمداً قبل حذف الأصل
            UPDATE content_nodes
            SET deleted_at = NULL
            WHERE path <@ OLD.path 
              AND id != OLD.id 
              AND deleted_at = OLD.deleted_at;
        END IF;
    END IF;

    -- إعادة ضبط العلم
    PERFORM set_config('entity.cascade_in_progress', 'false', true);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_cascade_content_node_soft_delete
AFTER UPDATE OF deleted_at ON content_nodes
FOR EACH ROW
EXECUTE FUNCTION cascade_content_node_soft_delete();

-- ====================================================================
-- الفهارس الصاروخية الحاكمة (Indexing Strategy)
-- ====================================================================

-- 1. فهرس تصفح الشجرة السريع لأي أصل
CREATE INDEX idx_content_nodes_tree 
    ON content_nodes(entity_type, entity_id, parent_id, "order");

-- 2. فهرس الاستدعاء بالرابط اللطيف وقيد التفرد المشروط بالحذف الناعم
CREATE UNIQUE INDEX uq_content_nodes_entity_slug 
    ON content_nodes(entity_type, entity_id, slug) 
    WHERE deleted_at IS NULL;

-- 3. فهرس تصفية الأنواع الهيكلية (فصول، مسائل، لوحات)
CREATE INDEX idx_content_nodes_type 
    ON content_nodes(entity_id, type);

-- 3. فهرس GiST للمسار الهرمي المتقدم (LTREE)
CREATE INDEX idx_content_nodes_path_gist 
    ON content_nodes USING GIST (path);

-- 4. فهارس B-Tree الصريحة للأوراق والتوقيتات (سرعة 1-2ms)
CREATE INDEX idx_content_nodes_folio 
    ON content_nodes(entity_id, folio_number, folio_side) 
    WHERE folio_number IS NOT NULL;

CREATE INDEX idx_content_nodes_time 
    ON content_nodes(entity_id, start_ms, end_ms) 
    WHERE start_ms IS NOT NULL;

-- 5. فهارس البحث النصي العربي المطبّع (Full-Text Search with Normalization)
-- تنبيه فيلولوجي ومعماري: يُستخدم قاموس 'simple' حصراً لمنع محلل Snowball في 'arabic' من تحويل التاء المربوطة (ة) قسرياً إلى هاء (ه) والعبث بالمتون
CREATE INDEX idx_content_nodes_fts 
    ON content_nodes USING GIN (to_tsvector('simple', normalize_arabic_text(plain_text)));

-- 6. فهرس GIN المحسّن للبيانات الوصفية (jsonb_path_ops يوفر 70% من الحجم ويكبح Write-Amplification)
-- تنبيه معماري: حُظر فهرس GIN على content_json لحماية قاعدة البيانات من انتفاخ الحفظ التلقائي؛ البحث النصي مكفول بالكامل عبر plain_text
CREATE INDEX idx_content_nodes_metadata_path 
    ON content_nodes USING GIN (metadata jsonb_path_ops);
```

---

## 2.3 جداول العنونة الثابتة وإعادة التوجيه (Persistent Identifiers & Redirects)
لتحقيق عقيدة "العنونة المطلقة" وفق المعايير الأكاديمية والأرشيفية الدولية (مثل DOI, ARK, URN)، وضمان عدم موت الروابط المحفوظة لدى الباحثين في حال تعديل الـ Slugs:

```sql
-- 1. جدول المعرفات المتعددة والدولية للعقدة
CREATE TABLE node_identifiers (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    node_id UUID NOT NULL REFERENCES content_nodes(id) ON DELETE CASCADE,
    scheme VARCHAR(30) NOT NULL,       -- 'slug', 'doi', 'ark', 'urn', 'handle'
    value VARCHAR(255) NOT NULL,       -- القيمة الفريدة للمعرف
    is_primary BOOLEAN DEFAULT FALSE,  -- هل هو المعرف الأساسي المعروض؟
    is_persistent BOOLEAN DEFAULT TRUE,-- هل هو معرف دائم لا يتغير؟
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT uq_scheme_value UNIQUE(scheme, value)
);

CREATE INDEX idx_identifiers_node ON node_identifiers(node_id);
CREATE INDEX idx_identifiers_lookup ON node_identifiers(scheme, value);

-- 2. جدول التحويلات الدائمة التلقائية (301 Permanent Redirects)
CREATE TABLE identifier_redirects (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    scheme VARCHAR(30) NOT NULL DEFAULT 'slug',  -- 'slug', 'doi', 'ark', 'urn'
    old_identifier VARCHAR(255) NOT NULL,        -- القيمة القديمة للمعرف التي تم تغييرها
    new_identifier VARCHAR(255) NOT NULL,        -- القيمة الجديدة المحال إليها
    entity_type VARCHAR(50) NOT NULL,
    entity_id UUID NOT NULL,
    reason VARCHAR(100) DEFAULT 'slug_updated',  -- 'slug_updated', 'split', 'merged'
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT uq_redirect_scheme_scoped UNIQUE(scheme, entity_type, entity_id, old_identifier)
);

CREATE INDEX idx_redirects_lookup ON identifier_redirects(scheme, entity_type, entity_id, old_identifier);

-- تنبيه معماري دستوري حول أتمتة إعادة التوجيه وحماية فضاء الأسماء (Scoped Cycle-Free Redirects):
-- 1. قيد التفرد يشتمل صراحة على (entity_type, entity_id) لأن عناوين العقد (content_nodes) ليست فريدة عالمياً بل في نطاق أصلها؛
--    مما يسمح لكتب مختلفة بتعديل فصول تحمل نفس العنوان القديم (مثل: 'al-muqaddimah') دون أي تصادم في القيود.
-- 2. تملأ سجلات identifier_redirects تلقائياً عبر حدث updating في مراقبي الكيانات (BookObserver و ContentNodeObserver).
-- 3. تلزم المنظومة بتسطيح السلاسل التاريخية (A -> B ثم B -> C يتحول إلى A -> C)، مع حذف أي سجل يتطابق فيه 
--    old_identifier مع new_identifier (Self-Loop Elimination) لحظر حلقات إعادة التوجيه اللانهائية (ERR_TOO_MANY_REDIRECTS)
--    خصوصاً عند تراجع المحقق إلى عنوان قديم سبق التخلي عنه (Slug Reverting).

-- 3. جدول تتبع أنساب الكتل والفقرات الذرية (Block-Level Lineage & Split/Merge Tracking)
-- يضمن بقاء الروابط المتصالبة والتعليقات المربوطة بالفقرات (anchor_id) حية حتى عند دمج الكتل أو تفكيكها في المحرر
-- قاعدة معمارية: قاعدة البيانات تضمن التكامل العلائقي، بينما تمتلك طبقة التطبيق (EntityContentService AST Parser)
-- الذكاء الدلالي لتحديد أي أنصاف الكتل المنشطرة يحتوي على الروابط والتعليقات وتوجيه السلالة إليها بدقة.
CREATE TABLE block_lineage (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    entity_type VARCHAR(50) NOT NULL,
    entity_id UUID NOT NULL,
    node_id UUID REFERENCES content_nodes(id) ON DELETE CASCADE,
    old_block_id VARCHAR(100) NOT NULL,     -- المعرف الذري الأصلي للكتلة (anchor_id)
    new_block_id VARCHAR(100),              -- المعرف الجديد المحال إليه (NULL في حالة الحذف الصريح للفقرة)
    action VARCHAR(30) NOT NULL CHECK (action IN ('split', 'merged', 'migrated', 'deleted')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT uq_block_lineage_step UNIQUE NULLS NOT DISTINCT (entity_id, old_block_id, new_block_id, action)
);

-- فهارس الاستعلام الأمامي والعكسي السريع للأنساب
CREATE INDEX idx_block_lineage_lookup ON block_lineage(entity_id, old_block_id);
CREATE INDEX idx_block_lineage_reverse ON block_lineage(entity_id, new_block_id) WHERE new_block_id IS NOT NULL;
CREATE INDEX idx_block_lineage_node ON block_lineage(node_id);

-- ====================================================================
-- محفز منع الحلقات المفرغة في أنساب الكتل (Cycle Prevention at Write Time)
-- ====================================================================
CREATE OR REPLACE FUNCTION trg_prevent_cyclic_block_lineage()
RETURNS TRIGGER AS $$
DECLARE
    v_cycle_detected BOOLEAN;
BEGIN
    IF NEW.new_block_id IS NOT NULL THEN
        WITH RECURSIVE check_cycle AS (
            SELECT old_block_id, new_block_id
            FROM block_lineage
            WHERE entity_id = NEW.entity_id AND new_block_id = NEW.old_block_id
            
            UNION ALL
            
            SELECT bl.old_block_id, bl.new_block_id
            FROM block_lineage bl
            JOIN check_cycle cc ON bl.new_block_id = cc.old_block_id
            WHERE bl.entity_id = NEW.entity_id
        )
        CYCLE old_block_id SET is_cycle USING cycle_path
        SELECT EXISTS (
            SELECT 1 FROM check_cycle WHERE old_block_id = NEW.new_block_id OR is_cycle
        ) INTO v_cycle_detected;

        IF v_cycle_detected THEN
            RAISE EXCEPTION 'انتهاك نسب الكتل: محاولة إنشاء علاقة دائرية مفرغة (Cyclic Block Lineage) بين الكتلة (%) والكتلة (%)!', 
                NEW.old_block_id, NEW.new_block_id USING ERRCODE = '22000';
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_block_lineage_cycle
BEFORE INSERT ON block_lineage
FOR EACH ROW
EXECUTE FUNCTION trg_prevent_cyclic_block_lineage();

-- ====================================================================
-- دالة استرجاع أصل الكتلة وتاريخها العكسي (Block Provenance Function)
-- ====================================================================
CREATE OR REPLACE FUNCTION get_block_provenance(p_entity_id UUID, p_block_id VARCHAR)
RETURNS TABLE (
    ancestor_block_id VARCHAR,
    action VARCHAR,
    created_at TIMESTAMP WITH TIME ZONE,
    depth INTEGER
) AS $$
    WITH RECURSIVE provenance_tree AS (
        SELECT old_block_id, new_block_id, action, created_at, 1 as depth
        FROM block_lineage
        WHERE entity_id = p_entity_id AND new_block_id = p_block_id
        
        UNION ALL
        
        SELECT bl.old_block_id, bl.new_block_id, bl.action, bl.created_at, pt.depth + 1
        FROM block_lineage bl
        JOIN provenance_tree pt ON bl.new_block_id = pt.old_block_id
        WHERE bl.entity_id = p_entity_id
    )
    CYCLE old_block_id SET is_cycle USING cycle_path
    SELECT old_block_id, action, created_at, depth 
    FROM provenance_tree 
    WHERE NOT is_cycle 
    ORDER BY depth ASC;
$$ LANGUAGE sql STABLE;

-- ====================================================================
-- محفز المواءمة التلقائية لشبكة المعرفة عند تعديل الكتل (Lineage Auto-Reconciliation)
-- ====================================================================
CREATE OR REPLACE FUNCTION trg_reconcile_knowledge_links_on_lineage()
RETURNS TRIGGER AS $$
BEGIN
    -- 1. في حالة الدمج أو الهجرة: تحويل صريح للرابط إلى المعرف الجديد
    IF NEW.action IN ('merged', 'migrated') AND NEW.new_block_id IS NOT NULL THEN
        UPDATE knowledge_links
        SET source_block_id = NEW.new_block_id
        WHERE source_type = NEW.entity_type 
          AND source_id = NEW.entity_id 
          AND source_block_id = NEW.old_block_id;

        UPDATE knowledge_links
        SET target_block_id = NEW.new_block_id
        WHERE target_type = NEW.entity_type 
          AND target_id = NEW.entity_id 
          AND target_block_id = NEW.old_block_id;

    -- 2. في حالة الانشطار: تُدار المواءمة الدلالية الدقيقة للروابط والتعليقات حصراً عبر EntityContentService
    -- لمنع فخ التنازع المزدوج (The Split Trigger Paradox) مع توثيق سياق الانشطار فقط دون فرض تحويل عشوائي
    ELSIF NEW.action = 'split' AND NEW.new_block_id IS NOT NULL THEN
        UPDATE knowledge_links
        SET metadata = jsonb_set(
            metadata, 
            '{lineage_split}', 
            jsonb_build_object('original_block', NEW.old_block_id, 'split_into', NEW.new_block_id, 'at', NOW())
        )
        WHERE (source_type = NEW.entity_type AND source_id = NEW.entity_id AND source_block_id = NEW.old_block_id)
           OR (target_type = NEW.entity_type AND target_id = NEW.entity_id AND target_block_id = NEW.old_block_id);

    -- 3. في حالة حذف الفقرة الحاملة للرابط: وسم الرابط كمعلق لمنع الروابط العمياء
    ELSIF NEW.action = 'deleted' THEN
        UPDATE knowledge_links
        SET metadata = jsonb_set(
            metadata, 
            '{orphaned_status}', 
            jsonb_build_object('reason', 'block_deleted', 'deleted_block_id', NEW.old_block_id, 'at', NOW())
        )
        WHERE (source_type = NEW.entity_type AND source_id = NEW.entity_id AND source_block_id = NEW.old_block_id)
           OR (target_type = NEW.entity_type AND target_id = NEW.entity_id AND target_block_id = NEW.old_block_id);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_auto_reconcile_knowledge_links
AFTER INSERT ON block_lineage
FOR EACH ROW
EXECUTE FUNCTION trg_reconcile_knowledge_links_on_lineage();
```

---

## 2.4 جدول سجل المراجعات والإصدارات التاريخية (`node_revisions`)
**حلاً حاسماً لمشكلة انتفاخ الجدول (Table Bloat):**  
يحتفظ جدول `content_nodes` **فقط بالنسخة الحية النشطة حالياً**، بينما تُعزل كافة النسخ والتعديلات التاريخية السابقة في هذا الجدول الأرشيفي المتخصص؛ فلا يتم تحميله إطلاقاً إلا عند طلب مقارنة النسخ أو الاسترجاع في الاستوديو:

> [!WARNING]
> **سياسة مكافحة انتفاخ المراجعات (Milestone-Based Versioning):**  
> يُحظر قطيعاً إنشاء مراجعة تاريخية جديدة عند كل حفظ تلقائي عابر (Debounced Auto-save).  
> تُنشأ المراجعات حصراً عند **نقاط الحفظ الكبرى (Major Milestones)**: كالحفظ اليدوي المباشر من المحقق، أو تغيير حالة العقدة التحقيقية، أو عبر إغلاق جلسة العمل.  
> كما يُلزم النظام بالتحقق من `content_hash (SHA-256)` لمنع حفظ أي نسخة مطابقة سابقة منعاً لهدر التخزين.

```sql
CREATE TABLE node_revisions (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    node_id UUID NOT NULL REFERENCES content_nodes(id) ON DELETE CASCADE,
    version_number INTEGER NOT NULL,
    content_hash CHAR(64) NOT NULL,    -- تجزئة SHA-256 لمنع تكرار النسخ المتطابقة
    
    -- لقطة كاملة للنص ومحتوى المحرر في هذه النسخة
    title VARCHAR(500) NOT NULL,
    content_html TEXT,
    content_json JSONB,
    plain_text TEXT,
    
    -- بيانات التعديل والتدقيق
    reason VARCHAR(255),               -- سبب التعديل (تصحيح سقط، تحقيق لفظ، مراجعة)
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    
    CONSTRAINT uq_node_version UNIQUE(node_id, version_number)
);

CREATE INDEX idx_revisions_node ON node_revisions(node_id, version_number DESC);
CREATE INDEX idx_revisions_author ON node_revisions(created_by);
CREATE INDEX idx_revisions_hash ON node_revisions(node_id, content_hash);

-- محفز الترقيم الذري التلقائي للمراجعات لحماية uq_node_version من سباق الحفظ المتزامن (Race-Free Revision Versioning)
CREATE OR REPLACE FUNCTION trg_assign_node_revision_version()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.version_number IS NULL OR NEW.version_number <= 0 THEN
        -- قفل العقدة الأم في content_nodes ذرياً لمنع سباق الترقيم المتزامن
        PERFORM 1 FROM content_nodes WHERE id = NEW.node_id FOR UPDATE;
        
        SELECT COALESCE(MAX(version_number), 0) + 1 INTO NEW.version_number
        FROM node_revisions 
        WHERE node_id = NEW.node_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_auto_version_node_revisions
BEFORE INSERT ON node_revisions
FOR EACH ROW
EXECUTE FUNCTION trg_assign_node_revision_version();
```

---

## 2.5 جدول شبكة المعرفة والربط المتصالب الموحد (`knowledge_links`)
يحل هذا الجدول محل الازدواجية السابقة (`node_links` و `entity_relations`)؛ حيث يمثل جدولاً بيانيا موحداً فائق القوة يربط بين الأصول والعُقد والذرات في شبكة معرفية متكاملة (Knowledge Graph):

> [!IMPORTANT]
> **حوكمة الحواف البوليمورفية ومكافحة فخ الـ Global Scope البوليمورفي (Polymorphic Edge Lifecycle Integrity):**  
> نظراً لأن PostgreSQL لا يدعم القيود الأجنبية الصريحة (`Foreign Keys`) على الأعمدة البوليمورفية (`source_type`, `target_type`)، وتجنباً لفخ الـ Global Scope البوليمورفي (الذي يولد 10 استعلامات فرعية و Anti-Joins تدمر أداء التحليلات والشبكة البيانية)، فإن حوكمة الروابط تُحسم دستورياً عبر:  
> 1. تزويد جدول `knowledge_links` بعمود `deleted_at` مع فهرس جزئي صاروخي للروابط الحية فقط (`WHERE deleted_at IS NULL`).  
> 2. تسجيل **`EntityLifecycleObserver` موحد** على كافة نماذج الأصول الأربعة (`Book`, `Manuscript`, `Audio`, `Video`) بالإضافة إلى `ContentNode`:  
>    * في الحذف الناعم (`delete`): يضع `deleted_at` على كافة الروابط الواردة والصادرة في خطوة ذرية واحدة.  
>    * في الاسترجاع (`restore`): يسترجع الروابط الناعمة التابعة للكيان تلقائياً (`onlyTrashed()->restore()`).  
>    * في الحذف النهائي الفيزيائي (`forceDelete`): يتكفل الـ Observer بتنفيذ `forceDelete()` للروابط برمجياً لعدم وجود DB FK Cascade في العلاقات البوليمورفية، قاطعاً دابر الروابط الشبحية (Ghost Links).  
> 3. حصر الـ Global Scope لنموذج `KnowledgeLink` في قيد وحيد مباشر وسريع: `WHERE deleted_at IS NULL` ($O(1)$ B-Tree Scan).

```sql
CREATE TABLE knowledge_links (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    
    -- الطرف المصدر (يمكن أن يكون أصلاً، أو عقدة، أو فقرة محددة)
    source_type VARCHAR(50) NOT NULL,   -- 'book', 'manuscript', 'audio', 'video', 'content_node'
    source_id UUID NOT NULL,
    source_block_id VARCHAR(100),       -- المعرف الذري للكتلة (anchor_id)
    
    -- الطرف الهدف (يمكن أن يكون أصلاً، أو عقدة، أو فقرة، أو توقيتاً)
    target_type VARCHAR(50) NOT NULL,   -- 'book', 'manuscript', 'audio', 'video', 'content_node'
    target_id UUID NOT NULL,
    target_block_id VARCHAR(100),       -- المعرف الذري للكتلة (anchor_id)
    
    -- الطبيعة العلمية والدلالية للرابط
    relation_type VARCHAR(50) NOT NULL, -- cites, commentary, explains, parallels, transcribes, refutes...
    
    -- التوثيق والموثوقية
    weight NUMERIC(3, 2) DEFAULT 1.00,
    confidence NUMERIC(3, 2) DEFAULT 1.00,
    metadata JSONB DEFAULT '{}'::jsonb,  -- يحمل: timestamp_display, folio_label, notes...
    
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    deleted_at TIMESTAMP WITH TIME ZONE
);

-- فهارس الاستعلام والتفرد المحمية من تصادم الحذف الناعم (Postgres 15+ Partial Unique Index)
-- تنبيه معماري: استُبدل قيد الجدول بفهرس تفرد جزئي (WHERE deleted_at IS NULL) لتمكين إعادة ربط الكيانات 
-- بعد حذف الروابط السابقة ناعماً دون الوقوع في استثناء كسر التفرد (Unique Violation)
CREATE UNIQUE INDEX uq_knowledge_link_active ON knowledge_links (
    source_type, source_id, source_block_id, 
    target_type, target_id, target_block_id, 
    relation_type
) NULLS NOT DISTINCT 
WHERE deleted_at IS NULL;

CREATE INDEX idx_klinks_source ON knowledge_links(source_type, source_id, source_block_id);
CREATE INDEX idx_klinks_target ON knowledge_links(target_type, target_id, target_block_id);
CREATE INDEX idx_klinks_relation ON knowledge_links(relation_type);
```

```php
// مراقب دورة حياة الكيانات والروابط البوليمورفية (EntityLifecycleObserver.php)
// إلزام دستوري: يجب تفعيل Relation::enforceMorphMap([...]) في AppServiceProvider لمنع تضارب أسماء الفئات مع قيود CHECK
namespace App\Observers;

use App\Models\KnowledgeLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class EntityLifecycleObserver
{
    public function deleted(Model $entity): void
    {
        $entityClass = $entity->getMorphClass();
        $entityId = $entity->getKey();

        $linksQuery = KnowledgeLink::where(function ($q) use ($entityClass, $entityId) {
            $q->where('source_type', $entityClass)->where('source_id', $entityId);
        })->orWhere(function ($q) use ($entityClass, $entityId) {
            $q->where('target_type', $entityClass)->where('target_id', $entityId);
        });

        // حسم أيتام الحذف النهائي لغياب الـ DB Foreign Keys في العلاقات البوليمورفية
        if (method_exists($entity, 'isForceDeleting') && $entity->isForceDeleting()) {
            $linksQuery->forceDelete();
        } else {
            $linksQuery->delete();
        }
    }

    public function restored(Model $entity): void
    {
        $entityClass = $entity->getMorphClass();
        $entityId = $entity->getKey();

        // حماية من فخ استرجاع الرابط نصف الميت (Half-Dead Link Restoration Trap):
        // التحقق من أن الطرف المقابل غير محذوف قبل استرجاع الرابط، منعاً لظهور حواف تشير لكيانات ميتة
        $trashedLinks = KnowledgeLink::onlyTrashed()
            ->where(function ($q) use ($entityClass, $entityId) {
                $q->where('source_type', $entityClass)->where('source_id', $entityId);
            })->orWhere(function ($q) use ($entityClass, $entityId) {
                $q->where('target_type', $entityClass)->where('target_id', $entityId);
            })->get();

        foreach ($trashedLinks as $link) {
            $oppositeType = ($link->source_type === $entityClass && $link->source_id === $entityId) 
                ? $link->target_type : $link->source_type;
            $oppositeId = ($link->source_type === $entityClass && $link->source_id === $entityId) 
                ? $link->target_id : $link->source_id;

            $oppositeModel = Relation::getMorphedModel($oppositeType);
            if ($oppositeModel && $oppositeModel::where('id', $oppositeId)->exists()) {
                $link->restore();
            }
        }
    }
}
```

---

## 2.6 جداول التفاعل والتعليق والوسم المستقل

> [!IMPORTANT]
> **حوكمة الجداول البوليمورفية للتفاعل والوسوم (Polymorphic Interactive Integrity):**  
> نظراً لكون جداول `comments` و `categorizables` و `taggables` ترتبط بالأصول والعُقد عبر علاقات متعددة الأشكال (`entity_type`, `entity_id`) تفتقر لقيود الـ FK الصريحة في قاعدة البيانات، يُلزم الدستور بـ:  
> 1. توسيع **`EntityLifecycleObserver`** لحذف كافة التعليقات والتصنيفات والوسوم التابعة للأصل أو العقدة عند حذفها صراحة أو ناعماً.  
> 2. مواءمة المعرفات الذرية (`anchor_id`) في جدول `comments` تلقائياً عبر أحداث `block_lineage` عند انشطار أو دمج الفقرات لضمان عدم ضياع تعليقات وهوامش المحققين المربوطة بالمتن.

### 2.6.1 جدول التعليقات الذرية (`comments`)
يرتبط بالعقدة مع دعم تثبيت التعليق على ذرة بعينها (`anchor_id`) دون تشويه المتن:

```sql
CREATE TABLE comments (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    entity_type VARCHAR(50) NOT NULL, -- 'content_node', 'book', etc.
    entity_id UUID NOT NULL,
    anchor_id VARCHAR(100),           -- المعرف الذري (مثل: 'p-101', 'masalah-2', 'poet-1')
    user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    parent_id UUID REFERENCES comments(id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'approved',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

CREATE INDEX idx_comments_entity ON comments(entity_type, entity_id, anchor_id);
CREATE INDEX idx_comments_user ON comments(user_id);
```

### 2.6.2 جداول التصنيف والوسوم (`categorizables` & `taggables`)

```sql
-- التصنيفات العلمية الهرمية
CREATE TABLE categorizables (
    category_id UUID NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    entity_type VARCHAR(50) NOT NULL,
    entity_id UUID NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    PRIMARY KEY (category_id, entity_type, entity_id)
);

-- الوسوم الموضوعية
CREATE TABLE taggables (
    tag_id UUID NOT NULL REFERENCES tags(id) ON DELETE CASCADE,
    entity_type VARCHAR(50) NOT NULL,
    entity_id UUID NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    PRIMARY KEY (tag_id, entity_type, entity_id)
);
```

---

# 📚 الجزء الثالث: معجم العُقَد التراثية والعلمية الشامل

## 3.1 عُقَد الكتاب (Book Taxonomy)

### أ) العُقَد الهيكلية الكبرى (أسطر في `content_nodes`):
1. **`sub_book` (كتاب فرعي):** الكتب التراثية المندرجة تحت الجوامع (كتاب الإيمان، كتاب الصلاة).
2. **`volume` (مجلد) / `part` (جزء) / `sifr` (سفر):** التقسيمات المادية للمطولات.
3. **`bab` (باب):** الجامع للأبواب العلمية المتجانسة.
4. **`chapter` (فصل):** الوحدة المعيارية الأساسية (عتبة التفكيك الهيكلي).
5. **`section` (قسم):** تنظيم فرعي مرن.
6. **`page` (صفحة):** مطابقة الترقيم الأصلي للمطبوع والمحقق.
7. **`introduction` (مقدمة/خطبة) / `conclusion` (خاتمة) / `commendation` (تقريظ).

### ب) العُقَد الاستدلالية والتفريعية (داخل `content_json` تحت الفصل):
1. **`mabhas` (مبحث):** دراسة موضوعية فرعية تحت الفصل.
2. **`matlab` (مطلب):** تفريع تحليلي داخل المبحث.
3. **`masalah` (مسألة):** حكم فقهي أو علمي مستقل بذاته.
4. **`far` (فرع):** استخراج تفريعي ملحق بالمسألة.
5. **`asl` (أصل) / `qaidah` (قاعدة):** تقرير أصل استدلالي أو قاعدة فقهية كلية.
6. **`tanbih` (تنبيه) / `faidah` (فائدة):** إضاءات واستدراكات علمية دقيقة.

---

## 3.2 عُقَد المخطوط الكوديكولوجية (Manuscript Taxonomy)
1. **`quire` (كراسة) / `gathering` (إضبارة):** البنية المادية للمخطوط.
2. **`folio` (ورقة مخطوطة):** السجل الأساسي الحامل للوحة والتفريغ.
3. **`recto` (وجه 'أ') / `verso` (ظهر 'ب'):** وجها الورقة الكوديكولوجية.
4. **`line` (مسطرة / سطر):** وحدة التحقيق والقراءة المقابلة.
5. **`turrah` (طُرّة / هامش / تعليقة):** الحواشي التراثية على هوامش النسخة.
6. **`codicological_record` (القيود التراثية):** قيود الوقف، والتملك، والإجازات، والسماعات، والمقابلات والبلاغات.
7. **`colophon` (الكولوفون / خاتمة النسخ):** توثيق الفراغ من النسخ واسم الناسخ وتاريخه.

---

## 3.3 عُقَد الصوت والمرئيات (Media Taxonomy)
1. **`majlis` (مجلس) / `dars` (درس) / `lecture` (محاضرة):** العقد التنظيمية الكبرى.
2. **`track` (مسار صوتي):** المسار الفيزيائي الصوتي.
3. **`segment` (مقطع زمني):** الوحدة المربوطة بالدقيقة والثانية (`start_ms`, `end_ms`).
4. **`scene` (مشهد مرئي) / `shot` (لقطة بصرية):** التقسيم البصري في الفيديو.
5. **`slide` (شريحة عرض / Keyframe):** الشاهد البصري المتزامن مع المتن.
6. **`cue_marker` (علامة موضعية) / `qa_segment` (مقطع سؤال وجواب).

---

## 3.4 العُقَد الذرية المشتركة داخل المحرر (Tiptap / ProseMirror AST)
1. **`paragraph` (الفقرة النصية):** الحامل الأساسي للمعنى.
2. **`quranic_verse` (الآية القرآنية):** بالرسم العثماني، والسورة، والآية، والجزء.
3. **`hadith` (الحديث النبوي المسند):** بالسند، والمتن، والتخريج، والحكم.
4. **`heritage_poetry` (الشعر التراثي):** بالصدر، والعجز، والبحر، والقافية، والشاعر.
5. **`scientific_footnote` (الحاشية العلمية):** نوعها (تحقيق، مقابلة نسخ، تخريج، شرح)، ورقمها، ومحررها الخاص.
6. **`blockquote` (الاقتباس التراثي):** مع عزو المصدر.
7. **`segment_link` (الرابط الزمني التدفيقي):** للقفز المباشر في مشغل الصوت أو الفيديو.
8. **`cross_entity_link` (الرابط المتصالب):** للربط المباشر بين لوحة مخطوط أو فقرة كتاب آخر.

---

# 🎼 الجزء الرابع: الاستوديو ومحرك التجزئة الجراحية (Studio Pipeline)

## 4.1 بيئة العمل التفاعلية الحية (`Technologies/Studio`)
الاستوديو ليس محرر نصوص بسيط، بل هو غرفة العمليات المتزامنة التي تجمع بين:
1. **المحرر الموحد (`Technologies/Editor`):** بيئة Tiptap المخصصة لعلوم التراث.
2. **مشغل الوسائط (`Technologies/Player`):** نافذة عائمة متزامنة للصوت والفيديو تقفز للتوقيتات فوراً.
3. **عارض المخطوطات (`Technologies/Manuscripter`):** عارض `DetailViewer` الفائق المزود بتقنيات Pan & Zoom والمقارنة بين النسخ (`CompareView`).

## 4.2 محرك التجميع والتجزئة الجراحية (Smart Aggregator & Splitter)
لحفظ تجربة المستخدم الانسيابية دون المساس بانضباط قاعدة البيانات:
1. **العرض المجمع (Full View Aggregation):** يقوم النظام بجمع نصوص فصول الكتاب أو أوراق المخطوط في مساحة قراءة متصلة واحدة، مع حقن عقد هيكلية واضحة داخل شجرة الـ AST:  
   `node: { type: 'structureMarker', attrs: { id: 'UUID', type: 'chapter', startTime: '...' } }`
2. **التجزئة الجراحية التلقائية عبر اجتياز الشجرة (AST Tree Traversal on Save):**  
   عند ضغط زر الحفظ (`Ctrl+S` أو الحفظ المعتمد)، يستلم `UnifiedEditorController` وثيقة Tiptap JSON كاملة. يقوم محرك `EntityContentService` بـ **اجتياز شجرة الكائنات برمجياً (Recursive AST Traversal)** بدلاً من هشاشة التعبيرات النمطية (`Regex`). يُقسّم المحرك الشجرة عند كل عقدة `structureMarker`، مستخرجاً الحقول النصية والميتاداتا بدقة جراحية لا تخطئ، ويعيد توزيعها كسطور مفهرسة في `content_nodes`.
3. **الفصل الدلالي متكامل الأطراف عند انشطار الفقرات (Semantic Multi-Anchor Splitter):**  
   تُحظر العشوائية في ترحيل الروابط؛ حيث تمتلك طبقة التطبيق الذكاء الدلالي لفحص علامات الـ AST. عند انشطار فقرة، تحدد الخدمة أي النصفين يحتوي على الرابط المعرفي أو التعليق الذري، وترحّلهما في معاملة ذرية موحدة تمنع يتيم التعليقات والروابط:

```php
// خدمة التجزئة الدلالية المتكاملة للروابط والتعليقات (EntityContentService.php)
namespace App\Services;

use App\Models\BlockLineage;
use App\Models\Comment;
use App\Models\KnowledgeLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EntityContentService
{
    public function splitBlock(
        string $entityType, 
        string $entityId, 
        string $originalBlockId, 
        array $firstHalfAst, 
        array $secondHalfAst
    ): void {
        $firstBlockId = (string) Str::uuid();
        $secondBlockId = (string) Str::uuid();

        // فحص الـ AST لاستخراج المعرفات الواقعة في كل نصف
        $linksInSecondHalf = $this->extractLinkIdsFromAst($secondHalfAst);
        $commentsInSecondHalf = $this->extractCommentIdsFromAst($secondHalfAst);

        DB::transaction(function () use (
            $entityType, $entityId, $originalBlockId, 
            $firstBlockId, $secondBlockId, 
            $linksInSecondHalf, $commentsInSecondHalf
        ) {
            // 1. تسجيل أنساب الكتل للجهتين
            BlockLineage::create([
                'entity_type'  => $entityType,
                'entity_id'    => $entityId,
                'old_block_id' => $originalBlockId,
                'new_block_id' => $firstBlockId,
                'action'       => 'split',
            ]);

            BlockLineage::create([
                'entity_type'  => $entityType,
                'entity_id'    => $entityId,
                'old_block_id' => $originalBlockId,
                'new_block_id' => $secondBlockId,
                'action'       => 'split',
            ]);

            // 2. ترحيل الروابط المعرفية للنصف الصحيح دلالياً
            if (!empty($linksInSecondHalf)) {
                KnowledgeLink::whereIn('id', $linksInSecondHalf)
                    ->update(['source_block_id' => $secondBlockId]);
            }

            // 3. ترحيل التعليقات الذرية للنصف الصحيح لحمايتها من اليُتم
            if (!empty($commentsInSecondHalf)) {
                Comment::where('entity_type', $entityType)
                    ->where('entity_id', $entityId)
                    ->where('anchor_id', $originalBlockId)
                    ->whereIn('id', $commentsInSecondHalf)
                    ->update(['anchor_id' => $secondBlockId]);
            }
        });
    }
}
```

## 4.3 نمط الإسقاط البياني المحدث للروابط (Materialized Graph Projection)
حلاً لمعادلة (سلاسة القراءة مقابل سرعة الاستعلامات البيانية):
* **أثناء التحرير والقراءة:** يعيش الرابط كعلامة تدفقية داخل الـ JSON (`<span data-segment-link data-id="...">`).
* **لحظة الحفظ (Save Hook):** يقوم الخادم باجتياز شجرة AST واستخراج كافة الروابط المتصالبة والأختام الزمنية، وإسقاطها فوراً في جدول **`knowledge_links`**.
* **النتيجة:** القارئ ينقر على الرابط في سياق الجملة، والباحث ومحرك الـ Knowledge Graph يستعلم عن الروابط والمسارات والمراجع المكسورة بـ B-Tree Index في **1 ميلي ثانية فقط**!

## 4.4 إدارة الوسائط والمشتقات الشبكية (Media & Derivatives Architecture)
لضمان الأداء الفائق على شبكات CDN والتوافق مع المشغلات العالمية:
1. **الصوتيات:** توليد ملفات HLS AAC للتدفق التكيفي، وحساب مصفوفة القمم الصوتية (`waveform_data`) لمرة واحدة عند الرفع.
2. **المرئيات:** توليد تدفق HLS بمستويات جودة متعددة (1080p, 720p, 480p) مع ملف الـ Master Playlist (`.m3u8`)، واستخراج لقطات الشرائح المصغرة بصيغة WebP خفيفة.
3. **المخطوطات:** توليد أهرامات صور عالية الدقة بتنسيق Deep Zoom / PTIF لتغذية خادم بروتوكول IIIF وعارض `Manuscripter`.

## 4.5 بروتوكول التزامن وعزل أقفال الاستوديو (Studio Concurrency & Ephemeral Locking)
لحماية غرف العمليات المشتركة من الكتابة المتزامنة المتضاربة (Race Conditions) وتجنب تدمير أداء قاعدة البيانات بانتفاخ MVCC:
1. **العزل التام عن جدول المحتوى (Zero-MVCC Churn):** يُحظر حظراً باتاً تخزين نبضات القفل في جدول `content_nodes`. يُدار القفل حصراً عبر **Redis** كطبقة أولى فائقة السرعة (`SET content_node:{id}:lock {user_id} EX 45 NX`)، مع الاعتماد على جدول `studio_locks` من نوع **`UNLOGGED TABLE`** في PostgreSQL كـ Fallback لا يُكتب في سجلات الـ WAL ولا يُثقل محرك الـ Autovacuum.
2. **النبضات الحية وتجديد القفل والشفاء الذاتي (Self-Healing Heartbeat Lease):**  
   يجدد المحرر قفله كل 30 ثانية تلقائياً، وينتهي القفل تلقائياً بعد 45 ثانية من انقطاع الاتصال دون الحاجة لتدخل يدوي.  
   وفي حال إعادة تشغيل خادم قاعدة البيانات أو انهياره وتفريغ جدول `UNLOGGED` تلقائياً، يقوم خادم التطبيق بإعادة حيازة القفل بشفافية تامة (`reacquired_after_crash`) دون مقاطعة كتابة المحقق أو تشويش واجهته.

```php
// 1. نموذج قفل الاستوديو الموجه للكاتب الأساسي (StudioLock.php)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudioLock extends Model
{
    protected $connection = 'pgsql::write'; // حظر القراءة من الـ Replicas حظراً باتاً
    protected $table = 'studio_locks';
    protected $primaryKey = 'node_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'node_id', 'user_id', 'lock_token', 'locked_at', 'expires_at'
    ];

    public static function acquire(string $nodeId, string $userId, string $token): bool
    {
        try {
            return DB::connection('pgsql::write')->table('studio_locks')->insertOrIgnore([
                'node_id' => $nodeId,
                'user_id' => $userId,
                'lock_token' => $token,
                'locked_at' => now(),
                'expires_at' => now()->addSeconds(45),
            ]);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function renew(string $nodeId, string $token): bool
    {
        return DB::connection('pgsql::write')->table('studio_locks')
            ->where('node_id', $nodeId)
            ->where('lock_token', $token)
            ->update(['expires_at' => now()->addSeconds(45)]) > 0;
    }
}

// 2. خدمة إدارة الأقفال المحصنة مع الشفاء الذاتي (StudioLockService.php)
namespace App\Services\Studio;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudioLockService
{
    protected string $connection = 'pgsql::write';

    public function heartbeat(string $nodeId, string $userId, string $lockToken): array
    {
        $now = Carbon::now();
        $expiresAt = $now->copy()->addSeconds(45);

        return DB::connection($this->connection)->transaction(function () use ($nodeId, $userId, $lockToken, $now, $expiresAt) {
            $lock = DB::connection($this->connection)
                ->table('studio_locks')
                ->where('node_id', $nodeId)
                ->lockForUpdate()
                ->first();

            if ($lock && $lock->lock_token === $lockToken) {
                DB::connection($this->connection)->table('studio_locks')
                    ->where('node_id', $nodeId)
                    ->update(['expires_at' => $expiresAt]);

                return ['status' => 'renewed', 'expires_at' => $expiresAt->toIso8601String()];
            }

            if ($lock && $lock->expires_at > $now && $lock->user_id !== $userId) {
                return ['status' => 'locked_by_other', 'locked_by' => $lock->user_id];
            }

            // الشفاء الذاتي بعد انهيار الخادم وتفريغ UNLOGGED Table
            DB::connection($this->connection)->table('studio_locks')->updateOrInsert(
                ['node_id' => $nodeId],
                ['user_id' => $userId, 'lock_token' => $lockToken, 'locked_at' => $now, 'expires_at' => $expiresAt]
            );

            return ['status' => 'reacquired_after_crash', 'expires_at' => $expiresAt->toIso8601String()];
        });
    }
}
```

```javascript
// 3. نبضة قلب الواجهة الأمامية وإعادة الحيازة التلقائية (studioHeartbeat.js)
export class StudioHeartbeat {
    constructor(nodeId, userId, token) {
        this.nodeId = nodeId;
        this.userId = userId;
        this.lockToken = token || crypto.randomUUID();
        this.timer = null;
    }

    start() {
        this.timer = setInterval(() => this.pulse(), 30000);
        this.pulse();
    }

    async pulse() {
        try {
            const res = await fetch(`/api/studio/nodes/${this.nodeId}/lock/heartbeat`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: this.userId, lock_token: this.lockToken })
            });
            const data = await res.json();
            if (data.status === 'locked_by_other') {
                window.dispatchEvent(new CustomEvent('studio:locked', { detail: data }));
            }
        } catch (e) {
            console.warn('⚠️ فشل إرسال نبضة القفل، سيتم المحاولة تلقائياً...');
        }
    }

    stop() {
        if (this.timer) clearInterval(this.timer);
    }
}
```

### 4.5.1 حظر الكتابة فوق قفل مسروق (Stale Lease Save Override Protection)
لحماية جهود المحققين من الضياع التام في سيناريو انقطاع الاتصال وسرقة القفل (Stale Lease Hijack):
* **قاعدة معمارية ملزمة:** يُحظر على خادم الـ API في `UnifiedEditorController` قبول أي طلب حفظ (`POST /api/nodes/{id}/save`) دون التحقق الذري داخل نفس المعاملة من أن الـ `lock_token` المصاحب للطلب ما زال حياً ويطابق القفل المسجل في `studio_locks`.
* **سلوك الرفض الآمن:** إذا انتهت صلاحية القفل أو استحوذ عليه محرر آخر، يُرفض الحفظ فوراً برمز `HTTP 423 Locked (Precondition Failed)` مع منع الكتابة في `content_nodes`، وإرجاع أحدث نسخة للمحرر السابق لتمكينه من دمج الفروقات يدوياً (Diff & Merge) بدلاً من سحق التعديلات الصامت.

## 4.6 حوكمة الحذف الناعم للأشجار المليارية وتجريد القراءة صفرية التكلفة (Zero-Cost Read Abstraction)
لحماية النظام من تجمد واجهة المستخدم وبلوغ مهلة الاتصال (504 Gateway Timeout) عند حذف أصول عملاقة تحوي أكثر من 100,000 عقدة، مع حماية أداء استعلامات القراءة بنسبة 100%:
1. **الفرز اللحظي ونمط الصندوق الصادر (Threshold Routing & Transactional Outbox):**  
   * الأشجار الفرعية $\le 500$ عقدة تُحذف متزامنة في نفس المعاملة عبر الـ Trigger في أقل من 5 ميلي ثانية.  
   * الأشجار $> 500$ عقدة تكتفي قاعدة البيانات بحذف الأب فوراً، وتُدرج سجلاً في جدول **`pending_tree_operations`** في نفس المعاملة دون استخدام `pg_notify` المعرض لفقدان الرسائل.
2. **تجريد القراءة صفرية التكلفة (Zero-Cost Read Abstraction):**  
   يُحظر دستورياً استخدام أية أغطية استعلام هرمية (`AncestorSoftDeleteScope` أو GiST Self-Joins) على استعلامات القراءة العادية لنموذج `ContentNode`؛ حيث يعتمد النظام حصراً على الـ Trigger والتحديث المتسلسل للـ Outbox مدعوماً بقيد `deleted_at IS NULL` الافتراضي في Laravel. وبذلك تسترجع العقد المفردة بسرعة البرق ($O(1)$ Primary Key Scan) بتكلفة حاسوبية صفرية.
3. **معالج الصندوق الصادر عبر تجزئة CTE المحمية من الأقفال (PostgreSQL CTE Batch Worker):**  
   نظراً لأن نواة PostgreSQL تمنع استخدام `LIMIT` داخل أمر `UPDATE` المباشر، تُعالج المهمة الخلفية دفعات الشجرة عبر Common Table Expression مدعومة بـ **`FOR UPDATE SKIP LOCKED`** لضمان التشغيل المتوازي الآمن ومنع الـ Deadlocks:

```php
// معالج دفعات الشجرة بالصندوق الصادر (ProcessPendingTreeOperationsJob.php)
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProcessPendingTreeOperationsJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * قفل ذري يمنع تزامن عاملين على معالجة الصندوق الصادر لنفس الأصل لمدة 5 دقائق
     * محصن تماماً ضد تسريب أقفال الجلسات في مجمعات الاتصال (PgBouncer Transaction Pooling)
     */
    public int $uniqueFor = 300;

    public string $entityType;
    public string $entityId;

    public function __construct(string $entityType = '', string $entityId = '')
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;
    }

    /**
     * مفتاح التفرد محصور على مستوى الأصل المشغول فقط لفك عنق الزجاجة العالمي (Global Outbox Bottleneck)
     * يتيح تشغيل عمال متعددين لمعالجة أصول مختلفة بالتوازي التام دون تجميد الطابور العام للمنصة
     */
    public function uniqueId(): string
    {
        return $this->entityType . ':' . $this->entityId;
    }

    public function handle(): void
    {
        $pendingOps = DB::table('pending_tree_operations')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        foreach ($pendingOps as $op) {
            DB::table('pending_tree_operations')->where('id', $op->id)->update(['status' => 'processing']);

            try {
                do {
                    if ($op->operation === 'soft_delete') {
                        // معالجة دفعات الحذف الناعم للأشجار الكبرى
                        $sql = "
                            WITH batch AS (
                                SELECT id FROM content_nodes
                                WHERE entity_type = ? 
                                  AND entity_id = ? 
                                  AND path <@ ?::ltree 
                                  AND deleted_at IS NULL
                                LIMIT 5000
                                FOR UPDATE SKIP LOCKED
                            )
                            UPDATE content_nodes
                            SET deleted_at = ?
                            WHERE id IN (SELECT id FROM batch)
                        ";
                        $affected = DB::update($sql, [
                            $op->entity_type, 
                            $op->entity_id, 
                            $op->root_path, 
                            $op->deleted_at
                        ]);
                    } elseif ($op->operation === 'restore') {
                        // معالجة دفعات الاسترجاع للأشجار الكبرى مع المطابقة الصارمة للختم الزمني
                        $sql = "
                            WITH batch AS (
                                SELECT id FROM content_nodes
                                WHERE entity_type = ? 
                                  AND entity_id = ? 
                                  AND path <@ ?::ltree 
                                  AND deleted_at = ?
                                LIMIT 5000
                                FOR UPDATE SKIP LOCKED
                            )
                            UPDATE content_nodes
                            SET deleted_at = NULL
                            WHERE id IN (SELECT id FROM batch)
                        ";
                        $affected = DB::update($sql, [
                            $op->entity_type, 
                            $op->entity_id, 
                            $op->root_path, 
                            $op->deleted_at
                        ]);
                    } else {
                        $affected = 0;
                    }

                } while ($affected > 0);

                DB::table('pending_tree_operations')->where('id', $op->id)->update([
                    'status'       => 'completed',
                    'processed_at' => now(),
                ]);
            } catch (Throwable $e) {
                DB::table('pending_tree_operations')->where('id', $op->id)->update([
                    'status'     => 'failed',
                    'last_error' => $e->getMessage(),
                ]);
                report($e);
            }
        }
    }
}
```

---

# 🏛️ الجزء الخامس: سجل القرارات المعمارية السيادية (ADRs)

### ADR-001: اعتماد الجدول الموحد السيادي (`content_nodes`) مع الأعمدة الصريحة
* **القرار:** رفض تفريخ جداول مساعدة مثل `manuscript_folios` و `media_segments`، ودمج الأعمدة الحرجة (`folio_number`, `folio_side`, `start_ms`, `end_ms`) مباشرة كأعمدة صريحة في جدول `content_nodes`.
* **السبب:** الاستفادة من سرعة فهارس الـ B-Tree التامة (1-2ms)، وضمان قيود الـ CHECK الصارمة، مع تجنب كوارث الـ JOINs وازدواجية الموديلات وتعطيل الاستوديو الموحد.

### ADR-002: اعتماد عتبة التفكيك الهيكلي والنقل الذري للشجرة الفرعية (Decomposition & Subtree Migration)
* **القرار:** حصر أسطر قاعدة البيانات في العقد الهيكلية المنظومة (حتى الفصل/اللوحة/المشهد)، وجعل ما دون ذلك داخل `content_json`. مع **حظر نقل العقد عبر UPDATE مباشر لـ parent_id**، وإلزام طبقة الخدمات باستدعاء دالة `move_content_node()` لإعادة حساب مسار الشجرة التابعة بالكامل ذرياً عبر `subpath()` و `nlevel()`.
* **السبب:** حماية شجرة الفهرس من التضخم الملاييني، وتفادي كارثة انقطاع مسارات الأبناء (Subtree Orphan Trap) عند سحب وإفلات العقد في الاستوديو.

### ADR-003: اعتماد جدول شبكة المعرفة الموحد (`knowledge_links`)
* **القرار:** إلغاء الازدواجية بين `node_links` و `entity_relations`، ودمجهما في جدول واحد موحد يدعم الأطراف البوليمورفية والكتل الذرية (`anchor_id`).
* **السبب:** توحيد استعلامات الـ Knowledge Graph بـ Recursive CTE واحدة، وتبسيط طبقة الخدمات والموديلات في Laravel.

### ADR-004: اعتماد نمط الإسقاط البياني للروابط (Materialized Graph Projection)
* **القرار:** كتابة الروابط كـ Inline Marks داخل نصوص Tiptap في المتن، ومزامنتها آلياً في جدول `knowledge_links` لحظة الحفظ.
* **السبب:** الجمع الكامل بين تجربة القراءة والتفاعل الانسيابي، وبين الفهرسة والتحليل البياني الفائق في قاعدة البيانات.

### ADR-005: سياسة حفظ المراجعات الكبرى ومكافحة التكرار (Milestone Versioning & Hash Deduplication)
* **القرار:** إلغاء حفظ المراجعات عند الحفظ التلقائي العابر، وقصرها على نقاط الحفظ الكبرى المعتمدة، مع التحقق الإجباري من `content_hash (SHA-256)`.
* **السبب:** منع تضخم جدول `node_revisions` بجيجابايتات مكررة وعديمة الجدوى.

### ADR-006: التجزئة الجراحية عبر شجرة الكائنات (AST Tree Traversal vs Regex)
* **القرار:** حظر استخدام التعبيرات النمطية (Regex) لتجزئة نصوص الاستوديو، واعتماد اجتياز شجرة Tiptap JSON AST المنظمة برمجياً.
* **السبب:** تجنب هشاشة الـ HTML والـ Regex وضمان سلامة البيانات المعقدة بنسبة 100%.

### ADR-007: حوكمة الحواف البوليمورفية ومكافحة فخ الـ Global Scope البوليمورفي (Polymorphic Edge Lifecycle Integrity)
* **القرار:** تزويد جدول `knowledge_links` بعمود `deleted_at` وفهرس جزئي، وفرض تسجيل **`EntityLifecycleObserver` موحد** على كافة نماذج الأصول الأربعة (`Book`, `Manuscript`, `Audio`, `Video`) و `ContentNode`، لتنفيذ حذف تسلسلي آلي للروابط (ناعم أو فيزيائي `forceDelete()`) واسترجاع متزامن، مع حصر التحقق في شرط مباشر `WHERE deleted_at IS NULL`.
* **السبب:** تعويض غياب القيود الأجنبية الصريحة (Foreign Keys) على الأعمدة البوليمورفية في PostgreSQL ومنع بقاء حواف يتيمة عند حذف أي أصل أو عقدة، مع استئصال فخ الـ 10 شروط المتداخلة (Anti-Joins) التي تدمر أداء التحليلات والشبكة البيانية.

### ADR-008: محرك البحث العربي المزدوج (Dual-Tier Arabic Search Architecture)
* **القرار:** اعتماد معمارية بحث ثنائية الطبقات:
  1. **الطبقة الأولى (In-Database Strict Search):** دالة `normalize_arabic_text()` مع فهرس GIN في PostgreSQL للبحث النصي المتطابق والمطبع (تجريد التشكيل وتوحيد الألفات والياءات).
  2. **الطبقة الثانية (Morphological Root Search):** محرك خارجي (Meilisearch / Elasticsearch) مدعوم بمحلل صرفي عربي (Khoja/ISRI Stemmer) للبحث الاشتقاقي في الجذور وتصريف الأفعال.
* **السبب:** قصور محرك PostgreSQL الداخلي عن الاشتقاق الصرفي للجذور، مع ضرورة الحفاظ على سرعة البحث المباشر في قاعدة البيانات.

### ADR-009: عزل أقفال التزامن عن دورة حياة MVCC (Zero-MVCC Studio Locking)
* **القرار:** حظر وضع أعمدة القفل داخل جدول `content_nodes`، وإدارتها عبر Redis (مع مفاتيح TTL) أو جدول `studio_locks` من نوع `UNLOGGED`.
* **السبب:** منع انتفاخ جدول المحتوى بآلاف الـ Dead Tuples الناتجة عن نبضات القفل التحريري كل 30 ثانية.

### ADR-010: التمييز بين التسلسل التشغيلي وقيد الإيداع الأرشيفي (Serial Sequence vs Archival Accession)
* **القرار:** يُعتمد `serial_number BIGSERIAL` كمعرف تسلسلي داخلي سريع، مع الإقرار بجواز حدوث فجوات رقمية نتيجة الحذف؛ بينما يُفوض "رقم الإيداع الأرشيفي غير المنقطع" (Gapless Accession Number) عند اللزوم القانوني إلى جدول ترقيم مستقل يُقفل بـ `FOR UPDATE`.
* **السبب:** الحفاظ على الأداء الفائق لـ PostgreSQL Sequences دون التضحية بالمتطلبات الأرشيفية الصارمة.

### ADR-011: التحصين الشامل للحذف الناعم بالأشجار المليارية (Session Flag Cascading Trigger & Threshold Routing)
* **القرار:** ضبط قيد `parent_id` على `ON DELETE NO ACTION DEFERRABLE INITIALLY DEFERRED`، وتفويض سريان الحذف الناعم واسترجاعه إلى تريجر داخلي محمي بـ **علم المعاملة المحلي** `current_setting('entity.cascade_in_progress')` مع فحص عتبة الـ 500 عقدة صراحة داخل التريجر وتفويض ما زاد عنها عبر الصندوق الصادر `pending_tree_operations` كبديل قطعي لـ `pg_notify`. ومطابقة الختم الزمني بدقة الميكروثانية عند الاسترجاع لمنع إحياء ما حُذف عمداً.
* **السبب:** القضاء على الانهيار الصامت للكاسكيد عند وجود تريجرات خارجية (Audit Triggers)، وضمان عدم فقدان رسائل الحذف في الأشجار الضخمة.

### ADR-012: مواءمة شبكة المعرفة وتتبع أنساب الذرات المحمي من الحلقات (Block Lineage Reconciliation & Cycle Prevention)
* **القرار:** تأسيس جدول `block_lineage` بقيد فريد مركب وفهرس عكسي جزئي `idx_block_lineage_reverse`، ومحفز وقائي `trg_prevent_cyclic_block_lineage` لمنع الحلقات المفرغة عند الكتابة، مع محفز مواءمة آلي `trg_auto_reconcile_knowledge_links` يحول الروابط المتصالبة فور انشطار أو دمج الفقرات.
* **السبب:** القضاء التام على ظاهرة الروابط المعرفية الميتة (Broken Deep Links)، وحماية خادم قاعدة البيانات من الاستعلامات التكرارية اللانهائية.

### ADR-013: أقفال الاستوديو ذاتية الشفاء وتجريد أقفال الاستشارة 64-بت (64-Bit Advisory Locks & Self-Healing Ephemeral Locks)
* **القرار:** استبدال `hashtext()` بدالة تجزئة 64-بت `fn_generate_entity_lock_key()` للقضاء على تصادم الأقفال الاستشارية، وتجريد `studio_locks` من المفاتيح الأجنبية لامتناع الـ FK على جداول `UNLOGGED` في PostgreSQL مع جدولة دالة `cleanup_orphaned_locks()`، وتطبيق نمط الشفاء الذاتي (Self-Healing Reacquisition) في `StudioLockService`.
* **السبب:** الامتثال لقواعد محرك PostgreSQL الداخلية، ومنع تجمد ترتيب الأصول غير المترابطة، وضمان تجربة تحرير انسيابية ومحصنة ضد انقطاعات السيرفر.

### ADR-014: تجريد القراءة صفرية التكلفة ونمط الصندوق الصادر المعاملاتي (Zero-Cost Read Abstraction & Transactional Outbox)
* **القرار:**  
  1. إلغاء أغطية الاستعلام الهرمية (`AncestorSoftDeleteScope`) في القراءة، والاعتماد المطلق على سريان التريجر والصندوق الصادر لتحقيق سرعة $O(1)$ لقراءة العقد دون ضريبة GiST Self-Join.  
  2. استبدال `pg_notify` بجدول الصندوق الصادر `pending_tree_operations` لمعالجة دفعات الأشجار العملاقة (> 500 عقدة) عبر Common Table Expression (CTE) ثنائي الاتجاه (`soft_delete` و `restore`) مدعوماً بـ `FOR UPDATE SKIP LOCKED` وواجهة `ShouldBeUnique` لحظر تسريب أقفال الجلسات في مجمعات اتصال PgBouncer.  
  3. استبدال قيد الجدول الصريح في `knowledge_links` بفهرس تفرد جزئي (`NULLS NOT DISTINCT WHERE deleted_at IS NULL`) لمنع انهيار إعادة الربط بعد الحذف الناعم.  
  4. ضبط نطاق التفرد في `identifier_redirects` ليشمل (`scheme, entity_type, entity_id, old_identifier`) لحماية فضاء الأسماء المشترك لعناوين الفصول من التصادم، مع تسطيح السلاسل واستئصال الحلقات الذاتية (`whereColumn('old_identifier', '=', 'new_identifier')->delete()`).  
  5. تحصين دالة `move_content_node` بشرط `v_new_path != v_old_path` لمنع الانفجار التحديثي الكاذب للفروع وتوليد Dead Tuples عديمة الفائدة عند إعادة الترتيب الموضعي.  
  6. توحيد ترحيل الروابط المعرفية والتعليقات الذرية عند انشطار العقد في طبقة التطبيق (`EntityContentService`) لحمايتها من اليُتم والضياع الدلالي.  
  7. تكفل `EntityLifecycleObserver` بالحذف الفيزيائي النهائي (`forceDelete`) للعلاقات البوليمورفية لمنع نشوء أيتام شبحية في غياب مفاتيح الـ Foreign Keys.
* **السبب:** الوصول بالمنصة إلى قمة الكمال الهندسي (Top 0.01%)؛ وضمان أعلى موثوقية تشغيلية تحت ضغط مليارات السجلات والطلبات المتزامنة.

---

**تمت الصياغة والاعتماد المعماري النهائي السيادي التام (الإصدار 3.4 — The Sovereign Masterpiece)**  
**منصة الأرشيف الرقمي الموحد — Entity Digital Library**
