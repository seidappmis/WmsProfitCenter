<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiptInvoiceAccountingController extends Controller
{
    public function index(Request $request)
    {
        return view('web.invoicing.receipt-invoice-accounting.index');
    }

    public function create()
    {
        return view('web.invoicing.receipt-invoice-accounting.create');
    }

    public function show()
    {
        return view('web.invoicing.receipt-invoice-accounting.view');
    }
    public function exportReceiptInvoiceAccounting(Request $request, $id)
    {
        $view_print = view('web.invoicing.receipt-invoice-accounting._print_receipt_invoice_accounting');
        $title      = 'receipt_invoice_accounting';

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
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5.3);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(6.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(22);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(13);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(11.5);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(17);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(9);


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
