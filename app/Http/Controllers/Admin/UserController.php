<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\IndexRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\UsersService;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        if (request()->expectsJson()) {
            $users = User::query()->select(['id', 'email', 'name', 'created_at'])
                ->when($request->get('searchQuery'), function (Builder $articles) use ($request) {
                    $searchQuery = $request->get('searchQuery');
                    $articles->where('email', 'LIKE', "%$searchQuery%")
                        ->orWhere('name', 'LIKE', "%$searchQuery%");
                })
                ->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc')
                ->paginate(10);

            $users->getCollection()->transform(function ($user) {
                $user['role'] = ucfirst($user->roles->implode('name', ' '));
                return $user;
            });

            return $users;
        }

        return view('users.index');
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => ['required', 'string']
        ]);

        $query = $request->get('query');

        $this->seo()->setTitle("Search for user: `$query`");

        $users = User::where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%");

        $users = $users->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new user');

        $this->userService->shareForCRUD();

        return view('users.create');
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

        return view('users.edit');
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
