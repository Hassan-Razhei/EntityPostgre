<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * NoteController - Refactored to inherit EntityController
 */
class NoteController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Note::class; }
    protected function getViewPath(): string { return 'Notes'; }
    protected function getRouteName(): string { return 'notes'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreNoteRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateNoteRequest::class; }

    // Customization
    protected function getRelations(): array { return ['user', 'entity']; }
    protected function getSearchFields(): array { return ['content']; }
    protected function getPerPage(): int { return 10; }

    protected function getCreateSuccessMessage(): string { return 'تم إضافة الملاحظة بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث الملاحظة بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف الملاحظة بنجاح'; }

    /**
     * Persist Note with user ownership
     */
    protected function persistModel(Model $model, array $data, Request $request): void
    {
        if (!$model->exists && empty($data['user_id'])) {
            $data['user_id'] = auth()->id() ?? \App\Models\User::first()?->id;
        }
        $model->fill($data);
        $model->save();
    }
}
