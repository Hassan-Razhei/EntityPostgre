<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Api\SegmentController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookContentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentNodeController;
use App\Http\Controllers\DeletionController;
use App\Http\Controllers\EditorTestController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ManuscriptController;
use App\Http\Controllers\MediaStreamController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ShelfController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UnifiedEditorController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::post('logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 2. Media Streaming Engine (HTTP Range & Seeking Support)
|--------------------------------------------------------------------------
*/
Route::prefix('stream')->name('stream.')->group(function () {
    Route::get('videos/{path}', [MediaStreamController::class, 'streamVideo'])
        ->where('path', '.*')
        ->name('video');

    Route::get('audio/{path}', [MediaStreamController::class, 'streamAudio'])
        ->where('path', '.*')
        ->name('audio');
});

/*
|--------------------------------------------------------------------------
| 3. Authenticated Core Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active'])->group(function () {

    // --- Unified Dashboard & Search ---
    Route::redirect('/dashboard', '/superadmin/dashboard')->name('dashboard');
    Route::get('/search', [GlobalSearchController::class, 'index'])->name('search');

    /*
    |--------------------------------------------------------------------------
    | 4. Sovereign Studio & Smart Editor (Entity Studio)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:transcriber,editor,chief_editor,super_admin'])->group(function () {
        Route::prefix('studio')->name('studio.')->group(function () {
            Route::get('resume', [UnifiedEditorController::class, 'resume'])->name('resume');
            Route::get('{type}/{slug}/{childId?}', [UnifiedEditorController::class, 'show'])->name('show');
            Route::post('{type}/{slug}/{childId?}/save', [UnifiedEditorController::class, 'save'])->name('save');
            Route::post('{type}/{slug}/{childId}/restore/{versionIndex}', [UnifiedEditorController::class, 'restoreVersion'])->name('restore');
            Route::post('{type}/{slug}/nodes', [ContentNodeController::class, 'store'])->name('nodes.store');
        });

        // Studio API Endpoints
        Route::prefix('api')->name('api.')->group(function () {
            Route::post('book-children/{id}/save', [BookContentController::class, 'updateValidation'])->name('book-children.save');
            Route::post('book-children/{id}/restore/{version?}', [BookContentController::class, 'restoreVersion'])->name('book-children.restore');

            Route::post('segments', [SegmentController::class, 'store'])->name('segments.store');
            Route::put('segments/{id}', [SegmentController::class, 'update'])->name('segments.update');
            Route::delete('segments/{id}', [SegmentController::class, 'destroy'])->name('segments.destroy');
        });

        Route::get('/editor-test', [EditorTestController::class, 'index'])->name('editor.test');
    });

    /*
    |--------------------------------------------------------------------------
    | 5. Super Admin Cockpit & Console (Super Admin Only)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/superadmin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('superadmin.dashboard');

        Route::prefix('api/system')->name('api.system.')->group(function () {
            Route::post('run-command', [SystemController::class, 'runCommand'])->name('run-command');
            Route::post('list-files', [SystemController::class, 'listFiles'])->name('list-files');
        });

        Route::get('/system/commands', function () {
            return Inertia\Inertia::render('System/Commands');
        })->name('system.commands');
    });

    /*
    |--------------------------------------------------------------------------
    | 6. Primary Digital Entities (Books, Manuscripts, Audio, Video)
    |--------------------------------------------------------------------------
    */
    // Books
    Route::resource('books', BookController::class);
    Route::get('books/{book}/editor/{child}', [BookController::class, 'editor'])->name('books.editor');
    Route::get('books/{book}/reader/{child?}', [BookContentController::class, 'show'])->name('books.reader');
    Route::get('book-contents/{child}', [BookContentController::class, 'getChildContent'])->name('book-contents.show');

    // Manuscripts
    Route::resource('manuscripts', ManuscriptController::class);
    Route::get('manuscripts/{manuscript}/editor/{child}', [ManuscriptController::class, 'editor'])->name('manuscripts.editor');

    // Audio
    Route::resource('audios', AudioController::class);
    Route::get('audios/{audio}/editor/{child}', [AudioController::class, 'editor'])->name('audios.editor');

    // Video
    Route::resource('videos', VideoController::class);
    Route::get('videos/{video}/editor/{child}', [VideoController::class, 'editor'])->name('videos.editor');

    /*
    |--------------------------------------------------------------------------
    | 7. Ecosystem & Taxonomies (with Bulk Destroy)
    |--------------------------------------------------------------------------
    */
    Route::post('authors/bulk-destroy', [AuthorController::class, 'bulkDestroy'])->name('authors.bulk-destroy');
    Route::post('authors/{author}/restore', [AuthorController::class, 'restore'])->name('authors.restore');
    Route::delete('authors/{author}/force-delete', [AuthorController::class, 'forceDelete'])->name('authors.force-delete');
    Route::resource('authors', AuthorController::class);

    Route::post('publishers/bulk-destroy', [PublisherController::class, 'bulkDestroy'])->name('publishers.bulk-destroy');
    Route::resource('publishers', PublisherController::class);

    Route::post('bookers/bulk-destroy', [BookerController::class, 'bulkDestroy'])->name('bookers.bulk-destroy');
    Route::resource('bookers', BookerController::class);

    Route::post('categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::resource('categories', CategoryController::class);

    Route::post('tags/bulk-destroy', [TagController::class, 'bulkDestroy'])->name('tags.bulk-destroy');
    Route::resource('tags', TagController::class);

    Route::post('topics/bulk-destroy', [TopicController::class, 'bulkDestroy'])->name('topics.bulk-destroy');
    Route::resource('topics', TopicController::class);

    Route::post('languages/bulk-destroy', [LanguageController::class, 'bulkDestroy'])->name('languages.bulk-destroy');
    Route::resource('languages', LanguageController::class);

    Route::post('shelves/bulk-destroy', [ShelfController::class, 'bulkDestroy'])->name('shelves.bulk-destroy');
    Route::resource('shelves', ShelfController::class);

    Route::post('series/bulk-destroy', [SeriesController::class, 'bulkDestroy'])->name('series.bulk-destroy');
    Route::resource('series', SeriesController::class);

    Route::resource('collections', CollectionController::class);

    /*
    |--------------------------------------------------------------------------
    | 8. Interactions, Timeline & Trash Bin
    |--------------------------------------------------------------------------
    */
    Route::resource('activities', ActivityController::class)->only(['index', 'show']);
    Route::resource('comments', CommentController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('deletions', DeletionController::class)->only(['index', 'show']);

    /*
    |--------------------------------------------------------------------------
    | 9. Reader Technology (Authenticated Tracking)
    |--------------------------------------------------------------------------
    */
    Route::get('/reader/{type}/{slug}/search', [ReaderController::class, 'search'])
        ->name('reader.search');
    Route::post('/api/reader/position', [ReaderController::class, 'savePosition'])
        ->name('reader.save-position');
});

/*
|--------------------------------------------------------------------------
| 10. Public Reader & Development Sandboxes
|--------------------------------------------------------------------------
*/
Route::get('/reader/{type}/{slug}/{childId?}', [ReaderController::class, 'show'])
    ->name('reader.show');

Route::get('/dev/editor', function () {
    return \Inertia\Inertia::render('Technologies/Editor/Sandbox');
})->name('dev.editor');

Route::get('/dev/player/{type}/{slug}', function ($type, $slug) {
    $modelClass = match ($type) {
        'audio' => \App\Models\Audio::class,
        'video' => \App\Models\Video::class,
        default => abort(404, 'Media type not found'),
    };

    $media = $modelClass::where('slug', $slug)->with(['authors', 'versions.publisher'])->firstOrFail();

    return \Inertia\Inertia::render('Technologies/Player/Sandbox', [
        'media' => $media,
        'type' => $type
    ]);
})->name('dev.player');

Route::get('/dev/manuscripter/{manuscript:slug}', [ManuscriptController::class, 'sandbox'])->name('dev.manuscripter');
