@php /* @var $country \App\Models\Rss\Country  */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>

    <main class="container">
        <h1 class="page-title title title-cyan line text-center mb-4">{{$country->name}}</h1>
        <rss-list order-name="country-{{$country->id}}"></rss-list>
    </main>
@endsection
