<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

/**
 * LanguageController - Refactored to inherit EntityController
 */
class LanguageController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Language::class; }
    protected function getViewPath(): string { return 'Languages'; }
    protected function getRouteName(): string { return 'languages'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreLanguageRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateLanguageRequest::class; }

    // Customization
    protected function getRelations(): array { return []; }
    protected function getWithCount(): array { return ['books', 'videos', 'audios', 'manuscripts']; }
    protected function getSearchFields(): array { return ['name', 'code']; }
    protected function getPerPage(): int { return 12; }

    protected function getCreateSuccessMessage(): string { return 'تم إضافة اللغة بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث اللغة بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف اللغة بنجاح'; }

    protected function getUpdateRedirect(\Illuminate\Database\Eloquent\Model $model): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('languages.index')
            ->with('message', $this->getUpdateSuccessMessage());
    }
}
