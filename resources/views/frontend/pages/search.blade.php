@php /* @var $page \App\Models\Page */  @endphp
@extends('frontend.layouts.master')

@section('content')
    <main class="container">
        {{ Breadcrumbs::render('search') }}
        <div class="title title-cyan medium-size mb-3 text-center">NEW SEARCH:</div>
        <div class="search-additional w-100">
            <form action="{{route('frontend.search')}}"
                  class="d-flex justify-content-between align-items-end flex-column flex-sm-row">
                <input type="text" class="form-control" placeholder="Type here">
                <button class="btn btn-cyan">Search</button>
            </form>
        </div>
    </main>
@endsection
