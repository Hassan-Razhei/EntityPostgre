<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use Illuminate\Http\Request;

/**
 * ShelfController - Refactored to inherit EntityController
 */
class ShelfController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Shelf::class; }
    protected function getViewPath(): string { return 'Shelves'; }
    protected function getRouteName(): string { return 'shelves'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreShelfRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateShelfRequest::class; }

    // Customization
    protected function getRelations(): array { return ['versions.versionable']; }
    protected function getWithCount(): array { return ['versions']; }
    protected function getSearchFields(): array { return ['location_code']; }
    protected function getPerPage(): int { return 12; }

    protected function getCreateSuccessMessage(): string { return 'تم إنشاء الرف بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث الرف بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف الرف بنجاح'; }

    protected function getUpdateRedirect(\Illuminate\Database\Eloquent\Model $model): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('shelves.index')
            ->with('message', $this->getUpdateSuccessMessage());
    }
}
