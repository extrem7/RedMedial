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
                <table id="products" class="table table-dark table-bordered table-hover table-sortable">
                    <thead>
                    <tr>
                        <th><i class="fa fa-sort"></i></th>
                        <th>Назва</th>
                        <th>Створено</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        @include('articles.includes.item')
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th><i class="fa fa-sort"></i></th>
                        <th>Назва</th>
                        <th>Створено</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection
