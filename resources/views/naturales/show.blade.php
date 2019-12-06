@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('institucion.index')}}">Instituciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$institucion->nombre}}</li>
                    </ol>
                </nav>
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!--[ daily sales section ] start-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas/Compras ultimos 7 días</h6>
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Ventas: $</span>{{number_format($ventas['dia'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width:60%;height:6px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Compras: $</span>{{number_format($compras['dia'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width:45%;height:6px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ daily sales section ] end-->
                            <!--[ Monthly  sales section ] starts-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card Monthly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas/Compras del més</h6>
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Ventas: $</span>{{number_format($ventas['mes'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width:60%;height:6px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Compras: $</span>{{number_format($compras['mes'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width:45%;height:6px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Monthly  sales section ] end-->
                            <!--[ year  sales section ] starts-->
                            <div class="col-md-12 col-xl-4">
                                <div class="card yearly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas/Compras anuales</h6>
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Ventas: $</span>{{number_format($ventas['ano'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width:60%;height:6px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Compras: $</span>{{number_format($compras['ano'],2)}}</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width:45%;height:6px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ year  sales section ] end-->
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$institucion->nombre}}</h5>
                                                <sub class="text-muted f-14">{{$institucion->direccion}}</sub><br>
                                                <sub class="text-muted f-14">{{$institucion->telefono}}</sub><br>
                                                <sub class="text-muted f-14">{{$institucion->email}}</sub>
                                                <sub class="text-muted f-14">{{$institucion->tipoInstitucion->tipo}}</sub>
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            @if(Auth::user()->hasRole('PersonaNatural'))
                                            <a href="{{route('naturales.edit',$institucion->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                            <a href="{{route('naturales.configuracion.edit')}}" class="label theme-bg2 text-white f-12">Configuraciones</a>
                                            @endif
                                        </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-trending-up f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300 text-c-green" >{{$ventas['total']}}</h3>
                                                <span class="d-block text-uppercase">VENTAS TOTALES</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-trending-down f-30 text-c-red"></i>
                                            </div>
                                            <div class="col">
                                                <h3 class="f-w-300 text-c-red">{{$compras['total']}}</h3>
                                                <span class="d-block text-uppercase">COMPRAS TOTALES</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <?php function seleccionado($val,$pes){
                                if($val==$pes) return 'active show';
                                else return '';
                            }?>
                            <!--[ Recent Users ] start-->
                            
                            <div class="col-xl-8 col-md-6">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                    {{--  <li class="nav-item">
                                        <a class="nav-link {{seleccionado('E',$pest)}}" id="estadisticas-tab" data-toggle="tab" href="#estadisticas" role="tab" aria-controls="estadisticas" aria-selected="false">Estadisticas</a>
                                    </li>  --}}
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('V',$pest)}}" id="ventas-tab" data-toggle="tab" href="#ventas" role="tab" aria-controls="ventas" aria-selected="true">Ventas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('C',$pest)}}" id="compras-tab" data-toggle="tab" href="#compras" role="tab" aria-controls="compras" aria-selected="true">Compras</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('U',$pest)}}" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="false">Usuarios</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    {{--  <div class="tab-pane fade {{seleccionado('E',$pest)}}" id="estadisticas" role="tabpanel" aria-labelledby="estadisticas-tab">
                                        <div class="row">
                                            <div class="col-xl-6 col-md6">
                                                <div class="card theme-bg">
                                                    <div class="card-block">
                                                        <div class="row align-items-center justify-content-center">
                                                            <div class="col">
                                                                <h4 class="text-white">Profit</h4>
                                                            </div>
                                                            <div class="col">
                                                                <h2 class="text-white text-right f-w-300">$3,764</h2>
                                                            </div>
                                                        </div>
                                                        <div class="m-t-50">
                                                            <h6 class="text-white">Monthly Profit <span class="float-right text-white">$340</span></h6>
                                                            <h6 class="text-white mt-3">Weekly Profit <span class="float-right text-whitw">$150</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card theme-bg earning-date">
                                                    <div class="card-header borderless">
                                                        <h5 class="text-white">Earnings</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="bd-example bd-example-tabs">
                                                            <div class="tab-content" id="tabContent-pills">
                                                                <div class="tab-pane fade show active" id="earnings-mon" role="tabpanel" aria-labelledby="pills-earnings-mon">
                                                                    <h2 class="text-white mb-3 f-w-300">359,234<i class="feather icon-arrow-up"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-tue" role="tabpanel" aria-labelledby="pills-earnings-tue">
                                                                    <h2 class="text-white mb-3 f-w-300">222,586<i class="feather icon-arrow-down"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-wed" role="tabpanel" aria-labelledby="pills-earnings-wed">
                                                                    <h2 class="text-white mb-3 f-w-300">859,745<i class="feather icon-arrow-up"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-thu" role="tabpanel" aria-labelledby="pills-earnings-thu">
                                                                    <h2 class="text-white mb-3 f-w-300">785,684<i class="feather icon-arrow-up"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-fri" role="tabpanel" aria-labelledby="pills-earnings-fri">
                                                                    <h2 class="text-white mb-3 f-w-300">123,486<i class="feather icon-arrow-down"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-sat" role="tabpanel" aria-labelledby="pills-earnings-sat">
                                                                    <h2 class="text-white mb-3 f-w-300">762,963<i class="feather icon-arrow-up"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                                <div class="tab-pane fade" id="earnings-sun" role="tabpanel" aria-labelledby="pills-earnings-sun">
                                                                    <h2 class="text-white mb-3 f-w-300">984,632<i class="feather icon-arrow-down"></i></h2>
                                                                    <span class="text-white mb-4 d-block">TOTAL EARNINGS</span>
                                                                </div>
                                                            </div>
                                                            <ul class="nav nav-pills align-items-center justify-content-center" id="pills-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="pills-earnings-mon" data-toggle="pill" href="#earnings-mon" role="tab" aria-controls="earnings-mon" aria-selected="true">Mon</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-tue" data-toggle="pill" href="#earnings-tue" role="tab" aria-controls="earnings-tue" aria-selected="false">Tue</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-wed" data-toggle="pill" href="#earnings-wed" role="tab" aria-controls="earnings-wed" aria-selected="false">Wed</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-thu" data-toggle="pill" href="#earnings-thu" role="tab" aria-controls="earnings-thu" aria-selected="false">Thu</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-fri" data-toggle="pill" href="#earnings-fri" role="tab" aria-controls="earnings-fri" aria-selected="false">Fri</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-sat" data-toggle="pill" href="#earnings-sat" role="tab" aria-controls="earnings-sat" aria-selected="false">Sat</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-earnings-sun" data-toggle="pill" href="#earnings-sun" role="tab" aria-controls="earnings-sun" aria-selected="false">Sun</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="card theme-bg gradientcolor">
                                                    <div class="card-header borderless">
                                                        <h5 class="text-white">Statistics</h5>
                                                    </div>
                                                    <div class="card-block p-0">
                                                        <div class="p-2 text-center">
                                                            <a class="text-white text-uppercase f-w-400">Month</a>
                                                            <a class="btn btn-round bg-white text-uppercase mx-3 px-4 f-w-400">Week</a>
                                                            <a class="text-white text-uppercase f-w-400">Day</a>
                                                        </div>
                                                        <div class="my-3 text-center text-white">
                                                            <a class=" d-block mb-1">$ 78.89 <span class="feather icon-arrow-up"></span></a>
                                                            <span>Week2 +15.44</span>
                                                        </div>
                                                        <div id="Chartline" class="lineChart ChartShadow" style="height:260px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-xl-6 col-md6">
                                                
                                            </div>
                                        </div>
                                        

                                    </div>  --}}
                                    <div class="tab-pane fade {{seleccionado('V',$pest)}}" id="ventas" role="tabpanel" aria-labelledby="ventas-tab">
                                        <div class="card Recent-Users">
                                            <div class="card-header">
                                                <h5>Ultimas Ventas </h5>
                                            </div>
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table  id="ventasTable" class="table table-hover" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Razón social</th>                                                        
                                                                <th>Estado</th>
                                                                <th>Numero</th>
                                                                <th>Total</th>                                                        
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="entrydata">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{seleccionado('C',$pest)}}" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                                        <div class="card Recent-Users">
                                            <div class="card-header">
                                                <h5>Ultimas Compras </h5>
                                            </div>
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table  id="comprasTable" class="table table-hover" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Razón social</th>                                                        
                                                                <th>Tipo</th>
                                                                <th>Total</th>                                                        
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="entrydata">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade {{seleccionado('U',$pest)}}" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
                                        <a href="{{route('naturales.usuario.crear',[$id])}}" class="btn btn-primary float-right f-12">Crear</a>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Email</th>
                                                    <th>Cedula</th>
                                                    <th>Telefonos</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usuarios as $user)
                                                    <tr>
                                                        <td>
                                                            <h6 class="m-0">
                                                                {{$user->full_name}}
                                                                <i class="fas fa-circle text-c-{{($user->activo)?'green':'red'}} f-10"></i>
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{$user->email}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{$user->cedula}}</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="m-0">{{$user->telefonos}}</h6>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="{{route('naturales.usuario.edit',[$id,$user->id])}}" class="label theme-bg2 text-white f-12">Editar</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                                
                                            </tbody>
                                        </table>
                                        {{-- {{$visitasTotal->appends(['pest'=>'T'])->links()}} --}}
                                    </div>
                                </div>
                                
                            </div>
                            <!--[ Recent Users ] end-->

                            
                            {{-- <!--[social-media section] start-->
                            <div class="col-md-12 col-xl-4">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <i class="fab fa-facebook-f text-primary f-36"></i>
                                            </div>
                                            <div class="col text-right">
                                                <h3>12,281</h3>
                                                <h5 class="text-c-green mb-0">+7.2% <span class="text-muted">Total Likes</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Target:</span>35,098</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width:60%;height:6px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center  m-b-10"><span class="text-muted m-r-5">Duration:</span>3,539</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width:45%;height:6px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <i class="fab fa-twitter text-c-blue f-36"></i>
                                            </div>
                                            <div class="col text-right">
                                                <h3>11,200</h3>
                                                <h5 class="text-c-purple mb-0">+6.2% <span class="text-muted">Total Likes</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Target:</span>34,185</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-green" role="progressbar" style="width:40%;height:6px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center  m-b-10"><span class="text-muted m-r-5">Duration:</span>4,567</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-blue" role="progressbar" style="width:70%;height:6px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <i class="fab fa-google-plus-g text-c-red f-36"></i>
                                            </div>
                                            <div class="col text-right">
                                                <h3>10,500</h3>
                                                <h5 class="text-c-blue mb-0">+5.9% <span class="text-muted">Total Likes</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Target:</span>25,998</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width:80%;height:6px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-center  m-b-10"><span class="text-muted m-r-5">Duration:</span>7,753</h6>
                                                <div class="progress">
                                                    <div class="progress-bar progress-c-theme2" role="progressbar" style="width:50%;height:6px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[social-media section] end-->
                            <!-- [ rating list ] starts-->
                            <div class="col-xl-4 col-md-6">
                                <div class="card user-list">
                                    <div class="card-header">
                                        <h5>Rating</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center m-b-20">
                                            <div class="col-6">
                                                <h2 class="f-w-300 d-flex align-items-center float-left m-0">4.7 <i class="fas fa-star f-10 m-l-10 text-c-yellow"></i></h2>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="d-flex  align-items-center float-right m-0">0.4 <i class="fas fa-caret-up text-c-green f-22 m-l-10"></i></h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h6 class="align-items-center float-left"><i class="fas fa-star f-10 m-r-10 text-c-yellow"></i>5</h6>
                                                <h6 class="align-items-center float-right">384</h6>
                                                <div class="progress m-t-30 m-b-20" style="height: 6px;">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <h6 class="align-items-center float-left"><i class="fas fa-star f-10 m-r-10 text-c-yellow"></i>4</h6>
                                                <h6 class="align-items-center float-right">145</h6>
                                                <div class="progress m-t-30  m-b-20" style="height: 6px;">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <h6 class="align-items-center float-left"><i class="fas fa-star f-10 m-r-10 text-c-yellow"></i>3</h6>
                                                <h6 class="align-items-center float-right">24</h6>
                                                <div class="progress m-t-30  m-b-20" style="height: 6px;">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <h6 class="align-items-center float-left"><i class="fas fa-star f-10 m-r-10 text-c-yellow"></i>2</h6>
                                                <h6 class="align-items-center float-right">1</h6>
                                                <div class="progress m-t-30  m-b-20" style="height: 6px;">
                                                    <div class="progress-bar progress-c-theme" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <h6 class="align-items-center float-left"><i class="fas fa-star f-10 m-r-10 text-c-yellow"></i>1</h6>
                                                <h6 class="align-items-center float-right">0</h6>
                                                <div class="progress m-t-30  m-b-20" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" style="width:0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ rating list ] end-->
                            <div class="col-xl-8 col-md-12 m-b-30">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Today</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">This Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">All</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">3:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">2:37 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">4:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">2:37 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">3:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">4:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Activity</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-3.jpg" alt="activity-user">Silje Larsen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Dog the quick brown</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-purple">Delayed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-purple f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">3:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-2.jpg" alt="activity-user">Albert Andersen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">Jumps over the lazy</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">2:37 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-red">Missed</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-red f-10"></i></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0"><img class="rounded-circle  m-r-10" style="width:40px;" src="assets/images/user/avatar-1.jpg" alt="activity-user">Ida Jorgensen</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">The quick brown fox</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">4:28 PM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 text-c-green">Done</h6>
                                                    </td>
                                                    <td class="text-right"><i class="fas fa-circle text-c-green f-10"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/data-tables/js/datatables.min.js")}}'></script>
<script type="text/javascript">
    $('#ventasTable').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.facturas.data',$institucion->id) !!}?start_date={{$start}}&end_date={{$end}}",
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.cliente.razon_social', name: 'cliente.cliente.razon_social' },
            { data: 'estado.estado', name: 'estado.estado' },
            { data: 'secuencia', name: 'secuencia' },
            { data: 'total', name: 'total' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/".$institucion."/facturas")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                 link+='<a href="{{ url("naturales/naturales/".$institucion."/facturas")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>'; 
                    return link;
                } 
            }
        ]
    });
    $('#comprasTable').DataTable({
        processing: true,
        serverSide: true,
        "pageLength": 50,
        "order": [[ 0, "desc" ]],
        ajax: "{!! route('naturales.compras.data',$institucion->id) !!}?start_date={{$start}}&end_date={{$end}}",
        columns: [
            // { data: 'id', name: 'id' },
            { data: 'fecha', name: 'fecha' },
            { data: 'cliente.cliente.razon_social', name: 'cliente.cliente.razon_social' },
            
            { data: 'tipoComprobante', name: 'tipoComprobante' },
            { data: 'total', name: 'total' },
            
            { "data": "id", render: function (dataField) { 
                var link='<a href="{{ url("naturales/naturales/".$institucion."/compras")}}/'+dataField+'" class="label theme-bg2 text-white f-12">Ver</a>';
                {{--  link+='<a href="{{ url("naturales/naturales/".$institucion."/clientes")}}/'+dataField+'/edit" class="label theme-bg text-white f-12">Editar</a>';  --}}
                    return link;
                } 
            }
        ]
    });
    $(document).ready(function() {
        var chartDatac = [{
            "Year": "Jan",
            "value": 50
        }, {
            "Year": "Feb",
            "value": 60
        }, {
            "Year": "Mar",
            "value": 55
        }, {
            "Year": "Apr",
            "value": 62
        }, {
            "Year": "May",
            "value": 55
        }, {
            "Year": "Jun",
            "value": 62
        }];
        var chartc = AmCharts.makeChart("Chartline", {
            "type": "serial",
            "addClassNames": true,
            "defs": {
                "filter": [{
                        "x": "-50%",
                        "y": "-50%",
                        "width": "200%",
                        "height": "200%",
                        "id": "blur",
                        "feGaussianBlur": {
                            "in": "SourceGraphic",
                            "stdDeviation": "30"
                        }
                    },
                    {
                        "id": "shadow",
                        "x": "-10%",
                        "y": "-10%",
                        "width": "120%",
                        "height": "120%",
                        "feOffset": {
                            "result": "offOut",
                            "in": "SourceAlpha",
                            "dx": "0",
                            "dy": "20"
                        },
                        "feGaussianBlur": {
                            "result": "blurOut",
                            "in": "offOut",
                            "stdDeviation": "10"
                        },
                        "feColorMatrix": {
                            "result": "blurOut",
                            "type": "matrix",
                            "values": "0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 .2 0"
                        },
                        "feBlend": {
                            "in": "SourceGraphic",
                            "in2": "blurOut",
                            "mode": "normal"
                        }
                    }
                ]
            },
            "fontSize": 15,
            "dataProvider": chartDatac,
            "autoMarginOffset": 0,
            "marginRight": 0,
            "categoryField": "Year",
            "categoryAxis": {
                "color": '#fff',
                "gridAlpha": 0,
                "axisAlpha": 0,
                "lineAlpha": 0,
                "offset": -20,
                "minPeriod": "YYYY",
                "inside": true,
            },
            "valueAxes": [{
                "fontSize": 0,
                "inside": true,
                "gridAlpha": 0,
                "axisAlpha": 0,
                "lineAlpha": 0,
                "minimum": 0,
                "maximum": 80,
            }],
            "chartCursor": {
                "valueLineEnabled": false,
                "valueLineBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false,
                "valueZoomable": false,
                "cursorColor": "#fff",
                "categoryBalloonDateFormat": "YYYY",
                "categoryBalloonColor": "#1dd6d1",
                "valueLineAlpha": 0
            },
            "graphs": [{
                "id": "g1",
                "type": "line",
                "valueField": "value",
                "bullet": "round",
                "lineColor": "#ffffff",
                "lineAlpha": 1,
                "lineThickness": 3,
                "fillAlphas": 0,
                "showBalloon": true,
                "balloon": {
                    "drop": true,
                    "adjustBorderColor": false,
                    "color": "#000",
                    "fillAlphas": 0.2,
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "type": "smoothedLine",
                    "useLineColorForBulletBorder": true,
                    "valueField": "value",
                    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                },
            }],
        });
    });
</script>
@endpush
@push('styles')
<link rel="stylesheet" href='{{asset("assets/plugins/data-tables/css/datatables.min.css")}}'>
@endpush