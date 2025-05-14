@extends('layouts.app')
@section('title', 'My Favorites')
@section('styles')
<style>
    .favorites-container {
        padding: 6rem 1rem 2rem;
        min-height: calc(100vh - 200px);
        max-width: 1200px;
        margin: 0 auto;
    }

    .favorites-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .favorites-header h1 {
        color: var(--first-color);
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
        padding: 0 1rem;
    }

    .favorite-card {
        background: var(--container-color);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .favorite-card:hover {
        transform: translateY(-5px);
    }

    .favorite-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .favorite-content {
        padding: 1.5rem;
    }

    .favorite-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--title-color);
    }

    .favorite-author {
        color: var(--text-color);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .favorite-price {
        color: var(--first-color);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .favorite-actions {
        display: flex;
        gap: 1rem;
        justify-content: space-between;
    }

    .favorite-btn {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .view-btn {
        background: var(--first-color);
        color: var(--white-color);
    }

    .view-btn:hover {
        background: var(--first-color-alt);
    }

    .remove-btn {
        background: #ff4444;
        color: var(--white-color);
    }

    .remove-btn:hover {
        background: #cc0000;
    }

    .empty-favorites {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-favorites i {
        font-size: 4rem;
        color: var(--text-color-light);
        margin-bottom: 1rem;
    }

    .empty-favorites h2 {
        color: var(--title-color);
        margin-bottom: 1rem;
    }

    .empty-favorites p {
        color: var(--text-color);
        margin-bottom: 1.5rem;
    }

    .browse-btn {
        display: inline-block;
        padding: 0.75rem 2rem;
        background: var(--first-color);
        color: var(--white-color);
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .browse-btn:hover {
        background: var(--first-color-alt);
    }

    @media screen and (max-width: 768px) {
        .favorites-container {
            padding: 5rem 0.5rem 1rem;
        }

        .favorites-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            padding: 0 0.5rem;
        }

        .favorite-image {
            height: 250px;
        }

        .favorites-header h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="favorites-container">
    <div class="favorites-header">
        <h1>My Favorite Books</h1>
        <p>Your personal collection of favorite books</p>
    </div>

    @if($favorites->count() > 0)
        <div class="favorites-grid">
            @foreach($favorites as $favorite)
                <div class="favorite-card">
                    <img src="{{ asset($favorite->book->image) }}" alt="{{ $favorite->book->title }}" class="favorite-image">
                    <div class="favorite-content">
                        <h3 class="favorite-title">{{ $favorite->book->title }}</h3>
                        <p class="favorite-author">By {{ $favorite->book->author }}</p>
                        <p class="favorite-price">{{ number_format($favorite->book->price, 0, '.', ',') }} FCFA</p>
                        <div class="favorite-actions">
                            <a href="{{ route('product.show', ['id' => $favorite->book->id]) }}" class="favorite-btn view-btn">
                                View Details
                            </a>
                            <form action="{{ route('favorites.remove', $favorite) }}" method="POST" style="margin: 0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="favorite-btn remove-btn">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-favorites">
            <i class="ri-heart-3-line"></i>
            <h2>No Favorite Books Yet</h2>
            <p>Start adding your favorite books to your collection</p>
            <a href="/books" class="browse-btn">Browse Books</a>
        </div>
    @endif
</div>
@endsection
