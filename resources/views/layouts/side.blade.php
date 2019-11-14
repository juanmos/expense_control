<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand">
                {{-- <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div> --}}
                <span class="b-title"><img src="{{asset('assets/images/logo.png')}}" style="max-width:74%"/></span>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                {{-- <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li> --}}
                {{-- <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item active">
                    <a href="{{route('home')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Panel de control</span></a>
                </li> --}}
                @if(Auth::user()->hasRole('SuperAdministrador'))
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item {{(Route::currentRouteName()=='admin.institucion.index')?'active':''}}">
                    <a href="{{route('admin.institucion.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Instituciones</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Institucion'))
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.show')?'active':''}}">
                    <a href="{{route('institucion.show',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Inicio</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.alumnos')?'active':''}}">
                    <a href="{{route('institucion.alumnos',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Alumnos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.refrigerio.index')?'active':''}}">
                    <a href="{{route('institucion.refrigerio.index')}}" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-food"></i></span><span class="pcoded-mtext">Refrigerios</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.menus.index')?'active':''}}">
                    <a href="{{route('institucion.menus.index',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-food"></i></span><span class="pcoded-mtext">Menus</span></a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración</label>
                </li>
                <li data-username="" class="nav-item pcoded-hasmenu {{(Route::currentRouteName()=='institucion.refrigerios.tipos.index' || Route::currentRouteName()=='institucion.usuario.index' || Route::currentRouteName()=='institucion.configuracion.edit')?'active pcoded-trigger':''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">                        
                        <li class="{{(Route::currentRouteName()=='institucion.refrigerios.tipos.index')?'active':''}}"><a href="{{route('institucion.refrigerios.tipos.index')}}" class="">Tipos de refrigerios</a></li>
                        <li class="{{(Route::currentRouteName()=='institucion.usuario.index')?'active':''}}"><a href="{{route('institucion.usuario.index')}}" class="">Usuarios</a></li>
                        <li class="{{(Route::currentRouteName()=='institucion.configuracion.edit')?'active':''}}"><a href="{{route('institucion.configuracion.edit')}}" class="">Configuraciones</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('PersonaNatural'))
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='naturales.show')?'active':''}}">
                    <a href="{{route('naturales.show',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Inicio</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.alumnos')?'active':''}}">
                    <a href="{{route('institucion.alumnos',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-credit-card"></i></span><span class="pcoded-mtext">Ventas</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='institucion.refrigerio.index')?'active':''}}">
                    <a href="{{route('institucion.refrigerio.index')}}" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-cart-outline"></i></span><span class="pcoded-mtext">Compras</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item {{(Route::currentRouteName()=='naturales.clientes.index')?'active':''}}">
                    <a href="{{route('naturales.clientes.index',Auth::user()->institucion_id)}}" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-office-building"></i></span><span class="pcoded-mtext">Clientes</span></a>
                </li>
                <li data-username="" class="nav-item pcoded-hasmenu {{( Route::currentRouteName()=='naturales.usuario.index' || Route::currentRouteName()=='naturales.categoria.index')?'active pcoded-trigger':''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="mdi mdi-barcode"></i></span><span class="pcoded-mtext">Productos y Servicios</span></a>
                    <ul class="pcoded-submenu">                        
                        
                        <li class="{{(Route::currentRouteName()=='naturales.usuario.index')?'active':''}}"><a href="{{route('naturales.usuario.index')}}" class="">Productos</a></li>
                        <li class="{{(Route::currentRouteName()=='naturales.configuracion.edit')?'active':''}}"><a href="{{route('naturales.configuracion.edit')}}" class="">Sevicios</a></li>
                        <li class="{{(Route::currentRouteName()=='naturales.categoria.index')?'active':''}}"><a href="{{route('naturales.categoria.index','producto')}}" class="">Categorias</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración</label>
                </li>
                <li data-username="" class="nav-item pcoded-hasmenu {{( Route::currentRouteName()=='naturales.usuario.index' || Route::currentRouteName()=='naturales.configuracion.edit')?'active pcoded-trigger':''}}">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">                        
                        
                        <li class="{{(Route::currentRouteName()=='naturales.usuario.index')?'active':''}}"><a href="{{route('naturales.usuario.index')}}" class="">Usuarios</a></li>
                        <li class="{{(Route::currentRouteName()=='naturales.configuracion.edit')?'active':''}}"><a href="{{route('naturales.configuracion.edit')}}" class="">Configuraciones</a></li>
                    </ul>
                </li>
                @endif
                {{-- @if(!Auth::user()->hasRole('SuperAdministrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('cliente.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Clientes</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('visita.index',null)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Calendario</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Vendedor') || Auth::user()->hasRole('JefeVentas'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('visita.usuario',Auth::user()->id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">Calendario</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('tarea.index',null)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">Tareas vendedores</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Vendedor') || Auth::user()->hasRole('JefeVentas'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('tarea.index',Auth::user()->id)}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">Mis tareas</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador') || Auth::user()->hasRole('JefeVentas'))
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="{{route('empresa.usuario.index')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Vendedores</span></a>
                </li>
                @endif
                @if(Auth::user()->hasRole('Administrador'))
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración</label>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">
                        
                        <li class=""><a href="{{route('tipoVisita.index')}}" class="">Tipos de visita</a></li>
                        <li class=""><a href="{{route('clasificacion.index')}}" class="">Clasificaciones</a></li>
                        <li class=""><a href="{{route('plantilla.index')}}" class="">Plantillas</a></li>
                        <li class=""><a href="{{route('configuracion.edit',Auth::user()->empresa_id)}}" class="">Configuraciones</a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->hasRole('SuperAdministrador'))
                <li class="nav-item pcoded-menu-caption">
                    <label>Administración general</label>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-settings"></i></span><span class="pcoded-mtext">Administración</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="{{route('usuario.index')}}" class="">Usuarios</a></li>
                        <li class=""><a href="{{route('plantilla.index')}}" class="">Plantillas</a></li>˜
                    </ul>
                </li>
                @endif --}}
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Cerrar sesión</span></a>
                </li>
                {{-- 
                <li class="nav-item pcoded-menu-caption">
                    <label>Configuraciones</label>
                </li>
                <li data-username="form elements advance componant validation masking wizard picker select" class="nav-item">
                    <a href="form_elements.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Partidos politicos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Candidatos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Puestos politicos</span></a>
                </li>
                <li data-username="Table bootstrap datatable footable" class="nav-item">
                    <a href="tbl_bootstrap.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-server"></i></span><span class="pcoded-mtext">Recintos electorales</span></a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Chart & Maps</label>
                </li>
                <li data-username="Charts Morris" class="nav-item"><a href="chart-morris.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Chart</span></a></li>
                <li data-username="Maps Google" class="nav-item"><a href="map-google.html" class="nav-link "><span class="pcoded-micon"><i class="feather icon-map"></i></span><span class="pcoded-mtext">Maps</span></a></li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Pages</label>
                </li>
                <li data-username="Authentication Sign up Sign in reset password Change password Personal information profile settings map form subscribe" class="nav-item pcoded-hasmenu">
                    <a href="javascript:" class="nav-link "><span class="pcoded-micon"><i class="feather icon-lock"></i></span><span class="pcoded-mtext">Authentication</span></a>
                    <ul class="pcoded-submenu">
                        <li class=""><a href="auth-signup.html" class="" target="_blank">Sign up</a></li>
                        <li class=""><a href="auth-signin.html" class="" target="_blank">Sign in</a></li>
                    </ul>
                </li>
                <li data-username="Sample Page" class="nav-item"><a href="sample-page.html" class="nav-link"><span class="pcoded-micon"><i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Sample page</span></a></li>
                <li data-username="Disabled Menu" class="nav-item disabled"><a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="feather icon-power"></i></span><span class="pcoded-mtext">Disabled menu</span></a></li> --}}
            </ul>
        </div>
    </div>
</nav>