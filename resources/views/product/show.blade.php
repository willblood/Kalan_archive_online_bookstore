@extends("layouts.app")
@section("title", $viewData['book']->title)
@section("styles")
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link rel="stylesheet" href={{ asset("css/show.css") }}>
    <style>
        .discount-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2em;
            z-index: 1;
        }
        .original-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 1.2em;
            margin-right: 10px;
        }
        .discounted-price {
            color: #dc3545;
            font-weight: bold;
            font-size: 1.8em;
            margin-right: 15px;
        }
        .category-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f8f9fa;
            border-radius: 15px;
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 10px;
        }
        /* Add spacing for the product show page */
        main.container {
            margin-top: 80px; /* Space below navbar */
            margin-bottom: 80px; /* Space above nav menu */
            min-height: calc(100vh - 160px); /* Ensure minimum height between navbar and nav menu */
            padding: 1rem;
        }
        @media (max-width: 940px) {
            main.container {
                margin-top: 60px;
                margin-bottom: 60px;
                padding: 0.75rem;
            }
            .container {
                flex-direction: column;
                margin-top: 0;
            }
            .left-column,
            .right-column {
                width: 100%;
            }
            .left-column {
                display: flex;
                justify-content: center;
                margin-bottom: 0.5rem;
            }
            .left-column img {
                width: 100%;
                max-width: 200px;
                height: auto;
                position: relative;
                top: 0;
                left: 0;
                margin: 0 auto;
                display: block;
                object-fit: contain;
            }
            .right-column {
                margin-top: 0.5rem;
            }
            .product-description h1 {
                font-size: 1.6rem;
            }
            .product-description p {
                font-size: 0.9rem;
            }
        }
        @media (max-width: 535px) {
            main.container {
                margin-top: 50px;
                margin-bottom: 50px;
                padding: 0.5rem;
            }
            .left-column img {
                max-width: 150px;
            }
            .product-description h1 {
                font-size: 1.4rem;
            }
            .product-description p {
                font-size: 0.85rem;
            }
        }
        /* Book Information Styles */
        .book-info {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }
        .book-info span {
            font-size: 14px;
            color: #5E6977;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: block;
        }
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .product-price .discounted-price {

            color:rgb(218, 29, 29);

        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #43484D;
            font-size: 14px;
        }
        .info-item i {
            font-size: 18px;
            color: #358ED7;
        }
        .info-item span {
            text-transform: none;
            letter-spacing: normal;
            margin: 0;
        }
        /* Sell Book Link Styles */
        .sell-book-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #358ED7;
            text-decoration: none;
            font-size: 14px;
            margin-top: 15px;
            transition: color 0.3s ease;
        }
        .sell-book-link:hover {
            color: #2a6db0;
            text-decoration: underline;
        }
        .sell-book-link i {
            font-size: 18px;
        }
        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 200px); /* Account for header and footer */
        }

        /* Mobile Responsive Styles */
        @media screen and (max-width: 768px) {
            .product-container {
                padding: 1rem;
                margin-bottom: 5rem; /* Add space for nav menu */
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .product-image {
                width: 100%;
                height: auto;
                max-height: 300px;
            }

            .product-info {
                padding: 1rem;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .product-price {
                font-size: 1.25rem;
                margin-bottom: 5rem; /* Add space for nav menu */
                padding-bottom: 1rem;
            }

            .product-description {
                font-size: 0.9rem;
            }

            .product-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .product-actions button {
                width: 100%;
                padding: 0.75rem;
            }

            .product-meta {
                flex-direction: column;
                gap: 1rem;
            }

            .product-meta-item {
                width: 100%;
                padding: 0.75rem;
            }

            /* Add padding to bottom of content */
            .product-container::after {
                content: '';
                display: block;
                height: 80px; /* Height of nav menu */
                width: 100%;
            }

            /* Fix for product price section */
            .right-column {
                padding-bottom: 5rem; /* Add space for nav menu */
            }

            .product-price {
                position: relative;
                z-index: 1;
            }

            .product-price .cart-btn,
            .product-price .btn {
                margin-bottom: 0.5rem;
                width: 100%;
            }

            .desktop-text {
                display: none;
            }
            .mobile-icon {
                display: inline-block;
                font-size: 1.2rem;
            }
            .product-price .btn {
                padding: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media screen and (min-width: 769px) {
            .desktop-text {
                display: inline-block;
            }
            .mobile-icon {
                display: none;
            }
        }

        /* Additional mobile optimizations */
        @media screen and (max-width: 480px) {
            .product-container {
                padding: 0.75rem;
                margin-bottom: 4rem;
            }

            .product-title {
                font-size: 1.25rem;
            }

            .product-price {
                font-size: 1.1rem;
                margin-bottom: 4rem;
            }

            .product-description {
                font-size: 0.85rem;
            }

            .product-actions button {
                padding: 0.6rem;
            }

            .product-meta-item {
                padding: 0.6rem;
            }

            /* Additional spacing for very small screens */
            .right-column {
                padding-bottom: 4rem;
            }
        }

        /* Add new styles for the favorite button positioning */
        .left-column {
            position: relative;
        }

        .favorite-position {
            position: absolute;
            top: 10px;
            left: 20px;
            z-index: 2;
        }

        .favorite-btn {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
        }

        .favorite-btn i {
            font-size: 1.5rem;
            color: var(--first-color);
        }

        @media (max-width: 768px) {
            .favorite-position {
                top: 5px;
                left: 10px;
            }

            .favorite-btn i {
                font-size: 1.2rem;
            }
        }
    </style>
@endsection
@section("content")
    <main class="container">
        <!-- Left Column / Headphones Image -->
        <div class="left-column">
            <div class="favorite-position">
                @auth
                    <form action="{{ route('favorites.store', $viewData['book']) }}" method="POST" style="margin:0">
                        @csrf
                        <button type="submit" class="favorite-btn">
                            <i class="ri-heart-3-{{ in_array($viewData['book']->id, auth()->user()->favorites()->pluck('book_id')->toArray()) ? 'fill' : 'line' }}"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="favorite-btn">
                        <i class="ri-heart-3-line"></i>
                    </a>
                @endauth
            </div>
            <div class="discount-badge">-40%</div>
            <img data-image="red" class="active" src={{ asset($viewData['book']->image) }} alt="">
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Product Description -->
            <div class="product-description">
                <span class="category-badge">{{ $viewData['book']->category->name }}</span>
                <h1>{{ $viewData['book']->title }}</h1>
                <p>{{ $viewData['book']->description }}</p>
                <p class="author">By {{ $viewData['book']->author }}</p>
            </div>

            <!-- Product Configuration -->
            <div class="product-configuration">
                <!-- Book Information -->
                <div class="book-info">
                    <span>Book Information</span>
                    <div class="info-list">
                        <div class="info-item">
                            <i class='bx bx-user'></i>
                            <span>Author: {{ $viewData['book']->author }}</span>
                        </div>
                        <div class="info-item">
                            <i class='bx bx-book'></i>
                            <span>Type: {{ $viewData['book']->e_book ? 'E-Book' : 'Hard Copy' }}</span>
                        </div>

                        <div class="info-item">
                            <i class='bx bx-package'></i>
                            <span>Stock: {{ $viewData['book']->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Pricing -->
            <div class="product-price">
                @php
                    $discount = 0.4; // 40% discount
                    $originalPrice = $viewData['book']->price + $viewData['book']->price * $discount;
                    $discountedPrice =  $viewData['book']->price ;
                @endphp
                <span class="original-price">{{ number_format($originalPrice, 0, '.', ',') }} FCFA</span>
                <span class="discounted-price">{{ number_format($discountedPrice, 0, '.', ',') }} FCFA</span>
                @if ($viewData['book']->stock != 0)
                    <div class="action-buttons">
                        <form action="{{ route('cart.add', $viewData['book']) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="cart-btn btn p-2 btn-success">
                                <i class='bx bx-cart'></i> Add to Cart
                            </button>
                        </form>
                        <a href="{{ route('orders.create.single', ['book' => $viewData['book']->id]) }}" class="cart-btn p-2 btn btn-success mt-2">
                            Order Now
                        </a>
                    </div>
                @else
                    <a href="#" class="cart-btn btn btn-primary">Notify me <i class='bx bx-envelope'></i></a>
                @endif
            </div>
        </div>
    </main>
@endsection

@section("scripts")
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
