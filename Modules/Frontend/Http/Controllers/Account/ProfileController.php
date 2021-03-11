<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Account\MediaUpdateRequest;
use Modules\Frontend\Http\Requests\Account\ProfileUpdateRequest;
use Modules\Frontend\Mail\AssistanceRequest;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        $this->seo()->setTitle('Profile settings');

        $user = \Auth::user()->only(['name', 'email']);

        return inertia('Profile', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->only(['name', 'email']);

        if ($password = $request->input('password')) {
            $validated['password'] = \Hash::make($password);
        }

        \Auth::user()->update($validated);

        return back()->with('message', 'Your profile has been updated.');
    }
}
