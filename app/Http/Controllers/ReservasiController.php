<?php
// app/Http/Controllers/ReservasiController.php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    public function index()
    {
        return view('reservasi');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'people' => 'required|integer|min:1|max:20',
            'table_type' => 'nullable|string',
            'floor' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'people' => $request->people,
            'table_type' => $request->table_type,
            'floor' => $request->floor,
            'notes' => $request->notes,
            'status' => 'pending',
            'edit_token' => Str::random(32),
            'can_edit' => true,
        ]);
        
        return redirect()->route('reservasi.history')->with('success', 'Reservasi berhasil dikirim! Anda dapat mengedit atau membatalkan sebelum dikonfirmasi admin.');
    }
    
    public function history()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('reservasi_history', compact('reservations'));
    }
    
    public function edit($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('can_edit', true)
            ->where('status', 'pending')
            ->firstOrFail();
        
        return view('reservasi_edit', compact('reservation'));
    }
    
    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('can_edit', true)
            ->where('status', 'pending')
            ->firstOrFail();
        
        $request->validate([
            'phone' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'people' => 'required|integer|min:1|max:20',
        ]);
        
        $reservation->update([
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'people' => $request->people,
            'table_type' => $request->table_type,
            'floor' => $request->floor,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('reservasi.history')->with('success', 'Reservasi berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('can_edit', true)
            ->where('status', 'pending')
            ->firstOrFail();
        
        $reservation->delete();
        
        return redirect()->route('reservasi.history')->with('success', 'Reservasi berhasil dibatalkan!');
    }
    
    public function replyMessage(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();
            
        $request->validate([
            'customer_reply' => 'required|string|max:255'
        ]);
        
        $reservation->update([
            'customer_reply' => $request->customer_reply
        ]);
        
        return redirect()->route('reservasi.history')->with('success', 'Balasan meja Anda telah dikirim! Menunggu konfirmasi admin.');
    }
}