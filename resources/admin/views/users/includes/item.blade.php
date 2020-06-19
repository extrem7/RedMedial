@php
    /* @var \App\Models\User $user */
$banned = $user->is_banned?'style=text-decoration:line-through;':'';
@endphp
<tr {{$banned}}>
    <td data-order="{{$user->id}}">#{{$user->id}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->name}}</td>
    <td>
        <div class="d-flex align-items-center">
            <span>{{$user->roles()->get()->implode('name',' ')}}</span>
        </div>
    </td>
    <td class="d-flex ">
        <a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-outline-primary">Edit</a>
        @if($user->id!==auth()->id())
            <form action="{{route('admin.users.destroy',$user->id)}}" method="post" class="form-ajax ml-2">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-danger delete">Delete</button>
            </form>
        @endif
    </td>
</tr>
