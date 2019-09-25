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
                                <div class="form-group-select col-md-6">
                                    <label class="col-md-7 control-label ">Contacto: </label>
                                    <div class="col-md-12">
                                        @if($cliente!=null)
                                        {!! Form::select("contacto_id", $cliente->contactos->pluck('name_cargo','id'), 0, ["class"=>"form-control tipoCitaId required selectpicker full-width-fix"]) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group-select col-md-6">
                                    <label class="col-md-7 control-label ">Vendedor: </label>
                                    <div class="col-md-12">
                                      {!! Form::select('usuario_id', Auth::user()->empresa->usuarios->pluck('full_name','id'),0 ,["class"=>"form-control"]) !!}
                                    </div>
                                </div>
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
@push('scripts')

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#aceptCreate',function(e){
      if ($('#cliente_id').val() != '') {
        var data = {cliente_id:{{$cliente->id}} ,horaEstimada:$('#horaModal').val()+':'+$('#minModal').val()+':00', fecha:$('#anioModal').val()+'/'+$('#mesModal').val()+'/'+$('#diaModal').val(), usuario_id:$('select[name=usuario_id]').val(),tipo_visita_id:$('select[name=tipo_visita_id]').val(), tiempo_visita:$('select[name=tiempo_visita]').val(),contacto_id:$('select[name=contacto_id]').val(),_token:'{{csrf_token()}}'};
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
    
  })
</script>
@endpush