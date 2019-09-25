<div class="modal fade bd-example-modal-lg" name="modalBuscaCliente" id="modalBuscaCliente" tabindex="-1" role="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                  <div class="card-header ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      <i class="material-icons">clear</i>
                    </button>

                    <h4 class="card-title">Buscar clientes</h4>
                  </div>
                <div class="modal-body">
                    {!! Form::open() !!}
                        <div class="row overflow-y-auto">                            
                            <div class="col-md-3">
                                <label>Buscar el cliente:</label>
                            </div>
                            <div class="col-md-9">                                
                                <input type="text" name="buscar" required id="buscar" class="form-control borderColorElement" value="" placeholder="Escriba el nombre de la empresa o el RUC">
                            </div>
                        </div>
                        <br/>
                        <div class="row overflow-y-auto height250">
                            <div ID="scroll" class="col-md-12 table-responsive">
                                <table id="table" class="table table-striped table-hover tabbable-wrap-content table-condensed" cellspacing="0" width="100%">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Teléfono</th>
                                            <th>Web</th>
                                            <th>Clasificación</th>
                                            <th class="qr_action">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="entrydata">                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {!! Form::close()!!}
                </div>
                <div class="modal-footer row">
                    <div class="col-md-12">
                        <button data-dismiss="modal" class="btn float-left btn-danger" data-dismiss="modal" id="cancelar">
                            <i class="far fa-times-circle"></i> CANCELAR
                        </button>
                    </div>    
                </div>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Cliente: </label>
                                <div class="col-md-10">
                                    <input type="text" required name="nombre" class="form-control" id="nombreAdd" >
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Teléfono: </label>
                                <div class="col-md-10">
                                    <input type="text" name="telefono" class="form-control" id="telefono" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-7 control-label ">Web: </label>
                                <div class="col-md-11">
                                    <input type="email" required name="web" class="form-control" id="email" >
                                </div>
                            </div>
                            <input type="hidden" id="cliente_id" name="cliente_id"/>
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group-select col-md-7">
                                    <label class="col-md-7 control-label ">Contacto: </label>
                                    <div class="col-md-12">
                                      <select name="contacto_id" id="contacto_id" class="form-control tipoCitaId required selectpicker full-width-fix"></select>
                                      <a href="" data-toggle="modal" data-target="#modalContacto">Nuevo contacto</a>
                                    </div>
                                </div>
                                <div class="form-group-select col-md-5">
                                    <label class="col-md-7 control-label ">Duración: </label>
                                    <div class="col-md-12">
                                      {!! Form::select('tiempo_visita', $tiempoVisita, Auth::user()->empresa->configuracion->tiempo_visita ,["class"=>"form-control"]) !!}
                                    </div>
                                </div>
                                <div class="form-group-select col-md-7">
                                    <label class="col-md-7 control-label ">Tipo: </label>
                                    <div class="col-md-12">
                                        {!! Form::select('tipo_visita_id', $tiposVisita, 0 ,array("class"=>"form-control tipoCitaId required selectpicker full-width-fix")); !!}                                         
                                    </div>
                                </div>
                                <div class="form-group-select col-md-5">
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
                      <button type="button" class="btn btn-secondary" id="buscaCliente">
                          <i class="fa fa-search"> </i> CAMBIAR CLIENTE
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
@include('includes.modalContacto')
@push('scripts')

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#aceptCreate',function(e){
      if ($('#cliente_id').val() != '') {
        var data = {cliente_id:$('#cliente_id').val() ,horaEstimada:$('#horaModal').val()+':'+$('#minModal').val()+':00', fecha:$('#anioModal').val()+'/'+$('#mesModal').val()+'/'+$('#diaModal').val(), usuario_id:{{$usuario_id}},tipo_visita_id:$('select[name=tipo_visita_id]').val(), tiempo_visita:$('select[name=tiempo_visita]').val(),contacto_id:$('select[name=contacto_id]').val(),_token:'{{csrf_token()}}'};
        saveVisita(data);
        
      }else {
        alert('Campo requerido');
        $("#nombreAdd").focus();
      }
    });
    function saveVisita(data) { 
      $.post("{{route('visita.store')}}",data,function(json){          
        $('#modalAddCita').modal('hide');      
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
    $('#buscar').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
    $(document).on('keyup', '#buscar', function(event){            
        if($(this).val().length == 0){
            $('#buscar').blur();
            lista();
            $('#buscar').focus();
        }else if($(this).val().length >= 2){
            if((event.keyCode == 8) || (event.keyCode == 32) || (event.keyCode == 35) || (event.keyCode == 36) || (event.keyCode == 37) || (event.keyCode == 39)){
                $('#entrydata').empty();
            }else{
                $('#buscar').blur();
                lista();
                $('#buscar').focus();
            }
        }else{
            $('#entrydata').empty();
        }
    });
    $(document).on('click','.seleccionarCliente',function(){
        $('#nombreAdd').val($(this).attr("nombre"));
        $('#telefono ').val($(this).attr("telefono"));
        $('#email').val($(this).attr('web'));
        $('#cliente_id').val($(this).attr('myid'));
        $('#modalBuscaCliente').modal('hide');
        $('#modalAddCita').modal('show');
        $('#entrydata').empty();
        $('#buscar').val('');
        $.post("{{route('contacto.buscar')}}",{_token:"{{csrf_token()}}",cliente_id:$(this).attr('myid')},function(json){
            $('#contacto_id').empty();
            if(json.length>0){
                json.forEach(function(contacto){
                    $('#contacto_id').append("<option value='"+contacto.id+"'>"+contacto.nombre+" "+contacto.apellido+" - "+contacto.cargo+"</option>");
                })
                $('#contacto_id').show();
            }else{
                $('#contacto_id').hide();
            }
        },'json');
    });

    $('#cancelar').on('click',function(){
        $('#entrydata').empty();
        $('#buscar').val('');
    })

    $(document).on('click','#selectCliente',function(e){ 
        e.preventDefault();
    });
    
    function lista (){
        var data = {buscar:$('#buscar').val(),vendedor_id:{{$usuario_id}}, _token:$('input[name="_token"]').val()};
        $.post("{{route('cliente.buscar')}}",data, function(json){
            $('#entrydata').empty();
            json.clientes.data.forEach(function(cliente){
                var web=(cliente.web!=null)?cliente.web:'';
                var telefono=(cliente.telefono!=null)?cliente.telefono:'';
                var cedula=(cliente.cedula!=null)?cliente.cedula:'';
                $('#entrydata').append('<tr class="seleccionarCliente" myid="'+cliente.id+'" nombre="'+cliente.nombre+'" telefono="'+telefono+'" web="'+web+'"><td>'+cliente.nombre+'</td><td>'+telefono+'</td><td>'+web+'</td><td>'+cliente.clasificacion.clasificacion+'</td><td><a id="selectCliente" class="btn btn-primary btn-sm" href="#">Seleccionar</a></td></tr>');    
            })
        } ,'json');            
    }
    $(document).on('click','#buscaCliente', function(event){
        $('#modalAddCita').modal('hide');
        $('#modalBuscaCliente').modal('show');
    }); 
  })
</script>
@endpush