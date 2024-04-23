<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
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

        $equipmentRequest = EquipmentRequest::getDataEquipmentRequestbyLenderId($lenderId);
        return view("lenders.V_HalPengajuanBantuanKT", ['equipmentRequest'=>$equipmentRequest]);
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
        ];

        $request->validate([
            'pdf_file' => 'required|mimes:pdf',
        ], $messages);

        $latestRequest = EquipmentRequest::latest()->first();
        $latestNumber = $latestRequest ? $latestRequest->equipment_request_number : 'PB000';

        $newNumber = 'PB' . str_pad(intval(substr($latestNumber, 2)) + 1, 3, '0', STR_PAD_LEFT);
        $fileName = '';
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $extension = $request->file('pdf_file')->getClientOriginalExtension();
            $fileName = $newNumber . '_' . $lender->name . '_pengajuanke' . ($lender->equipmentRequests()->count() + 1) . '.' . $extension;
            $request->file('pdf_file')->storeAs('pdf_files', $fileName);
            $filePath = public_path('storage/pdf_files/' . $fileName);
            $pdf = new Fpdi();
            $pdf->setSourceFile($filePath);
            $pageId = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($pageId);
            $pdf->SetTitle($fileName);
            $pdf->SetAuthor($lender->name);
            $pdf->SetSubject('Pengajuan Bantuan');
            $pdf->Output('F', $filePath);
            $pdf->Close();
        }

        $equipmentRequestId = EquipmentRequest::postDataEquipmentRequest($fileName, $newNumber, $lenderId);
        EquipmentRequestLog::postDataEquipmentRequestLog($equipmentRequestId);

        return redirect('HalPengajuanBantuanKT')->with('success', 'Pengajuan berhasil dibuat, silahkan melakukan pengecekan berkala pada riwayat pengajuan bantuan.');
    }
}
