<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('menu')->orderBy('created_at', 'desc')->get();
        $menus = Menu::all();
        return view('admin.promo', compact('promos', 'menus'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        Promo::create([
            'menu_id' => $request->menu_id,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $promo = Promo::with('menu')->findOrFail($id);
        return response()->json([
            'id' => $promo->id,
            'menu_id' => $promo->menu_id,
            'original_price' => $promo->menu ? $promo->menu->price : 0,
            'discount' => $promo->discount,
            'start_date' => $promo->start_date->format('Y-m-d'),
            'end_date' => $promo->end_date->format('Y-m-d'),
            'is_active' => $promo->is_active,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $promo->update([
            'menu_id' => $request->menu_id,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        
        $this->updateActiveStatus($promo);
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->is_active = !$promo->is_active;
        $promo->save();
        
        return response()->json(['success' => true]);
    }
    
    private function updateActiveStatus($promo)
    {
        $now = Carbon::now();
        $startDate = Carbon::parse($promo->start_date);
        $endDate = Carbon::parse($promo->end_date);
        
        $shouldBeActive = $promo->is_active && $now >= $startDate && $now <= $endDate;
        
        if ($promo->is_active != $shouldBeActive) {
            $promo->is_active = $shouldBeActive;
            $promo->save();
        }
    }
}