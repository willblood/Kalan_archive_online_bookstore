@extends("layouts.app")
@section("title", $viewData["title"])
@section("styles")
    <link rel="stylesheet" href={{ asset("css/show.css") }}>
@endsection
@section("content")
    <main class="container">

        <!-- Left Column / Headphones Image -->
        <div class="left-column">
            <img data-image="red" class="active" src={{ asset($viewData['book']->image) }} alt="">
        </div>


        <!-- Right Column -->
        <div class="right-column">

            <!-- Product Description -->
            <div class="product-description">
                <span>Programming</span>
                <h1>{{ $viewData['book']->title}}</h1>
                <p>{{ $viewData['book']->description}}</p>
            </div>

            <!-- Product Configuration -->
            <div class="product-configuration">

                <!-- Product Color -->
                <div class="product-color">
                    <span>Writer</span>

                    <div class="color-choose">
                        <p class="text-primary">{{ $viewData['book']->author }}</p>
                    </div>

                </div>

                <!-- Cable Configuration -->
                <div class="cable-config">
                    <span class="mt-2">Version</span>

                    <div class="cable-choose">
                        @if ($viewData['book']->e_book)
                            <span class="mt-2">Ebook</span>
                        @else

                            <span class="mt-2">Handbook</span>
                        @endif
                    </div>

                    <a href="#">Borrow book from our library</a>
                </div>
            </div>

            <!-- Product Pricing -->
            <div class="product-price">
                <span class="text-danger">{{ number_format($viewData['book']->price, 0, '.', ',') }} FCFA</span>
                @if ($viewData['book']->stock!=0)
                <a href="#" class="cart-btn btn btn-success  me-2"> Book now</a>
                <a href="#" class=" btn btn-primary">Add to cart</a>
                @else
                <a href="#" class="cart-btn btn btn-primary"> Notify me <i class='bx bx-envelope'></i></a>

                @endif

            </div>
        </div>
    </main>
@endsection
