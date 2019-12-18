<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{Config::get('app.name')}}</title>
    <link rel="icon" href="{{asset('web/img/favicon.png')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{asset('web/css/animate.css')}}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{asset('web/css/owl.carousel.min.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('web/css/all.css')}}">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{asset('web/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/themify-icons.css')}}">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{asset('web/css/magnific-popup.css')}}">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{asset('web/css/slick.css')}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{asset('web/css/style.css')}}">
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.html"> <img src="{{asset('web/img/logo.png')}}" width="100" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/')}}">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/')}}/#beneficios">Beneficios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/')}}/#precios">Precios</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/ayuda')}}">Ayuda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('/contactos')}}">Contactos</a>
                                </li>
                            </ul>
                        </div>
                        <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
                        {{-- <div class="dropdown cart">
                            <a class="dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cart-plus"></i>
                            </a>
                            <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="single_product">

                                </div>
                            </div> -->
                        </div> --}}
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- Header part end-->
    @yield('content')
    <!--::footer_part start::-->
    <footer class="footer_part">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <a href="index.html" class="footer_logo_iner"> <img src="{{asset('web/img/logo.png')}}" alt="#"> </a>
                        
                    </div>
				</div>
				<div class="col-sm-6 col-lg-3">
					<div class="single_footer_part">
						<h4>Sobre nosotros</h4>
                        <p>
							Somos una startup enfocada en ayudarte a mejorar y simplificar tareas tediosas y 
							rutinarias por medio de tecnología, con mas de 10 años de experiencia en el desarrollo de web y aplicaciones móviles.
						</p>
					</div>
				</div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Contactanos</h4>
                        <p>Dirección : Av de las Americas y Naranjos.</p>
                        <p>Telf : +593 991704980</p>
                        <p>Email : info@factu.app</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Información importante</h4>
                        <ul class="list-unstyled">
                            <li><a href=""> WHMCS-bridge</a></li>
                            <li><a href="">Search Domain</a></li>
                            <li><a href="">My Account</a></li>
                            <li><a href="">Shopping Cart</a></li>
                            <li><a href="">Our Shop</a></li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-sm-6 col-lg-3">
                    <div class="single_footer_part">
                        <h4>Newsletter</h4>
                        <p>Heaven fruitful doesn't over lesser in days. Appear creeping seasons deve behold bearing days
                            open
                        </p>
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
                </div> --}}
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-8">
                    <div class="copyright_text">
                        <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib cant be removed. Template is licensed under CC BY 3.0. --></P>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- <div class="footer_icon social_icon">
                        <ul class="list-unstyled">
                            <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                            <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->

    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="{{asset('web/js/jquery-1.12.1.min.js')}}"></script>
    <!-- popper js -->
    <script src="{{asset('web/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('web/js/bootstrap.min.js')}}"></script>
    <!-- easing js -->
    <script src="{{asset('web/js/jquery.magnific-popup.js')}}"></script>
    <!-- swiper js -->
    <script src="{{asset('web/js/swiper.min.js')}}"></script>
    <!-- swiper js -->
    <script src="{{asset('web/js/masonry.pkgd.js')}}"></script>
    <!-- particles js -->
    <script src="{{asset('web/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('web/js/jquery.nice-select.min.js')}}"></script>
    <!-- slick js -->
    <script src="{{asset('web/js/slick.min.js')}}"></script>
    <script src="{{asset('web/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('web/js/waypoints.min.js')}}"></script>
    <script src="{{asset('web/js/contact.js')}}"></script>
    <script src="{{asset('web/js/jquery.ajaxchimp.min.js')}}"></script>
    <script src="{{asset('web/js/jquery.form.js')}}"></script>
    <script src="{{asset('web/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('web/js/mail-script.js')}}"></script>
    <!-- custom js -->
    <script src="{{asset('web/js/custom.js')}}"></script>
</body>

</html>