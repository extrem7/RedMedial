<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use App\Services\UsersService;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Requests\IndexRequest;
use Modules\Admin\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected UsersService $userService;

    public function __construct()
    {
        $this->userService = app(UsersService::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Users');

        $users = User::query()->select(['id', 'email', 'name', 'created_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->with('roles')
            ->paginate(10);

        $users->getCollection()->transform(function ($user) {
            $user['role'] = ucfirst($user->roles->implode('name', ' '));
            return $user;
        });
        if (request()->expectsJson()) {
            return $users;
        } else {
            share(compact('users'));
        }

        return view('admin::users.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new user');

        $this->userService->shareForCRUD();

        return view('admin::users.form');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = new User($data);

        $user->assignRole($data['role']);
        if ($request->hasFile('avatar'))
            $user->uploadAvatar($request->file('avatar'));

        $user->save();

        return response()->json(['status' => 'User has been created', 'id' => $user->id], 201);
    }

    public function edit(User $user)
    {
        $this->seo()->setTitle('Edit a user');

        $this->userService->shareForCRUD();

        $user->oldAvatar = $user->getAvatar();
        $user->role = $user->roles()->first()->id;
        share(compact('user'));

        return view('admin::users.form');
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->syncRoles($data['role']);
        if ($request->hasFile('avatar'))
            $user->uploadAvatar($request->file('avatar'));
        $user->save();
        $user->load('avatarMedia');

        return response()->json(['status' => 'User has been updated', 'avatar' => $user->getAvatar()]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 'User has been deleted']);
    }
}
