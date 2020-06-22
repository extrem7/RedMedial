@php
    /* @var \App\Models\User $user */
@endphp
@extends('layouts.base')

@section('content')
    <section class="content">
        <div class="row align-items-center flex-column">
            @include('includes.status')
            <div class="col-md-4">
                <user-edit></user-edit>
            </div>
        </div>
    </section>
@endsection
