<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $notes = Note::with(['user', 'entity'])->latest()->get();

        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
            'entity_id' => 'required_without:notable_id|uuid',
            'entity_type' => 'required_without:notable_type|string',
        ]);

        $note = Note::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id() ?? \App\Models\User::first()?->id,
            'entity_id' => $request->input('entity_id') ?? $request->input('notable_id'),
            'entity_type' => $request->input('entity_type') ?? $request->input('notable_type'),
        ]);

        return response()->json([
            'message' => 'تم إضافة الملاحظة بنجاح',
            'data' => $note
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note): JsonResponse
    {
        return response()->json($note->load(['user', 'entity']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note): JsonResponse
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $note->update($request->only('content'));

        return response()->json([
            'message' => 'تم تحديث الملاحظة بنجاح',
            'data' => $note
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): JsonResponse
    {
        $note->delete();

        return response()->json([
            'message' => 'تم حذف الملاحظة بنجاح'
        ]);
    }
}
