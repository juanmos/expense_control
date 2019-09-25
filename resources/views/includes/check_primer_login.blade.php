@if(Auth::user()->primer_login && !Request::is('e/usuario/*'))  
<div class="modal fade bd-example-modal-lg show" name="modalPrimerLogin" id="modalPrimerLogin" tabindex="-1" role="">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                  <div class="card-header ">
                    

                    <h4 class="card-title">Debes completar los datos de tu perfil</h4>
                  </div>
                <div class="modal-body">
                    <p>Por favor ingresa lso datos faltantes de tu perfil, actualiza tu foto y cambia la contraseña por favor</p>
                </div>
                <div class="modal-footer row">
                    <div class="col-md-12">
                        <a class="btn float-left btn-primary" id="cancelar" href="{{route('empresa.usuario.edit',Auth::user()->id)}}">
                            <i class="far fa-user"></i> Ir a mi perfil
                        </a>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#modalPrimerLogin').modal('show');
    });
</script>
@endpush
@endif