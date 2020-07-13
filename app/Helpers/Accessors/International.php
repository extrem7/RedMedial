<?php


namespace App\Helpers\Accessors;


class International
{
    public function handle($value): array
    {
        return explode(',', $value);
    }
}
