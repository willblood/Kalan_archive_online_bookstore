@extends("layouts.app")
@section("title", $viewData['title'])

@section("styles")
    <link rel="stylesheet" href="{{ asset('css/indexProduct.css') }}">
@endsection

@section("content")


    <!-- Big Title -->
    <div class="container-fluid text-center my-4">
        <h1 class="display-4 fw-bold">Featured Books</h1>
    </div>

    <!-- Filter Section -->
    <div class="container-fluid mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="" method="GET" class="d-flex gap-3 align-items-center">
                    <!-- Filter by Author -->
                    <div class="flex-grow-1">
                        <label for="author" class="form-label">Filter by Author</label>
                        <input type="text" name="author" id="author" class="form-control" placeholder="Enter author name">
                    </div>

                    <!-- Filter by Category -->
                    <div class="flex-grow-1">
                        <label for="category" class="form-label">Filter by Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Select category</option>

                        </select>
                    </div>

                    <!-- Filter by Price Range -->
                    <div class="flex-grow-1">
                        <label for="price" class="form-label">Filter by Price</label>
                        <select name="price" id="price" class="form-select">
                            <option value="">Select price range</option>
                            <option value="0-5000">0 - 5000 FCFA</option>
                            <option value="5000-10000">5000 - 10000 FCFA</option>
                            <option value="10000-20000">10000 - 20000 FCFA</option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="align-self-end">
                        <button type="submit" class="btn btn-success">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Book List -->
    <div class="container-fluid row vstack gap-3" style="width:100%;">
        @foreach ($viewData['books'] as $book)
               <!-- Visible on Medium (md) and Larger Screens -->
        <div class="d-flex col-lg-12 col-md-12 d-none d-sm-flex stack"
        onclick="window.location.href='{{ route('product.show', ['id' => $book->id]) }}'">
            <img src="{{ asset($book->image) }}" class="flex-shrink-1 m-2 me-3" alt="...">
            <div>
                <p class="mt-0 fs-5">{{ $book->title }}</p>
                <span class="text-primary">{{ $book->author }}</span>
                <p>{{ $book->description }}</p>
                <div class="row">
                    <div class="col-6 p-2">
                        <span class="text-danger me-4">{{ number_format($book->price, 0, '.', ',') }} FCFA</span>
                        <br>
                        @if ($book->stock != 0)
                            <span class="text-success">in stock</span>
                        @else
                            <span class="text-danger">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-6 ms-auto d-flex flex-column justify-content-end align-items-end">
                @if ($book->stock != 0)
                    <button class="btn btn-lg btn-success m-2">
                        <i class='bx bxs-cart-add'></i>
                    </button>
                    @if (!$book->e_book)
                        <button class="btn btn-outline-success m-2">Reserve</button>
                    @else
                        <span class="m-2 text-success">E-version</span>
                    @endif
                @endif
            </div>
        </div>

        <!-- Visible on Small (sm) Screens Only -->
        <div class="d-flex col-12 d-sm-none stack position-relative"
        onclick="window.location.href='{{ route('product.show', ['id' => $book->id]) }}'">

            <div class="m-2">
                <img src="{{ asset($book->image) }}" class="flex-shrink-1 m-2 me-3" alt="...">
                <p class="mt-0 fs-5">{{ $book->title }}</p>
                <span class="text-primary">{{ $book->author }}</span>
                <p>{{ $book->description }}</p>
                <div class="row">
                    <div class="col-6 p-2">
                        <span class="text-danger me-4">{{ number_format($book->price, 0, '.', ',') }} FCFA</span>
                        <br>
                        @if ($book->stock != 0)
                            <span class="text-success">in stock</span>
                        @else
                            <span class="text-danger">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-6 ms-auto d-flex flex-column justify-content-end align-items-end">
                @if ($book->stock != 0)
                    <button class="btn btn-lg btn-success m-2">
                        <i class='bx bxs-cart-add'></i>
                    </button>
                    @if (!$book->e_book)
                        <button class="btn btn-outline-success m-2">Reserve</button>
                    @else
                        <span class="m-2 text-success">E-version</span>
                    @endif
                @endif
            </div>
        </div>
        @endforeach
    </div>



    <!-- Pagination Links -->
    <div class="row">
        <div class="d-flex text-success justify-content-center mt-4">
            {{ $viewData['books']->links() }}
        </div>
    </div>


@endsection
