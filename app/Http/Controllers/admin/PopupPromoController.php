<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PopupPromoController extends Controller
{
    public function index()
    {
        // Auto nonaktifkan promo yang masa berlakunya sudah habis
        \App\Models\PopupPromo::where('is_active', true)
            ->whereDate('end_date', '<', now())
            ->update(['is_active' => false]);

        $promos = \App\Models\PopupPromo::latest()->get();
        return view('admin.popup_promo', compact('promos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'voucher_code' => 'required|string|unique:popup_promos',
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/popup_promos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/popup_promos/' . $filename;
        }

        // Jika promo baru ini aktif, nonaktifkan yang lain
        if ($request->has('is_active')) {
            $data['is_active'] = true;
            \App\Models\PopupPromo::where('is_active', true)->update(['is_active' => false]);
        } else {
            $data['is_active'] = false;
        }

        \App\Models\PopupPromo::create($data);

        return redirect()->route('admin.popup-promo')->with('success', 'Pop-up Promo berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $promo = \App\Models\PopupPromo::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'voucher_code' => 'required|string|unique:popup_promos,voucher_code,' . $promo->id,
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($promo->image && file_exists(public_path($promo->image))) {
                unlink(public_path($promo->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/popup_promos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $data['image'] = 'uploads/popup_promos/' . $filename;
        }

        if ($request->has('is_active')) {
            $data['is_active'] = true;
            \App\Models\PopupPromo::where('id', '!=', $promo->id)->update(['is_active' => false]);
        } else {
            $data['is_active'] = false;
        }

        $promo->update($data);

        return redirect()->route('admin.popup-promo')->with('success', 'Pop-up Promo berhasil diperbarui!');
    }

    public function toggleStatus($id)
    {
        $promo = \App\Models\PopupPromo::findOrFail($id);
        
        if (!$promo->is_active) {
            \App\Models\PopupPromo::where('id', '!=', $promo->id)->update(['is_active' => false]);
            $promo->is_active = true;
        } else {
            $promo->is_active = false;
        }
        
        $promo->save();

        return response()->json([
            'success' => true,
            'is_active' => $promo->is_active,
            'message' => 'Status promo berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        $promo = \App\Models\PopupPromo::findOrFail($id);
        
        if ($promo->image && file_exists(public_path($promo->image))) {
            unlink(public_path($promo->image));
        }
        
        $promo->delete();
        return redirect()->route('admin.popup-promo')->with('success', 'Pop-up Promo berhasil dihapus!');
    }
}
