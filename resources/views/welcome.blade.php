@extends("layouts.app")
@section('title', $viewData['title'])
@section('styles')
    <style>
        .swiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .swiper-slide {
            background-position: center;
            background-size: cover;
            max-width: 300px;
            max-height: 400px;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured__swiper {
            padding: 2rem 0;
            position: relative;
            overflow: visible;
            width: 100%;
        }

        .featured__container {
            padding: 0 3rem;
            width: 100%;
            max-height: 600px;
            overflow: visible;
            position: relative;
        }

        .featured__card {
            position: relative;
            border-radius: 1rem;
            height: 400px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 0.5rem;
            overflow: hidden;
            width: 100%;
        }

        .featured__card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: var(--bg-image);
            background-size: cover;
            background-position: center;
            filter: brightness(0.7);
            transition: transform 0.3s ease;
        }

        .featured__card:hover::before {
            transform: scale(1.1);
        }

        .featured__content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
        }

        .featured__title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: auto;
            line-height: 1.4;
            color: var(--white-color);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .featured__prices {
            position: absolute;
            bottom: 80px;
            left: 0;
            right: 0;
            background: rgba(244, 239, 239, 0.8);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .featured__discount {
            color: var(--first-color);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .featured__price {
            text-decoration: line-through;
            color: var(--white-color);
            font-size: 0.9rem;
        }

        .featured__card .button {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            padding: 10px;
            background-color: var(--first-color);
            color: var(--white-color);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            z-index: 2;
        }

        .featured__card .button:hover {
            background-color: var(--first-color-alt);
        }

        .featured__actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 10;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .featured__actions .favorite-btn,
        .featured__actions .view-btn {
            background: transparent;
            border: none;
            color: var(--text-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured__actions .favorite-btn:hover,
        .featured__actions .view-btn:hover {
            color: var(--first-color);
            transform: scale(1.1);
        }

        .featured__actions .favorite-btn i.ri-heart-3-fill {
            color: var(--first-color);
        }

        /* Swiper specific styles */
        .featured__swiper .swiper-slide {
            max-height: 500px;
            padding: 0;
            width: 100%;
        }

        .featured__swiper .swiper-wrapper {
            padding-right: 0;
            max-height: 500px;
        }

        /* Navigation Buttons Styling */
        .featured__swiper .swiper-button-next,
        .featured__swiper .swiper-button-prev {
            color: var(--first-color);
            background-color: var(--container-color);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .featured__swiper .swiper-button-next {
            right: 0.5rem;
        }

        .featured__swiper .swiper-button-prev {
            left: 0.5rem;
        }

        /* Mobile Responsive Navigation */
        @media screen and (max-width: 768px) {
            .featured__container {
                padding: 0 1rem;
            }

            .featured__card {
                margin: 0 auto;
                max-width: 300px;
            }

            .featured__swiper .swiper-slide {
                display: flex;
                justify-content: center;
            }

            .featured__card .button {
                bottom: 0.5rem;
                width: 90%;
            }

            .featured__prices {
                bottom: 70px;
                padding: 0.75rem;
            }

            .featured__actions {
                padding: 0.35rem;
                gap: 0.4rem;
            }

            .featured__actions .favorite-btn,
            .featured__actions .view-btn {
                width: 30px;
                height: 30px;
                font-size: 1rem;
            }

            .featured__container .button {
                margin-top: 5px;
            }

            .featured__see-more .button:hover {
                background-color: var(--first-color-alt);
            }

            /* More Button Styles */
            .featured__container .button {
                display: block;
                margin: 5px auto 0;
                padding: 0.75rem 2rem;
                background-color: var(--first-color);
                color: var(--white-color);
                border: none;
                border-radius: 0.5rem;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.3s ease;
                text-align: center;
                text-decoration: none;
            }

            .featured__container .button:hover {
                background-color: var(--first-color-alt);
            }
        }

        /* Heroes Section Styles */
        .heroes {
            background-color: var(--body-color);
            padding: 4rem 0;
            position: relative;
        }

        .heroes__container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .heroes__grid {
            display: grid;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .heroes__item {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
            background: var(--container-color);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .heroes__content {
            padding: 2rem;
        }

        .heroes__content h1 {
            color: var(--title-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .heroes__content .lead {
            color: var(--text-color);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .heroes__image {
            width: 100%;
            height: 100%;
            min-height: 280px;
        }

        .heroes__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .heroes__service {
            background: var(--container-color);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }

        .heroes__service-content {
            padding-right: 2rem;
        }

        .heroes__service-content h1 {
            color: var(--title-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .heroes__service-content .lead {
            color: var(--text-color);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .heroes__service-image {
            width: 100%;
            height: 100%;
            min-height: 280px;
        }

        .heroes__service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 1rem;
        }

        @media screen and (max-width: 991px) {
            .heroes__item,
            .heroes__service {
                grid-template-columns: 1fr;
            }

            .heroes__content,
            .heroes__service-content {
                padding: 1.5rem;
            }

            .heroes__content h1,
            .heroes__service-content h1 {
                font-size: 1.8rem;
            }

            .heroes__content .lead,
            .heroes__service-content .lead {
                font-size: 1rem;
            }

            .heroes__image,
            .heroes__service-image {
                min-height: 200px;
            }
        }

        /* Favorite button styles */
        .favorite-btn {
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-color);
            font-size: 1.25rem;
        }

        .favorite-btn:hover {
            color: var(--first-color);
            transform: scale(1.1);
        }

        .favorite-btn.active {
            color: var(--first-color);
        }

        .favorite-btn.active i {
            animation: heartBeat 0.3s ease-in-out;
        }

        @keyframes heartBeat {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .featured__actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0;
        }
    </style>
@endsection
@section("content")
    <main style="margin-bottom:80px" class="main">
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h1 class="home__title">
                        Browse & <br>
                        Select Books
                    </h1>
                    <p class="home__description">
                        Find the best books from your favorite
                        writers,explore hundreds of books with all
                        possible categories, take advantage of that 50%
                        discount and much more.
                    </p>
                    <a href="{{ route('product.index') }}" class="button">Explore Now</a>
                </div>
                <div class="div-slider">
                    <!-- Main Swiper -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($viewData['books_swiper'] as $book)
                                <div class="swiper-slide">
                                    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Service -->
        <section class="services section">
            <div class="services__container container grid">
                <article class="services__card">
                    <i class="ri-truck-line"></i>
                    <h3 class="services__title">Free Shipping</h3>
                    <p class="services__description">Order More than 15000 FCFA</p>
                </article>
                <article class="services__card">
                    <i class="ri-secure-payment-line"></i>
                    <h3 class="services__title">Secure Payment</h3>
                    <p class="services__description">100% Secure Payment</p>
                </article>
                <article class="services__card">
                    <i class="ri-customer-service-2-line"></i>
                    <h3 class="services__title">24/7 Support</h3>
                    <p class="services__description">Call us anytime</p>
                </article>
            </div>
        </section>

        <!-- Featured -->
        <section class="featured section" id="featured">
            <h2 class="section__title">Featured Books</h2>
            <div class="featured__container container">
                <div class="featured__swiper swiper">
                    <div class="swiper-wrapper">
                        @foreach ($viewData['featured'] as $bookFeatured)
                            <article onclick="window.location.href='{{ route('product.show', $bookFeatured->id) }}'"
                                class="featured__card swiper-slide"
                                style="--bg-image: url('{{ asset($bookFeatured->image) }}')">
                                <div class="featured__content">
                                    <h2 class="featured__title">{{ $bookFeatured->title }}</h2>
                                    <div class="featured__prices">
                                        <span class="featured__discount">{{ $bookFeatured->price }} FCFA</span>
                                        <span class="featured__price">{{ $bookFeatured->price + ($bookFeatured->price * 40 / 100) }} FCFA</span>
                                    </div>
                                    <form action="{{ route('cart.add', $bookFeatured) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="button">
                                            <i class="ri-shopping-cart-line"></i>
                                            Add to cart
                                        </button>
                                    </form>
                                    <div class="featured__actions">
                                        @auth
                                            <form action="{{ route('favorites.store', $bookFeatured) }}" method="POST" style="margin:0">
                                                @csrf
                                                <button type="submit" class="favorite-btn">
                                                    <i class="ri-heart-3-{{ in_array($bookFeatured->id, auth()->user()->favorites()->pluck('book_id')->toArray()) ? 'fill' : 'line' }}"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="/login" class="favorite-btn">
                                                <i class="ri-heart-3-line"></i>
                                            </a>
                                        @endauth
                                        <a href="{{ route('product.show', ['id' => $bookFeatured->id]) }}" class="view-btn">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="{{ route('product.index') }}" class="button">More Books</a>
                </div>
            </div>
        </section>

        <section class="heroes section">
            <div class="heroes__container">
                <div class="heroes__grid">
                    <div class="heroes__item">
                        <div class="heroes__content">
                            <h1>Get Started with Kalan</h1>
                            <p class="lead">Kalan Archive introduce you to  its new AI recommender that recommend tou books based on your needs!</p>
                            <a href="/chat" class="button">Get Started</a>
                        </div>
                        <div class="heroes__image">
                            <img src="https://images.pexels.com/photos/2599244/pexels-photo-2599244.jpeg" alt="Trending Books">
                        </div>
                    </div>

                </div>

                <div class="heroes__service">
                    <div class="heroes__service-content">
                        <h1>Can't find what you are looking for?</h1>
                        <p class="lead">If you can't find what you are looking for,
                            ask Kalan AI to recommend you some books !</p>

                        <a href="/chat" class="button">Ask Kalan AI</a>

                    </div>
                    <div class="heroes__service-image">
                        <img src="https://images.pexels.com/photos/6530543/pexels-photo-6530543.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Library Service">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('scripts')
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
