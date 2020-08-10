<?php

/**
 * @apiDefine User
 * @apiSuccess {Object} user Registered user.
 * @apiSuccess {Number} user.id User id.
 * @apiSuccess {String} user.name User name.
 * @apiSuccess {String} user.email User email.
 * @apiSuccess {String} user.bio User biography.
 * @apiSuccess {String} user.avatar User avatar.
 * @apiSuccess {Object} user.country User country.
 * @apiSuccess {Number} user.country.id Country id.
 * @apiSuccess {String} user.country.name Country name.
 */

/**
 * @apiDefine Token
 * @apiHeader  Authorization Bearer token from register|login.
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Authorization": "Bearer 21*|1BH99*"
 *     }
 */

namespace Modules\Api\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\Users\RegistrationRequest;
use Modules\Api\Http\Resources\UserResource;
use Modules\Api\Notifications\ResetPassword;
use Str;

/**
 * @group User
 */
class UserController extends Controller
{
    /**
     * @api {post} /users/register Register a new user
     * @apiName RegisterUser
     * @apiGroup User
     *
     * @apiParam {String} name User name.
     * @apiParam {String} email User email.
     * @apiParam {String} password User password.
     * @apiParam {File}   [avatar] User avatar file.
     * @apiParam {String} [bio] User biography.
     * @apiParam {String} [country_id] User country id.
     * @apiParam {String} device Device name for token generation.
     *
     * @apiUse User
     * @apiSuccess {String} token Bearer Token.
     */
    public function register(RegistrationRequest $request)
    {
        $validated = $request->only(['name', 'email']);
        $password = Hash::make($request->input('password'));

        $user = User::create(array_merge($validated, [
            'password' => $password
        ]));

        $user->information()->create($request->only(['country_id', 'bio']));
        $user->load('information.country');

        $user->assignRole('mobile-user');

        if ($request->hasFile('avatar')) {
            $user->uploadAvatar($request->file('avatar'));
            $user->load('avatarMedia');
        }

        return $this->userWithToken($user, $request->input('device'));
    }

    /**
     * @api {post} /users/login Login
     * @apiName LoginUser
     * @apiGroup User
     *
     * @apiParam {String} email User email.
     * @apiParam {String} password User password.
     * @apiParam {String} device Device name for token generation.
     *
     * @apiUse User
     * @apiSuccess {String} token Bearer Token.
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device' => ['required', 'string']
        ]);

        if (Auth::once($request->only(['email', 'password']))) {
            $user = Auth::getUser();
            $user->load(['avatarMedia', 'information.country']);

            return $this->userWithToken($user, $request->input('device'));
        } else {
            $this->response->errorUnauthorized(trans('auth.failed'));
        }
    }

    /**
     * @api {get} /users/self Get user data
     * @apiName GetSelf
     * @apiGroup User
     *
     * @apiUse Token
     *
     * @apiUse User
     */
    public function self(Request $request)
    {
        /* @var $user User */
        $user = $request->user();
        $user->load(['avatarMedia', 'information.country']);
        return new UserResource($user);
    }

    /**
     * @api {patch} /users/update Update a user
     * @apiName UpdateUser
     * @apiGroup User
     *
     * @apiUse Token
     *
     * @apiParam {String} name User name.
     * @apiParam {String} email User email.
     * @apiParam {String} [password] User password.
     * @apiParam {File}   [avatar] User avatar file.
     * @apiParam {String} [bio] User biography.
     * @apiParam {String} [country_id] User country id.
     * @apiParam {String} _method=patch Should be provided to use PATCH method.
     *
     * @apiUse User
     * @apiSuccess {String} token Bearer Token.
     */
    public function update(RegistrationRequest $request)
    {
        $validated = $request->only(['name', 'email']);

        /* @var $user User */
        $user = $request->user();
        $user->fill($validated);

        if ($request->has('password')) {
            $password = Hash::make($request->input('password'));
            $user->password = $password;
        }

        $user->save();

        $user->information()->update($request->only(['country_id', 'bio']));
        $user->load('information.country');

        if ($request->hasFile('avatar')) {
            $user->uploadAvatar($request->file('avatar'));
            $user->load('avatarMedia');
        }

        return new UserResource($user);
    }

    /**
     * @api {post} /users/reset-password Reset passwords
     * @apiName ResetPassword
     * @apiGroup User
     *
     * @apiParam {String} email User email.
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = User::whereEmail($request->input('email'))->first();
        if ($user !== null) {
            $password = Str::random(8);
            if ($user->update(['password' => Hash::make($password)]))
                $user->notify(new ResetPassword($password));
        }
        return ['message' => 'New password has been sent to your email'];
    }

    protected function userWithToken(User $user, string $device)
    {
        $token = $user->createToken($device);
        return [
            'user' => new UserResource($user),
            'token' => $token->plainTextToken
        ];
    }
}
