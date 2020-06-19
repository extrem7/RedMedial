@php
    /* @var \App\Models\User $user */
@endphp
@extends('layouts.base')

@section('content')
    <section class="content">
        <div class="row align-items-center flex-column">
            @include('includes.status')
            <div class="col-md-4">
                <form method="post" action="{{route('admin.users.update',$user->id)}}" class="card card-primary bg-dark"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control bg-dark mb-2 {{is_valid('email')}}" id="email"
                                   name="email"
                                   value="{{old('email',$user->email)}}">
                            <x-errors name="email"></x-errors>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control bg-dark mb-2 {{is_valid('name')}}" id="name"
                                   name="name"
                                   value="{{old('name',$user->name)}}">
                            <x-errors name="name"></x-errors>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control bg-dark mb-2 {{is_valid('password')}}" id="password"
                                   name="password" value="{{old('password')}}" minlength="8">
                            <x-errors name="password"></x-errors>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label><br>
                            <select class="form-control" id="role" name="role">
                                @foreach($roles as $id=>$role)
                                    <option
                                        value="{{$id}}" {{selected('role',$id,old('role',$user->hasRole($id)))}}>{{ucfirst($role)}}</option>
                                @endforeach
                            </select>
                            <x-errors name="role"></x-errors>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">Back</a>
                        <button type="submit" class="btn btn-outline-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
