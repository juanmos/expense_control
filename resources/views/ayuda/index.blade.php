@extends('layouts.app')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                @include('includes.mensaje')
                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                           
                            <!--[ year  sales section ] end-->
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <h5>Ayudas</h5>
                                        <a class="btn btn-primary float-right" href="{{route('ayuda.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear ayuda</span></a>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            @if($ayudas->count()>0)
                                            @foreach($ayudas as $ayuda)
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                        <h5 class="mb-0">
                                                            <a href="#!" data-toggle="collapse" data-target="#collapse{{$ayuda->id}}" aria-expanded="false" aria-controls="collapse{{$ayuda->id}}">
                                                                {{$ayuda->titulo}}
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div id="collapse{{$ayuda->id}}" class=" card-body collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        {{-- {!! $ayuda->trix('content', [ 'hideToolbar' => ['True'],'containerElement'=>'div' ]) !!}  --}}
                                                        {!! $ayuda->trixRichText[0]->content !!}
                                                        
                                                        {!! Form::open(['route'=>['ayuda.destroy',$ayuda->id],'method'=>'POST']) !!}
                                                        <button type="submit" class="btn btn-danger float-right"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Eliminar</span></button>
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::close() !!}
                                                        <a class="btn btn-primary float-right" href="{{route('ayuda.edit',$ayuda->id)}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Editar</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            {{ $ayudas->links() }}
                                            @else
                                            <h4>No hay ninguna ayuda creada</h4>
                                            <a class="btn btn-primary" href="{{route('ayuda.create')}}"><span class="pcoded-micon"><i class="feather icon-plus-circle"></i></span><span class="pcoded-mtext">Crear ayuda</span></a>
                                            @endif
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
@endsection
@push('styles')
@trixassets
@endpush