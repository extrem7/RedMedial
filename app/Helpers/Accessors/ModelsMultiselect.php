<?php


namespace App\Helpers\Accessors;


class ModelsMultiselect
{
    public function handle($value): array
    {
        return array_map(fn($id) => intval($id), explode(',', $value));
    }
}
