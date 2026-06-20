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
        $promos = Promo::with('menus')->orderBy('created_at', 'desc')->get();
        $menus = Menu::all();
        return view('admin.promo', compact('promos', 'menus'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'menus' => 'required|array',
            'menus.*' => 'exists:menus,id',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $menuImage = '';
        if ($request->has('menus') && count($request->menus) > 0) {
            $firstMenu = Menu::find($request->menus[0]);
            if ($firstMenu) {
                $menuImage = $firstMenu->image ?? '';
            }
        }
        
        $promo = Promo::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $menuImage,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
            'user_id' => Auth::id(),
        ]);

        // Attach menus to this promo
        if ($request->has('menus')) {
            Menu::whereIn('id', $request->menus)->update(['promo_id' => $promo->id]);
        }
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $promo = Promo::with('menus')->findOrFail($id);
        return response()->json([
            'id' => $promo->id,
            'name' => $promo->name,
            'description' => $promo->description,
            'menus' => $promo->menus->pluck('id'),
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'menus' => 'required|array',
            'menus.*' => 'exists:menus,id',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $menuImage = $promo->image;
        if ($request->has('menus') && count($request->menus) > 0) {
            $firstMenu = Menu::find($request->menus[0]);
            if ($firstMenu) {
                $menuImage = $firstMenu->image ?? '';
            }
        }
        
        $promo->name = $request->name;
        $promo->description = $request->description;
        $promo->image = $menuImage;
        $promo->discount = $request->discount;
        $promo->start_date = $request->start_date;
        $promo->end_date = $request->end_date;
        $promo->save();

        // Update menus
        // Detach all menus first
        Menu::where('promo_id', $promo->id)->update(['promo_id' => null]);
        // Attach selected menus
        if ($request->has('menus')) {
            Menu::whereIn('id', $request->menus)->update(['promo_id' => $promo->id]);
        }
        
        $this->updateActiveStatus($promo);
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        // We don't delete the image file because it belongs to the Menu!
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