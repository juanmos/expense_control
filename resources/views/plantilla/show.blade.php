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
                            <!-- [ statistics year chart ] start -->
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-event">
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">{{$plantilla->nombre}}</h5>
                                                <h6 class="mt-3">{{($plantilla->previsita==1)?'Previsita':'Visita'}}</h6>
                                            </div>
                                        </div>
                                        <h6 class="text-muted mt-4 mb-0">
                                            <a href="{{route('plantilla.edit',$plantilla->id)}}" class="label theme-bg text-white f-12">Editar</a> 
                                        </h6>
                                        <i class="far fa-building text-c-purple f-50"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- [ statistics year chart ] end -->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-8 col-md-6">
                                <div class="card Recent-Users">
                                    <div class="card-block px-0 py-3 row">
                                        <div class="col-md-12" ><a href="#" class="btn btn-primary nuevoCampo float-right"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Agregar campo</span></a></div>
                                        <div class="col-md-12" id="camposPreview">
                                            <ul class="list-group list-group-sortable">
                                            @if($plantilla->detalles->count()>0)
                                                
                                                @foreach ($plantilla->detalles()->orderBy('orden')->get() as $detalle )
                                                <li class="list-group-item"  id="{{$detalle->id}}" orden="{{$detalle->orden}}">
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <span class="feather icon-move"></span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h6 class="mb-2">{{$detalle->label}}</h6>
                                                            @if($detalle->tipo_campo==1)
                                                            <input type="text" class="form-control col-md-12 borderColorElement mb-2" placeholder="{{$detalle->label}}" />
                                                            @elseif($detalle->tipo_campo==2)
                                                            <textarea rows="4" class="form-control borderColorElement mb-2"  placeholder="{{$detalle->label}}"></textarea>
                                                            @elseif($detalle->tipo_campo==3)
                                                            <input type="text" class="form-control col-md-12 borderColorElement mb-2"  placeholder="{{$detalle->label}}"/>
                                                            @elseif($detalle->tipo_campo==4)
                                                            <select class="form-control opcionesId_{{$detalle->id}} col-md-12 full-width-fix">
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                    <option value="{{$opcion}}">{{$opcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            @elseif($detalle->tipo_campo==6)
                                                                @if($detalle->opciones!=null)
                                                                @foreach(explode('|',$detalle->opciones) as $opcion)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="check_{{$detalle->id}}" value="{{$opcion}}"> {{$opcion}}
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                    <input type="checkbox" class="custom-control-input" name="check_{{$detalle->id}}"> Check 
                                                                @endif
                                                            @else
                                                            <div class="mb-2">&nbsp;</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a href="#" class="label btn-primary text-white f-12 btnModificar" myid="{{$detalle->id}}" title="Editar"><i class="fas fa-edit"></i></a>
                                                            @if($detalle->tipo_campo==4 || $detalle->tipo_campo==6)
                                                                <a href="#" class="label btn-secondary text-white f-12 btnOpciones" myid="{{$detalle->id}}" title="Opciones"><i class="fa fa-chevron-circle-down"></i></a>
                                                            @endif
                                                            <a href="#" class="label btn-danger text-white f-12 btnEliminar" myid="{{$detalle->id}}" title="Eliminar"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            
                                            @else
                                                <li class="list-group-item">
                                                    <p>No hay vista previa de la plantilla</p>
                                                    <a href="#" class="btn btn-primary nuevoCampo"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext"> Agregar campo</span></a>
                                                </li>
                                            @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->

                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" name="modalNuevoCampo" id="modalNuevoCampo" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Campos personalizados</h4>
                  </div>
                </div>
                <div class="modal-body" align="center">    
                    <div class="row">                
                        <div class="form-group-select col-md-12">   
                            <div class="form-group col-md-12 ">                     
                                <label class="col-md-4">Tipo de campo:</label>                            
                                {!! Form::select('tipoCampo', ['1'=>'Texto corto','2'=>'Texto largo','3'=>'Numero','4'=>'Opciones','5'=>'Etiqueta','6'=>'Checks'], 1 ,array("class"=>"form-control","id"=>"tipoCampo")); !!}                            
                            </div>
                        </div>
                        <div class="form-group-select col-md-12">
                            <div class="form-group col-md-12 ">
                                <label for="exampleInputEmail1">Nombre del campo</label>
                                <input type="text" id="nombreCampo" value="" name="label" class="form-control" aria-describedby="emailHelp" placeholder="Nombre del campo">
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                     
                        <button class="btn btn-danger float-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button class="btn btn-primary float-right" id="btnGuardaTipoCampo">
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="" id="campoId"/>
                        <input type="hidden" value="false" id="antecedentes"/>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-md" name="opcionesCampo" id="opcionesCampo" tabindex="-1" role="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain"> 
                <div class="">
                  <div class="card-header card-header-blue text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Opciones del campo</h4>
                  </div>
                </div>
                <div class="modal-body">
                    <div id="opcionesView">                        
                        <div class="col-md-12 row">
                            <label class="col-md-2"><b>1:</b></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="modal-footer">    
                    <div class="col-md-12">                                    
                        <button class="btn btn-danger pull-left" data-dismiss="modal">
                            <i class="fas fa-times-circle"> </i> CERRAR
                        </button>
                        <button class="btn btn-primary float-right" id="btnGuardaOpcionesCampo" >
                            <i class="fa fa-save"> </i> GUARDAR
                        </button>
                        <input type="hidden" value="" id="campoOpcionesId"/>
                        <input type="hidden" value="" id="antecedentesOpcionesId"/> 
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('assets/plugins/jquery-sortable/jquery.sortable.min.js')}}"></script>
<script type="text/javascript">
    var opcionCount=1;
    var opcionCountAnt=1;

    $(document).ready(function(){
        $('.list-group-sortable').sortable({
            placeholderClass: 'list-group-item'
        }).on('sortupdate', function(e, ui) {
            var orden = [];
            for(var i=0;i<e.currentTarget.children.length ;i++){
                orden[i]=e.currentTarget.children[i].id;
            };
            $.post("{{route('plantilla.campo.orden',$plantilla->id)}}",{ids:orden.join(','),_token:"{{csrf_token()}}"},function(json){

            },'json');
        });
;
    });

    $(document).on('click','.nuevoCampo',function(){
        $('#modalNuevoCampo').modal('show');
        // $('#tipoCampo').val('');
        $('#ordenCampo').val('');
        $('#nombreCampo').val('');
        $('#campoId').val('');
        $('#antecedentes').val("false");
    });

    $(document).on('click','#btnGuardaTipoCampo',function(){
        var tipoCampo = $('select[name=tipoCampo]').val();
        if ($('#nombreCampo').val() != "") {
            $.post("{{route('plantilla.campo.create',$plantilla->id)}}",{_token:"{{csrf_token()}}",tipo_campo:$('select[name=tipoCampo]').val(),orden:$('#ordenCampo').val() ,label:$('#nombreCampo').val(),id:$('#campoId').val()},function(json){
                llenaCampos(json);            
            },'json');
            cleanFields();
        }else {
            alert("Ingrese todos los campos por favor.");
        }            
                         
    });

    function cleanFields() {
        $('#modalNuevoCampo').modal('hide');
        // $('#tipoCampo').val('');
        $('#ordenCampo').val('');
        $('#nombreCampo').val('');
        $('#campoId').val('');
    }

    $(document).on('click','.btnEliminar',function(e){
        e.preventDefault();
        var r = confirm("Está seguro que desea eliminar el campo, ya no estará visible en sus fichas médicas");
        if (r == true) {
            $.post("{{route('plantilla.campo.eliminar')}}",{_token:"{{csrf_token()}}",id:$(this).attr('myid')},function(json){
                llenaCampos(json);;
            },'json')
        }
    });

    $(document).on('click','.btnModificar',function(e){
        e.preventDefault();
        $.get("{{url('plantilla/campo/edit/')}}/"+$(this).attr('myid'),function(json){
            $('#tipoCampo').val(json.campo.tipo_campo);
            $('#ordenCampo').val(json.campo.orden);
            $('#nombreCampo').val(json.campo.label);
            $('#campoId').val(json.campo.id);
            $('#modalNuevoCampo').modal('show');
            $('#antecedentes').val("false");
        },'json')
        
    });
   
    $(document).on('click','.btnOpciones',function(e){
        e.preventDefault();
        opcionCount=1;
        $('#campoOpcionesId').val($(this).attr('myid'));
        $('#antecedentesOpcionesId').val('false');
        if($(".opcionesId_"+$(this).attr('myid')+" option").length>0){
            $('#opcionesView').empty();
            opcionCount=0;
            $(".opcionesId_"+$(this).attr('myid')+" option").each(function(){
                opcionCount++;
                $('#opcionesView').append('<div class="col-md-12 row" id="row_'+opcionCount+'">\
                    <label class="col-md-2"><b>'+opcionCount+':</b></label>\
                    <div class="col-md-8"><input type="text" value="'+$(this).val()+'" class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/></div>\
                    <div class="col-md-1"><a href="#" class="label btn-danger text-white f-12 removeOpcion" count="'+opcionCount+'"><i class="fa fa-times-circle"></i></a></div>\
                </div>');
            });
        }        
        $('#opcionesCampo').modal('show');
    })
    
    $(document).on('focus','.opcionCampo',function(){
        opcionCount++;
        $('#opcionesView').append('<div class="col-md-12 row" id="row_'+opcionCount+'">\
            <label class="col-md-2"><b>'+opcionCount+':</b></label>\
            <div class="col-md-8"><input type="text"  class="form-control borderColorElement opcionCampo" name="opcionCampo[]"/></div>\
            <div class="col-md-1"><a href="#" class="label btn-danger text-white f-12 removeOpcion" count="'+opcionCount+'"><i class="fa fa-times-circle"></i></a></div>\
        </div>');
        
    });
    $(document).on('click','.removeOpcion',function(e){
        e.preventDefault();
        var count = $(this).attr('count');
        if(count>1){
            $('#row_'+count).remove();
        }else{
            alert('No puede eliminar el primer campo!')
        }
        
        if(count==opcionCount && count>1){
            opcionCount--;
        }
    })
    $(document).on('click','#btnGuardaOpcionesCampo',function(){
        var opciones = $('input[name="opcionCampo[]"]').map(function(){ 
                if(this.value!='')
                    return this.value; 
                else
                    return ;
            }).get();
        
        $.post("{{route('plantilla.campo.opciones')}}",{_token:"{{csrf_token()}}",id:$('#campoOpcionesId').val(),'opciones[]':opciones},function(json){
            llenaCampos(json);
            $('#opcionesCampo').modal('hide');
        },'json')
        
            
    })

    function llenaCampos(json){
        $('.list-group-sortable').empty();
        json.campos.forEach(function(data){
            var campo='<li class="list-group-item"  id="'+data.id+'" orden="'+data.orden+'">';
            campo+='<div class="row"><div class="col-md-1"><span class="feather icon-move"></span></div><div class="col-md-8"><h6 class="mb-2">'+data.label+'</h6>';
            if(data.tipo_campo==1){
                campo+='<input type="text" class="form-control  mb-2 col-md-12 borderColorElement" placeholder="'+data.label+'" />';
            }else if(data.tipo_campo==2){
                campo+='<textarea rows="4" class="form-control  mb-2 borderColorElement"  placeholder="'+data.label+'"></textarea>';
            }else if(data.tipo_campo==3){
                campo+='<input type="text" class="form-control  mb-2 col-md-12 borderColorElement"  placeholder="'+data.label+'"/>';
            }else if(data.tipo_campo==4){
                campo+='<select class="selectpicker  mb-2 borderColorElement opcionesId_'+data.id+' col-md-12 full-width-fix">';
                if(data.opciones!=null){
                    data.opciones.split('|').forEach(function(opcion){
                        campo+='<option value="'+opcion+'">'+opcion+'</option>';
                    });
                }
                campo+='</select>';
            }else if(data.tipo_campo==6){
                
                if(data.opciones!=null){
                    data.opciones.split('|').forEach(function(opcion){
                        campo+='<input type="checkbox" value="'+opcion+'" name="check_'+data.id+'"/> '+opcion;
                    });
                }else{
                    campo+='<input type="checkbox" value="" name="check_'+data.id+'"/> Check';
                }
                
            }else{
                campo+='<div class="mb-2">&nbsp;</div>';
            }
            campo+='</div><div class="col-md-3"><a href="#" class="label btn-primary text-white f-12 btnModificar" myid="'+data.id+'" title="Editar"><i class="fas fa-edit"></i></a>';
            if(data.tipo_campo==4 || data.tipo_campo==6){
                campo+='<a href="#" class="label btn-secondary text-white f-12 btnOpciones" myid="'+data.id+'" title="Opciones"><i class="fa fa-chevron-circle-down"></i></a>';
            }
            campo+='<a href="#" class="label btn-danger text-white f-12 btnEliminar" myid="'+data.id+'" title="Eliminar"><i class="fa fa-trash"></i></a>';
            campo+='</div></li>';
            $('.list-group-sortable').append(campo);
            $('.list-group-sortable').sortable('destroy');
            $('.list-group-sortable').sortable({
                placeholderClass: 'list-group-item'
            }).on('sortupdate', function(e, ui) {
                var orden = [];
                for(var i=0;i<e.currentTarget.children.length ;i++){
                    orden[i]=e.currentTarget.children[i].id;
                };
                $.post("{{route('plantilla.campo.orden',$plantilla->id)}}",{ids:orden.join(','),_token:"{{csrf_token()}}"},function(json){

                },'json');
            });
        })
    }
    
    var campos ={campos: JSON.parse($('#campos').val())};
    var ant={antecedentes:JSON.parse($('#camposAnt').val())};
    llenaCampos(campos);
    llenaAnt(ant);
</script>
@endpush