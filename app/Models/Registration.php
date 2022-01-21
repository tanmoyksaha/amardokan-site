<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'mobile',
        'billing_address',
        'b_date',
        'blood_group',
        'reff_rin',
        'passeord_hash',
        'status'
    ];
}
