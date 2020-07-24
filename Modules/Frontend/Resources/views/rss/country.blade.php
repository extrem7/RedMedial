@php /* @var $country \App\Models\Rss\Country  */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>

    <main class="container">
        <rss-list order-name="country-{{$country->id}}"></rss-list>
    </main>
@endsection
