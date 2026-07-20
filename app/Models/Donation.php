<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // ADD THIS ARRAY: Explicitly allow these columns to be mass-assigned
    protected $fillable = [
        'donor_name',
        'email',
        'amount',
        'tx_ref',
        'status',
    ];
}
