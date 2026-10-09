<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * SeriesController - Refactored to use EntityController Hooks
 */
class SeriesController extends EntityController
{
    //Configuration
    protected function getModelClass(): string { return Series::class; }
    protected function getViewPath(): string { return 'Series'; }
    protected function getRouteName(): string { return 'series'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreSeriesRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateSeriesRequest::class; }

    //Customization
    protected function getRelations(): array { return ['books', 'videos', 'audio', 'manuscripts']; }
    protected function getSearchFields(): array { return ['title', 'description']; }
    protected function getPerPage(): int { return 15; }

    protected function getCreateSuccessMessage(): string { return 'تم إنشاء السلسلة بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث السلسلة بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف السلسلة بنجاح'; }

    /**
     * Attach an entity to the series.
     */
    public function attachEntity(Request $request, Series $series)
    {
        $validated = $request->validate([
            'entity_type' => 'required|string|in:book,video,audio,manuscript',
            'entity_id' => 'required|string',
            'position' => 'nullable|integer',
        ]);

        $modelClass = Relation::getMorphedModel($validated['entity_type']) ?? $validated['entity_type'];
        $entity = $modelClass::findOrFail($validated['entity_id']);

        $series->addEntity($entity, $validated['position'] ?? null);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'series_id' => $series->id,
                'entity_id' => $entity->id,
                'message' => 'تمت إضافة العنصر إلى السلسلة بنجاح',
            ]);
        }

        return back()->with('message', 'تمت إضافة العنصر إلى السلسلة بنجاح');
    }
}
