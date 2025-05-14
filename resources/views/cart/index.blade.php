@extends('layouts.app')
@section('title', 'Shopping Cart')
@section('styles')
    <style>
        .cart-container {
            padding: 6rem 1rem 2rem;
            min-height: calc(100vh - 200px);
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cart-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .cart-header h1 {
            color: var(--first-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .cart-items {
            background: var(--container-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 0.75rem;
            padding: 0.5rem;
            border-bottom: 1px solid var(--border-color);
            align-items: center;
            position: relative;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 60px;
            height: 90px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .cart-item-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--title-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ebook-badge {
            background: var(--first-color);
            color: var(--white-color);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .cart-item-author {
            color: var(--text-color);
            font-size: 0.8rem;
        }

        .cart-item-price {
            color: var(--first-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .quantity-btn {
            background: var(--first-color);
            color: var(--white-color);
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
            font-size: 0.9rem;
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        .quantity-btn:focus {
            outline: none;
        }

        .quantity-btn:focus-visible {
            outline: 2px solid var(--first-color);
            outline-offset: 2px;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.25rem;
            font-size: 0.9rem;
        }

        .cart-summary {
            margin-top: 2rem;
            background: var(--container-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        .summary-row.total {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--title-color);
            border-top: 1px solid var(--border-color);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .cart-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .cart-btn {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }

        .checkout-btn {
            background: var(--first-color);
            color: var(--white-color);
        }

        .checkout-btn:hover {
            background: var(--first-color-alt);
        }

        .clear-btn {
            background: #ff4444;
            color: var(--white-color);
        }

        .clear-btn:hover {
            background: #cc0000;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-cart i {
            font-size: 4rem;
            color: var(--text-color-light);
            margin-bottom: 1rem;
        }

        .empty-cart h2 {
            color: var(--title-color);
            margin-bottom: 1rem;
        }

        .empty-cart p {
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
            body {
                padding-top: 60px; /* Ensure content does not collapse with navbar */
            }

            .cart-container {
                padding: 6rem 0.5rem 1rem; /* Add padding to account for the fixed navbar */
                margin-bottom: 120px; /* Add space for the fixed cart summary and actions */
            }

            .cart-summary {
                margin-bottom: 20px; /* Add margin to prevent overlap with fixed nav */
                bottom: 70px;
                left: 0;
                right: 0;
                background: white;
                padding: 15px;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                z-index: 1050; /* Ensure it appears above the nav menu */
                border-top: 1px solid var(--border-color);
            }

            .cart-actions {

                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                padding: 15px;
                margin-bottom: 10px
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
                z-index: 1050; /* Ensure it appears above the nav menu */
                border-top: 1px solid var(--border-color);
            }
        }

        /* Large screen adjustments */
        @media screen and (min-width: 769px) {
            body {
                padding-top: 0px;
            }

            .cart-container {
                margin-top: 30px;
                /* Add margin to prevent overlap with fixed nav */
            }
        }

        .ebook-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: var(--body-color);
            border-radius: 0.5rem;
        }

        .quantity-display {
            font-weight: 600;
            color: var(--text-color);
        }

        .text-muted {
            color: var(--text-color-light);
            font-size: 0.85rem;
        }

        .remove-item {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: none;
            border: none;
            color: #ff4444;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }

        .remove-item:hover {
            transform: scale(1.1);
        }

        .remove-item:focus {
            outline: none;
        }

        .remove-item:focus-visible {
            outline: 2px solid #ff4444;
            outline-offset: 2px;
        }

        .checkout-btn {
            background-color: var(--first-color);
            color: var(--white-color);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background-color: var(--first-color-alt);
            transform: scale(1.05);
        }

        .checkout-btn:active {
            transform: scale(0.95);
        }
    </style>
@endsection

@section('content')
    <div class="cart-container">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <p>Your selected books</p>
        </div>

        @if((is_array($cartItems) && count($cartItems) > 0) || ($cartItems instanceof \Illuminate\Support\Collection && $cartItems->count() > 0))
            <div class="cart-items">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ asset(is_array($item) ? $item['image'] ?? 'default-image.jpg' : $item->book->image ?? 'default-image.jpg') }}"
                             alt="{{ is_array($item) ? $item['title'] ?? 'Unknown Title' : $item->book->title ?? 'Unknown Title' }}"
                             class="cart-item-image">

                        <div class="cart-item-content">
                            <h3 class="cart-item-title">
                                {{ is_array($item) ? $item['title'] ?? 'Unknown Title' : $item->book->title ?? 'Unknown Title' }}
                                @if(is_array($item) ? ($item['e_book'] ?? false) : ($item->book->e_book ?? false))
                                    <span class="ebook-badge">E-Book</span>
                                @endif
                            </h3>
                            <p class="cart-item-author">
                                By {{ is_array($item) ? ($item['author'] ?? 'Unknown Author') : ($item->book->author ?? 'Unknown Author') }}
                            </p>
                            <p class="cart-item-price" data-book-id="{{ is_array($item) ? $item['book_id'] ?? '' : $item->book_id ?? '' }}">
                                {{ number_format(is_array($item) ? ($item['price'] ?? 0) : ($item->book->price ?? 0), 0, '.', ',') }} FCFA
                            </p>

                            <div class="cart-item-quantity">
                                @if(!(is_array($item) ? ($item['e_book'] ?? false) : ($item->book->e_book ?? false)))
                                    <form action="{{ isset($item['book_id']) ? route('cart.update', $item['book_id']) : '#' }}" method="POST">
                                        @csrf
                                        <button type="button" class="quantity-btn minus-btn" data-book-id="{{ is_array($item) ? $item['book_id'] ?? '' : $item->book_id ?? '' }}">-</button>
                                        <input type="number" name="quantity" value="{{ is_array($item) ? ($item['quantity'] ?? 1) : ($item->quantity ?? 1) }}"
                                               min="1" max="{{ is_array($item) ? ($item['stock'] ?? 999) : ($item->book->stock ?? 999) }}"
                                               class="quantity-input" data-book-id="{{ is_array($item) ? $item['book_id'] ?? '' : $item->book_id ?? '' }}">
                                        <button type="button" class="quantity-btn plus-btn" data-book-id="{{ is_array($item) ? $item['book_id'] ?? '' : $item->book_id ?? '' }}">+</button>
                                    </form>
                                @else
                                    <small class="text-muted">E-Book (Quantity: 1)</small>
                                @endif
                            </div>
                        </div>

                        <form action="{{ isset($item['book_id']) ? route('cart.remove', $item['book_id']) : '#' }}" method="POST" class="remove-item-form">
                            @csrf
                            <button type="submit" class="remove-item" title="Remove item">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span class="cart-subtotal">{{ number_format($subtotal, 0, '.', ',') }} FCFA</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span class="cart-totals">{{ number_format($total, 0, '.', ',') }} FCFA</span>
                </div>
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn checkout-btn">Checkout</button>
                </form>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="clear-btn cart-btn">Clear Cart</button>
                </form>
            </div>
        @else
            <!-- Empty Cart Message -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>Your cart is empty</h2>
                <p>Add some books to your cart to see them here</p>
                <a href="{{ route('product.index') }}" class="browse-btn">Browse Books</a>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateQuantity(bookId, quantity) {
                console.log(`Updating quantity for book ID: ${bookId} to ${quantity}`);

                // Get the CSRF token from the meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Perform AJAX request to update quantity on the server
                fetch(`/cart/update/${bookId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ quantity: quantity }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Server Response:', data);

                        if (data.success) {
                            // Update item price in the DOM
                            const itemPriceElement = document.querySelector(`.cart-item-price[data-book-id="${bookId}"]`);
                            if (itemPriceElement) {
                                itemPriceElement.textContent = `${data.item_price.toLocaleString()} FCFA`;
                            }

                            // Update subtotal and total dynamically
                            updateCartSummary(data.cart_subtotal);
                        } else {
                            alert('Failed to update quantity. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to update quantity. Please try again.');
                    });
            }

            function updateCartSummary(subtotal) {
                // Update the subtotal in the DOM
                const subtotalElement = document.querySelector('.cart-subtotal');
                if (subtotalElement) {
                    subtotalElement.textContent = `${subtotal.toLocaleString()} FCFA`;
                }

                // Compute and update the total (e.g., subtotal + additional charges like tax or shipping)
                const additionalCharges = 0; // Add any additional charges here if applicable
                const total = subtotal + additionalCharges;

                const totalElement = document.querySelector('.cart-totals');
                if (totalElement) {
                    totalElement.textContent = `${total.toLocaleString()} FCFA`;
                }
            }

            // Add event listeners to quantity buttons
            const quantityButtons = document.querySelectorAll('.quantity-btn');
            quantityButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const bookId = this.dataset.bookId;
                    const input = document.querySelector(`input[data-book-id="${bookId}"]`);
                    if (!input) return;

                    const currentValue = parseInt(input.value);
                    const maxValue = parseInt(input.max);
                    const change = this.classList.contains('minus-btn') ? -1 : 1;
                    const newValue = Math.max(1, Math.min(currentValue + change, maxValue));

                    input.value = newValue;
                    updateQuantity(bookId, newValue);
                });
            });

            // Add event listeners to quantity inputs
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                input.addEventListener('change', function () {
                    const bookId = this.dataset.bookId;
                    const value = parseInt(this.value);
                    const max = parseInt(this.max);
                    const newValue = Math.max(1, Math.min(value, max));

                    if (value !== newValue) this.value = newValue;
                    updateQuantity(bookId, newValue);
                });
            });
        });
    </script>

@endsection



<?php
\Log::info($cartItems);
?>
