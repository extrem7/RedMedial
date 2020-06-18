<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image d-flex align-items-center">
            <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="avatar img-circle elevation-2"
                 alt="avatar">
        </div>
        <div class="info d-flex align-items-center">
            <p class="d-block text-white m-0">{{$name}}</p>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
            data-accordion="false">
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
            <li class="nav-item has-treeview {{ Nav::urlDoesContain('order','menu-open') }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-warehouse"></i>
                    <p>
                        Бланк замовлення
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href=""
                           class="nav-link {{ Nav::isResource('categories') }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Категорії</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link {{ Nav::isResource('markers') }}">
                    <i class="nav-icon fa fa-map-marked-alt"></i>
                    <p>Мапа мийок</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
