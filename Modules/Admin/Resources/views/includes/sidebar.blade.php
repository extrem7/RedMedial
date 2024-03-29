<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image d-flex align-items-center">
            <img src="{{Auth::getUser()->avatar}}" class="avatar img-circle elevation-2" alt="avatar">
        </div>
        <div class="info d-flex align-items-center">
            <p class="d-block text-white m-0">{{$name}}</p>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy">

            @if(Auth::getUser()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ Nav::isRoute('admin.dashboard') }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ config('app_settings.url') }}" class="nav-link {{ Nav::urlDoesContain('settings') }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ Nav::urlDoesContain('rss','menu-open') }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-rss"></i>
                        <p>
                            Rss
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.rss.channels.index')}}"
                               class="nav-link {{ Nav::isResource('channels') }}">
                                <i class="nav-icon fas fa-sitemap"></i>
                                <p>Channels</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.rss.countries.index')}}"
                               class="nav-link {{ Nav::isResource('countries') }}">
                                <i class="nav-icon fa fa-globe"></i>
                                <p>Countries</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.rss.languages.index')}}"
                               class="nav-link {{ Nav::isResource('languages') }}">
                                <i class="nav-icon fa fa-language"></i>
                                <p>Languages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.rss.categories.index')}}"
                               class="nav-link {{ Nav::isResource('categories') }}">
                                <i class="nav-icon fa fa-tag"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.pages.index')}}" class="nav-link {{ Nav::isResource('pages') }}">
                        <i class="nav-icon fa fa-file-signature"></i>
                        <p>Pages</p>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{route('admin.articles.index')}}" class="nav-link {{ Nav::isResource('articles') }}">
                    <i class="nav-icon fa fa-newspaper"></i>
                    <p>Blog</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('admin.playlists.index')}}" class="nav-link {{ Nav::isResource('playlists') }}">
                    <i class="nav-icon fab fa-youtube"></i>
                    <p>Playlists</p>
                </a>
            </li>
            @if(Auth::getUser()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{route('admin.users.index')}}" class="nav-link {{ Nav::isResource('users') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('pragmarx.health.panel')}}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>Health</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('log-viewer::dashboard')}}" class="nav-link" target="_blank">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Logs</p>
                    </a>
                </li>
                @if(config('telescope.enabled'))
                    <li class="nav-item">
                        <a href="{{config('app.url').route('telescope',null,false)}}" class="nav-link"
                           target=_blank>
                            <i class="nav-icon fa">
                                <svg-vue icon="telescope"></svg-vue>
                            </i>
                            <p>Telescope</p>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
</div>
