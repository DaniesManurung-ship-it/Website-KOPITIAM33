<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        // Admin melihat SEMUA promo (termasuk yang expired)
        $promos = Promo::orderBy('created_at', 'desc')->get();
        return view('admin.promo', compact('promos'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'original_price' => 'required|integer|min:1000',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/promos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/promos/' . $filename;
            
            Promo::create([
                'name' => $request->name,
                'image' => $imagePath,
                'description' => $request->description,
                'original_price' => $request->original_price,
                'discount' => $request->discount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => true,
            ]);
        }
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return response()->json($promo);
    }
    
    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'original_price' => 'required|integer|min:1000',
            'discount' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'discount' => $request->discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        
        if ($request->hasFile('image')) {
            if ($promo->image && file_exists(public_path($promo->image))) {
                unlink(public_path($promo->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/promos');
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/promos/' . $filename;
        }
        
        $promo->update($data);
        
        // Update is_active berdasarkan tanggal setelah update
        $this->updateActiveStatus($promo);
        
        return redirect()->route('admin.promo')->with('success', 'Promo berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        
        if ($promo->image && file_exists(public_path($promo->image))) {
            unlink(public_path($promo->image));
        }
        
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
    
    // Method untuk update status aktif berdasarkan tanggal
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