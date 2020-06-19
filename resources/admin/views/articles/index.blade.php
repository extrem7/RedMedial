@extends('layouts.base')

@section('content')
    <section class="content">
        <div class="row align-items-center flex-column">
            <div class="col-6">
                @include('includes.errors')
            </div>
            <div class="col-12">
                <div class="form-group">
                    <a href="{{route('admin.articles.create')}}" class="btn btn-outline-success">Create</a>
                </div>
                <articles-index></articles-index>
            </div>
        </div>
    </section>
@endsection
