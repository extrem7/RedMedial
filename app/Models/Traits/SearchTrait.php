<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait SearchTrait
{
    /**
     * @param Builder|static $query
     * @return Builder|static
     */
    public static function scopeSearch($query, string $keyword, bool $matchAllFields = false)
    {
        return static::where(function ($query) use ($keyword, $matchAllFields) {
            foreach (static::getSearchFields() as $field) {
                if ($matchAllFields) {
                    $query->where($field, 'LIKE', "%$keyword%");
                } else {
                    $query->orWhere($field, 'LIKE', "%$keyword%");
                }
            }
        });
    }

    public static function getSearchFields(): array
    {
        $model = new static;

        $fields = $model->search;

        if (empty($fields)) {
            $fields = Schema::getColumnListing($model->getTable());

            $others[] = $model->primaryKey;

            $others[] = $model->getUpdatedAtColumn() ?: 'created_at';
            $others[] = $model->getCreatedAtColumn() ?: 'updated_at';
            $others[] = 'category_id';
            $others[] = 'status';
            $others[] = 'user_id';
            $others[] = 'views';

            $others[] = method_exists($model, 'getDeletedAtColumn')
                ? $model->getDeletedAtColumn()
                : 'deleted_at';

            $fields = array_diff($fields, $model->getHidden(), $others);
        }

        return $fields;
    }
}
