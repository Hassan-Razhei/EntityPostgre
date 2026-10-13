<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Video;
use App\Services\EntityManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    protected $manager;

    public function __construct(EntityManagerService $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $videos = Video::query()->paginate($perPage);

        return response()->json($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();
        $data['type'] = 'video';

        $video = $this->manager->create($data);

        return response()->json([
            'message' => 'تم إنشاء الفيديو بنجاح',
            'data' => $video
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video): JsonResponse
    {
        return response()->json($video->load(['tags', 'categories', 'comments']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video): JsonResponse
    {
        $this->manager->update($video, $request->all());

        return response()->json([
            'message' => 'تم تحديث الفيديو بنجاح',
            'data' => $video
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video): JsonResponse
    {
        $this->manager->delete($video);

        return response()->json([
            'message' => 'تم حذف الفيديو بنجاح'
        ]);
    }
}
