@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <div class="main-content">
        <div class="wrap-banner">
            <!-- menu category -->
            <div class="menu-banner d-xs-none">
                <div class="tiva-verticalmenu block" data-count_showmore="17">
                    <div class="box-content block_content">
                        <div class="verticalmenu" role="navigation">
                            <ul class="menu level1">
                                <li class="item parent">
                                    <a href="#" class="hasicon" title="SIDE TABLE">
                                        <img src="img/home/table-lamp.png" alt="img">SIDE TABLE</a>
                                    <div class="dropdown-menu">
                                        <div class="menu-items">
                                            <ul>
                                                <li class="item">
                                                    <a href="#" title="Aliquam lobortis">Aliquam lobortis</a>
                                                </li>
                                                <li class="item parent-submenu parent">
                                                    <a href="#" title="Duis Reprehenderit">Duis Reprehenderit</a>
                                                    <span class="show-sub fa-active-sub"></span>
                                                    <div class="dropdown-submenu">
                                                        <div class="menu-items">
                                                            <ul>
                                                                <li class="item">
                                                                    <a href="#" title="Aliquam lobortis">Aliquam
                                                                        lobortis</a>
                                                                </li>
                                                                <li class="item">
                                                                    <a href="#" title="Duis Reprehenderit">Duis
                                                                        Reprehenderit</a>
                                                                </li>
                                                                <li class="item">
                                                                    <a href="#" title="Voluptate">Voluptate</a>
                                                                </li>
                                                                <li class="item">
                                                                    <a href="#" title="Tongue Est">Tongue Est</a>
                                                                </li>
                                                                <li class="item">
                                                                    <a href="#" title="Venison Andouille">Venison
                                                                        Andouille</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <a href="#" title="Voluptate">Voluptate</a>
                                                </li>
                                                <li class="item">
                                                    <a href="#" title="Tongue Est">Tongue Est</a>
                                                </li>
                                                <li class="item">
                                                    <a href="#" title="Venison Andouille">Venison Andouille</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="item parent group">
                                    <a href="#" class="hasicon" title="FI">
                                        <img src="img/home/fireplace.png" alt="img">FIREPLACE
                                    </a>
                                    <div class="dropdown-menu menu-2">
                                        <div class="menu-items">
                                            <div class="item">
                                                <div class="menu-content">
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>DINNING ROOM</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">Toshiba</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Samsung</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>BATHROOM</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">Toshiba</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Samsung</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier Media</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Gee</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Digimart</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Vitivaa</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sanaky</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sunshine</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>LIVING ROOM</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">Media</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Gee</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Digimart</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Vitivaa</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sanaky</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sunshine</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Toshiba</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Samsung</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>BEDROOM</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>KITCHEN</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tags">
                                                        <div class="title float-left">
                                                            <b>Blender</b>
                                                        </div>
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <a href="#">LG</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Sharp</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Electrolux</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Hitachi</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Panasonic</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Mitsubishi Electric</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Daikin</a>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <a href="#">Haier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item group-category-img parent group">
                                    <a href="#" class="hasicon" title="TABLE LAMP">
                                        <img src="img/home/table-lamp.png" alt="img">TABLE LAMP
                                    </a>
                                    <div class="dropdown-menu menu-3">
                                        <div class="menu-items">
                                            <div class="item">
                                                <div class="menu-content">
                                                    <div class="group-category row">
                                                        <div class="mt-20">
                                                            <div class="d-flex">
                                                                <div class="col">
                                                                    <span class="menu-title">Coventry dining</span>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">Accessories</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Activewear</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">ASOS Basic Tops</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Bags &amp; Purses</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Beauty</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Coats &amp; Jackets</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Curve &amp; Plus Size</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col">
                                                                    <span class="menu-title">Amara stools</span>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">Accessories</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Activewear</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">ASOS Basic Tops</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Bags &amp; Purses</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Beauty</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Coats &amp; Jackets</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Curve &amp; Plus Size</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="col">
                                                                    <span class="menu-title">Kingston dining</span>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">Accessories</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Activewear</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">ASOS Basic Tops</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Bags &amp; Purses</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Beauty</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Coats &amp; Jackets</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Curve &amp; Plus Size</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col">
                                                                    <span class="menu-title">Ellinger dining</span>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">Accessories</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Activewear</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">ASOS Basic Tops</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Bags &amp; Purses</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Beauty</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Coats &amp; Jackets</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">Curve &amp; Plus Size</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ml-15">
                                                            <a>
                                                                <img class="img-fluid" src="img/home/img-menu.jpg"
                                                                    alt="img">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="OTTOMAN">
                                        <img src="img/home/ottoman.png" alt="img">OTTOMAN
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="ARMCHAIR">
                                        <img src="img/home/armchair.png" alt="img">ARMCHAIR
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="CUSHION">
                                        <img src="img/home/cushion.png" alt="img">CUSHION
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="COFFEE TABLE">
                                        <img src="img/home/coffee_table.png" alt="img">COFFEE TABLE</a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="SHELF">
                                        <img src="img/home/shelf.png" alt="img">SHELF
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="SOFA">
                                        <img src="img/home/sofa.png" alt="img">SOFA
                                    </a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="DRESSING TABLE">
                                        <img src="img/home/dressing.png" alt="img">DRESSING TABLE</a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="WINDOWN CURTAIN">
                                        <img src="img/home/windown.png" alt="img">WINDOWN CURTAIN</a>
                                </li>
                                <li class="item">
                                    <a href="#" class="hasicon" title="CHANDELIER">
                                        <img src="img/home/chandelier.png" alt="img">CHANDELIER
                                    </a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="CEILING FAN">
                                        <img src="img/home/ceiling_fan.png" alt="img">CEILING FAN
                                    </a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="WARDROBE">
                                        <img src="img/home/wardrobe.png" alt="img">WARDROBE
                                    </a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="FLOOR LAMP">
                                        <img src="img/home/floor_lamp.png" alt="img">FLOOR LAMP</a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="VASE-FLOWER">
                                        <img src="img/home/vase-flower.png" alt="img">VASE-FLOWER
                                    </a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="BED">
                                        <img src="img/home/bed.png" alt="img">BED
                                    </a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="BED GIRL">
                                        <img src="img/home/bed.png" alt="img">BED GIRL</a>
                                </li>
                                <li class="item toggleable menu-hidden">
                                    <a href="#" class="hasicon" title="BED BOY">
                                        <img src="img/home/bed.png" alt="img">BED BOY</a>
                                </li>
                                <li class="more item">Show More</li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-center align-items-center header-top-left pull-left">
                            <div class="toggle-nav act">
                                <div class="btnov-lines-large">
                                    <i class="zmdi zmdi-close"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- main -->
        <div id="wrapper-site">
            <div id="content-wrapper" class="full-width">
                <div id="main">
                    <section class="page-home">
                        <!-- SHOP THE LOOK -->
                        <div class="section spacing-10 groupbanner-special">
                            <div class="title-block">
                                <span>Mua Sắm Tại STYLE HOUSE 2025</span>
                                <span>STYLE HOUSE</span>
                                <span>SẢN PHẨM ĐƯỢC THIẾT KẾ TỪ CÁC CHUYÊN GIA</span>
                            </div>

                            <div class="row">
                                <div class="lookbook owl-carousel owl-theme owl-loaded owl-drag">
                                    <div class="item">
                                        <!-- Module Lookbooks -->
                                        <div class="tiva-lookbook defaul">
                                            <div class="items col-lg-12 col-sm-12 col-xs-12">
                                                <div class="tiva-content-lookbook">
                                                    <img class="img-fluid img-responsive"
                                                        src="img/home/home1-tolltip1.jpg" alt="lookbook">

                                                    <div class="item-lookbook item1">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook lookbook-custom">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip2.jpg"
                                                                        alt="lorem-ipsum-dolor-sit-amet">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Lorem ipsum dolor</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £52.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>

                                                    <div class="item-lookbook item2">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip1.jpg"
                                                                        alt="contrary-to-popular-belief">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Sed vel malesuada
                                                                        lorem</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £68.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <!-- Module Lookbooks -->
                                        <div class="tiva-lookbook default">
                                            <div class="items col-lg-12 col-sm-12 col-xs-12">
                                                <div class="tiva-content-lookbook">
                                                    <img class="img-fluid img-responsive"
                                                        src="img/home/home1-tolltip2.jpg" alt="lookbook">

                                                    <div class="item-lookbook item3">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip5.jpg"
                                                                        alt="lorem-ipsum-dolor-sit-amet">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Lorem ipsum dolor
                                                                        sit</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £45.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>

                                                    <div class="item-lookbook item4">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip6.jpg"
                                                                        alt="lorem-ipsum-dolor-sit-amet">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Lorem ipsum dolor</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £21.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>

                                                    <div class="item-lookbook item5">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook lookbook-custom">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip4.jpg"
                                                                        alt="mug-the-adventure-begins">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Sed vel malesuada
                                                                        lorem</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £11.90
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <!-- Module Lookbooks -->
                                        <div class="tiva-lookbook default">
                                            <div class="items col-lg-12 col-sm-12 col-xs-12">
                                                <div class="tiva-content-lookbook">
                                                    <img class="img-fluid img-responsive"
                                                        src="img/home/home1-tolltip3.jpg" alt="lookbook">

                                                    <div class="item-lookbook item6">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip4.jpg"
                                                                        alt="mug-the-adventure-begins">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Sed vel malesuada
                                                                        lorem</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £11.90
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>

                                                    <div class="item-lookbook item7">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/product/13.jpg"
                                                                        alt="brown-bear-vector-graphics">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Orci varius natoque
                                                                        penatibus</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £9.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>

                                                    <div class="item-lookbook item8">
                                                        {{-- <span class="number-lookbook">+</span>
                                                    <div class="content-lookbook">
                                                        <div class="main-lookbook d-flex align-items-center">
                                                            <div class="item-thumb">
                                                                <a href="product-detail.html">
                                                                    <img src="img/home/icon-tolltip6.jpg"
                                                                        alt="lorem-ipsum-dolor-sit-amet">
                                                                </a>
                                                            </div>
                                                            <div class="content-bottom">
                                                                <div class="item-title">
                                                                    <a href="product-detail.html">Etiam congue nisl
                                                                        nec</a>
                                                                </div>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="item-price">
                                                                    £16.00
                                                                </div>
                                                                <div class="readmore">
                                                                    <a href="product-detail.html">View More</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    </div>
                                                </div>

                                                <div class="info-lookbook">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- product living room -->
                        <div class="section living-room background-none">
                            <div class="container">
                                <div class="tiva-row-wrap row">
                                    <div class="col-md-12 col-xs-12 groupcategoriestab-vertical">
                                        <div class="grouptab">
                                            <div class="product-tab categoriestab-left flex-9">
                                                <div class="title-tab-content d-flex">
                                                    <!-- tab product -->
                                                    <div class="dropdown-toggle toggle-category tab-category-none">Select
                                                        Category</div>
                                                    <ul class="nav nav-tabs wibkit row">
                                                        <li class="col-xs-6">
                                                            <a href="#all" data-toggle="tab" class="active">ALL
                                                                PRODUCTS</a>
                                                        </li>
                                                        {{-- <li class="col-xs-6">
                                                            <a href="#table" data-toggle="tab">SIDE TABLE</a>
                                                        </li>
                                                        <li class="col-xs-6">
                                                            <a href="#armchair" data-toggle="tab">ARMCHAIR</a>
                                                        </li>
                                                        <li class="col-xs-6">
                                                            <a href="#cushion" data-toggle="tab">CUSHION</a>
                                                        </li> --}}
                                                    </ul>


                                                </div>
                                                <!-- tab product content -->
                                                <div class="tab-content">
                                                    <div id="all" class="tab-pane fade in active show">
                                                        <div class="item text-center row">
                                                            @foreach ($products as $product)
                                                                <div class="col-md-3 col-xs-12">
                                                                    <div
                                                                        class="product-miniature js-product-miniature item-one first-item">
                                                                        <div class="thumbnail-container">
                                                                            @php
                                                                                $variant = $product->variants->first();
                                                                            @endphp
                                                                            <a
                                                                                href="{{ route('client.products.show', $product->id) }}">
                                                                                <img class="img-fluid image-cover"
                                                                                    src="{{ asset('storage/' . $product->image) }}"
                                                                                    alt="">
                                                                                @if ($variant && $variant->image)
                                                                                    <img class="img-fluid image-secondary"
                                                                                        src="{{ asset('storage/' . $variant->image) }}"
                                                                                        alt="hover image">
                                                                                @endif
                                                                            </a>
                                                                            @if (isset($product->discount_percent) && $product->discount_percent > 0)
                                                                                <div class="product-flags discount">
                                                                                    -{{ $product->discount_percent }}%</div>
                                                                            @endif
                                                                            <div class="highlighted-informations">
                                                                                <div class="variant-links">
                                                                                    {{-- Nếu có màu hoặc biến thể, thêm tại đây
                                                                            --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-description">
                                                                            <div class="product-groups">
                                                                                <div class="product-title">
                                                                                    <a
                                                                                        href="{{ route('client.products.show', $product->id) }}">
                                                                                        {{ $product->name }}
                                                                                    </a>
                                                                                </div>
                                                                                {{-- <div class="rating">
                                                                                    <div class="star-content">
                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            <div class="star">
                                                                                            </div>
                                                                                        @endfor
                                                                                    </div>
                                                                                </div> --}}
                                                                                <div class="product-group-price">
                                                                                    <div
                                                                                        class="product-price-and-shipping">
                                                                                        <span
                                                                                            class="price">{{ number_format($product->base_price, 0, ',', '.') }}₫</span>
                                                                                        @if (isset($product->original_price) && $product->original_price > $product->base_price)
                                                                                            <del
                                                                                                class="regular-price">{{ number_format($product->original_price, 0, ',', '.') }}₫</del>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="product-buttons d-flex justify-content-center">
                                                                                {{-- Add to Cart Button --}}
                                                                                {{-- @auth
                                                                    <form action="{{ route('client.carts.add') }}"
                                                                        method="POST" class="formAddToCart">
                                                                        @csrf
                                                                        <input type="hidden" name="variant_id"
                                                                            value="{{ $variant->id }}">
                                                                        <a class="add-to-cart" href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                            data-button-action="add-to-cart"
                                                                            title="Thêm vào giỏ">
                                                                            <i class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    </form>
                                                                    @else
                                                                    <a class="add-to-cart" href="{{ route('login') }}"
                                                                        title="Đăng nhập để mua hàng"
                                                                        onclick="return confirm('Bạn cần đăng nhập để thêm vào giỏ hàng!');">
                                                                        <i class="fa fa-shopping-cart"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                    @endauth --}}
                                                                                <form
                                                                                    action="{{ route('client.carts.add') }}"
                                                                                    method="POST" class="formAddToCart">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="variant_id"
                                                                                        value="{{ $variant->id }}">
                                                                                    <input type="hidden" name="token"
                                                                                        value="{{ csrf_token() }}">

                                                                                    @auth
                                                                                        {{-- Khi đã đăng nhập: submit form --}}
                                                                                        <a class="add-to-cart" href="#"
                                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                            data-button-action="add-to-cart"
                                                                                            title="Thêm vào giỏ">
                                                                                            <i class="fa fa-shopping-cart"
                                                                                                aria-hidden="true"></i>
                                                                                        </a>
                                                                                    @else
                                                                                        {{-- Khi chưa đăng nhập: chuyển sang login --}}
                                                                                        <a class="add-to-cart"
                                                                                            href="{{ route('login') }}"
                                                                                            title="Đăng nhập để mua hàng"
                                                                                            onclick="return confirm('Bạn cần đăng nhập để thêm vào giỏ hàng!');">
                                                                                            <i class="fa fa-shopping-cart"
                                                                                                aria-hidden="true"></i>
                                                                                        </a>
                                                                                    @endauth
                                                                                </form>


                                                                                {{-- Wishlist Button --}}
                                                                                @auth
                                                                                    <form
                                                                                        action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                                        method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                                            href="#"
                                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                            data-rel="{{ $product->id }}"
                                                                                            title="Yêu thích">
                                                                                            <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                                aria-hidden="true"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                @else
                                                                                    <a class="addToWishlist"
                                                                                        href="{{ route('login') }}"
                                                                                        title="Đăng nhập để yêu thích">
                                                                                        <i class="fa fa-heart"
                                                                                            aria-hidden="true"></i>
                                                                                    </a>
                                                                                @endauth

                                                                                {{-- Quick View / Xem chi tiết --}}
                                                                                <a href="{{ route('client.products.show', $product->id) }}"
                                                                                    class="quick-view"
                                                                                    data-link-action="quickview"
                                                                                    title="Xem chi tiết">
                                                                                    <i class="fa fa-eye"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach



                                                        </div>
                                                        {{-- <div class="content-showmore text-center has-showmore">
                                                            <button type="button" class="btn btn-default novShowMore"
                                                                name="novShowMore" data-loading="Loading..."
                                                                data-loadmore="Load More Products">
                                                                <span>Load More Products</span>
                                                            </button>
                                                            <input type="hidden" value="0" class="count_showmore">
                                                        </div> --}}
                                                    </div>
                                                    <div id="table" class="tab-pane fade">
                                                        <div class="item text-center row">
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/1.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-30%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/2.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/3.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/4.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/5.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/6.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/7.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/8.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="content-showmore text-center has-showmore">
                                                            <button type="button" class="btn btn-default novShowMore"
                                                                name="novShowMore" data-loading="Loading..."
                                                                data-loadmore="Load More Products">
                                                                <span>Load More Products</span>
                                                            </button>
                                                            <input type="hidden" value="0" class="count_showmore">
                                                        </div>
                                                    </div>

                                                    <div id="armchair" class="tab-pane fade">
                                                        <div class="item text-center row">
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid" src="img/product/9.jpg"
                                                                                alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-30%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/10.jpg" alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-30%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/11.jpg" alt="img">

                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/12.jpg" alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/12.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/13.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/14.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/15.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="content-showmore text-center has-showmore">
                                                            <button type="button" class="btn btn-default novShowMore"
                                                                data-loading="Loading..."
                                                                data-loadmore="Load More Products">
                                                                <span>Load More Products</span>
                                                            </button>
                                                            <input type="hidden" value="0"
                                                                class="count_showmore">
                                                        </div>
                                                    </div>

                                                    <div id="cushion" class="tab-pane fade">
                                                        <div class="item text-center row">
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/1.jpg" alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-30%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/2.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
                                                                                    non augue</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/3.jpg" alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/4.jpg" alt="img">
                                                                        </a>
                                                                        <div class="product-flags discount">-10%</div>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Nam semper a
                                                                                    ligula nec</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                    <del
                                                                                        class="regular-price">£28.68</del>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/5.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/6.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/7.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-xs-12">
                                                                <div
                                                                    class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container">
                                                                        <a href="product-detail.html">
                                                                            <img class="img-fluid"
                                                                                src="img/product/8.jpg" alt="img">
                                                                        </a>
                                                                        <div class="highlighted-informations">
                                                                            <div class="variant-links">
                                                                                <a href="#" class="color beige"
                                                                                    title="Beige"></a>
                                                                                <a href="#" class="color orange"
                                                                                    title="Orange"></a>
                                                                                <a href="#" class="color green"
                                                                                    title="Green"></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a href="product-detail.html">Phasellus
                                                                                    vitae...</a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                    <div class="star"></div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">£20.08</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="product-buttons d-flex justify-content-center">
                                                                            <form action="#" method="post"
                                                                                class="formAddToCart">
                                                                                <input type="hidden" name="token">
                                                                                <a class="add-to-cart" href="#"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </form>
                                                                            <a class="addToWishlist wishlistProd_1"
                                                                                href="#" data-rel="1"
                                                                                onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="content-showmore text-center has-showmore">
                                                            <button type="button" class="btn btn-default novShowMore"
                                                                name="novShowMore" data-loading="Loading..."
                                                                data-loadmore="Load More Products">
                                                                <span>Load More Products</span>
                                                            </button>
                                                            <input type="hidden" value="0"
                                                                class="count_showmore">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- banner -->
                        <div class="section spacing-10 group-image-special">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 banner1">
                                    <div class="effect">
                                        <a href="#">
                                            <img class="img-fluid width-100" src="img/home/effect5.jpg" alt="banner-1"
                                                title="banner-1">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 banner1">
                                    <div class="effect">
                                        <a href="#">
                                            <img class="img-fluid width-100" src="img/home/effect6.jpg" alt="banner-2"
                                                title="banner-2">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 banner1">
                                    <div class="effect">
                                        <a href="#">
                                            <img class="img-fluid width-100" src="img/home/effect7.jpg" alt="banner-2"
                                                title="banner-2">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 banner1">
                                    <div class="effect">
                                        <a href="#">
                                            <img class="img-fluid width-100" src="img/home/effect8.jpg" alt="banner-2"
                                                title="banner-2">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 banner1">
                                    <div class="effect">
                                        <a href="#">
                                            <img class="img-fluid width-100" src="img/home/effect9.jpg" alt="banner-2"
                                                title="banner-2">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="section new-arrivals col-lg-6 col-xs-6">
                                    <div class="tab-content">
                                        <div class="title-product">
                                            <h2>New Arrivals</h2>
                                            <p>Discover our new products</p>
                                        </div>
                                        <div class="category-product owl-carousel owl-theme owl-loaded owl-drag">
                                            @foreach ($latestProducts as $product)
                                                <div class="item text-center">
                                                    <div
                                                        class="product-miniature js-product-miniature item-one first-item">
                                                        <div class="thumbnail-container">
                                                            <a href="{{ route('client.products.show', $product->id) }}">
                                                                <img class="img-fluid image-cover"
                                                                    src="{{ asset('storage/' . $product->image) }}"
                                                                    alt="{{ $product->name }}">
                                                                @php $variant = $product->variants->first(); @endphp
                                                                @if ($variant && $variant->image)
                                                                    <img class="img-fluid image-secondary"
                                                                        src="{{ asset('storage/' . $variant->image) }}"
                                                                        alt="{{ $product->name }} hover">
                                                                @endif
                                                            </a>
                                                            {{-- @if ($product->discount_percent > 0)
                                            <div class="product-flags discount">
                                                -{{ $product->discount_percent }}%
                                            </div>
                                            @endif --}}
                                                        </div>
                                                        <div class="product-description">
                                                            <div class="product-groups">
                                                                <div class="product-title">
                                                                    <a
                                                                        href="{{ route('client.products.show', $product->id) }}">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </div>
                                                                {{-- <div class="rating">
                                                                    <div class="star-content">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <div class="star">
                                                                            </div>
                                                                        @endfor
                                                                    </div>
                                                                </div> --}}
                                                                <div class="product-group-price">
                                                                    <div class="product-price-and-shipping">
                                                                        <span class="price">
                                                                            {{ number_format($product->base_price, 0, ',', '.') }}₫
                                                                        </span>
                                                                        {{-- @if ($product->discount_percent > 0)
                                                    <del class="regular-price">
                                                        {{ number_format($product->original_price, 0, ',', '.') }}₫
                                                    </del>
                                                    @endif --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-buttons d-flex justify-content-center">
                                                                <form action="{{ route('client.carts.add') }}"
                                                                    method="POST" class="formAddToCart">
                                                                    @csrf

                                                                    @if (!is_null($variant))
                                                                        <input type="hidden" name="variant_id"
                                                                            value="{{ $variant->id }}">
                                                                    @endif

                                                                    @auth
                                                                        {{-- Khi đã đăng nhập: submit form --}}
                                                                        <a class="add-to-cart" href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                            data-button-action="add-to-cart"
                                                                            title="Thêm vào giỏ">
                                                                            <i class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    @else
                                                                        {{-- Khi chưa đăng nhập: chuyển sang login --}}
                                                                        <a class="add-to-cart" href="{{ route('login') }}"
                                                                            title="Đăng nhập để mua hàng"
                                                                            onclick="return confirm('Bạn cần đăng nhập để thêm vào giỏ hàng!');">
                                                                            <i class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    @endauth
                                                                </form>


                                                                {{-- Wishlist Button --}}
                                                                @auth
                                                                    <form
                                                                        action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                            href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                            data-rel="{{ $product->id }}"
                                                                            title="Yêu thích">
                                                                            <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    </form>
                                                                @else
                                                                    <a class="addToWishlist" href="{{ route('login') }}"
                                                                        title="Đăng nhập để yêu thích">
                                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                                    </a>
                                                                @endauth
                                                                <a href="{{ route('client.products.show', $product->id) }}"
                                                                    class="quick-view hidden-sm-down"
                                                                    data-link-action="quickview">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="section best-sellers col-lg-6 col-xs-6">
                                    <div class="tab-content">
                                        <div class="title-product">
                                            <h2>Best Sellers</h2>
                                            <p>Discover our best sellers</p>
                                        </div>
                                        <div class="category-product owl-carousel owl-theme owl-loaded owl-drag">
                                            @foreach ($bestSellers as $product)
                                                <div class="item text-center">
                                                    <div
                                                        class="product-miniature js-product-miniature item-one first-item">
                                                        <div class="thumbnail-container">
                                                            <a href="{{ route('client.products.show', $product->id) }}">
                                                                <img class="img-fluid image-cover"
                                                                    src="{{ asset('storage/' . $product->image) }}"
                                                                    alt="{{ $product->name }}">
                                                                @php $variant = $product->variants->first(); @endphp
                                                                @if ($variant && $variant->image)
                                                                    <img class="img-fluid image-secondary"
                                                                        src="{{ asset('storage/' . $variant->image) }}"
                                                                        alt="{{ $product->name }} hover">
                                                                @endif
                                                            </a>

                                                            @if ($product->promotion_price && $product->promotion_price < $product->base_price)
                                                                <div class="product-flags discount">
                                                                    -{{ number_format(100 - ($product->promotion_price / $product->base_price) * 100) }}%
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="product-description">
                                                            <div class="product-groups">
                                                                <div class="product-title">
                                                                    <a
                                                                        href="{{ route('client.products.show', $product->id) }}">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </div>

                                                                {{-- <div class="rating">
                                                                    <div class="star-content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                    </div>
                                                                </div> --}}

                                                                <div class="product-group-price">
                                                                    <div class="product-price-and-shipping">
                                                                        <span
                                                                            class="price">{{ number_format($product->promotion_price ?? $product->base_price, 0, ',', '.') }}₫</span>
                                                                        @if ($product->promotion_price && $product->promotion_price < $product->base_price)
                                                                            <del
                                                                                class="regular-price">{{ number_format($product->base_price, 0, ',', '.') }}₫</del>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="product-buttons d-flex justify-content-center">
                                                                <form action="{{ route('client.carts.add') }}"
                                                                    method="POST" class="formAddToCart">
                                                                    @csrf
                                                                    <input type="hidden" name="variant_id"
                                                                        value="{{ $variant->id }}">

                                                                    @auth
                                                                        {{-- Khi đã đăng nhập: submit form --}}
                                                                        <a class="add-to-cart" href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                            data-button-action="add-to-cart"
                                                                            title="Thêm vào giỏ">
                                                                            <i class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    @else
                                                                        {{-- Khi chưa đăng nhập: chuyển sang login --}}
                                                                        <a class="add-to-cart" href="{{ route('login') }}"
                                                                            title="Đăng nhập để mua hàng"
                                                                            onclick="return confirm('Bạn cần đăng nhập để thêm vào giỏ hàng!');">
                                                                            <i class="fa fa-shopping-cart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    @endauth
                                                                </form>


                                                                {{-- Wishlist Button --}}
                                                                @auth
                                                                    <form
                                                                        action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                            href="#"
                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                            data-rel="{{ $product->id }}"
                                                                            title="Yêu thích">
                                                                            <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    </form>
                                                                @else
                                                                    <a class="addToWishlist" href="{{ route('login') }}"
                                                                        title="Đăng nhập để yêu thích">
                                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                                    </a>
                                                                @endauth

                                                                <a href="{{ route('client.products.show', $product->id) }}"
                                                                    class="quick-view hidden-sm-down">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- newsletter -->
                        <div class="section newsletter">
                            <div class="container">
                                <div class="row">
                                    <div class="news-content">
                                        <div class="tiva-modules">
                                            <div class="block">
                                                <div class="title-block">Newsletter</div>
                                                <div class="sub-title">Sign up to our newsletter to get the latest
                                                    articles,
                                                    lookbooks voucher codes
                                                    direct to your inbox</div>
                                                <div class="block-newsletter">
                                                    <form action="#" method="post">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="email"
                                                                value="" placeholder="Enter Your Email">
                                                            <span class="input-group-btn">
                                                                <button class="effect-btn btn btn-secondary"
                                                                    name="submitNewsletter" type="submit">
                                                                    <span>subscribe</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <input type="hidden" name="action" value="0">
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="block">
                                                <div class="social-content">
                                                    <div id="social-block">
                                                        <div class="social">
                                                            <ul class="list-inline mb-0 justify-content-end">
                                                                <li class="list-inline-item mb-0">
                                                                    <a href="#" target="_blank">
                                                                        <i class="fa fa-facebook"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item mb-0">
                                                                    <a href="#" target="_blank">
                                                                        <i class="fa fa-twitter"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item mb-0">
                                                                    <a href="#" target="_blank">
                                                                        <i class="fa fa-google"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item mb-0">
                                                                    <a href="#" target="_blank">
                                                                        <i class="fa fa-instagram"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Popup newsletter -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>



@endsection
