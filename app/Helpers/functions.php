<?php

if (!function_exists('asset_admin')) {
    function asset_admin($path)
    {
        return url("admin/$path");
    }
}

if (!function_exists('form_was_validated')) {
    function form_was_validated(Illuminate\Support\ViewErrorBag $errors = null): string
    {
        if ($errors == null)
            $errors = Session('errors');

        if ($errors && $errors->isNotEmpty())
            return $errors->isNotEmpty() ? 'was-validated' : '';

        return '';
    }
}

if (!function_exists('valid_class')) {
    function valid_class(string $name, Illuminate\Support\ViewErrorBag $errors = null): string
    {
        if ($errors == null)
            $errors = Session('errors');

        if ($errors && $errors->isNotEmpty())
            return !$errors->has($name) ?: 'is-invalid';

        return '';
    }
}

function get_admins_mails(): array
{
    return array_map(fn($e) => trim($e), explode(',', setting('emails_for_messages')));
}

function checked($name, $default = false)
{
    return old($name, $default) ? 'checked' : '';
}

function radio_checked($name, $value)
{
    return old($name) == $value ? 'checked' : '';
}

function selected($name, $value, $old = null): string
{
    if (old($name) == $value || ($old !== null && $value == $old)) {
        echo 'selected';
    }
    return '';
}

function is_valid(string $name): string
{
    return valid_class($name);
}
