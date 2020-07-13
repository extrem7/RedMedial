<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        $array = [
            'data' => $this->collection,
        ];
        if ($this->resource instanceof LengthAwarePaginator) {
            $array['lastPage'] = $this->resource->lastPage();
            $array['currentPage'] = $this->resource->currentPage();
        }
        return $array;
    }
}
