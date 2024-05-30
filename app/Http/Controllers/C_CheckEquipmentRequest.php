<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentRequest;

class C_CheckEquipmentRequest extends Controller
{
    // CONTROLLER INI KHUSUS DIGUNAKAN UNTUK NOTIFIKASI RED DOT PADA AKTOR PEMERINTAH / TPHP
    public function check() // digunakan untuk cek apakah ada request equipment yang sedang diproses (belum dikonfirmasi)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') { //cek apakah requestnya GET
            $Data = EquipmentRequest::getDataEquipmentRequest(); // ambil semua data equipment request yang sedang diproses
            if (!$Data->isEmpty()) { // jika equipment request yang sedang diproses ada maka return true (agar dapat diakses oleh ajax)
                echo json_encode(true);
            } else { // jika equipment request yang sedang diproses tidak ada maka return false (agar dapat daikses oleh ajax)
                echo json_encode(false);
            }
        }
    }
}
