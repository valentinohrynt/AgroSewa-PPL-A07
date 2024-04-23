<?php

namespace App\Models;

use App\Models\Lender;
use App\Models\RentTransaction;
use Illuminate\Database\Eloquent\Model;

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

    public static function getDataProducts()
    {
        $DataProducts = static::All();
        return $DataProducts;
    }

    public static function getDataProductsbyRentTransaction($rentTransaction)
    {
        $DataProductsbyRentTransaction = static::find($rentTransaction->product_id);;
        return $DataProductsbyRentTransaction;
    }

    public static function getDataProductsbyLenderId($id)
    {
        $DataProductsbyLenderId = static::where('lender_id', $id)->get();
        return $DataProductsbyLenderId;
    }

    public static function getDataProductsbyId($id)
    {
        $DataProductsbyId = static::findOrFail($id);
        return $DataProductsbyId;
    }

    public static function postDataProducts($name, $product_code, $product_description, $product_img, $price, $lender_id)
    {
        return static::create([
            'name' => $name,
            'product_code' => $product_code,
            'product_description' => $product_description,
            'product_img' => $product_img,
            'price' => $price,
            'lender_id' => $lender_id
        ]);
    }

    public static function pacthDataProducts($id, $name, $product_description, $price, $lender_id, $product_img)
    {
        $product = static::find($id);
        
        $data = [
            'name' => $name,
            'price' => $price,
            'lender_id' => $lender_id,
        ];

        if ($product_description != null) {
            $data['product_description'] = $product_description;
        }
        
        if ($product_img != null) {
            $data['product_img'] = $product_img;
        }
    
        $product->update($data);
    }

    public static function patchStatusProductstoYes($id)
    {
        return static::where('id', $id)->update(['is_rented' => 'yes']);
    }

    public static function patchStatusProductstoNo($id)
    {
        return static::where('id', $id)->update(['is_rented' => 'no']);
    }

    public function rentTransactions()
    {
        return $this->hasMany(RentTransaction::class, 'product_id');
    }

    public function lender()
    {
        return $this->belongsTo(Lender::class, 'lender_id');
    }
}
