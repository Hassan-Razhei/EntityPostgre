<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $comments = Comment::with(['user', 'entity'])->latest()->get();

        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
            'entity_id' => 'required_without:commentable_id|uuid',
            'entity_type' => 'required_without:commentable_type|string',
        ]);

        $comment = Comment::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id() ?? \App\Models\User::first()?->id,
            'entity_id' => $request->input('entity_id') ?? $request->input('commentable_id'),
            'entity_type' => $request->input('entity_type') ?? $request->input('commentable_type'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return response()->json([
            'message' => 'تم إضافة التعليق بنجاح',
            'data' => $comment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json($comment->load(['user', 'entity']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $comment->update($request->only('content'));

        return response()->json([
            'message' => 'تم تحديث التعليق بنجاح',
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'message' => 'تم حذف التعليق بنجاح'
        ]);
    }
}
