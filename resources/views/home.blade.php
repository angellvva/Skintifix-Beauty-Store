<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>

        .category .card {
            transition: box-shadow 0.3s ease;
            border: 1px solid #e965a7; /* border pink */
        }

        .category .card:hover {
            cursor: pointer;
            box-shadow: 0 0 24px rgba(0, 0, 0, 0.15);
        }

        .category .btn-outline-secondary {
            border-color: #e965a7 !important; /* border pink */
            color: #e965a7 !important; /* text pink */
        }

        .category .btn-outline-secondary:hover {
            background-color: #e965a7 !important;
            color: white !important;
        }
    </style>
</head>
<body>
    @extends ('base.base')
    
    @section('content')
        <div class="container-fluid py-5" style="background-image: url('{{ asset('images/home/background.jpg') }}');">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 style="color: #e965a7;">Premium products for a radiant, healthy glow skin</h4>
                        <h1 class="display-3 fw-bold mb-5">Discover Your Natural Beauty!</h1>
                        <div class="position-relative mx-auto">
                            <a type="button"
                                href="{{ route('catalog') }}" class="fw-semibold btn py-2 rounded-pill text-white w-50 shadow-sm" style="background-color: #e965a7">
                                Start Shopping Now
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="{{ asset('images/home/hero-1.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="First slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{ asset('images/home/hero-2.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{ asset('images/home/hero-3.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
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

        <div class="container">
            <div class="p-4 category">
                <!-- Judul dan Button Nav Carousel -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="fw-bold">Shop by Category</h2>
                        <p class="mb-0 text-muted">Browse our wide range of skincare categories to find exactly what your skin needs</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
                            ‹ Prev
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
                            Next ›
                        </button>
                    </div>
                </div>

                <!-- Carousel Start-->
                <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($product_categories->chunk(4) as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
                                    @foreach ($chunk as $pc)
                                        <div class="col">
                                            <div class="card h-100">
                                                <div class="card-body shadow-sm">
                                                    <img src="{{ asset('images/category/' . $pc->images) }}" class="card-img-top" alt="{{ $pc->name }}">
                                                    <h5 class="card-title">{{ $pc->name }}</h5>
                                                    <p class="card-text">{{ $pc->products->count() }} products</p>
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

        <!-- Featurs Section Start -->
        <div class="container-fluid featurs py-2" style="background-color: #fff0f5;">
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
                                <i class="fas fa-truck fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold">Secure Payment</h5>
                            <p class="mb-0">Trusted & encrypted checkout</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                            <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                                style="background-color: #e965a7; width: 80px; height: 80px;">
                                <i class="fas fa-truck fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold">Easy Returns</h5>
                            <p class="mb-0">7-day return guarantee</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-white p-4 shadow-sm">
                            <div class="featurs-icon rounded-circle d-flex align-items-center justify-content-center mb-4 mx-auto"
                                style="background-color: #e965a7; width: 80px; height: 80px;">
                                <i class="fas fa-truck fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold">Beauty Support</h5>
                            <p class="mb-0">Live chat & email 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs Section End -->


    @endsection
</body>
</html>