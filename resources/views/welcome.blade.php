@extends("layouts.app")
@section('title',$viewData['title'])
@section("content")
    <main>
        <!-- Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div style="max-height:400px;" class="carousel-item active">
                    <img style=" filter: brightness(50%);" class="img-fluid"
                        src="https://images.pexels.com/photos/2908984/pexels-photo-2908984.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                        class="d-block w-100" alt="...">
                    <!-- Carousel Title -->
                    <div class="carousel-caption mb-2 mt-5  d-md-block ">
                        <div class="pt-5 header">
                            <div class="container-fluid  text-white d-flex justify-content-center align-items-center">
                                <div>
                                    <h1 class="display-6 fw-bold mt-5"> Find your next adventure</h1>
                                    <p class=" fs-4">where would you like to go next?</p>
                                    <a href="/books" class="btn text-white " style="background-color: #3F4F44;"> Explore
                                            books</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Title End -->
                </div>
                <div class="carousel-item" style="max-height:400px">
                    <img class="img-fluid" src="https://images.pexels.com/photos/13278839/pexels-photo-13278839.jpeg"
                        class="d-block w-100" alt="...">
                    <!-- Carousel Title -->
                    <div class="carousel-caption mt-5 mb-2  d-md-block mb-2">
                        <div class="pt-5  header">
                            <div class="container-fluid  text-white d-flex justify-content-center align-items-center">
                                <div>

                                    <h1 class="mt-5 display-6 fw-bold"> More 1000 ebooks available</h1>
                                    <p class=" text-center fs-4">explore E-version of your favorite books</p>
                                    <button class="btn  " style="background-color: #3F4F44;"> <a class="text-white"
                                            style="text-decoration: none;" href="https://facebook.com">Explore</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Title End -->
                </div>
                <div class="carousel-item" style="max-height:400px">
                    <img class="img-fluid"
                        src="https://images.pexels.com/photos/1738536/pexels-photo-1738536.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                        class="d-block w-100" alt="...">
                    <!-- Carousel Title -->
                    <div class="carousel-caption mt-5 mb-2  d-md-block ">
                        <div class="pt-5  header">
                            <div class="container-fluid text-white d-flex justify-content-center align-items-center">
                                <div>
                                    <h1 class=" mt-5 display-6 fw-bold">Where to start ?</h1>
                                    <p class=" text-center fs-4">Expand your knowledge of the world with us! </p>
                                    <button class="btn  " style="background-color: #3F4F44;"> <a class="text-white"
                                            style="text-decoration: none;" href="https://facebook.com">Guide</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Title End -->
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Carousel End -->

        <!-- Book Carousel -->
        <div class="container mt-5" style="height: 550px;">
            <h2 class="display-6 text-center">Your adventure start now</h2>
            <!-- This Book carousel display only on large screen -->
            <div id="carouselExample" class="carousel slide carousel-dark mt-5 d-none d-lg-block">
                <div class="carousel-inner">
                    <!-- Carousel 1 -->
                    <div class="carousel-item active">
                        <div class="row d-flex justify-content-center align-items-center">
                            <!-- Book 1 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][1]->image) }}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][1]->author }}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][1]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 2 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][2]->image) }}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][2]->author }}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][2]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 3 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][3]->image) }}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][3]->author }}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][3]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel 1 End -->

                    <!-- Carousel 2 -->
                    <div class="carousel-item">
                        <div class="row d-flex justify-content-center align-items-center">
                            <!-- Book 1 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src="{{ asset('images/books/book4.jpg') }}"
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][4]->author }}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][4]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 2 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][5]->image) }}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][5]->author}}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][5]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 3 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][6]->image )}}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][6]->author }}</p>
                                    <a href={{ route("product.show",["id"=>$viewData['books'][6]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel 2 End -->

                    <!-- Carousel 3 -->
                    <div class="carousel-item">
                        <div class="row d-flex justify-content-center align-items-center">
                            <!-- Book 1 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src="{{asset($viewData['books'][7]->image) }}"
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][7]->author }}</p>
                                    <a href={{ route("product.show",["id"=>$viewData['books'][7]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 2 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][8]->image) }}
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][8]->author }}</p>
                                    <a href={{ route("product.show",['id'=>$viewData['books'][8]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                            <!-- Book 3 -->
                            <div class="col-ms-6 col-xs-6 col-md-4 col-lg-3">
                                <div class="text-center">
                                    <img style="width: 151px;height: 233px;" src="{{ asset($viewData['books'][9]->image) }}"
                                        alt="book">
                                    <h6 class="mt-2"></h6>
                                    <p>{{ $viewData['books'][9]->author }}</p>
                                    <a href={{ route("product.show",["id"=>$viewData['books'][9]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel 3 End -->
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!--Mobile View -->
            <div id="carouselExample1" class="carousel slide d-lg-none mt-3  carousel-dark">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="text-center">
                            <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][9]->image ) }} alt="book">
                            <h6 class="mt-2"></h6>
                            <p>{{ $viewData['books'][9]->author }}</p>
                            <a href={{ route("product.show",['id'=>$viewData['books'][9]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="text-center">
                            <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][7]->image) }} alt="book">
                            <h6 class="mt-2"></h6>
                            <p>{{ $viewData['books'][7]->author }}</p>
                            <a href={{ route("product.show",['id'=>$viewData['books'][7]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="text-center">
                            <img style="width: 151px;height: 233px;" src={{ asset($viewData['books'][11]->image) }} alt="book">
                            <h6 class="mt-2"></h6>
                            <p>{{ $viewData['books'][11]->author }}</p>
                            <a href={{ route("product.show",['id'=>$viewData['books'][11]->id]) }} style="background-color: #3F4F44;" class="btn text-white">More details</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample1" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample1" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>

        <!--Mobile View end -->

        <!-- Book Carousel End -->


        <!-- Heroes -->

        <div>
            <div class="d-none d-lg-block">
                <div class="row g-0 mt-4">
                    <div class="col-sm-6 col-md-6">
                        <img class="img-fluid ps-5" style="max-height: 280px;"
                            src="https://images.pexels.com/photos/6860404/pexels-photo-6860404.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                            alt="">
                    </div>

                    <div class="col-4 col-md-4 container d-flex justify-content-center align-items-center">
                        <div class="ml-2">
                            <h1>Book Recommendation </h1>
                            <p class="lead">The library team would love to know what book you will like to see in the
                                library.
                                Whatever the book,
                                we will be able to provide the top content for you!
                            </p>
                            @auth
                                <a style="background-color: #3F4F44;" href="#" class="btn mb-4 btn-lg text-white">send
                                    message</a>
                            @else
                                <a style="background-color: #3F4F44;" href="/login-form"
                                    class="btn mb-4 btn-lg text-white">Login</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-4 col-md-4 container d-flex justify-content-center align-items-center">
                        <div class="ml-2">
                            <h1>Our collection is always changing!</h1>
                            <p class="lead">
                                Try to check in daily as our collection is always changing!
                                We work nonstop to provide the most accurate book selection possible
                                for our Luv 2 Read students ! we are diligent about our our book selection
                                and our book selection and our books are always going to be our
                                top priority.
                            </p>
                            <a style="background-color: #3F4F44;" href="/login-form" class="btn  btn-lg text-white">see
                                collection</a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img class="img-fluid" style="max-height: 280px;" src="{{ asset('images/heroes1.jpg') }}" alt="">
                    </div>
                </div>
            </div>


            <div class="d-lg-none">
                <div class="container">
                    <div class="m-2">
                        <img class="img-fluid" style="max-height: 280px;"
                            src="https://images.pexels.com/photos/6860404/pexels-photo-6860404.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                            alt="">
                        <div class="mt-2">
                            <h1>Book Recommendation </h1>
                            <p class="lead">The library team would love to know what book you will like to see in the
                                library.
                                Whatever the book,
                                we will be able to provide the top content for you!
                            </p>
                            @auth
                                <a href="/login-form" style="background-color: #3F4F44;" class="btn btn-lg text-white">send
                                    message</a>
                            @else
                                <a href="/login-form" style="background-color: #3F4F44;" class="btn btn-lg text-white">Login</a>
                            @endauth
                        </div>
                    </div>
                    <div class="m-2">
                        <img class="img-fluid " style="max-height: 280px;" src="{{ asset('images/heroes1.jpg') }}" alt="">
                        <div class="mt-2">
                            <h1>Our collection is always changing!</h1>
                            <p class="lead">
                                Try to check in daily as our collection is always changing!
                                We work nonstop to provide the most accurate book selection possible
                                for our Luv 2 Read students ! we are diligent about our our book selection
                                and our book selection and our books are always going to be our
                                top priority.
                            </p>
                            <a style="background-color: #3F4F44;" href="/login-form" class="btn  btn-lg text-white">see
                                collection</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Library Service-->
        <div class="container my-4">
            <div class="row p-4 align-items-center border shadow-lg">
                <div class="col-lg-7 p-3">
                    <h1 class="display-4 fw-bold">
                        Can't find what you are looking for,
                    </h1>
                    <p class="lead">
                        If you can't find what you are looking for,
                        send our library admin's a personal message
                    </p>
                    <div class="d-grid gap-2 justify-content-md-start mb-4 mb-lg-3">
                        @auth
                            <a style="background-color: #3F4F44;" href="/login-form" class="btn  btn-lg text-white">
                                send message
                            </a>
                        @else

                            <a style="background-color: #3F4F44;" href="/login-form" class="btn  btn-lg text-white">
                                Login
                            </a>
                        @endauth

                    </div>
                </div>

                <img class="mt-2 col-lg-4 offset-lg-1 shadow-lg"
                    src="https://images.pexels.com/photos/6530543/pexels-photo-6530543.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                    alt="">

            </div>

        </div>

        <!-- Heroes end -->
    </main>
@endsection
