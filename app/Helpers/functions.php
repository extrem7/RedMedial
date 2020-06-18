<?php

if (!function_exists('asset_admin')) {
    function asset_admin($path)
    {
        return url("admin/$path");
    }
}
