<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Account\LoginRequest;
use Modules\Frontend\Http\Requests\Account\RegistrationRequest;
use Modules\Frontend\Notifications\ResetPassword;

class AuthController extends Controller
{
    public function login()
    {
        $this->seo()->setTitle('Sign in');

        return inertia('Login');
    }

    public function tryLogin(LoginRequest $request): Response
    {
        $request->authenticate();

        if (!$request->user()->hasRole('media-user')) {
            \Auth::logout();
            $request->session()->invalidate();

            throw ValidationException::withMessages([
                'email' => 'You are not registered as public media.',
            ]);
        }

        $request->session()->regenerate();

        return inertia()->location(route('frontend.account.media.edit'));
    }

    public function register()
    {
        $this->seo()->setTitle('Sign up');

        return inertia('Register');
    }

    public function tryRegister(RegistrationRequest $request): Response
    {
        $data = $request->only(['name', 'email']);
        $password = \Hash::make($request->input('password'));

        $user = User::create(array_merge($data, [
            'name' => $request->input('name'),
            'password' => $password
        ]));

        $user->assignRole('media-user');

        $mediaData = $request->only(['media_name', 'url', 'facebook', 'phone']);
        $mediaData['name'] = $mediaData['media_name'];
        unset($mediaData['media_name']);

        $user->mediaInformation()->create($mediaData);

        \Auth::guard()->login($user);

        return inertia()->location(route('frontend.account.media.edit'));
    }

    public function logout(Request $request): Response
    {
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return inertia()->location(back()->getTargetUrl());
    }

    public function resetPassword()
    {
        $this->seo()->setTitle('Password reset');

        return inertia('ResetPassword');
    }

    public function tryResetPassword(Request $request): RedirectResponse
    {
        $this->validate($request, ['email' => ['required', 'email', 'exists:users,email']]);

        if ($user = User::where('email', '=', $request->email)->first()) {
            $password = \Str::random(8);
            if ($user->update(['password' => \Hash::make($password)])) {
                $user->notify(new ResetPassword($password));
                $user->tokens()->delete();
            }
        }

        return back();
    }
}
