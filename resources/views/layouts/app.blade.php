<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Remixcons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
        integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('styles') <!-- This allows child views to add their own styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>@yield('title', 'Kalan Archive')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset("css/styles.css") }}">
    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset("js/swiper-bundle.min.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        /* Existing styles */
        .user-dropdown {
            position: relative;
            display: inline-block;
            margin-left: 1rem;
        }

        .user-dropdown-btn {
            background: none;
            border: none;
            color: var(--first-color);
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            transition: color 0.3s ease;
            font-weight: 600;
        }

        .user-dropdown-btn:hover {
            color: var(--first-color-alt);
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: var(--container-color);
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .user-dropdown:hover .user-dropdown-content {
            display: block;
        }

        .user-dropdown-content a {
            color: var(--text-color);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .user-dropdown-content a:hover {
            background-color: var(--first-color);
            color: var(--white-color);
        }

        .dropdown-logout {
            width: 100%;
            padding: 12px 16px;
            background: none;
            border: none;
            color: var(--text-color);
            text-align: left;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dropdown-logout:hover {
            background-color: var(--first-color);
            color: var(--white-color);
        }

        @media screen and (max-width: 768px) {
            .user-dropdown-btn {
                font-size: 0.9rem;
            }

            .user-dropdown-content {
                right: -1rem;
            }
        }

        /* Mobile Profile Styles */
        @media (max-width: 768px) {
            .desktop-greeting {
                display: none;
            }

            .mobile-profile-icon {
                display: block;
                font-size: 1.5rem;
            }

            .mobile-greeting {
                display: block;
                padding: 10px 15px;
                color: var(--title-color);
                font-weight: 600;
                border-bottom: 1px solid var(--border-color);
                margin-bottom: 5px;
            }

            .user-dropdown-btn {
                padding: 0.5rem;
            }

            .user-dropdown-content {
                width: 200px;
            }
        }

        @media (min-width: 769px) {
            .mobile-profile-icon {
                display: none;
            }

            .mobile-greeting {
                display: none;
            }
        }

        .popup-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            /* Success green */
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 1rem;
            font-weight: bold;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .popup-notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .cart-icon {
            position: relative;
            display: inline-block;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: rgb(223, 57, 57);
            opacity: 0.8;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 0.2rem 0.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
        }
    </style>

</head>

<body>
    <!-- header-->
    <!-- Navbar -->

    <header class="header" id="header">
        <nav class="nav container navmargin">
            <a href="/" class="nav__logo">
                <i class="ri-book-3-line"></i>Kalan Archive
            </a>
            @if (!auth()->check() || auth()->user()->is_admin == 0)
                <div class="nav__menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="/" class="nav__link">
                                <i class="ri-home-line"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="/books" class="nav__link">
                                <i class="ri-book-3-line"></i>
                                <span>Featured</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('chat.index') }}" class="nav__link">
                                <i class='bx bxs-bot'></i>
                                <span> Kalan AI</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('about') }}" class="nav__link">
                                <i class="ri-information-line"></i>
                                <span>About</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Admin Navigation -->
                <li class="nav__item">
                    <a href="{{ route('admin.dashboard') }}" class="nav__link">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('admin.books.index') }}" class="nav__link">
                        <i class="ri-book-line"></i>
                        <span>Manage Books</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('admin.users.index') }}" class="nav__link">
                        <i class="ri-user-settings-line"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li class="nav__item">
                    <a href="{{ route('admin.orders.index') }}" class="nav__link">
                        <i class="ri-file-list-line"></i>
                        <span>Manage Orders</span>
                    </a>
                </li>

            @endif

            <div class="nav__actions">
                <!-- login button and profile button -->
                @auth
                    @if(Auth::user()->is_admin == 0)
                        <div class="user-dropdown">
                            <button class="user-dropdown-btn">
                                <span class="desktop-greeting">Hello,
                                    {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}</span>
                                <i class="ri-user-line mobile-profile-icon"></i>
                                <i class="ri-arrow-down-s-line"></i>
                            </button>
                            <div class="user-dropdown-content">
                                <div class="mobile-greeting">
                                    Hello, {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}
                                </div>
                                <a href="{{ route('favorites.index') }}"><i class="ri-heart-line"></i>Favorite</a>
                                <a href="/orders"><i class="ri-history-line"></i>Order History</a>
                                <a href="{{ route('account.settings') }}"><i class="ri-settings-2-line"></i>Account
                                    Settings</a>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-logout">Logout</button>
                                </form>
                            </div>
                        </div>

                    @if (Auth::user()->is_admin == 1)
                        <div class="user-dropdown">
                            <button class="user-dropdown-btn">
                                <span class="desktop-greeting">Hello,
                                    {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}</span>
                                <i class="ri-user-line mobile-profile-icon"></i>
                                <i class="ri-arrow-down-s-line"></i>
                            </button>
                            <div class="user-dropdown-content">
                                <div class="mobile-greeting">
                                    Hello, {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}
                                </div>
                                @if (!Auth::user()->is_admin)
                                    <a href="{{ route('favorites.index') }}"><i class="ri-heart-line"></i>Favorite</a>
                                    <a href="/orders"><i class="ri-history-line"></i>Order History</a>
                                @endif
                                <a href="{{ route('account.settings') }}"><i class="ri-settings-2-line"></i>Account Settings</a>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-logout">Logout</button>
                                </form>
                            </div>
                            @endif
                    @else
                        <div class="user-dropdown">
                            <button class="user-dropdown-btn">
                                <span class="desktop-greeting">Hello,
                                    {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}</span>
                                <i class="ri-user-line mobile-profile-icon"></i>
                                <i class="ri-arrow-down-s-line"></i>
                            </button>
                            <div class="user-dropdown-content">
                                <div class="mobile-greeting">
                                    Hello, {{ explode(' ', Auth::user()->name)[1] ?? explode(' ', Auth::user()->name)[0] }}
                                </div>
                                <a href="{{ route('account.settings') }}"><i class="ri-settings-2-line"></i>Account
                                    Settings</a>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-logout">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endif

                @else
                    <a class="" href="/login"><i class="ri-user-line login-button" id="login-button"></i></a>
                @endauth
                    <!-- Cart button  -->
                    @if (!Auth::check() || Auth::user()->is_admin == 0)
                                        <a href="{{ route('cart.index') }}" class="cart-icon">
                                            <i class="ri-shopping-cart-2-line"></i>
                                            @php
                                                $cartCount = Auth::check()
                                                    ? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity') // For authenticated users
                                                    : collect(json_decode(request()->cookie('cart', '[]'), true))->sum('quantity'); // For guest users
                                            @endphp
                                            @if($cartCount > 0)
                                                <span class="cart-count">{{ $cartCount }}</span>
                                            @endif
                                        </a>
                                        <!-- Theme button -->
                                        <i class="ri-moon-line change-theme" id="theme-button"></i>
                    @endif

                </div>
        </nav>
    </header>
    <!-- Navbar End -->

    <!--header end -->



    <!--main content-->
    <div class=" flex-grow-1 my-4">
        @yield('content')
    </div>
    <!--main content end -->

    <!-- footer-->

    <!--footer end-->

    @if(session('success'))
        <div id="popup-notification" class="popup-notification">
            {{ session('success') }}
        </div>
    @endif

    <script src="{{ asset("js/main.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainSwiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 50,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows: true,
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            const featuredSwiper = new Swiper('.featured__swiper', {
                spaceBetween: 20,
                grabCursor: true,
                slidesPerView: 1,
                centeredSlides: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                        centeredSlides: false,
                    }
                },
                on: {
                    init: function () {
                        this.update();
                    },
                    resize: function () {
                        this.update();
                    }
                },
                watchOverflow: true,
                allowTouchMove: true,
                preventInteractionOnTransition: true
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const popup = document.getElementById('popup-notification');
            if (popup) {
                // Show the popup
                popup.classList.add('show');

                // Hide the popup after 3 seconds
                setTimeout(() => {
                    popup.classList.remove('show');
                }, 3000);
            }
        });
    </script>

    @yield('scripts')

</body>

</html>
