<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('styles') <!-- This allows child views to add their own styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>@yield('title', 'Kalan Archive')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- header-->
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color:rgb(163, 86, 31);">
        <div class="container-fluid">
            <a href="/" class="text-white" style="text-decoration: none;">
                Kalan Archive
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class=" navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href={{ route('product.index') }}>Books</a></li>
                </ul>
                <form class="d-flex m-5" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>


                @auth
                    <ul class=" navbar-nav ">
                        <li class="nav-item p-5"><a class="text-white fs-4" style="text-decoration: none;" href=""><i
                                    class='bx bxs-user'></i></a></li>
                    </ul>
                    <form action={{ route('logout') }} method="post">
                        @csrf
                        <button type="submit" class="btn text-white" style="background-color: #3F4F44;">
                            Logout
                        </button>
                    </form>
                @else
                        <a class="text-white btn" style="text-decoration: none; background-color: #3F4F44;" href="/login-form">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!--header end -->
     <!--main content-->
    <div class="container flex-grow-1 my-4">
        @yield('content')
    </div>
    <!--main content end -->

    <!-- footer-->

    <footer style="background-color: #3F4F44;" class="container-fluid d-flex mt-2 mt-auto text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-1">
                    <h3>Contact Us</h3>
                    <p class="fs-5"><i class='bx bxs-envelope'></i> Kalan@gmail.com</p>
                    <p class="fs-5"><i class='bx bxs-phone'></i> 0799363394</p>
                    <p class="fs-5"><a style="text-decoration: none;" class="text-white" href="#"><i class='bx bxl-instagram-alt'></i> Instagram</a></p>
                    <p class="fs-5 text-white"><a style="text-decoration: none;" class="text-white" href="#"><i class='bx bxl-facebook-circle'></i> Facebook</a></p>
                </div>

                <div class="col-md-6 mt-2">
                    <h5>Newsletter</h5>
                    <form action="">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input style="max-width: 400px" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your email address">
                        </div>
                        <button class="btn" style="background-color:rgb(163, 86, 31);">Subscribe</button>
                    </form>
                    <p class="mb-0 text-white">© Kalan Archive, Inc</p>
                </div>
            </div>
        </div>
</footer>
    <!--footer end-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</body>

</html>
