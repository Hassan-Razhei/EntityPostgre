<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * CommentController - Refactored to inherit EntityController
 */
class CommentController extends EntityController
{
    // Configuration
    protected function getModelClass(): string { return Comment::class; }
    protected function getViewPath(): string { return 'Comments'; }
    protected function getRouteName(): string { return 'comments'; }
    protected function getStoreRequestClass(): ?string { return \App\Http\Requests\StoreCommentRequest::class; }
    protected function getUpdateRequestClass(): ?string { return \App\Http\Requests\UpdateCommentRequest::class; }

    // Customization
    protected function getRelations(): array { return ['user', 'entity']; }
    protected function getSearchFields(): array { return ['content']; }
    protected function getPerPage(): int { return 10; }

    protected function getCreateSuccessMessage(): string { return 'تم إضافة التعليق بنجاح'; }
    protected function getUpdateSuccessMessage(): string { return 'تم تحديث التعليق بنجاح'; }
    protected function getDeleteSuccessMessage(): string { return 'تم حذف التعليق بنجاح'; }

    /**
     * Persist Comment with user ownership
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
