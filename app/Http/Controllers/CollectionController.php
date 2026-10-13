<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * CollectionController - Refactored to inherit EntityController
 */
class CollectionController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Collection::class; }
    protected function getViewPath(): string { return 'Collections'; }
    protected function getRouteName(): string { return 'collections'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreCollectionRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateCollectionRequest::class; }

    // Customization
    protected function getRelations(): array
    {
        if (request()->routeIs('collections.index')) {
            return ['user'];
        }
        return ['books', 'videos', 'audio', 'manuscripts', 'user'];
    }

    protected function getWithCount(): array { return ['books', 'videos', 'audio', 'manuscripts']; }
    protected function getSearchFields(): array { return ['name', 'description']; }
    protected function getPerPage(): int { return 15; }

    protected function getCreateSuccessMessage(): string { return 'تم إنشاء المجموعة بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث المجموعة بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف المجموعة بنجاح'; }

    /**
     * Persist Collection with user ownership
     */
    protected function persistModel(Model $model, array $data, Request $request): void
    {
        if (!$model->exists && empty($data['user_id'])) {
            $data['user_id'] = auth()->id() ?? \App\Models\User::first()?->id;
        }
        if (!isset($data['is_public'])) {
            $data['is_public'] = false;
        }
        $model->fill($data);
        $model->save();
    }

    /**
     * Redirect to collections.index after update
     */
    protected function getUpdateRedirect(Model $model): RedirectResponse
    {
        return redirect()->route('collections.index')
            ->with('message', $this->getUpdateSuccessMessage());
    }

    /**
     * Attach an entity to the collection.
     */
    public function attachEntity(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'entity_type' => 'required|string|in:book,video,audio,manuscript',
            'entity_id' => 'required|string',
        ]);

        $modelClass = \Illuminate\Database\Eloquent\Relations\Relation::getMorphedModel($validated['entity_type']) ?? $validated['entity_type'];
        $entity = $modelClass::findOrFail($validated['entity_id']);

        $collection->addEntity($entity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'collection_id' => $collection->id,
                'entity_id' => $entity->id,
                'message' => 'تمت إضافة العنصر إلى المجموعة بنجاح',
            ]);
        }

        return back()->with('message', 'تمت إضافة العنصر إلى المجموعة بنجاح');
    }
}
