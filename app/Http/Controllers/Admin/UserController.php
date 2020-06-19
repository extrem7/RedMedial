<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\UsersService;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UsersService $userService;

    public function __construct()
    {
        parent::__construct();

        $this->userService = app(UsersService::class);

        /*  share([
              'resource' => 'types',
          ]); */
    }

    public function index()
    {
        $this->meta->prependTitle('Users');

        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => ['required', 'string']
        ]);

        $query = $request->get('query');

        $this->meta->prependTitle("Search for user: `$query`");

        $users = User::where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%");

        $users = $users->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->meta->prependTitle('Create a new user');

        $roles = $this->userService->getRoles();

        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = new User($data);
        $user->assignRole($data['role']);

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "User `$user->name` has been added");
    }

    public function edit(User $user)
    {
        $this->meta->prependTitle('Edit a user');

        $roles = $this->userService->getRoles();

        return view('users.edit', compact('user', 'roles'));
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
        $user->save();

        return back()->with('status', "User `$user->name` has been edited");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('status', "User `$user->name has been` deleted");
    }
}
