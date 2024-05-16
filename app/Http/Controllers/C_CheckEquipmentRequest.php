<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentRequest;

class C_CheckEquipmentRequest extends Controller
{
    public function check()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $Data = EquipmentRequest::getDataEquipmentRequest();
            if (!$Data->isEmpty()) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        }
    }
}
