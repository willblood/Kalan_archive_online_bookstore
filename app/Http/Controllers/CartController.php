<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Authenticated user: Retrieve cart from the database
            $cartItems = Cart::where('user_id', Auth::id())->with('book')->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->book->price;
            });
        } else {
            // Guest user: Retrieve cart from cookies
            $cartItems = collect(json_decode($request->cookie('cart', '[]'), true));
            $subtotal = $cartItems->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });
        }

        $total = $subtotal; // Add any additional charges if needed

        return view('cart.index', compact('cartItems', 'subtotal', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        if (Auth::check()) {
            // Authenticated user: Store cart in the database
            $user = Auth::user();
            $cartItem = Cart::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();

            if ($cartItem) {
                if (!$book->e_book) {
                    $cartItem->quantity += 1;
                }
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'quantity' => 1,
                ]);
            }
        } else {
            // Guest user: Store cart in cookies
            $cart = json_decode($request->cookie('cart', '[]'), true);

            $found = false;
            foreach ($cart as &$item) {
                if ($item['book_id'] == $book->id) {
                    if (!$book->e_book) {
                        $item['quantity'] += 1;
                    }
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = [
                    'book_id' => $book->id,
                    'quantity' => 1,
                    'title' => $book->title,
                    'price' => $book->price,
                    'image' => $book->image,
                    'author' => $book->author,
                    'e_book' => $book->e_book,
                ];
            }

            $cookie = cookie('cart', json_encode($cart), 60 * 24 * 7); // 7 days
            return back()->withCookie($cookie)->with('success', 'Book successfully added to your cart!');
        }

        return back()->with('success', 'Book successfully added to your cart!');
    }

    public function update(Request $request, $bookId)
    {
        \Log::info('Update Quantity Request:', $request->all());

        try {
            if (Auth::check()) {
                // Authenticated user: Update cart in the database
                $cartItem = Cart::where('user_id', Auth::id())->where('book_id', $bookId)->first();

                if ($cartItem) {
                    $cartItem->quantity = $request->input('quantity');
                    $cartItem->save();

                    $subtotal = Cart::where('user_id', Auth::id())->get()->sum(function ($item) {
                        return $item->quantity * $item->book->price;
                    });

                    $additionalCharges = 0; // Add any additional charges here
                    $total = $subtotal + $additionalCharges;

                    return response()->json([
                        'success' => true,
                        'quantity' => $cartItem->quantity,
                        'item_price' => $cartItem->quantity * $cartItem->book->price,
                        'cart_subtotal' => $subtotal,
                        'cart_total' => $total,
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Cart item not found.'], 404);
                }
            } else {
                // Guest user: Update cart in cookies
                $cart = json_decode($request->cookie('cart', '[]'), true);

                foreach ($cart as &$item) {
                    if ($item['book_id'] == $bookId) {
                        $item['quantity'] = $request->input('quantity');
                        break;
                    }
                }

                $subtotal = collect($cart)->sum(function ($item) {
                    return $item['quantity'] * $item['price'];
                });

                $additionalCharges = 0; // Add any additional charges here
                $total = $subtotal + $additionalCharges;

                $cookie = cookie('cart', json_encode($cart), 60 * 24 * 7); // 7 days

                return response()->json([
                    'success' => true,
                    'quantity' => $request->input('quantity'),
                    'item_price' => $request->input('quantity') * collect($cart)->firstWhere('book_id', $bookId)['price'],
                    'cart_subtotal' => $subtotal,
                    'cart_total' => $total,
                ])->withCookie($cookie);
            }
        } catch (\Exception $e) {
            \Log::error('Error updating cart item:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    public function remove(Book $book)
    {
        if (Auth::check()) {
            Auth::user()->cart()->where('book_id', $book->id)->delete();
        } else {
            $cart = json_decode(request()->cookie('cart', '[]'), true);

            // Ensure $item is an array and contains 'book_id'
            $cart = array_filter($cart, function ($item) use ($book) {
                return is_array($item) && isset($item['book_id']) && $item['book_id'] != $book->id;
            });

            return back()->cookie('cart', json_encode(array_values($cart)), 60 * 24 * 7);
        }

        return back();
    }

    public function clear()
    {
        if (Auth::check()) {
            Auth::user()->cart()->delete();
        } else {
            return back()->cookie('cart', '[]', 60 * 24 * 7);
        }

        return back();
    }

    public function checkout(Request $request)
    {
        if (Auth::check()) {
            // Authenticated user: Retrieve cart from the database
            $cartItems = Cart::where('user_id', Auth::id())->with('book')->get()->map(function ($item) {
                return [
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'title' => $item->book->title,
                    'author' => $item->book->author,
                    'description' => $item->book->description,
                    'price' => $item->book->price,
                    'image' => $item->book->image,
                    'e_book' => $item->book->e_book,
                ];
            })->toArray();
        } else {
            // Guest user: Retrieve cart from cookies
            $cartItems = json_decode($request->cookie('cart', '[]'), true);
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Store cart items in the session for the orders page
        session(['checkoutCartItems' => $cartItems]);

        return redirect()->route('orders.create');
    }
}
