@extends('web.layout')
@section('content')
    <!-- banner part start-->
    <section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="banner_text">
                        <div class="banner_text_iner">
                            <h1>Contabilidad y Facturación electrónica
                                fácil y sencilla</h1>
                            <p>Maneja tus facturas, compras, retenciones y clientes desde un solo lugar, de manera fácil y disponible desde cualquier plataforma.</p>
                            <a href="#beneficios" class="btn_2 banner_btn_1">Conocer más </a>
							<a href="{{route('login')}}" class="btn_2 banner_btn_2">Iniciar sesión </a>
							<a href="{{route('register')}}" class="btn_2 banner_btn_2">Registrarme </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner_img d-none d-lg-block">
                        <img src="{{asset('web/img/banner_img.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner part start-->

    <!-- feature_part start-->
    <section id="beneficios" class="feature_part padding_top">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 ">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-sm-6">
                            <div class="single_feature">
                                <div class="single_feature_part">
                                    <img src="{{asset('web/img/icon/facturas.png')}}" alt="">
                                    <h4>FACTURACION</h4>
                                    <p>Factura electronicamente desde cualquier lugar y dispositivo</p>
                                </div>
							</div>
							<div class="single_feature">
                                <div class="single_feature_part single_feature_part_2">
                                    <img src="{{asset('web/img/icon/retenciones.png')}}" alt="">
                                    <h4>RETENCIONES</h4>
                                    <p>Obtenemos directamente del SRI todas las retenciones recibidas</p>
                                </div>
                            </div>
							
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="single_feature">
                                <div class="single_feature_part">
                                    <img src="{{asset('web/img/icon/compras.png')}}" alt="">
                                    <h4>COMPRAS</h4>
                                    <p>Todas tus compras en un solo lugar y clasificadas por rubro</p>
                                </div>
                            </div>
                            <div class="single_feature">
                                <div class="single_feature_part single_feature_part_2">
                                    <img src="{{asset('web/img/icon/clientes.png')}}" alt="">
                                    <h4>CLIENTES Y CRM</h4>
                                    <p>Gestiona las relaciones con tus clientes desde nuestro CRM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="feature_part_text">
                        <h2>Solución completa para tu día a día</h2>
                        <p>Somos una solución completa para el manejo de tus facturas, tus compras, retenciones y manejo de clientes todo en un solo lugar y conectados al SRI.</p>
                        <p>Ten toda tu información almacenada en un solo lugar, gestiona tus declaraciones al SRI de forma fácil mediante nuestro metodo de exportación a EXCEL</p>
                        {{-- <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-5">
                                <div class="feature_part_text_iner">
                                    <h4>50k</h4>
                                    <p>Usuarios inscritos</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-5">
                                <div class="feature_part_text_iner">
                                    <h4>100k</h4>
                                    <p>Facturas realizadas</p>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <a href="#" class="btn_4">conoce más <img src="{{asset('web/img/icon/right-arrow.svg')}}" alt=""></a> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <img src="{{asset('web/img/animate_icon/Shape-1.png')}}" alt="" class="feature_icon_1">
        <img src="{{asset('web/img/animate_icon/Shape-14.png')}}" alt="" class="feature_icon_2">
        <img src="{{asset('web/img/animate_icon/Shape.png')}}" alt="" class="feature_icon_3">
        <img src="{{asset('web/img/animate_icon/Shape-3.png')}}" alt="" class="feature_icon_4">
    </section>
    <!-- upcoming_event part start-->

    <!-- about_us part start-->
    <section class="about_us section_padding">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-6">
                    <div class="about_us_text">
                        <h2>Olvidate de los problemas
							del facturero físico.</h2>
						<p>
							<ul>
								<li><img src="{{asset('web/img/icon/remove.png')}}" style="width:20px; padding-right:2px;" alt="">No más facturas caducadas.</li>
								<li><img src="{{asset('web/img/icon/remove.png')}}" style="width:20px; padding-right:2px;" alt="">Olvidate de ir a entregar tus facturas.</li>
								<li><img src="{{asset('web/img/icon/remove.png')}}" style="width:20px; padding-right:2px;" alt="">Te olvidaste el facturero.</li>
								<li><img src="{{asset('web/img/icon/remove.png')}}" style="width:20px; padding-right:2px;" alt="">No te ha llegado la retención.</li>
							</ul>
						</p>
                        <a href="#" class="btn_1">iniciar sesión</a>
                        <a href="#" class="btn_2">registrarme</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="learning_img">
                        <img src="{{asset('web/img/relax.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('web/img/left_sharp.png')}}" alt="" class="left_shape_1">
        <img src="{{asset('web/img/about_shape.png')}}" alt="" class="about_shape_1">
        <img src="{{asset('web/img/animate_icon/Shape-16.png')}}" alt="" class="feature_icon_1">
        <img src="{{asset('web/img/animate_icon/Shape-1.png')}}" alt="" class="feature_icon_4">
    </section>
    <!-- about_us part end-->
	<!-- about_us part start-->
    <section class="about_us right_time">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 col-lg-6">
                    <div class="learning_img">
                        <img src="{{asset('web/img/about_img_3.png')}}" alt="">
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="about_us_text">
                        <h2>Haz facturas desde cualquier lugar</h2>
						<p>Usa nuestra aplicación móvil para poder facturar desde cualquier lugar, en cualquier momento.
							<br>Descargala ahora mismo</p>
                        <a href="https://apps.apple.com/us/app/factu/id1450193094?l=es&ls=1"><img width="150" src="{{asset('images/apple.png')}}"/></a>
                        <a href="https://play.google.com/store/apps/details?id=app.factu.naturales"><img width="150" src="{{asset('images/google.png')}}"/></a>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('web/img/about_shape.png')}}" alt="" class="about_shape_1">
        <img src="{{asset('web/img/animate_icon/Shape-1.png')}}" alt="" class="feature_icon_1">
        <img src="{{asset('web/img/animate_icon/Shape.png')}}" alt="" class="feature_icon_4">
    </section>
    <!-- about_us part end-->
    
    <section class="use_sasu section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section_tittle text-center">
                        <h2>Quienes pueden usar factu?</h2>
                        <p>Factu es para cualqueir persona que quiera usar facturación electronica y llevar todas sus compras y retenciones en un solo lugar</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src="{{asset('web/img/abogado.png')}}" alt="">
                            <h4>Personas naturales obligados a facturar</h4>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src="{{asset('web/img/doctora.png')}}" alt="">
                            <h4>Doctores, dentistas, Veterianarios</h4>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <img src="{{asset('web/img/startup.png')}}" alt="">
                            <h4>Startups y Emprendimientos</h4>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('web/img/animate_icon/Shape-14.png')}}" alt="" class="feature_icon_1">
        <img src="{{asset('web/img/animate_icon/Shape-10.png')}}" alt="" class="feature_icon_2">
        <img src="{{asset('web/img/animate_icon/Shape.png')}}" alt="" class="feature_icon_3">
        <img src="{{asset('web/img/animate_icon/Shape-13.png')}}" alt="" class="feature_icon_4">
    </section>
    <!-- use sasu part end-->

    

    <!-- pricing part start-->
    <section id="precios" class="pricing_part mb_130 home_page_pricing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_tittle text-center">
                        <h2>Precios</h2>
                        <p>Usa nuestra plataforma gratuitamente para obtener tus compras y retenciones electronicas, y cuando quieras comenzar a facturar paga un valor mensual</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-sm-6">
                    <div class="single_pricing_part">
                        {{-- <img src="{{asset('web/img/icon/feature_icon_1.png')}}" alt=""> --}}
                        <p>gratuito</p>
                        <h3>Gratis <span></span></h3>
                        <ul>
                            <li>Ingreso de facturas manuales</li>
                            <li>Ingreso de compras manuales</li>
                            <li>Ingreso de retenciones manuales</li>
                            <li>Almacenamiento ilimitados de todos tus comprobantes</li>
                            <li>Estadisticas de ventas, compras y retenciones</li>
                            <li>Manejo de clientes</li>
                            <li>Soporte 8/5</li>
                        </ul>
                        <a href="{{route('register')}}" class="btn_1">Registrarme</a>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-6">
                    <div class="single_pricing_part">
                        {{-- <img src="{{asset('web/img/icon/feature_icon_2.png')}}" alt=""> --}}
                        <p>facturador</p>
                        <h3>$9.99 <span>/ mes</span></h3>
                        <ul>
                            <li>Todo lo del plan gratuito</li>
                            <li>Facturación Electrónica</li>
                            <li>Obtención de compras electroinicas desde el SRI</li>
                            <li>Obtención de retenciones electronicas desde el SRI</li>
							<li>CRM de clientes</li>
							<li>Acceso para contadores</li>
							<li>Punto de venta móvil y web</li>
							<li>Aplicación para iPAD</li>
                            <li>Soporte 24/7</li>
                        </ul>
                        <a href="{{route('register')}}" class="btn_1">Registrarme</a>
                    </div>
                </div>
                
            </div>
        </div>
        <img src="{{asset('web/img/left_sharp.png')}}" alt="" class="left_shape_1">
        <img src="{{asset('web/img/animate_icon/Shape-1.png')}}" alt="" class="feature_icon_1">
        <img src="{{asset('web/img/animate_icon/Shape.png')}}" alt="" class="feature_icon_4">
    </section>
    <!-- pricing part end-->

    <!-- cta part start-->
    <section class="cta_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="cta_text text-center single_footer_part">
                        <h2>Suscribete a nuestro boletin</h2>
                        <p>Recibe la ultima información sobre factu, nuevas funcionalidades, eventos y mucho más</p>
                        <div id="mc_embed_signup">
                            <form target="_blank"
                                action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                method="get" class="subscribe_form relative mail_part">
                                <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                                    class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = ' Email Address '">
                                <button type="submit" name="submit" id="newsletter-submit"
                                    class="email_icon newsletter-submit button-contactForm"><i
                                        class="far fa-paper-plane"></i></button>
                                <div class="mt-10 info"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cta part end-->

@endsection