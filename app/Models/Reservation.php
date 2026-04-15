<?php
// app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    protected $table = 'reservations';
    
    protected $fillable = [
        'user_id',
        'name', 
        'email', 
        'phone', 
        'date', 
        'time', 
        'people', 
        'table_type', 
        'floor', 
        'notes', 
        'status',
        'edit_token',
        'can_edit'
    ];
    
    protected $casts = [
        'can_edit' => 'boolean',
        'date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function canBeEdited()
    {
        return $this->can_edit && $this->status === 'pending';
    }
}