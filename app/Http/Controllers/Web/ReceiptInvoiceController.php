<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiptInvoiceController extends Controller
{
    public function exportReceiptNo(Request $request, $id)
    {
        $view_print = view('web.invoicing.receipt-invoice._print_receipt_no');
        $title      = 'receipt_no';

        if ($request->input('filetype') == 'html') {

            // request HTML View
            return $view_print;
        } elseif ($request->input('filetype') == 'xls') {

            // Request FILE EXCEL
            $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

            $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

            // Set warna background putih
            $spreadsheet->getActiveSheet()->getStyle('A1:G1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
            // Set Font
            $spreadsheet->getActiveSheet()->getStyle('A1:G1000')->getFont()->setName('courier New');

            // Atur lebar kolom
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $title . '.xls"');

            $writer->save("php://output");
        } else if ($request->input('filetype') == 'pdf') {

            // REQUEST PDF
            $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

            $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

            $mpdf->Output($title . '.pdf', "D");
        } else {
            // Parameter filetype tidak valid / tidak ditemukan return 404
            return redirect(404);
        }
    }
}
