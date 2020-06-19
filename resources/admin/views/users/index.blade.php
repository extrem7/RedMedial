@php
    /* @var \Illuminate\Pagination\LengthAwarePaginator $users */
@endphp

@extends('layouts.base')
@section('title', 'Users')
@section('content')
    <section class="content">
        <div class="row align-items-center flex-column">
            @include('includes.errors')
            <div class="col-12">
                <div class="d-flex justify-content-lg-between">
                    @if(auth()->user()->is_super_admin)
                        <div class="form-group">
                            <a href="{{route('admin.users.create')}}" class="btn btn-outline-success">Create</a>
                        </div>
                    @endif
                    <form action="{{route('admin.users.search')}}" class="form-group w-25 d-flex">
                        <input type="search" name="query" class="form-control bg-dark" min="3" placeholder="Search"
                               required>
                        <button class="btn btn-outline-secondary ml-1">Search</button>
                    </form>
                </div>
                <table id="documents" class="table table-dark table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        @include('users.includes.item')
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
                {{$users->appends(request()->query())->links()}}
            </div>
        </div>
    </section>
@endsection
