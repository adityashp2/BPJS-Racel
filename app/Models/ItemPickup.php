<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPickup extends Model
{
    /** @use HasFactory<\Database\Factories\ItemPickupFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'user_id',
        'quantity',
        'taken_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'taken_date' => 'date',
    ];

    /**
     * Get the item that the item pickup belongs to.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user that created the item pickup.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
