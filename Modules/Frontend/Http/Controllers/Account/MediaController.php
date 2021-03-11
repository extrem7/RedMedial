<?php

namespace Modules\Frontend\Http\Controllers\Account;

use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Account\MediaUpdateRequest;
use Modules\Frontend\Mail\AssistanceRequest;

class MediaController extends Controller
{
    public function edit(): Response
    {
        $this->seo()->setTitle('Complete profile');

        $information = $this->getInformation();
        $information = $information->only([...$information->fillable, 'logo', 'statistic']);

        return inertia('Media', compact('information'));
    }

    public function update(MediaUpdateRequest $request): RedirectResponse
    {
        $information = $this->getInformation();
        $this->getInformation()->update($request->only($information->fillable));

        if ($request->hasFile('statisticImage')) {
            $information->clearMediaCollection('statistic');
            $information->addMedia($request->file('statisticImage'))->toMediaCollection('statistic');
        }

        return back()->with('message', 'Your profile has been updated.');
    }

    public function updateLogo(Request $request, User $user): RedirectResponse
    {
        ['logo' => $logo] = $this->validate($request, [
            'logo' => ['required', 'image', 'max:2048']
        ]);

        $information = $this->getInformation();
        $this->getInformation()->clearMediaCollection('logo');
        $information->addMedia($logo)->toMediaCollection('logo');

        return back();
    }

    public function destroyLogo(User $user): RedirectResponse
    {
        $this->getInformation()->clearMediaCollection('logo');

        return redirect()->back();
    }

    public function destroyStatistic(): RedirectResponse
    {
        $this->getInformation()->clearMediaCollection('statistic');

        return back()->with('message', 'Statistic screenshot has been deleted.');
    }

    public function assistance(): RedirectResponse
    {
        \Mail::to(get_admins_mails())->send(new AssistanceRequest(\Auth::user()));

        return back()->with('message', 'Your request has been sent to administrator.');
    }

    protected function getInformation(): User\MediaInformation
    {
        return \Auth::user()->mediaInformation;
    }
}
