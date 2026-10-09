<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص بوابة قمرة قيادة السوبر أدمن (Proof of Concept)
 * المسار: /superadmin/dashboard
 * المكون: AdminDashboard
 */
class SuperAdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $editor;
    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        $this->superAdmin = User::factory()->superAdmin()->create();
        $this->editor = User::factory()->editor()->create();
        $this->viewer = User::factory()->create();
    }

    #[Test]
    public function it_redirects_unauthenticated_guests_to_login(): void
    {
        $response = $this->get('/superadmin/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function it_forbids_non_super_admin_users_from_accessing_dashboard(): void
    {
        // المحرر يُمنع بـ 403
        $this->actingAs($this->editor)
            ->get('/superadmin/dashboard')
            ->assertStatus(403);

        // المستخدم العادي يُمنع بـ 403
        $this->actingAs($this->viewer)
            ->get('/superadmin/dashboard')
            ->assertStatus(403);
    }

    #[Test]
    public function it_allows_super_admin_to_access_and_renders_admin_dashboard_component(): void
    {
        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
            );
    }

    #[Test]
    public function it_shares_live_database_statistics_and_recent_activities_to_admin_dashboard(): void
    {
        // تجهيز بيانات اختبارية حقيقية
        Book::factory()->count(5)->create();
        Manuscript::factory()->count(3)->create();
        Audio::factory()->count(4)->create();
        Video::factory()->count(2)->create();
        Author::factory()->count(6)->create();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->has('stats', fn (Assert $stats) => $stats
                    ->where('books', 5)
                    ->where('manuscripts', 3)
                    ->where('audios', 4)
                    ->where('videos', 2)
                    ->where('authors', 6)
                    ->etc()
                )
                ->has('recentActivities')
            );
    }

    #[Test]
    public function it_shares_recent_users_and_accurate_deletions_count_to_admin_dashboard(): void
    {
        // تجهيز أصول محذوفة ناعماً (Soft Deleted)
        $b1 = Book::factory()->create();
        $b2 = Book::factory()->create();
        $b1->delete();
        $b2->delete();

        $a1 = Author::factory()->create();
        $a1->delete();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->where('stats.deletions', 3)
                ->has('recentUsers', 3) // المستخدمون الثلاثة المنشأون في setUp
            );
    }

    #[Test]
    public function it_shares_live_books_data_to_admin_dashboard(): void
    {
        $book = Book::factory()->create([
            'title' => 'مقدمة ابن خلدون',
            'slug' => 'muqaddimah-ibn-khaldun',
            'author' => 'ابن خلدون',
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->has('books', 1)
                ->where('books.0.title', 'مقدمة ابن خلدون')
                ->where('books.0.slug', 'muqaddimah-ibn-khaldun')
                ->where('books.0.author', 'ابن خلدون')
                ->where('books.0.reader_url', '/books/muqaddimah-ibn-khaldun/reader')
                ->where('books.0.studio_url', '/studio/book/muqaddimah-ibn-khaldun')
            );
    }

    #[Test]
    public function it_shares_all_live_entities_and_deletions_to_admin_dashboard(): void
    {
        $manuscript = Manuscript::factory()->create([
            'title' => 'مخطوط صحيح البخاري',
            'slug' => 'sahih-bukhari-ms',
            'code' => 'MS-BKH-01',
        ]);

        $audio = Audio::factory()->create([
            'title' => 'شرح المقدمة الآجرومية',
            'slug' => 'sharh-ajrumiyyah',
            'code' => 'AUD-AJR-01',
        ]);

        $video = Video::factory()->create([
            'title' => 'مجلس علوم الحديث',
            'slug' => 'majlis-hadith',
            'code' => 'VID-HDT-01',
        ]);

        $author = Author::factory()->create([
            'name' => 'الحافظ ابن حجر',
            'slug' => 'ibn-hajar',
        ]);

        $publisher = \App\Models\Publisher::factory()->create([
            'name' => 'دار الرسالة العالمية',
            'slug' => 'dar-al-risalah',
        ]);

        // كيان محذوف ناعماً
        $deletedBook = Book::factory()->create(['title' => 'كتاب محذوف للتجربة']);
        $deletedBook->delete();

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->has('manuscripts', 1)
                ->where('manuscripts.0.title', 'مخطوط صحيح البخاري')
                ->where('manuscripts.0.code', 'MS-BKH-01')
                ->has('audios', 1)
                ->where('audios.0.title', 'شرح المقدمة الآجرومية')
                ->where('audios.0.code', 'AUD-AJR-01')
                ->has('videos', 1)
                ->where('videos.0.title', 'مجلس علوم الحديث')
                ->where('videos.0.code', 'VID-HDT-01')
                ->has('authors', 1)
                ->where('authors.0.name', 'الحافظ ابن حجر')
                ->has('publishers', 1)
                ->where('publishers.0.name', 'دار الرسالة العالمية')
                ->has('deletions', 1)
                ->where('deletions.0.title', 'كتاب محذوف للتجربة')
            );
    }

    #[Test]
    public function it_shares_live_categories_tags_versions_and_studio_data(): void
    {
        $category = \App\Models\Category::factory()->create([
            'name' => 'علوم الحديث النبوي',
            'slug' => 'ulum-al-hadith',
        ]);

        $tag = \App\Models\Tag::factory()->create([
            'name' => 'نادر ونفيس',
            'slug' => 'nader-wa-nafees',
        ]);

        $book = Book::factory()->create([
            'title' => 'فتح الباري بشرح صحيح البخاري',
            'slug' => 'fath-al-bari',
        ]);

        $version = \App\Models\Version::factory()->create([
            'versionable_type' => 'book',
            'versionable_id' => $book->id,
            'title' => 'طبعة بولاق الأولى',
            'edition_number' => 1,
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->has('categories')
                ->where('categories.0.name', 'علوم الحديث النبوي')
                ->has('tags')
                ->where('tags.0.name', 'نادر ونفيس')
                ->has('versions')
                ->where('versions.0.title', 'طبعة بولاق الأولى')
                ->has('studioBooks')
                ->where('studioBooks.0.title', 'فتح الباري بشرح صحيح البخاري')
                ->has('stats.studio_books')
                ->has('stats.funnel_drafts')
            );
    }

    #[Test]
    public function it_shares_live_collections_series_and_topics_data(): void
    {
        $collection = \App\Models\Collection::factory()->create([
            'name' => 'خزانة التراث الأندلسي',
            'description' => 'مختارات من نوادر المخطوطات والكتب الأندلسية',
            'is_public' => true,
        ]);

        $series = \App\Models\Series::factory()->create([
            'title' => 'سلسلة أعلام الحديث',
            'description' => 'موسوعة تراجم أئمة الرواية والدراية',
        ]);

        $topic = \App\Models\Topic::factory()->create([
            'name' => 'فقه المعاملات المالية المعاصرة',
            'slug' => 'contemporary-financial-fiqh',
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->get('/superadmin/dashboard');

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('AdminDashboard/Index')
                ->has('collections')
                ->where('collections.0.name', 'خزانة التراث الأندلسي')
                ->has('series')
                ->where('series.0.title', 'سلسلة أعلام الحديث')
                ->has('topics')
                ->where('topics.0.name', 'فقه المعاملات المالية المعاصرة')
                ->where('stats.collections', 1)
                ->where('stats.series', 1)
                ->where('stats.topics', 1)
            );
    }
}

