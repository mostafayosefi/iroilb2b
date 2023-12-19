<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site\Table;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class PdfController extends Controller
{
    // export table to pdf
    public function make(Request $request)
    {
        $detail = json_decode($request->get('detail'));
        view()->share('data', [
            'water' => $request->get('water'),
            'title' => $request->get('title'),
            'headers' => $request->get('header'),
            'body' => $request->get('data'),
            'detail' => $detail,
        ]);
        Pdf::setOption(['dpi' => 150, 'debugCss' => true]);
        $pdf = PDF::loadView('admin/pdf', [
            'water' => $request->get('water'),
            'title' => $request->get('title'),
            'headers' => $request->get('header'),
            'body' => $request->get('data'),
            'detail' => $detail,
        ]);
        $pdf->save('pdf/table.pdf');
        return response()->download(public_path('pdf/table.pdf'));
    }
}
