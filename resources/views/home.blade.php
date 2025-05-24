@extends('base.base')

@section('content')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .category .card {
            transition: box-shadow 0.3s ease;
            border: 1px solid #e965a7;
            /* border pink */
        }

        .category .card:hover {
            cursor: pointer;
            box-shadow: 0 0 24px rgba(0, 0, 0, 0.15);
        }

        .category .btn-outline-secondary {
            border-color: #e965a7 !important;
            /* border pink */
            color: #e965a7 !important;
            /* text pink */
        }

        .category .btn-outline-secondary:hover {
            background-color: #e965a7 !important;
            color: white !important;
        }

        .product-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;

            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-stock {
            color: #888;
            font-size: 14px;
        }

        .product-unit-sold {
            color: #888;
            font-size: 14px;
        }

        .product-price {
            font-size: 16px;
            color: #e965a7;
            font-weight: bold;
            margin: 10px 0;
        }

        .product-category-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e965a7;
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            z-index: 10;
        }

        .most-wanted-slider {
            padding: 10px 0;
        }

        .swiper-slide {
            width: auto;
            max-width: 200px;
            padding: 10px;
        }

        .wishlist-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            color: #e965a7;
            font-size: 18px;
            z-index: 10;
            background-color: white;
            padding: 6px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .wishlist-icon:hover {
            background-color: #fce4ef;
            color: #c44c8f;
        }

        .product-card {
            position: relative;
            background-color: #fff;
            border-radius: 12px;
            width: calc(25% - 24px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            text-align: center;
        }

        .product-card:hover {
            box-shadow: 0 0 24px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            max-height: 150px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .btn-outline-pink {
            color: #e965a7;
            border: 2px solid #e965a7;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-pink:hover {
            background-color: #e965a7;
            color: white;
            border-color: #e965a7;
        }
    </style>

    <div class="container-fluid py-5" style="background-image: url('{{ asset('images/home/background.jpg') }}');">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 style="color: #e965a7;">Premium products for a radiant, healthy glow skin</h4>
                    <h1 class="display-3 fw-bold mb-5">Discover Your Natural Beauty!</h1>
                    <div class="position-relative mx-auto">
                        <a type="button" href="{{ route('catalog') }}"
                            class="fw-semibold btn py-2 rounded-pill text-white w-50 shadow-sm"
                            style="background-color: #e965a7">
                            Start Shopping Now
                        </a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ asset('images/home/hero-1.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="First slide">
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ asset('images/home/hero-2.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ asset('images/home/hero-3.jpg') }}" class="img-fluid w-100 h-100 rounded"
                                    alt="Second slide">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Our Products Swiper --}}
    <div class="container my-5">
        <h2 class="text-center fw-bold mb-4">Our Products</h2>
        <div class="swiper most-wanted-slider">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    <div class="swiper-slide text-center">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            style="height: 180px; object-fit: contain;">
                        <h6 class="mt-2 fw-semibold">{{ $product->name }}</h6>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Our Products Swiper End -->

    <!-- Contact us Now Start-->
    <div class="container py-5 mb-5" style="background-color: #ffcee2; color: #e965a7; padding: 60px 0;">
        <div class="row align-items-center">
            <!-- Text Content -->
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0 ps-md-5">
                <h2 class="fw-bold display-5 ps-md-5" style="color: #333;">Exclusive Products</h2>
                <h3 class="fw-normal ps-md-5">only in <strong>Skintifix Beauty Store</strong></h3>
                <p class="mt-3 mb-4 small ps-md-5" style="color: #333;">Start your beauty goals with us, right here right
                    now. Get in touch with
                    us!</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-pink rounded-pill px-4 py-2  ms-md-5">
                    Contact Us Now
                </a>
            </div>

            <!-- Image Content -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="position-relative" style="border-radius: 20px; overflow: hidden; border: 10px solid white;">
                    <img src="{{ asset('images/contact.png') }}" alt="Contact" class="img-fluid"
                        style="border-radius: 10px; object-fit: cover; max-height: 400px;">
                    <span class="position-absolute top-0 start-0 bg-white ps-2 pe-3 pb-2 fw-bold"
                        style="border-bottom-right-radius: 20px; color:#e965a7;">NEW</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact us Now End-->

    <div class="container">
        {{-- Best Seller --}}
        <div class="px-4 pt-4 category" style="padding-bottom: 48px;">
            <!-- Judul dan Button Nav Carousel -->
            <h2 class="fw-bold">Best Seller Products</h2>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="mb-0 text-muted">Discover our best seller products and find the perfect essentials
                        tailored to your skin’s unique needs</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('best-seller') }}" class="btn btn-outline-secondary btn-sm">
                        See All
                    </a>
                </div>
            </div>

            <!-- Carousel Start-->
            <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($order_items->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
                                @foreach ($chunk as $item)
                                    <div class="col">
                                        <div class="card h-100"
                                            onclick="window.location='{{ route('product.detail', $item->product->id) }}'">
                                            <div class="card-body shadow-sm position-relative">
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                                    class="img-fluid">

                                                <!-- Left: Category label -->
                                                <div class="product-category-label">
                                                    {{ $item->product->category->name }}
                                                </div>

                                                <!-- Right: Heart icon -->
                                                <form action="{{ route('wishlist.toggle', $item->product->id) }}"
                                                    method="POST"
                                                    style="position: absolute; top: 10px; right: 10px; z-index: 20;">
                                                    @csrf
                                                    <button type="submit"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        @if ($item->isInWishlist ?? false)
                                                            <i class="fas fa-heart"
                                                                style="color: #e965a7; font-size: 20px;"></i>
                                                        @else
                                                            <i class="far fa-heart"
                                                                style="color: #e965a7; font-size: 20px;"></i>
                                                        @endif
                                                    </button>
                                                </form>

                                                <h5 class="card-title product-name">{{ $item->product->name }}</h5>

                                                <div class="product-unit-sold">Units Sold:
                                                    {{ $order_items->where('product_id', $item->product->id)->sum('quantity') }}
                                                </div>

                                                <div class="product-price">
                                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Carousel End-->
        </div>
    </div>

    <div class="container">
        {{-- New Arrival --}}
        <div class="px-4 pt-4 category" style="padding-bottom: 48px;">
            <!-- Judul dan Button Nav Carousel -->
            <h2 class="fw-bold">New Arrival Products</h2>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="mb-0 text-muted">Explore our latest arrivals and be the first to enjoy fresh, innovative
                        products designed to elevate your skin</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('new-arrival') }}" class="btn btn-outline-secondary btn-sm">
                        See All
                    </a>
                </div>
            </div>

            <!-- Carousel Start-->
            <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($order_itemss->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                            <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
                                @foreach ($chunk as $item)
                                    <div class="col">
                                        <div class="card h-100"
                                            onclick="window.location='{{ route('product.detail', $item->product->id) }}'">
                                            <div class="card-body shadow-sm position-relative">
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                                    class="img-fluid">

                                                <!-- Left: Category label -->
                                                <div class="product-category-label">
                                                    {{ $item->product->category->name }}
                                                </div>

                                                <!-- Right: Heart icon -->
                                                <form action="{{ route('wishlist.toggle', $item->product->id) }}"
                                                    method="POST"
                                                    style="position: absolute; top: 10px; right: 10px; z-index: 20;">
                                                    @csrf
                                                    <button type="submit"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        @if ($item->isInWishlist ?? false)
                                                            <i class="fas fa-heart"
                                                                style="color: #e965a7; font-size: 20px;"></i>
                                                        @else
                                                            <i class="far fa-heart"
                                                                style="color: #e965a7; font-size: 20px;"></i>
                                                        @endif
                                                    </button>
                                                </form>

                                                <h5 class="card-title product-name">{{ $item->product->name }}</h5>

                                                <div class="product-unit-sold">Units Sold:
                                                    {{ $order_items->where('product_id', $item->product->id)->sum('quantity') }}
                                                </div>

                                                <div class="product-price">
                                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Carousel End-->
        </div>
        <!-- Carousel End-->
    </div>
    </div>

    <!-- Nourishing Beauty Section Start -->
    <div class="container py-5 text-center mb-5" style="background-color: #fff0f6;">
        <h1 class="fw-bold mb-3" style="color: #333;">Nourishing Beauty, Naturally</h1>
        <p class="mb-5 mx-auto" style="max-width: 750px; color: #555;">
            Skintifix Beauty Store is your modern haven for conscious beauty. Born from the belief that glowing skin
            starts with gentle care, our collection features clean, cruelty-free, and skin-loving products that elevate
            your daily routine. At Skintifix, we celebrate beauty in all forms—pure, empowering, and joyfully yours.
        </p>

        <div class="ratio ratio-16x9 mb-4" style="max-width: 800px; margin: 0 auto;">
            <iframe src="https://www.youtube.com/embed/FLpOzbdncHw?si=DCbus7x9Ed65pnuS" title="Skintifix Video"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                style="border-radius: 10px;"></iframe>
        </div>

        <a href="https://youtu.be/FLpOzbdncHw?si=DCbus7x9Ed65pnuS" target="_blank"
            class="btn text-white fw-semibold py-3 px-4"
            style="background-color: #e965a7; border-radius: 0; max-width: 400px; width: 100%;">
            <i class="fas fa-volume-up me-2"></i> VIEW “SKINTIFIX” CLEAN FORMULA
        </a>
    </div>
    <!-- Nourishing Beauty Section End -->

    <!-- Featurs Section Start -->
    <div class="container-fluid featurs py-2" style="background-color: #ffcee2; ">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                        <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                            style="background-color: #e965a7; width: 80px; height: 80px;">
                            <i class="fas fa-truck fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold">Free Shipping</h5>
                        <p class="mb-0">For all orders above Rp300.000</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                        <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                            style="background-color: #e965a7; width: 80px; height: 80px;">
                            <i class="fas fa-user-shield fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold">Secure Payment</h5>
                        <p class="mb-0">Trusted & encrypted checkout</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                        <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                            style="background-color: #e965a7; width: 80px; height: 80px;">
                            <i class="fas fa-exchange-alt fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold">Easy Returns</h5>
                        <p class="mb-0">7-day return guarantee</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                        <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                            style="background-color: #e965a7; width: 80px; height: 80px;">
                            <i class="fas fa-phone-alt fa-lg text-white"></i>
                        </div>
                        <h5 class="fw-bold">Beauty Support</h5>
                        <p class="mb-0">Live chat & email 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.most-wanted-slider', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            speed: 5000,
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            freeMode: true,
            freeModeMomentum: false,
            allowTouchMove: false,
        });
    </script>
@endsection
