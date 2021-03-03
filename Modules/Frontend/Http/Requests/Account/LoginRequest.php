<?php

namespace Modules\Frontend\Http\Requests\Account;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'rememberMe' => ['nullable', 'boolean']
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!$this->try()) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return 'login-' . $this->ip();
    }

    public function try(): bool
    {
        return \Auth::attempt(
            $this->only('email', 'password'),
            $this->filled('rememberMe')
        );
    }

    public function authorize(): bool
    {
        return true;
    }
}
