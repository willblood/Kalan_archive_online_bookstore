<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this import

class OrderController extends Controller
{
    use AuthorizesRequests; // Add this trait

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.book')->latest()->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function create(Request $request)
    {
        $cartItems = session('checkoutCartItems', []);

        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['price'];
        }


        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('orders.create', [
            'cartItems' => $cartItems, // Pass all cart items to the view
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function createForSingleBook(Request $request, $bookId)
    {
        // Retrieve the book from the database
        $book = Book::find($bookId);

        if (!$book) {
            return redirect()->route('product.index')->with('error', 'The selected book does not exist.');
        }


        // Prepare the book as a single cart item
        $cartItems = [
            [
                'book_id' => $book->id,
                'title' => $book->title,
                'price' => $book->price,
                'quantity' => 1, // Default quantity for single book
                'e_book' => $book->e_book,
                'image' => $book->image,
                'author' => $book->author,
            ],
        ];



        // Store the cart items in the session for consistency with the store method
        session(['checkoutCartItems' => $cartItems]);

        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalQuantity += $item['quantity'];
            $totalPrice += $item['quantity'] * $item['price'];
        }

        return view('orders.create', [
            'cartItems' => $cartItems,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'shipping_address' => 'required|array',
                'shipping_address.*' => 'required|string|max:255',
                'quantities' => 'required|array',
                'quantities.*' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:15',
            ]);

            // Retrieve cart items from the session
            $cartItems = session('checkoutCartItems', []);

            // Log debug information
            \Log::info('Store method called');
            \Log::info('Validated Data:', $validatedData);
            \Log::info('Cart Items:', $cartItems);

            // Create orders for each cart item
            // Log debug information
            \Log::info('Store method called');
            \Log::info('Validated Data:', $validatedData);
            \Log::info('Cart Items:', $cartItems);
            \Log::info('Quantities:', $validatedData['quantities']);
             // Initialize total quantity and total amount
            $totalQuantity = 0;
            $totalAmount = 0;

            // Create orders for each cart item
            foreach ($cartItems as $item) {
                $bookId = $item['book_id'];
                $quantity = $validatedData['quantities'][$bookId];
                $totalQuantity += $quantity;
                $totalAmount += $quantity * $item['price'];
            }

            // Create the order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null, // Null for guest users
                'status' => 'pending',
                'shipping_address' => $validatedData['shipping_address'][array_key_first($validatedData['shipping_address'])],
                'payment_status' => 'pending',
                'customer_name' => $validatedData['customer_name'],
                'customer_email' => $validatedData['customer_email'],
                'customer_phone' => $validatedData['customer_phone'],
                'quantity' => $totalQuantity, // Total quantity of all items
                'total_amount' => $totalAmount, // Total amount of the order
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $bookId = $item['book_id'];
                $quantity = $validatedData['quantities'][$bookId];
                $price = $item['price'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $bookId,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            // Clear the cart after placing the order
            session()->forget('checkoutCartItems');

            // Redirect to the success page
            return redirect()->route('orders.success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::error('Validation failed:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log any other errors
            \Log::error('An error occurred:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // Ensure this works now
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);

            // Restore book stock
            foreach ($order->items as $item) {
                $item->book->increment('stock', $item->quantity);
            }

            return back()->with('success', 'Order cancelled successfully.');
        }

        return back()->with('error', 'Order cannot be cancelled.');
    }
}
