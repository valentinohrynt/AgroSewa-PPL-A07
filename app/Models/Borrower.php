<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nik',
        'phone',
        'street',
        'village_id',
        'district_id',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
