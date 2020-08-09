<?php


namespace App\Helpers\Accessors;


class ModelsMultiselect
{
    public function handle($value): array
    {
        return explode(',', $value);
    }
}
