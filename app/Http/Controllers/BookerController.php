<?php

namespace App\Http\Controllers;

use App\Models\Booker;
use App\Helpers\SlugHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * BookerController - Refactored to inherit EntityController
 */
class BookerController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Booker::class; }
    protected function getViewPath(): string { return 'Bookers'; }
    protected function getRouteName(): string { return 'bookers'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreBookerRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateBookerRequest::class; }

    // Customization
    protected function getRelations(): array { return ['books', 'videos', 'audios', 'manuscripts']; }
    protected function getWithCount(): array { return ['books', 'videos', 'audios', 'manuscripts']; }
    protected function getSearchFields(): array { return ['name']; }
    protected function getPerPage(): int { return 12; }

    protected function getCreateSuccessMessage(): string { return 'تم إضافة المساهم بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث بيانات المساهم بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف المساهم بنجاح'; }

    /**
     * Persist Booker with automatic slug generation
     */
    protected function persistModel(Model $model, array $data, Request $request): void
    {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = SlugHelper::generate($data['name']);
        }
        $model->fill($data);
        $model->save();
    }

    protected function getUpdateRedirect(Model $model): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('bookers.index')
            ->with('message', $this->getUpdateSuccessMessage());
    }
}
