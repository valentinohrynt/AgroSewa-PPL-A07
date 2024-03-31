<?php

namespace App\Models;

use App\Models\RentTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = [
        'name',
        'product_code',
        'product_description',
        'price',
        'product_img',
        'lender_id'
    ];
    public function rentTransactions()
    {
        return $this->hasMany(RentTransaction::class, 'product_id');
    }
    public function lender()
    {
        return $this->belongsTo(Lender::class, 'lender_id');
    }
    use HasFactory;
}
