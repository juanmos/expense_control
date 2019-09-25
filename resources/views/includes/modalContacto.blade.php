<div class="modal fade bd-example-modal-lg" name="modalContacto" id="modalContacto" tabindex="-1" role="">
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
                            {!! Form::open(['method'=>'POST','id'=>'nuevoContactoForm']) !!}
                            <div class="row">
                                <div class="form-group col-md-6 ">
                                    <label for="exampleInputEmail1">Nombre *</label>
                                    <input type="text" value="" name="nombre" class="form-control" aria-describedby="emailHelp" required="required" placeholder="Nombre">
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="exampleInputPassword1">Apellido *</label>
                                    <input type="text" value="" name="apellido" class="form-control" id="exampleInputPassword1" required="required" placeholder="Apellido">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input type="email" value="" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Cargo</label>
                                    <input type="text" value="" name="cargo" class="form-control" id="exampleInputPassword1" placeholder="Cargo">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Teléfono</label>
                                    <input type="text" value="" name="telefono" class="form-control" id="exampleInputPassword1" placeholder="Teléfono">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Extensión</label>
                                    <input type="text" value="" name="extension" class="form-control" id="exampleInputPassword1" placeholder="Extensión">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Ciudad</label>
                                    {!! Form::select('ciudad_id', [], null ,["class"=>"form-control",'id'=>"ciudad_id"]) !!}
                                </div> 
                                
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Oficina</label>
                                    {!! Form::select('oficina_id', [], null ,["class"=>"form-control",'id'=>"oficina_id"]) !!}
                                </div>  
                            </div>
                            
                            {!! Form::close() !!}
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                
                    <div class="col-md-12">
                      <button type="button" data-dismiss="modal" class="btn float-left btn-danger" data-dismiss="modal">                      
                        <i class="far fa-times-circle"></i> CANCELAR
                      </button>  
                      <button type="button" class="btn btn-success float-right" name="createContact" id="createContact">
                          <i class="fa fa-save"> </i> GUARDAR
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
        $('#createContact').on('click',function(){
            $.post('{{url("contacto/store")}}/'+$('#cliente_id').val()+'/1',$('#nuevoContactoForm').serialize(),function(json){
                $('#contacto_id').empty();
                json.contactos.forEach(function(contacto){
                    $('#contacto_id').append("<option value='"+contacto.id+"'>"+contacto.nombre+" "+contacto.apellido+" - "+contacto.cargo+"</option>");
                    $('#contacto_id').show();
                });
                $("#modalContacto").modal('hide');
            },'json');
        });
        $("#modalContacto").on('show.bs.modal', function(){
            $.get("{{url('/')}}/oficina/"+$('#cliente_id').val(),function(json){
                if(json.oficinas.length>0){
                    json.oficinas.forEach(function(item){
                        $('#oficina_id').append("<option value='"+item.id+"'>"+item.direccion+" - "+item.ciudad.ciudad+"</option>");
                    });
                }
            } ,'json');
            $.get("{{route('varios.ciudades')}}",function(json){
                if(json.ciudades.length>0){
                    json.ciudades.forEach(function(item){
                        $('#ciudad_id').append("<option value='"+item.id+"'>"+item.ciudad+"</option>");
                    });
                }
            } ,'json');
        });
    
    })
</script>
@endpush