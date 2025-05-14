<div class="featured__card">
    <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" class="featured__img">
    <div class="featured__content">
        <h3 class="featured__title">{{ $book->title }}</h3>
        <p class="featured__price">{{ $book->price }} FCFA</p>
        <button class="featured__button">Add to Cart</button>
    </div>
</div>
