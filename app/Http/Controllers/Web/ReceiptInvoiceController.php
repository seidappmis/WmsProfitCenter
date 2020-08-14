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
            $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
            // Set Font
            $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFont()->setName('courier New');

            // Atur lebar kolom
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(2.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(2.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(11);

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

    public function exportReceiptInvoice(Request $request, $id)
    {
        $view_print = view('web.invoicing.receipt-invoice._print_receipt_invoice');
        $title      = 'receipt_invoice';

        if ($request->input('filetype') == 'html') {

            // request HTML View
            return $view_print;
        } elseif ($request->input('filetype') == 'xls') {

            // Request FILE EXCEL
            $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

            $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

            // Set warna background putih
            $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
            // Set Font
            $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFont()->setName('courier New');

            // Atur lebar kolom
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(2.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(2.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(11);
            $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(11);

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
