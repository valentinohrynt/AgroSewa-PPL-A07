<?php

namespace App\Http\Controllers;

use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Setasign\Fpdi\PdfParser;
use App\Models\Lender;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\EquipmentRequest;
use App\Models\EquipmentRequestLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class C_HalPengajuanBantuanKT extends Controller
{
    public function setHalPengajuanBantuanKT()
    {
        $user = Auth::user();
        $userId = $user -> id;
        $lender = Lender::getDataLenderbyUserId($userId);
        $lenderId = $lender->id;
        $productCategories = ProductCategory::getAllDataProductCategory();

        $equipmentRequest = EquipmentRequest::getDataEquipmentRequestbyLenderId($lenderId);
        return view("lenders.V_HalPengajuanBantuanKT", compact('equipmentRequest', 'productCategories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user -> id;
        $lender = Lender::where('user_id', $userId)->first();
        $lenderId = $lender -> id;
        $messages = [
            'pdf_file.required' => 'File proposal tidak boleh kosong.',
            'pdf_file.mimes' => 'Hanya menerima file pdf.',
            'product_category_id.required' => 'Jenis alat yang diajukan tidak boleh kosong.',
        ];
        
        $request->validate([
            'pdf_file' => 'required|mimes:pdf',
            'product_category_id' => 'required',
        ], $messages);
        
        $equipmentRequest = EquipmentRequest::postDataEquipmentRequest($lenderId, $request->product_category_id);
        $equipmentRequestNumber = $equipmentRequest->equipment_request_number;
        $equipmentRequestId = $equipmentRequest -> id;
        $fileName = '';
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $extension = $request->file('pdf_file')->getClientOriginalExtension();
            $fileName = $equipmentRequestNumber . '_' . $lender->name . '_pengajuanke' . ($lender->equipmentRequests()->count()) . '.' . $extension;
            $request->file('pdf_file')->storeAs('pdf_files', $fileName);
            $filePath = storage_path('app/public/pdf_files/' . $fileName);
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($filePath);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                $pdf->useTemplate($tplId);
            }
            $pdf->SetTitle($fileName);
            $pdf->SetAuthor($lender->name);
            $pdf->SetSubject('Pengajuan Bantuan');
            $pdf->Output($filePath, 'F');
        }
        
        $equipmentRequest->pdf_file_name = $fileName;
        $equipmentRequest->save();

        EquipmentRequestLog::postDataEquipmentRequestLog($equipmentRequestId);

        return redirect('HalPengajuanBantuanKT')->with('success', 'Pengajuan berhasil dibuat, silahkan melakukan pengecekan berkala pada riwayat pengajuan bantuan.');
    }
}
