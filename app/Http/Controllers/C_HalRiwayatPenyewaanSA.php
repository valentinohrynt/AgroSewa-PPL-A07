<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\RentLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class C_HalRiwayatPenyewaanSA extends Controller
{
    public function setHalRiwayatPenyewaanSA(Request $request)
    {
        $lenderId = $request->input('lender_id');
        $lender = Lender::getDataLenderbyId($lenderId);
        $rentLogs = RentLog::getDataRentLogbyLenderId($lenderId);
        return view('superadmin.V_HalRiwayatPenyewaanSA', compact('rentLogs', 'lender'));
    }
    public function getDynamicContent(Request $request) 
    {
        $itemId = $request->itemId;
        $rentLog = RentLog::findOrFail($itemId);
        $productImg = $rentLog->rentTransaction->product->product_img;
        $dynamicContent = [
            "productName" => $rentLog->rentTransaction->product->name,
            "borrowerName" => $rentLog->rentTransaction->borrower->name,
            "landArea" => $rentLog->rentTransaction->borrower->land_area,
            "rentDate" => $rentLog->rentTransaction->rent_date,
            "returnDate" => $rentLog->rentTransaction->return_date,
            "totalPrice" => $rentLog->total_price,
            "productImage" => asset('storage/product_img/'. $productImg)
        ];

        return response()->json($dynamicContent);
    }
}
