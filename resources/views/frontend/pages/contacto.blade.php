@php /* @var $page \App\Models\Page */  @endphp
@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="box">
                    <div class="page-title title title-cyan">{{$page->title}}</div>
                    <div class="mt-3">{!!$page->body!!}</div>
                    <form-contacto></form-contacto>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="mt-4">
                    <div class="title title-cyan page-title">Emails</div>
                    <div class="mt-4">
                        <a href="mailto:contacto@elciudadano.cl" class="title text-decoration-underline">contacto@elciudadano.cl</a>
                    </div>
                </div>
                <social class="mt-5"></social>
            </div>
        </div>

    </main>
@endsection
