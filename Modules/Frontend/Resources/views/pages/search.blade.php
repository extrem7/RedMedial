@php /* @var $page \App\Models\Page */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render(request()->route()->getName(),$query,$page) }}
    </div>
    @if($query)
        <div class="box-info">
            <div class="container text-center">
                <div class="title error-title mb-2">Search Results for “{{$query}}” – Red Medial</div>
            </div>
        </div>
    @endif
    <main class="container">
        <div class="title title-cyan medium-size mb-3 text-center">NEW SEARCH:</div>
        <div class="search-additional w-100">
            <form action="{{route('frontend.search')}}"
                  class="d-flex justify-content-between align-items-end flex-column flex-sm-row">
                <input type="text" name="query" class="form-control" placeholder="Type here" required>
                <button class="btn btn-cyan">Search</button>
            </form>
        </div>
        <div class="row">
            <articles-list></articles-list>
            @include('frontend::includes.archive-sidebar')
        </div>
    </main>
@endsection
