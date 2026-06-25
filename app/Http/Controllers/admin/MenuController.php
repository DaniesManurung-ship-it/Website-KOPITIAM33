<?php
// app/Http/Controllers/Admin/MenuController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->get();
        return view('admin.menu', compact('menus'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1000',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke public/uploads/menus (code menyimpan gambar)
            $destinationPath = public_path('uploads/menus');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/menus/' . $filename;
        }
        
        $is_featured = false;
        $badge = $request->badge;
        $is_special_menu = $request->has('is_special_menu') ? true : false;
        
        // Cek jika ini adalah Menu Spesial dan badge unggulan dipilih
        if ($is_special_menu && $badge === 'unggulan') {
            $is_featured = true;
            $badge = null; // Opsional: Kosongkan teks badge atau biarkan tetap 'unggulan' jika ingin ditampilkan
            
            // Nonaktifkan unggulan lain di Menu Spesial
            Menu::where('is_special_menu', true)->where('is_featured', true)->update(['is_featured' => false]);
        } elseif (!$is_special_menu && $badge === 'unggulan') {
            $badge = null; // Reset jika bukan menu spesial tapi unggulan dikirim
        }
        
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_special_menu' => $is_special_menu,
            'image' => $imagePath,
            'badge' => $badge,
            'is_available' => true,
            'is_featured' => $is_featured,
        ]);
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }
    
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1000',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        
        $is_featured = $menu->is_featured;
        $badge = $request->badge;
        $is_special_menu = $request->has('is_special_menu') ? true : false;
        
        // Cek jika ini Menu Spesial dan badge unggulan dipilih
        if ($is_special_menu && $badge === 'unggulan') {
            $is_featured = true;
            $badge = null;
            
            // Nonaktifkan unggulan lain kecuali menu ini sendiri
            Menu::where('is_special_menu', true)
                ->where('is_featured', true)
                ->where('id', '!=', $id)
                ->update(['is_featured' => false]);
        } elseif ($is_special_menu && $is_featured) {
            // Jika sebelumnya unggulan tapi badge diubah, cabut unggulannya
            if ($badge !== 'unggulan' && $request->has('badge')) {
                $is_featured = false;
            }
        } else {
            $is_featured = false; // Reset jika bukan Menu Spesial
            if ($badge === 'unggulan') {
                $badge = null;
            }
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_special_menu' => $is_special_menu,
            'badge' => $badge,
            'is_featured' => $is_featured,
        ];
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/menus');
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/menus/' . $filename;
        }
        
        $menu->update($data);
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu->image && file_exists(public_path($menu->image))) {
            unlink(public_path($menu->image));
        }
        
        $menu->delete();
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus');
    }
    
    public function toggleAvailable($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_available = !$menu->is_available;
        $menu->save();
        
        return response()->json(['success' => true]);
    }
}