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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\Users\RegistrationRequest;
use Modules\Api\Http\Requests\Users\UpdateRequest;
use Modules\Api\Http\Resources\UserResource;
use Modules\Api\Notifications\ResetPassword;

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
    public function register(RegistrationRequest $request): JsonResponse
    {
        $validated = $request->only(['name', 'email']);
        $password = \Hash::make($request->input('password'));

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
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device' => ['required', 'string']
        ]);

        if (\Auth::once($request->only(['email', 'password'])) && $user = \Auth::user()) {

            $user->load(['avatarMedia', 'information.country']);

            return $this->userWithToken($user, $request->input('device'));
        }

        $this->response->errorUnauthorized(trans('auth.failed'));
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
    public function self(Request $request): JsonResponse
    {
        /* @var $user User */
        $user = $request->user();
        $user->load(['avatarMedia', 'information.country']);

        return $this->userWithToken($user);
    }

    /**
     * @api {patch} /users/update Update a user
     * @apiName UpdateUser
     * @apiGroup User
     *
     * @apiUse Token
     *
     * @apiParam {String} [name] User name.
     * @apiParam {String} [email] User email.
     * @apiParam {String} [password] User password.
     * @apiParam {File}   [avatar] User avatar file.
     * @apiParam {String} [bio] User biography.
     * @apiParam {String} [country_id] User country id.
     * @apiParam {String} [settings] User country id.
     * @apiParam {String} _method=patch Should be provided to use PATCH method.
     *
     * @apiUse User
     * @apiSuccess {String} token Bearer Token.
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->only(['name', 'email']);

        /* @var $user User */
        $user = $request->user();
        $user->fill($validated);

        if ($request->has('password')) {
            $password = \Hash::make($request->input('password'));
            $user->password = $password;
        }

        $isSaved = $user->save();

        if ($isSaved && $request->has('password')) {
            $user->tokens()->delete();
        }

        $user->information->fill($request->only(['country_id', 'bio', 'settings']))->save();

        $user->load('information.country');

        if ($request->hasFile('avatar')) {
            $user->uploadAvatar($request->file('avatar'));
            $user->load('avatarMedia');
        }

        if ($isSaved && $request->has('password')) {
            return $this->userWithToken($user);
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->currentAccessToken()->plainTextToken
        ]);
    }

    /**
     * @api {post} /users/reset-password Reset passwords
     * @apiName ResetPassword
     * @apiGroup User
     *
     * @apiParam {String} email User email.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = User::whereEmail($request->input('email'))->first();
        if ($user !== null) {
            $password = \Str::random(8);
            if ($user->update(['password' => \Hash::make($password)])) {
                $user->notify(new ResetPassword($password));
            }
        }
        return response()->json(['message' => 'New password has been sent to your email.']);
    }

    protected function userWithToken(User $user, string $device = null): JsonResponse
    {
        $token = $user->createToken($device ?? $user->currentAccessToken()->name);
        return response()->json([
            'user' => new UserResource($user),
            'token' => $token->plainTextToken
        ]);
    }
}
