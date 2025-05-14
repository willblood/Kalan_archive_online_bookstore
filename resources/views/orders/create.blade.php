@extends('layouts.app')
@php
    /** @var \Illuminate\Support\ViewErrorBag $errors */
@endphp
@section('title', 'Place Order')
@section('content')
    <div class="order-container">
        <div class="order-header">
            <h1>Place Your Order</h1>
            <p>Complete your purchase securely</p>
        </div>

        <div class="order-content">
            @foreach($cartItems as $item)

                <div class="book-preview">
                    <div class="book-image">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}">
                        @if($item['quantity'] > 0)
                            <span class="stock-badge in-stock">In Stock</span>
                        @else
                            <span class="stock-badge out-of-stock">Out of Stock</span>
                        @endif
                    </div>
                    <div class="book-info">
                        <h2>{{ $item['title'] }}</h2>
                        <p class="author">by {{ $item['author'] ?? 'Unknown Author' }}</p>
                        <div class="price-container">
                            <span class="price">{{ number_format($item['price'], 0, '.', ',') }} FCFA</span>
                        </div>
                    </div>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn minus-btn" data-book-id="{{ $item['book_id'] }}">-</button>
                        <input type="number" id="quantity_{{ $item['book_id'] }}" name="quantities[{{ $item['book_id'] }}]"
                            value="{{ old('quantities.' . $item['book_id'], $item['quantity']) }}" readonly
                            class="quantity-input" data-price="{{ $item['price'] }}">
                        <button type="button" class="quantity-btn plus-btn" data-book-id="{{ $item['book_id'] }}">+</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <ul>
                <li><strong>Total Quantity:</strong> <span id="total-quantity">{{ $totalQuantity }}</span></li>
                <li><strong>Total Price:</strong> <span id="total-price">{{ number_format($totalPrice, 0, '.', ',') }}</span> FCFA</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @php
            $hasEbook = false;
            $hasPhysicalBook = false;

            foreach ($cartItems as $item) {
                if ($item['e_book']) {
                    $hasEbook = true;
                } else {
                    $hasPhysicalBook = true;
                }

                // If both types are found, no need to continue looping
                if ($hasEbook && $hasPhysicalBook) {
                    break;
                }
            }
        @endphp

        <form style="margin-top: 20px;" action="{{ route('orders.store') }}" method="POST">
            @csrf
            @foreach($cartItems as $item)

                <div class="form-group" style="display: none;">
                    <label for="quantity_{{ $item['book_id'] }}">Quantity</label>
                    <input type="hidden" id="hidden_quantity_{{ $item['book_id'] }}" name="quantities[{{ $item['book_id'] }}]"
                        value="{{ old('quantities.' . $item['book_id'], $item['quantity']) }}">
                </div>
            @endforeach

            @guest
                <div class="form-group">
                    <label for="customer_name">Full Name</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                        class="form-control @error('customer_name') is-invalid @enderror">
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="customer_email">Email Address</label>
                    <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                        class="form-control @error('customer_email') is-invalid @enderror">
                    @error('customer_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="customer_phone">Phone Number</label>
                    <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                        class="form-control @error('customer_phone') is-invalid @enderror">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @else
                <div class="form-group">
                    <label for="customer_name">Full Name</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ auth()->user()->name }}" readonly
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="customer_email">Email Address</label>
                    <input type="email" id="customer_email" name="customer_email" value="{{ auth()->user()->email }}" readonly
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="customer_phone">Phone Number</label>
                    <input type="tel" id="customer_phone" name="customer_phone"
                        value="{{ old('customer_phone', auth()->user()->phone) }}"
                        class="form-control @error('customer_phone') is-invalid @enderror">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endguest

           <!-- Input for e-books -->
    @if($hasEbook)
        <div class="form-group">
            <label for="delivery_email">Delivery Email</label>
            <input type="email" id="delivery_email" name="shipping_address[e_book]" value="{{ old('shipping_address.e_book') }}" required
                class="form-control @error('shipping_address.e_book') is-invalid @enderror"
                placeholder="Enter your email address">
            @error('shipping_address.e_book')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif

           <!-- Input for physical books -->
    <!-- Input for physical books -->
    @if($hasPhysicalBook)
        <div class="form-group">
            <label for="shipping_address_physical">Shipping Address</label>
            <textarea id="shipping_address_physical" name="shipping_address[physical_book]" rows="3" required
                class="form-control @error('shipping_address.physical_book') is-invalid @enderror"
                placeholder="Enter your shipping address">{{ old('shipping_address.physical_book') }}</textarea>
            @error('shipping_address.physical_book')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endif
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'checked' : '' }} required>
                        <img src="{{ asset('images/wave.jpg') }}" alt="Wave">
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }} required>
                        <img src="{{ asset('images/om.png') }}" alt="Orange Money">
                    </label>
                    @if(!$hasEbook)
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="cash_delivery" {{ old('payment_method') == 'cash_delivery' ? 'checked' : '' }} required>
                            <img src="{{ asset('images/cd.png') }}" alt="Cash Delivery">
                            <span>Cash</span>
                        </label>
                    @endif
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="visa" {{ old('payment_method') == 'visa' ? 'checked' : '' }} required>
                        <img src="{{ asset('images/visa.png') }}" alt="Visa">
                    </label>
                </div>
                @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <style>
                .payment-methods {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 1rem;
                    margin-top: 1rem;
                    justify-content: center;
                }

                .payment-method {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 0.5rem;
                    padding: 1rem;
                    border: 2px solid transparent;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    text-align: center;
                    width: 150px;
                    height: 150px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .payment-method input[type="radio"] {
                    display: none;
                }

                .payment-method img {
                    width: 80px;
                    height: auto;
                }

                .payment-method span {
                    font-size: 1rem;
                    font-weight: bold;
                    color: #333;
                }

                .payment-method:hover {
                    border-color: #007bff;
                    background-color: #f0f8ff;
                }

                .payment-method input[type="radio"]:checked + img,
                .payment-method input[type="radio"]:checked + span {
                    border-color: #007bff;
                    background-color: #e6f7ff;
                }

                .payment-method input[type="radio"]:checked + img {
                    border: 2px solid #007bff;
                    border-radius: 8px;
                }

                .payment-method input[type="radio"]:checked + span {
                    color: #007bff;
                }
            </style>
            <button style="margin-top: 10px;" type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
@endsection

@section('styles')
    <style>
        .order-container {
            max-width: 1000px;
            margin: 2rem auto;
            /* Add top and bottom margins */
            padding: 2rem 1rem;
            min-height: calc(100vh - 200px);
        }

        .order-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .order-header h1 {
            color: var(--first-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .order-header p {
            color: var(--text-color);
            font-size: 1.1rem;
        }

        .order-content {
            background: var(--container-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .book-preview {
            display: flex;
            align-items: center;
            /* Align items vertically */
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            max-height: 70px;
            /* Set maximum height */
            overflow: hidden;
            /* Hide overflow content */
        }

        .book-image {
            width: 40px;
            /* Smaller image size */
            height: 40px;
            overflow: hidden;
            border-radius: 0.5rem;
            flex-shrink: 0;
            /* Prevent shrinking */
        }

        .book-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-info {
            flex: 1;
            /* Allow text to take remaining space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            /* Hide overflow content */
        }

        .book-info h2 {
            font-size: 0.85rem;
            /* Smaller title size */
            margin: 0;
            white-space: nowrap;
            /* Prevent text wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
            /* Add ellipsis for overflow text */
        }

        .book-info .author {
            font-size: 0.75rem;
            /* Smaller author text */
            color: var(--text-color);
            margin: 0;
            white-space: nowrap;
            /* Prevent text wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
            /* Add ellipsis for overflow text */
        }

        .price-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            /* Smaller price text */
        }

        .price {
            font-weight: 600;
            color: var(--first-color);
        }

        .stock {
            color: var(--text-color);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background: var(--first-color);
            color: white;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--first-color-alt);
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.3rem;
            font-size: 0.9rem;
        }

        .form-section {
            margin-bottom: 1rem;
            /* Reduce spacing between sections */
        }

        .form-section h3 {
            font-size: 1rem;
            /* Smaller section titles */
            margin-bottom: 0.5rem;
            color: var(--title-color);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            /* Reduce spacing in the grid */
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 0.9rem;
            /* Smaller label text */
            font-weight: 500;
            color: var(--title-color);
        }

        .form-control {
            padding: 0.5rem;
            /* Reduce input padding */
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.9rem;
            /* Smaller input text */
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--first-color);
            outline: none;
        }

        .quantity-input {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: var(--first-color);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--first-color-alt);
        }

        .quantity-input input {
            width: 80px;
            text-align: center;
        }

        .order-summary {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .order-summary h3 {
            font-size: 1.5rem;
            color: var(--first-color);
            margin-bottom: 1rem;
            text-align: center;
        }

        .order-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 1rem;
            color: #333;
        }

        .order-summary li {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .summary-total {
            font-size: 1.2rem;
            /* Make the total text larger */
            font-weight: 700;
            color: var(--first-color);
            margin-top: 1.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .summary-item.total {
            margin-top: 0.8rem;
            padding-top: 0.8rem;
            border-top: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--title-color);
        }

        .total-price {
            color: var(--first-color);
        }

        .summary-total {
            font-size: 1rem;
            /* Smaller total text */
            font-weight: 600;
            color: var(--title-color);
        }

        .order-actions {
            display: flex;
            gap: 0.5rem;
            /* Reduce spacing between buttons */
            justify-content: center;
            /* Center the buttons */
            margin-top: 1rem;
            /* Add spacing above */
            padding: 1rem;
            /* Add padding for better spacing */
            max-width: 400px;
            /* Limit the width */
            margin-left: auto;
            /* Center horizontally */
            margin-right: auto;
            /* Center horizontally */
        }

        .btn-primary,
        .btn-secondary {
            flex: 1;
            /* Ensure buttons are evenly sized */
            padding: 0.6rem;
            /* Reduce padding */
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            font-size: 0.9rem;
            /* Adjust font size */
        }

        .btn-primary {
            background: var(--first-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--first-color-alt);
        }

        .btn-secondary {
            background: var(--body-color);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
        }

        .ebook-notice {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem;
            background: var(--body-color);
            border-radius: 0.5rem;
            color: var(--text-color);
            font-size: 0.95rem;
        }

        .ebook-notice i {
            color: var(--first-color);
        }

        @media (max-width: 768px) {
            .order-container {
                margin: 4rem auto;
                /* Add more space for mobile view */
                padding: 1rem;
                min-height: auto;
            }

            .order-summary {
                margin: 0.5rem auto;
                /* Center horizontally */
            }

            .book-preview {
                flex-direction: row;
                /* Stack items horizontally on mobile */
                align-items: center;
            }

            .book-image {
                width: 80px;
                /* Smaller image size for mobile */
                height: 120px;
            }

            .book-info h2 {
                font-size: 0.9rem;
                /* Smaller title size for mobile */
            }

            .book-info .author {
                font-size: 0.75rem;
                /* Smaller author text for mobile */
            }

            .price {
                font-size: 0.9rem;
                /* Smaller price text for mobile */
            }

            .stock {
                font-size: 0.75rem;
                /* Smaller stock text for mobile */
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .order-actions {
                margin-bottom: 3rem;
                flex-direction: column;
            }
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--text-color);
            margin-top: 0.25rem;
        }

        .text-muted {
            color: var(--text-color-light) !important;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn ----- {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: var(--first-color);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--first-color-alt);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            padding: 0.5rem;
            background: var(--container-color);
            pointer-events: none;
            /* Prevent manual input */
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const minusButtons = document.querySelectorAll('.minus-btn');
            const plusButtons = document.querySelectorAll('.plus-btn');
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const totalQuantityElement = document.getElementById('total-quantity');
            const totalPriceElement = document.getElementById('total-price');

            function updateTotals() {
                let totalQuantity = 0;
                let totalPrice = 0;

                quantityInputs.forEach(input => {
                    const quantity = parseInt(input.value) || 0;
                    const price = parseFloat(input.getAttribute('data-price')) || 0;

                    totalQuantity += quantity;
                    totalPrice += quantity * price;
                });

                totalQuantityElement.textContent = totalQuantity;
                totalPriceElement.textContent = totalPrice.toLocaleString(); // Format the price
            }

            minusButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookId = this.getAttribute('data-book-id');
                    const quantityInput = document.getElementById(`quantity_${bookId}`);
                    const hiddenQuantityInput = document.getElementById(`hidden_quantity_${bookId}`);
                    let currentValue = parseInt(quantityInput.value) || 1;

                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                        hiddenQuantityInput.value = quantityInput.value; // Update hidden input
                        updateTotals();
                    }
                });
            });

            plusButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bookId = this.getAttribute('data-book-id');
                    const quantityInput = document.getElementById(`quantity_${bookId}`);
                    const hiddenQuantityInput = document.getElementById(`hidden_quantity_${bookId}`);
                    let currentValue = parseInt(quantityInput.value) || 1;

                    quantityInput.value = currentValue + 1;
                    hiddenQuantityInput.value = quantityInput.value; // Update hidden input
                    updateTotals();
                });
            });

            // Initialize totals on page load
            updateTotals();
        });
    </script>
@endsection
