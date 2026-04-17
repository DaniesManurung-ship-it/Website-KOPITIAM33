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
            
            // Simpan ke public/uploads/menus
            $destinationPath = public_path('uploads/menus');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/menus/' . $filename;
        }
        
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
            'badge' => $request->badge,
            'is_available' => true,
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
        
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'badge' => $request->badge,
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