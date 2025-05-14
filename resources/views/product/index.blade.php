@extends("layouts.app")
@section("title", $viewData['title'])

@section("styles")
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/indexProduct.css') }}">
    <style>
        .content-wrapper {
            margin-top: 5rem; /* Add space below navbar */
            padding-bottom: 4rem; /* Add padding at bottom for pagination */
        }
        @media (max-width: 768px) {
            .content-wrapper {
                margin-top: 4rem;
                padding-bottom: 5rem;
            }
            .search-feedback {
                margin-top: 1rem;
                padding: 0.5rem;
                border-radius: 4px;
            }
            .search-feedback.info {
                background-color: #e3f2fd;
                color: #0d47a1;
            }
            .search-feedback.warning {
                background-color: #fff3e0;
                color: #e65100;
            }
            .filter-form {
                flex-direction: column;
                gap: 1rem;
            }
            .filter-form > div {
                width: 100%;
            }
            .filter-buttons {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
@endsection

@section("content")
    <div class="content-wrapper">
        <!-- Big Title -->
        <div class="container-fluid text-center my-4">
            <h1 class="display-4 fw-bold">Featured Books</h1>
        </div>

        <!-- Filter Section -->
        <div class="container-fluid mb-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ route('product.index') }}" method="GET" class="filter-form d-flex gap-3 align-items-center">
                        <!-- Search -->
                        <div class="flex-grow-1">
                            <label for="search" class="form-label">Search Books</label>
                            <input type="text" name="search" id="search" class="form-control"
                                   placeholder="Search by title, author, or description" value="{{ $viewData['searchTerm'] }}">
                        </div>

                        <!-- Filter by Category -->
                        <div class="flex-grow-1">
                            <label for="filter_category" class="form-label">Filter by Category</label>
                            <select name="category" id="filter_category" class="form-select">
                                <option value="">Select category</option>
                                @foreach($viewData['categories'] as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter by Price Range -->
                        <div class="flex-grow-1">
                            <label for="filter_price" class="form-label">Filter by Price</label>
                            <select name="price" id="filter_price" class="form-select">
                                <option value="">Select price range</option>
                                <option value="0-5000" {{ request('price') == '0-5000' ? 'selected' : '' }}>0 - 5000 FCFA</option>
                                <option value="5000-10000" {{ request('price') == '5000-10000' ? 'selected' : '' }}>5000 - 10000 FCFA</option>
                                <option value="10000-20000" {{ request('price') == '10000-20000' ? 'selected' : '' }}>10000 - 20000 FCFA</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="filter-buttons align-self-end d-flex gap-2">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Reset</a>
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>

                    <!-- Search Feedback -->
                    @if($viewData['searchTerm'])
                        <div class="search-feedback {{ $viewData['books']->count() > 0 ? 'info' : 'warning' }}">
                            @if($viewData['books']->count() > 0)
                                Found {{ $viewData['books']->count() }} books matching your search for "{{ $viewData['searchTerm'] }}"
                            @else
                                No books found matching your search for "{{ $viewData['searchTerm'] }}"
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Book List -->
        <div class="container-fluid row vstack gap-3" style="width:100%;">
            @if($viewData['books']->count() > 0)
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
                                <form action="{{ route('cart.add', ['book' => $book->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="{{ $book->e_book ? 1 : 1 }}">
                                    <button type="submit" class="btn btn-lg btn-success m-2">
                                        <i class='bx bxs-cart-add'></i>
                                    </button>
                                </form>
                                <button class="btn btn-outline-success m-2">Buy</button>
                                @if ($book->e_book)
                                    <span class="m-2 text-success">E-version</span>
                                @endif
                            @else
                                <button class="btn btn-outline-success m-2">Notice me when in stock</button>
                            @endif
                        </div>
                    </div>

                    <!-- Visible on Small (sm) Screens Only -->
                    <div class="d-flex col-12 d-sm-none stack position-relative">
                        <form action="{{ route('cart.add', ['book' => $book->id]) }}" method="POST" class="m-2">
                            @csrf
                            <input type="hidden" name="quantity" value="{{ $book->e_book ? 1 : 1 }}">
                            <button type="submit" class="btn btn-lg btn-success">
                                <i class='bx bxs-cart-add'></i>
                            </button>
                        </form>
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
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <h3>No books found</h3>
                    <p>Try adjusting your search terms or filters</p>
                </div>
            @endif
        </div>

        <!-- Pagination Links -->
        @if($viewData['books']->count() > 0)
            <div class="row">
                <div class="d-flex text-success justify-content-center mt-4">
                    {{ $viewData['books']->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section("scripts")
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

