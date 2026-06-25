<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    // ========== AMBIL CART DARI DATABASE & SESSION ==========
    public function index()
    {
        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cart = [];
        $total = 0;
        
        foreach ($cartItems as $item) {
            // EKSTRAK METADATA DULU SEBELUM DIPAKAI
            $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;

            $key = $item->item_type . '_' . $item->item_id;
            $cart[$key] = [
                'id' => $item->item_id,
                'type' => $item->item_type,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->image,
                'db_id' => $item->id,
                // SEKARANG METADATA-NYA TERBACA
                'is_menu_spesial' => $metadata['is_menu_spesial'] ?? false,
            ];
            $total += $item->price * $item->quantity;
        }
        
        $cartKey = 'cart_' . $user->id;
        session()->put($cartKey, $cart);
        
        return view('cart', compact('cart', 'total', 'user'));
    }
    
    // ========== GET CART VIA API (JSON) - DARI DATABASE ==========
    public function getCart()
    {
        $user = Auth::user();
        
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cart = [];
        
        foreach ($cartItems as $item) {
            // EKSTRAK METADATA
            $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;

            $cart[] = [
                'id' => $item->item_id,
                'type' => $item->item_type,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->image,
                'db_id' => $item->id,
                'is_menu_spesial' => $metadata['is_menu_spesial'] ?? false,
            ];
        }
        
        $cartKey = 'cart_' . $user->id;
        $sessionCart = [];
        foreach ($cart as $item) {
            $key = $item['type'] . '_' . $item['id'];
            $sessionCart[$key] = $item;
        }
        session()->put($cartKey, $sessionCart);
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total_items' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
    
    // ========== ADD ITEM TO CART (DATABASE + SESSION) ==========
    public function add(Request $request)
    {
        $user = Auth::user();
        $itemId = $request->item_id;
        $itemType = $request->item_type ?? 'menu';
        
        $existingCart = Cart::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->where('item_type', $itemType)
            ->first();
        
        if ($existingCart) {
            $existingCart->quantity += $request->quantity ?? 1;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
                'item_type' => $itemType,
                'name' => $request->name,
                'price' => (int)$request->price,
                'quantity' => (int)($request->quantity ?? 1),
                'image' => $request->image,
                'metadata' => [
                    'is_menu_spesial' => $request->is_menu_spesial ?? false,
                ]
            ]);
        }
        
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cart = [];
        
        foreach ($cartItems as $item) {
            // EKSTRAK METADATA
            $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;

            $cart[] = [
                'id' => $item->item_id,
                'type' => $item->item_type,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->image,
                'is_menu_spesial' => $metadata['is_menu_spesial'] ?? false,
            ];
        }
        
        return response()->json([
            'success' => true,
            'message' => $request->name . ' ditambahkan ke keranjang',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
            'cart' => $cart
        ]);
    }
    
    // ========== UPDATE ITEM QUANTITY (DATABASE) ==========
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        $lastUnderscorePos = strrpos($id, '_');
        if ($lastUnderscorePos !== false) {
            $itemType = substr($id, 0, $lastUnderscorePos);
            $itemId = substr($id, $lastUnderscorePos + 1);
        } else {
            $itemType = 'menu';
            $itemId = null;
        }
        
        if (!$itemId) {
            return response()->json(['success' => false, 'message' => 'Invalid item ID'], 400);
        }
        
        $quantity = (int)$request->quantity;
        
        $cartItem = Cart::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->where('item_type', $itemType)
            ->first();
        
        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
            } else {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }
        
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cart = [];
        foreach ($cartItems as $item) {
            // EKSTRAK METADATA
            $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;

            $cart[] = [
                'id' => $item->item_id,
                'type' => $item->item_type,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->image,
                'is_menu_spesial' => $metadata['is_menu_spesial'] ?? false,
            ];
        }
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total_items' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
    
    // ========== REMOVE ITEM FROM CART (DATABASE) ==========
    public function destroy($id)
    {
        $user = Auth::user();
        
        $lastUnderscorePos = strrpos($id, '_');
        if ($lastUnderscorePos !== false) {
            $itemType = substr($id, 0, $lastUnderscorePos);
            $itemId = substr($id, $lastUnderscorePos + 1);
        } else {
            $itemType = 'menu';
            $itemId = null;
        }
        
        if (!$itemId) {
            return response()->json(['success' => false, 'message' => 'Invalid item ID'], 400);
        }
        
        Cart::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->where('item_type', $itemType)
            ->delete();
        
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cart = [];
        foreach ($cartItems as $item) {
            // EKSTRAK METADATA
            $metadata = is_string($item->metadata) ? json_decode($item->metadata, true) : $item->metadata;

            $cart[] = [
                'id' => $item->item_id,
                'type' => $item->item_type,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $item->image,
                'is_menu_spesial' => $metadata['is_menu_spesial'] ?? false,
            ];
        }
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total_items' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
    
    // ========== CLEAR ALL CART ITEMS (DATABASE) ==========
    public function clear()
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)->delete();
        
        return response()->json(['success' => true]);
    }
    
    // ========== GET CART COUNT (DATABASE) ==========
    public function getCount()
    {
        $user = Auth::user();
        $count = Cart::where('user_id', $user->id)->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}