@extends('admin::layouts.base')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$posts}}</h3>

                            <p>Posts</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-rss"></i>
                        </div>
                    </div>
                </div>
                @if(Auth::getUser()->hasRole('admin'))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$channels}}</h3>

                                <p>Channels</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-sitemap"></i>
                            </div>
                            <a href="{{route('admin.rss.channels.index')}}" class="small-box-footer">See
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$articles}}</h3>

                            <p>Blog articles</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper"></i>
                        </div>
                        <a href="{{route('admin.articles.index')}}" class="small-box-footer">See
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                @if(Auth::getUser()->hasRole('admin'))
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$users}}</h3>

                                <p>Registered users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <a href="{{route('admin.users.index')}}" class="small-box-footer">See
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
