@extends('layouts.app')

@section('content')
    <body>
    <div class="preloader">
        <img class="preloader__image" width="55" src="assets/images/loader.png" alt="" />
    </div>
    <!-- /.preloader -->
    <div class="page-wrapper">

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>
                    My
                    @if($etat == 1)
                        Active
                    @elseif($etat == 0)
                        Pending
                    @else
                        Inactive
                    @endif
                    Gardens
                </h2>
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>/</li>
                    <li><span>My Gardens</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <section class="products-page">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-3">
                        <div class="product-sidebar">
                            <div class="product-sidebar__single product-sidebar__search-widget">
                                <div class="text-center">
                                    <a href="{{ route('jardins.create') }}" class="thm-btn products__load-more">add garden</a><!-- /.thm-btn -->
                                </div><!-- /.text-center -->
                            </div><!-- /.product-sidebar__single -->

                            <div class="product-sidebar__single">
                                <h3>Categories</h3>
                                <ul class="list-unstyled product-sidebar__links">
                                    <!-- Filter for Active Gardens (etat = 1) -->
                                   @if($etat != 1)
                                    <li>
                                        <a href="{{ route('getJardinierGardens', ['etat' => 1]) }}" class="{{ $etat == 1 ? 'active' : '' }}">
                                            Active Gardens <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                    @endif
                                    <!-- Filter for Pending Gardens (etat = 0) -->
                                    @if($etat != 0)
                                    <li>
                                        <a href="{{ route('getJardinierGardens', ['etat' => 0]) }}" class="{{ $etat == 0 ? 'active' : '' }}">
                                            Pending Gardens <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if($etat != -1)
                                    <!-- Filter for Inactive Gardens (etat = -1) -->
                                    <li>
                                        <a href="{{ route('getJardinierGardens', ['etat' => -1]) }}" class="{{ $etat == -1 ? 'active' : '' }}">
                                            Inactive Gardens <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                    @endif

                                </ul><!-- /.list-unstyled product-sidebar__links -->

                            </div><!-- /.product-sidebar__single -->
                        </div><!-- /.product-sidebar -->
                    </div><!-- /.col-sm-12 col-md-12 col-lg-3 -->
                    <div class="col-sm-12 col-md-12 col-lg-9">

                        <div class="row">
                            @foreach($jardins as $jardin)

                                    <div class="col-md-6 col-lg-4">
                                        <div class="product-card">
                                            <div class="product-card__image">
                                                <!-- Use an image field from the database if available, or default to placeholder -->
                                                @if($jardin->photo)
                                                    <img src="{{ asset('storage/' . $jardin->photo) }}" alt="Image of {{ $jardin->nom }}" style="max-width: 400px;max-height: 150px">
                                                @else
                                                    <p>No image available</p>
                                                @endif


                                                <div class="product-card__image-content">
                                                    @if($jardin->utilisateur_id==$conectedJardinier)
                                                        <div class="product-card__image-content">

                                                            @if($etat != 0)
                                                            <a style="background:#9f9f00;margin-right: 10px" href="{{ route('jardins.edit', $jardin->id) }}"><i class="fa fa-edit"></i></a>
                                                            @endif

                                                            <form action="{{ route('jardins.destroy', $jardin->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" style="border:none; background:red; padding: 10px ;border-radius: 100%"><i style="color: white;margin-left: 10px;margin-right: 10px" class="fa fa-trash"></i></button>

                                                            </form>

                                                        </div><!-- /.product-card__image-content -->
                                                    @endif
                                                    {{-- Optionally add a button to take an action --}}
                                                    {{-- <a href="{{ route('cart.add', $jardin->id) }}"><i class="organik-icon-shopping-cart"></i></a> --}}
                                                </div><!-- /.product-card__image-content -->
                                            </div><!-- /.product-card__image -->

                                            <div class="product-card__content">
                                                <div class="product-card__left">
                                                    <!-- Jardin Name -->
                                                    <h3><a href="{{ route('jardins.show', $jardin->id) }}">{{ $jardin->nom }}</a></h3>
                                                    <!-- Display Jardin Localisation -->
                                                    <p>{{ $jardin->localisation }}</p>
                                                </div><!-- /.product-card__left -->
                                                <div class="product_detail_review">
                                                    @if ($jardin->reviews_avg_rating!==null)
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <a href="#">
                                                                <a class="@if($i > $jardin->reviews_avg_rating) deactive @endif" href="#">
                                                                    <i style="width: 10px" class="fa fa-star"></i>
                                                                </a>
                                                            </a>
                                                        @endfor
                                                    @else
                                                        <p style="color: green">No reviews yet</p>
                                                    @endif
                                                </div>
                                            </div><!-- /.product-card__content -->
                                        </div><!-- /.product-card -->
                                    </div><!-- /.col-md-6 col-lg-4 -->
                            @endforeach
                        </div><!-- /.row -->
                    </div><!-- /.col-sm-12 col-md-12 col-lg-9 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.products-page -->



    </div><!-- /.page-wrapper -->


    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="organik-icon-close"></i></span>

            <div class="logo-box">
                <a href="index.html" aria-label="logo image"><img src="assets/images/logo-light.png" width="155" alt="" /></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->

            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <i class="organik-icon-email"></i>
                    <a href="mailto:needhelp@organik.com">needhelp@organik.com</a>
                </li>
                <li>
                    <i class="organik-icon-calling"></i>
                    <a href="tel:666-888-0000">666 888 0000</a>
                </li>
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__top">
                <div class="mobile-nav__language">
                    <img src="assets/images/resources/flag-1-1.jpg" alt="">
                    <label class="sr-only" for="language-select">select language</label>
                    <!-- /#language-select.sr-only -->
                    <select class="selectpicker" id="language-select">
                        <option value="english">English</option>
                        <option value="arabic">Arabic</option>
                    </select>
                </div><!-- /.mobile-nav__language -->
                <div class="main-menu__login">
                    <a href="#"><i class="organik-icon-user"></i>Login / Register</a>
                </div><!-- /.main-menu__login -->
            </div><!-- /.mobile-nav__top -->



        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->

    <div class="mini-cart">
        <div class="mini-cart__overlay mini-cart__toggler"></div>
        <div class="mini-cart__content">
            <div class="mini-cart__top">
                <h3 class="mini-cart__title">Shopping Cart</h3>
                <span class="mini-cart__close mini-cart__toggler"><i class="organik-icon-close"></i></span>
            </div><!-- /.mini-cart__top -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-1.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.html">Banana</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-2.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.html">Tomato</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <div class="mini-cart__item">
                <img src="assets/images/products/cart-1-3.jpg" alt="">
                <div class="mini-cart__item-content">
                    <div class="mini-cart__item-top">
                        <h3><a href="product-details.html">Bread</a></h3>
                        <p>$9.99</p>
                    </div><!-- /.mini-cart__item-top -->
                    <div class="quantity-box">
                        <button type="button" class="sub">-</button>
                        <input type="number" id="2" value="1" />
                        <button type="button" class="add">+</button>
                    </div>
                </div><!-- /.mini-cart__item-content -->
            </div><!-- /.mini-cart__item -->
            <a href="checkout.html" class="thm-btn mini-cart__checkout">Proceed To Checkout</a>
        </div><!-- /.mini-cart__content -->
    </div><!-- /.cart-toggler -->

    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="organik-icon-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

    </body>

@endsection
