@php /* @var $country \App\Models\Rss\Country  */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>

    <main class="container">
        <rss-list order-name="country-{{$country->id}}"></rss-list>

        <!--<div class="text-center">
            <button class="btn btn-cyan">Load more</button>
        </div>-->
    </main>
@endsection
