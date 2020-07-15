@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>
    <main class="container">
        <div class="row">
            <articles-list></articles-list>
            @include('frontend::includes.archive-sidebar')
        </div>
    </main>
@endsection
