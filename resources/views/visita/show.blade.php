@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!--[ daily sales section ] start-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card daily-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ultima visita</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 249.95</h3>
                                            </div>

                                            <div class="col-3 text-right">
                                                <p class="m-b-0">67%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ daily sales section ] end-->
                            <!--[ Monthly  sales section ] starts-->
                            <div class="col-md-6 col-xl-4">
                                <div class="card Monthly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Valores pendientes</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-down text-c-red f-30 m-r-10"></i>$ 2.942.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">36%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme2" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Monthly  sales section ] end-->
                            <!--[ year  sales section ] starts-->
                            <div class="col-md-12 col-xl-4">
                                <div class="card yearly-sales">
                                    <div class="card-block">
                                        <h6 class="mb-4">Ventas anuales</h6>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-9">
                                                <h3 class="f-w-300 d-flex align-items-center  m-b-0"><i class="feather icon-arrow-up text-c-green f-30 m-r-10"></i>$ 8.638.32</h3>
                                            </div>
                                            <div class="col-3 text-right">
                                                <p class="m-b-0">80%</p>
                                            </div>
                                        </div>
                                        <div class="progress m-t-30" style="height: 7px;">
                                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                <span class="d-block text-uppercase">datos del cliente </span>
                                                <h5 class="m-0">{{$visita->cliente->nombre}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->cliente->telefono}}</sub><br>
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('visita.edit',$visita->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                            <a href="{{route('cliente.show',$visita->cliente_id)}}" class="label theme-bg2 text-white f-12">Ver cliente</a>
                                        </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <span class="d-block text-uppercase">Datos del contacto </span>
                                                @if($visita->contacto!=null)
                                                <h5 class="m-0">{{$visita->contacto->nombre}} {{$visita->contacto->apellido}}</h5>
                                                <sub class="text-muted f-14">Teléfono: {{$visita->contacto->telefono}}</sub><br>
                                                <sub class="text-muted f-14">Email: {{$visita->contacto->email}}</sub>
                                                @else
                                                <sub class="text-muted f-14">No has seleccionado un contacto</sub>
                                                @endif
                                            </div>
                                            {{-- <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">34%</label>
                                            </div> --}}
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            @if($visita->contacto!=null)
                                            <a href="{{route('visita.edit',$visita->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                            <a href="{{route('contacto.show',$visita->cliente_id)}}" class="label theme-bg2 text-white f-12">Ver contacto</a>
                                            @else
                                            <a href="{{route('cliente.show',$visita->cliente_id)}}" class="label theme-bg2 text-white f-12">Seleccionar contacto</a>
                                            @endif
                                        </h6>
                                        <i class="far fa-user text-c-purple f-50"></i>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-inbox f-30 text-c-green"></i>
                                            </div>
                                            <div class="col">
                                                <span class="d-block text-uppercase">ESTADO </span>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center">
                                            <ul class="nav nav-pills" id="myEstado" role="tablist" style="background-color:transparent;box-shadow:0 0px 0px 0 rgba(0, 0, 0, 0.05);overflow-x: auto;width: 500px;display: -webkit-inline-box;">
                                                @if($visita->estado_visita_id<5)
                                                @foreach ($estados as $estado)
                                                <li class="nav-item">
                                                    <a class="nav-link {{($estado->id==$visita->estado_visita_id)?'active show':' '}}" id="creado-tab"  href="{{route('visita.estado',[$visita->id,$estado->id])}}" aria-selected="{{($estado->id==$visita->estado_visita_id)?'true':'false' }}">{{$estado->estado}}</a>
                                                </li>    
                                                @endforeach
                                                @elseif($visita->estado_visita_id==6)
                                                <li class="nav-item">                                                    
                                                    <a class="nav-link theme-danger show text-white" id="creado-tab"  aria-selected="true">{{$visita->estado->estado}}</a>
                                                </li> 
                                                @else
                                                <li class="nav-item">                                                    
                                                    <a class="nav-link active show" id="creado-tab"  aria-selected="true">{{$visita->estado->estado}}</a>
                                                </li> 
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-block  border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-map-pin f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">                                                
                                                <span class="d-block text-uppercase">Tipo de visita </span>
                                                <h3 class="f-w-300">{{$visita->tipoVisita->tipo}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-users f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">                                                
                                                <span class="d-block text-uppercase">Agregar acompañantes </span>
                                                <h3 class="f-w-300"></h3>
                                                <h3 class="f-w-300"><a href="#" id="abrirCalendario" data-toggle="modal" data-target="#modal-usuarios" class="label theme-bg text-white f-12">Agregar acompañante</a></h3>
                                                @if($visita->usuarios_adicionales()->count()>0)
                                                <div class="">
                                                    <h6 class="text-muted f-12">Acompañantes</h6>
                                                    @foreach ($visita->usuarios_adicionales()->get() as $user)
                                                        <label class="label theme-bg text-white f-14 f-w-400">{{$user->full_name}} <a href="{{route('visita.user.delete',[$visita->id,$user->id])}}"><i class="feather icon-delete text-white"></i></a></label>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block border-bottom">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-calendar f-30 text-c-blue"></i>
                                            </div>
                                            <div class="col">                                                
                                                <span class="d-block text-uppercase">Proxima visita </span>
                                                <h3 class="f-w-300"></h3>
                                                <h3 class="f-w-300"><a href="#" id="abrirCalendario" data-toggle="modal" data-target="#modalProxima" class="label theme-bg2 text-white f-12">Nueva visita</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if($visita->estado_visita_id<5)
                                    <div class="card-block">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-auto">
                                                <i class="feather icon-x-circle f-30 text-c-red"></i>
                                            </div>
                                            <div class="col">                                                
                                                {{-- <span class="d-block text-uppercase">Cancelar visita </span>
                                                <h3 class="f-w-300"></h3> --}}
                                                <h3 class="f-w-300"><a href="#" data-toggle="modal" data-target="#modalCancelar" class="label theme-danger text-white f-12">Cancelar visita</a></h3>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <?php function seleccionado($val,$pes){
                                if($val==$pes) return 'active show';
                                else return '';
                            }?>
                            <!-- [ Previsita y visita ] end -->
                            <div class="col-xl-8 col-md-8 m-b-30">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('pre',$pest)}}" id="previsita-tab" data-toggle="tab" href="#previsita" role="tab" aria-controls="previsita" aria-selected="false">Previsita</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('post',$pest)}}" id="visita-tab" data-toggle="tab" href="#visita" role="tab" aria-controls="visita" aria-selected="true">Visita</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('T',$pest)}}" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tareas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{seleccionado('C',$pest)}}" id="calendario-tab" data-toggle="tab" href="#calendario" role="tab" aria-controls="calendario" aria-selected="false">Visitas anteriores</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade {{seleccionado('pre',$pest)}}" id="previsita" role="tabpanel" aria-labelledby="previsita-tab">
                                        @if($visita->tipoVisita->plantillaPre->detalles->count()>0)
                                        {!! Form::open(["method"=>"POST","route"=>["visita.save.previsita",$visita->id] ]) !!}
                                            <ul class="list-group list-group-sortable">    
                                                @foreach ($visita->tipoVisita->plantillaPre->detalles()->with(['visita'=>function($query) use($visita){$query->where('id',$visita->id);}])->orderBy('orden')->get() as $detalle )
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-2">{{$detalle->label}}</h6>
                                                            @if($detalle->tipo_campo==1)
                                                            <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}" name="custom_{{$detalle->id}}" type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif />
                                                            @elseif($detalle->tipo_campo==2)
                                                            <textarea name="custom_{{$detalle->id}}"  rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif>{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}</textarea>
                                                            @elseif($detalle->tipo_campo==3)
                                                            <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}" name="custom_{{$detalle->id}}"  type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif/>
                                                            @elseif($detalle->tipo_campo==4)
                                                            <select name="custom_{{$detalle->id}}"  class="form-control opcionesId_{{$detalle->id}} " @if($visita->estado_visita_id==6)disabled="disabled"@endif>
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                    <option value="{{$opcion}}" {{($detalle->visita->count()>0)?($detalle->visita[0]->respuestas->valor==$opcion)?'selected="selected"':'':''}}>{{$opcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            @elseif($detalle->tipo_campo==6)
                                                            
                                                                @if($detalle->opciones!=null)
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" name="visita_{{$detalle->id}}[]" id="visita_{{$detalle->id.'_'.$opcion}}" class="custom-control-input" value="{{$opcion}}" {{($detalle->visita->count()>0)?
                                                                        ( array_search($opcion,array_column(array_column($detalle->visita->toArray(),"respuestas"),"valor"),true )!==FALSE )  ?'checked="checked"':'':''}} @if($visita->estado_visita_id==6)disabled="disabled"@endif> 
                                                                    <label class="custom-control-label" for="visita_{{$detalle->id.'_'.$opcion}}">{{$opcion}}</label>
                                                                    
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                    <input type="checkbox" name="custom_{{$detalle->id}}" class="custom-control-input" @if($visita->estado_visita_id==6)readonly="readonly"@endif> Check 
                                                                @endif
                                                            
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @if($visita->estado_visita_id<6)
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary float-right" >Guardar</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                            {!! Form::hidden('pest', 'pre') !!}
                                        {!! Form::close() !!}
                                        @endif

                                    </div>
                                    <div class="tab-pane fade {{seleccionado('post',$pest)}}" id="visita" role="tabpanel" aria-labelledby="visita-tab">
                                        @if($visita->tipoVisita->plantillaVisita->detalles->count()>0)
                                        {!! Form::open(["method"=>"POST","route"=>["visita.save.visita",$visita->id] ]) !!}
                                            <ul class="list-group list-group-sortable">    
                                                @foreach ($visita->tipoVisita->plantillaVisita->detalles()->with(['visita'=>function($query) use($visita){$query->where('id',$visita->id);}])->orderBy('orden')->get() as $detalle )
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-2">{{$detalle->label}}</h6>
                                                            @if($detalle->tipo_campo==1)
                                                            <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}"  name="visita_{{$detalle->id}}" type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif />
                                                            @elseif($detalle->tipo_campo==2)
                                                            <textarea name="visita_{{$detalle->id}}"  rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif>{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}</textarea>
                                                            @elseif($detalle->tipo_campo==3)
                                                            <input value="{{($detalle->visita->count()>0)?$detalle->visita[0]->respuestas->valor:''}}"  name="visita_{{$detalle->id}}"  type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}" @if($visita->estado_visita_id==6)readonly="readonly"@endif/>
                                                            @elseif($detalle->tipo_campo==4)
                                                            <select name="visita_{{$detalle->id}}"  class="form-control opcionesId_{{$detalle->id}} " @if($visita->estado_visita_id==6)disabled="disabled"@endif>
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                    <option value="{{$opcion}}" {{($detalle->visita->count()>0)?($detalle->visita[0]->respuestas->valor==$opcion)?'selected="selected"':'':''}}>{{$opcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            @elseif($detalle->tipo_campo==6)
                                                            
                                                                @if($detalle->opciones!=null)
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" name="visita_{{$detalle->id}}[]" id="visita_{{$detalle->id.'_'.$opcion}}" class="custom-control-input" value="{{$opcion}}" {{($detalle->visita->count()>0)?
                                                                        ( array_search($opcion,array_column(array_column($detalle->visita->toArray(),"respuestas"),"valor"),true )!==FALSE )  ?'checked="checked"':'':''}} @if($visita->estado_visita_id==6)disabled="disabled"@endif> 
                                                                    <label class="custom-control-label" for="visita_{{$detalle->id.'_'.$opcion}}">{{$opcion}}</label>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                    <input type="checkbox" name="visita_{{$detalle->id}}" class="custom-control-input" @if($visita->estado_visita_id==6)readonly="readonly"@endif> Check 
                                                                @endif
                                                            </div>
                                                            @else
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @if($visita->estado_visita_id<6)
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary float-right" >Guardar</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                            
                                            {!! Form::hidden('pest', 'post') !!}
                                            
                                        {!! Form::close() !!}
                                        @endif

                                    </div>
                                    <div class="tab-pane fade {{seleccionado('T',$pest)}}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        @if($visita->estado_visita_id<6)
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalTarea">
                                            <span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Nueva tarea</span>
                                        </a>
                                        @endif
                                        <table class="table table-hover">
                                            
                                            <tbody>
                                                @foreach($visita->tareas as $tarea)
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <span class="text-muted f-12">Tarea:</span><br>
                                                                <h6 class="m-0">{{$tarea->nombre}}</h6>
                                                            </div>
                                                            
                                                            <div class="col-md-4 text-right">
                                                                <h6 class="m-0 text-right text-c-{{($tarea->realizado)?'green' :'purple'}}" id="tarea_estado_{{$tarea->id}}">{{($tarea->realizado)? 'Realizado': 'Por hacer'}}</h6>
                                                                
                                                            </div>
                                                            <div class="col-md-1 text-right">
                                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                                    <input type="checkbox" name="tarea_{{$tarea->id}}" id="tarea_{{$tarea->id}}" class="custom-control-input form-control tareaCheckbox" value="{{$tarea->id}}" {{($tarea->realizado)?'checked="checked"':''}}>    
                                                                    <label class="custom-control-label tareaCheckbox" for="tarea_{{$tarea->id}}"></label>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-8">
                                                                <span class="text-muted f-12">Descripción:</span><br>
                                                                <h6 class="m-0">{{$tarea->detalle}}</h6>
                                                            </div>
                                                            <div class="col-md-4"> 
                                                                <h6 class="m-0 text-muted  float-right">
                                                                    <img class="rounded-circle  m-r-10" style="width:40px;" src="{{asset($tarea->usuarioCrea->foto)}}" alt="activity-user">
                                                                    {{$tarea->usuarioCrea->full_name}}
                                                                </h6>
                                                                <h6 class="m-0 text-muted float-right">{{date('d-m-Y',strtotime($tarea->fecha))}} {{date('H:i:s',strtotime($tarea->fecha))}}</h6>
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade {{seleccionado('C',$pest)}}" id="calendario" role="tabpanel" aria-labelledby="calendario-tab">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Tipo</th>
                                                    <th>Time</th>
                                                    <th>Estado</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($visitasAnteriores as $ultima)
                                                <tr>
                                                    <td>
                                                        <h6 class="m-0">{{date('d-m-Y H:i',strtotime($ultima->fecha_inicio))}}</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">{{$ultima->tipoVisita->tipo}}</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0">10:23 AM</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0 @if($ultima->estado_visita_id==1)text-c-purple @elseif( $ultima->estado_visita_id==6)text-c-red @elseif( $ultima->estado_visita_id==5) text-c-green @else text-c-blue  @endif">{{$ultima->estado->estado}}</h6>
                                                        {{-- <h6 class="m-0 text-c-purple"><i class="fas fa-circle text-c-purple f-10"></i> {{$ultima->estado->estado}}</h6> --}}
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="{{route('visita.show',$ultima->id)}}" class="btn btn-primary">Ir a visita</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                   

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md modal-xl" name="modalProxima" id="modalProxima" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="width: 80vw;margin-left:-20vw;height:70vh;">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>"tarea.store","method"=>"POST"]) !!}
                <div class="">
                    <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Nueva visita</h4>
                    </div>
                </div>
                <div class="modal-body" align="center">                        
                    <div class="row">   
                        <div id="calendar"></div>             
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <input type="hidden" value="{{$visita->id}}" name="visita_id"/>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" name="modalTarea" id="modalTarea" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>"tarea.store","method"=>"POST"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Nueva tarea</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Nombre de la tarea:</label>                            
                                {!! Form::text('nombre', "", ["class"=>"form-control","placeholder"=>"Nombre de la tarea"]) !!}
                            </div>
                        </div>
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Descripción de la tarea</label>
                                <input type="text" id="detalle" value="" name="detalle" class="form-control" aria-describedby="emailHelp" placeholder="Descripción">
                            </div>
                        </div> 
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Fecha</label>
                                <input type="text" id="fecha" value="" name="fecha" class="form-control datetime" aria-describedby="emailHelp" placeholder="Fecha">
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="{{$visita->id}}" name="visita_id"/>
                    </div>    
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" name="modalAddCita" id="modalAddCita" tabindex="-1" role="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {{-- <div class="modal-header"> --}}
                    <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">   
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="card-title"> Datos de la visita</h4> 
                    </div>
                {{-- </div> --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group-select col-md-4">
                                    <label class="col-md-7 control-label ">Tipo: </label>
                                    <div class="col-md-12">
                                        {!! Form::select('tipo_visita_id', $tiposVisita, 0 ,array("class"=>"form-control tipoCitaId required selectpicker full-width-fix")); !!}                                         
                                    </div>
                                </div>
                                <div class="form-group-select col-md-4">
                                    <label class="col-md-7 control-label ">Duración: </label>
                                    <div class="col-md-12">
                                        {!! Form::select('tiempo_visita', $tiempoVisita, Auth::user()->empresa->configuracion->tiempo_visita ,["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                                <div class="form-group-select col-md-4">
                                    <label class="col-md-7 control-label ">Hora: </label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="horaModal" id="horaModal" required class="form-control selectpicker col-md-12 full-width-fix">
                                                @for ($i = 1; $i < 23; $i++)
                                                    @if($i < 10)
                                                        <option value="0{{$i}}" > 0{{$i}} </option>
                                                    @else
                                                        <option value="{{$i}}" > {{$i}} </option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="minModal" id="minModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                                @for ($j = 0; $j <= 59; $j = $j+5)
                                                    @if($j < 10)
                                                        <option value="0{{$j}}" > 0{{$j}} </option>
                                                    @else
                                                        <option value="{{$j}}" > {{$j}} </option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-select pickFecha" >
                                <label class="col-md-3 control-label">Fecha:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="diaModal" id="diaModal" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($i = 1; $i < 32; $i++)
                                                @if($i < 10)
                                                    <option value="0{{$i}}" > 0{{$i}} </option>
                                                @else
                                                    <option value="{{$i}}" > {{$i}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="mesModal" id="mesModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            @for ($j = 1; $j <= 12; $j++)
                                                @if($j < 10)
                                                    <option value="0{{$j}}" > 0{{$j}} </option>
                                                @else
                                                    <option value="{{$j}}" > {{$j}} </option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <?php 
                                            $fecha = new DateTime();
                                            $anio=$fecha->format('Y');
                                            $anio1 = intval($anio) + 1;
                                        ?>
                                        <input type="hidden" id="mesAct" value="{{$fecha->format('m')}}">
                                        <input type="hidden" id="diaAct" value="{{$fecha->format('d')}}">
                                        
                                        <select name="anioModal" id="anioModal" align="center" required class="form-control selectpicker col-md-12 full-width-fix">
                                            <option value="{{$anio}}" > {{$anio}} </option>
                                            <option value="{{$anio1}}" > {{$anio1}} </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 color1" id="horariosDiv"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                
                    <div class="col-md-12">
                        <button type="button" data-dismiss="modal" class="btn float-left btn-danger" data-dismiss="modal">                      
                        <i class="far fa-times-circle"></i> CANCELAR
                        </button>  
                        <button type="button" class="btn btn-success float-right" name="aceptCreate" id="aceptCreate">
                            <i class="fa fa-save"> </i> ACEPTAR
                        </button>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" name="modalCancelar" id="modalCancelar" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>["visita.update",$visita->id],"method"=>"POST"]) !!}
                
                {!! Form::hidden('_method', 'PUT' ) !!}
                
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Cancelar visita</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Razón de cancelación:</label>                            
                                {!! Form::text('razon_cancelacion', "", ["class"=>"form-control","placeholder"=>"Razón de cancelación","required"=>"required"]) !!}
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        
                    </div>    
                </div>
                
                {!! Form::hidden('estado_visita_id', 6) !!}
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" name="modal-usuarios" id="modal-usuarios" tabindex="-1" role="">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                {!! Form::open(["route"=>["visita.user.add",$visita->id],"method"=>"POST"]) !!}
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Agregar acompañante</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <table class="table">
                            <tr>
                                <th>Usuario</th>
                                <th>Seleccionar</th>
                            </tr>
                            @foreach ($usuarios as $usuario )
                                <tr>
                                    <td>
                                        {{$usuario->full_name}}
                                    </td>
                                    <td>
                                        <input type="checkbox" value="{{$usuario->id}}" name="usuarios[]">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button type="submit" class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                    </div>    
                </div>
                <input type="hidden" name="tarea_id" id="add_usuario_id"/>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src='{{asset("assets/plugins/fullcalendar/packages/core/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/interaction/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/list/main.js")}}'></script>
<script src='{{asset("assets/plugins/fullcalendar/packages/core/locales-all.js")}}'></script>
<script type="text/javascript">
$(document).ready(function(){
      $(document).on('click','#aceptCreate',function(e){
        if ($('#cliente_id').val() != '') {
          var data = {cliente_id:{{$visita->cliente_id}} ,horaEstimada:$('#horaModal').val()+':'+$('#minModal').val()+':00', fecha:$('#anioModal').val()+'/'+$('#mesModal').val()+'/'+$('#diaModal').val(), usuario_id:{{$visita->usuario_id}},tipo_visita_id:$('select[name=tipo_visita_id]').val(), tiempo_visita:$('select[name=tiempo_visita]').val(),contacto_id:{{($visita->contacto_id)?$visita->contacto_id:'0'}},_token:'{{csrf_token()}}'};
          saveVisita(data);
          
        }else {
          alert('Campo requerido');
          $("#nombreAdd").focus();
        }
      });
      function saveVisita(data) { 
        $.post("{{route('visita.store')}}",data,function(json){          
          $('#modalAddCita').modal('hide');      
          $('#modalProxima').modal('hide');
          if(json.validate){
              try{
                calendar.refetchEvents();
                $.notify('Cita creada con éxito',{className: "success",globalPosition:'top center'});                      
              }catch(e){
                  $.notify('Cita creada con éxito',{className: "success",globalPosition:'top center'});   
              }                    
          }else{
            alert("La cita no pudo ser creada por conflictos de horario, por favor revise e intente nuevamente");
          }
        },'json');
      }
      
    })
  </script>
<script>
    var calendar=null;
$(document).ready(function(){
    var calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid', 'timeGrid', 'list', 'interaction' ],
        locale:'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        defaultView:'{{Auth::user()->empresa->configuracion->defaultView}}',
        hiddenDays: [ 0 ],
        minTime:"{{Auth::user()->empresa->configuracion->min_time}}",
        maxTime:'{{Auth::user()->empresa->configuracion->max_time}}',
        scrollTime:'08:00:00',
        slotDuration:'00:15:00',
        eventSources: [
            {
            url: "{{route('visita.vendedor',$visita->usuario_id)}}", // use the `url` property
            }
        ],
        dateClick: function(info) {
            var fecha=moment(info.dateStr);
            
            $('#mesModal').val(fecha.format('MM'))
            $('#diaModal').val(fecha.format('DD'));
            $('#anioModal').val(fecha.format('YYYY'));
            $('#horaModal').val(fecha.format('HH'));
            $('#minModal').val(fecha.format('mm'));
            $('#modalAddCita').modal('show');
        },
        eventDrop: function(event) {
            if (!confirm("La visita a "+event.event.title + " se reagendara para el: " + moment(event.event.start).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_inicio:moment(event.event.start).format('YYYY-MM-DD HH:mm:ss'),fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
        eventResize: function(event) {
            if (!confirm("La visita a "+event.event.title + " terminara ahora: " + moment(event.event.end).format('dddd, DD-MM-YYYY HH:mm')+". Es esto correcto?")) {
                event.revert();
            }else{
                $.ajax({
                    url: '{{url("e/visita")}}/'+event.event.id,
                    type: 'PUT',
                    data:{_token:"{{csrf_token()}}",fecha_fin:moment(event.event.end).format('YYYY-MM-DD HH:mm:ss')},
                    success: function(response) {
                        calendar.refetchEvents();
                    }
                });
            }
        },
    });

    calendar.render();
})
</script>
<script>
    $(document).ready(function(){
        $('.tareaCheckbox').on('change',function(){
            var valor=$(this).prop('checked');
            $.post("{{route('tarea.completada')}}",{'valor':(valor)?1:0,id:$(this).prop('id').split('_')[1],_token:"{{csrf_token()}}"},function(json){
                if(valor){
                    $('#tarea_estado_'+json.id).html('Realizado');
                    $('#tarea_estado_'+json.id).removeClass('text-c-purple');
                    $('#tarea_estado_'+json.id).addClass('text-c-green');
                }else{
                    $('#tarea_estado_'+json.id).html('Por hacer');                    
                    $('#tarea_estado_'+json.id).removeClass('text-c-green');
                    $('#tarea_estado_'+json.id).addClass('text-c-purple');
                }
                
            },'json');
        })
    });
</script>
@endpush
@push('styles')
<link href='{{asset("assets/plugins/fullcalendar/packages/core/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/daygrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/timegrid/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/list/main.css")}}' rel='stylesheet' />
<link href='{{asset("assets/plugins/fullcalendar/packages/bootstrap/main.css")}}' rel='stylesheet' />
@endpush