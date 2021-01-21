<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceReceiptConfirm;
use App\Models\InvoiceReceiptPR;
use DataTables;
use DB;

class ReceiptInvoiceAccountingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = InvoiceReceiptConfirm::select(
                'log_invoice_receipt_confirm.group_id_report',
                DB::raw('GROUP_CONCAT(DISTINCT invoice_receipt_id SEPARATOR ", ") AS invoice_receipt_id')
            )
                ->whereNotNull('group_id_report')
                ->groupBy('group_id_report');

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $btn = get_button_view(url('receipt-invoice-accounting/' . $data->group_id_report));
                    $btn .= ' ' . get_button_delete('Rollback');
                    return $btn;
                });

            return $datatables->make(true);
        }

        return view('web.invoicing.receipt-invoice-accounting.index');
    }

    public function create()
    {
        return view('web.invoicing.receipt-invoice-accounting.create');
    }

    public function store(Request $request)
    {
        if (empty(json_decode($request->input('data_list_receipt'), true))) {
            return sendError('No Receipt selected.');
        }

        $group_id_report = !empty($request->input('group_id_report')) ? $request->input('group_id_report') : date('Y-m-d H:i:s');

        try {
            DB::beginTransaction();
            $rsReceipt = $this->getPostListReceipt($request, $group_id_report);

            DB::commit();
            return sendSuccess('Data Submited', [
                'rs_receipt' => $rsReceipt,
                'group_id_report' => $group_id_report
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            sendError('failed', $th);
            //throw $th;
        }
    }

    protected function getPostListReceipt($request, $group_id_report)
    {
        $rs_list_receipt = [];
        foreach (json_decode($request->input('data_list_receipt'), true) as $key => $value) {
            $invoiceReceiptConfirm = InvoiceReceiptConfirm::find($value['invoice_receipt_id']);
            $invoiceReceiptConfirm->group_id_report = $group_id_report;
            $invoiceReceiptConfirm->create_report_by = auth()->user()->username;
            $invoiceReceiptConfirm->create_report_date = date('Y-m-d H:i:s');

            $invoiceReceiptConfirm->save();

            $rs_list_receipt[] = $invoiceReceiptConfirm;
        }

        return $rs_list_receipt;
    }

    public function getReceiptList(Request $request)
    {
        if ($request->ajax()) {
            $from_date = date("Y-m-01", strtotime(str_replace('/', '-', '01/' . $request->input('receipt_period'))));
            $to_date   = date("Y-m-t", strtotime(str_replace('/', '-', '01/' . $request->input('receipt_period'))));

            $query  = InvoiceReceiptConfirm::select(
                'log_invoice_receipt_confirm.*',
                'log_invoice_receipt_header.kwitansi_no',
                'log_invoice_receipt_header.invoice_receipt_no'
            )
                ->leftjoin('log_invoice_receipt_header', 'log_invoice_receipt_header.invoice_receipt_id', '=', 'log_invoice_receipt_confirm.invoice_receipt_id')
                ->whereBetween(DB::raw('DATE(log_invoice_receipt_confirm.invoice_date)'), array($from_date, $to_date))
                ->whereNull('log_invoice_receipt_confirm.group_id_report');

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
            ;

            return $datatables->make(true);
        }
    }

    public function getListPaymentRequisition(Request $request, $id)
    {
        if ($request->ajax()) {
            $query  = InvoiceReceiptConfirm::select(
                'log_invoice_receipt_confirm.expedition_name',
                'log_invoice_receipt_pr.payment_requisition'
            )
                ->leftjoin('log_invoice_receipt_pr', function ($join) {
                    $join->on('log_invoice_receipt_pr.group_id_report', '=', 'log_invoice_receipt_confirm.group_id_report');
                    $join->on('log_invoice_receipt_pr.expedition_name', '=', 'log_invoice_receipt_confirm.expedition_name');
                })
                ->where('log_invoice_receipt_confirm.group_id_report', $id);

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    return get_button_delete();
                });

            return $datatables->make(true);
        }
    }

    public function storeListPaymentRequisition(Request $request, $id)
    {
        $rsReceiptPR = [];
        foreach ($request->input('expedition_name') as $key => $value) {
            $rsReceiptPR[$key]['group_id_report'] = $id;
            $rsReceiptPR[$key]['expedition_name'] = $value;
        }

        foreach ($request->input('payment_requisition') as $key => $value) {
            $rsReceiptPR[$key]['payment_requisition'] = $value;
        }

        foreach ($rsReceiptPR as $key => $value) {
            InvoiceReceiptPR::updateOrInsert(
                ['group_id_report' => $value['group_id_report'], 'expedition_name' => $value['expedition_name']],
                ['payment_requisition' => $value['payment_requisition']]
            );
        }

        return sendSuccess('Data Updated.', $rsReceiptPR);
    }

    public function show(Request $request, $id)
    {
        $rsReceiptConfirm = InvoiceReceiptConfirm::where('group_id_report', $id)->get();

        if ($request->ajax()) {
            $query  = InvoiceReceiptConfirm::select(
                'log_invoice_receipt_confirm.*',
                'log_invoice_receipt_header.kwitansi_no',
                'log_invoice_receipt_header.invoice_receipt_no'
            )
                ->leftjoin('log_invoice_receipt_header', 'log_invoice_receipt_header.invoice_receipt_id', '=', 'log_invoice_receipt_confirm.invoice_receipt_id')
                ->where('log_invoice_receipt_confirm.group_id_report', $id);

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    return get_button_delete();
                });

            return $datatables->make(true);
        }

        if ($rsReceiptConfirm->count() == 0) {
            return redirect(404);
        }

        return view('web.invoicing.receipt-invoice-accounting.view', [
            'group_id_report' => $id,
            'rs_receipt' => $rsReceiptConfirm
        ]);
    }

    public function update(Request $request, $id)
    {
        $rsReceiptConfirm = InvoiceReceiptConfirm::where('group_id_report', $id)->get();

        foreach ($rsReceiptConfirm as $key => $value) {
            $value->logistic_staff = $request->input('logistic_staff');
            $value->logistic_ass_manager = $request->input('logistic_ass_manager');
            $value->logistic_manager = $request->input('logistic_manager');
            $value->accounting_division = $request->input('accounting_division');

            $value->save();
        }

        return sendSuccess('Assign has been update !', $rsReceiptConfirm);
    }

    public function destroy($id)
    {
        InvoiceReceiptConfirm::where('group_id_report', $id)->delete();

        return sendSuccess("Successfully roll back data", []);
    }

    public function destroyInvoice($id, $invoice_receipt_id)
    {
        InvoiceReceiptConfirm::where('invoice_receipt_id', $invoice_receipt_id)->delete();

        return sendSuccess("Successfully delete invoice", []);
    }

    public function exportReceiptInvoiceAccounting(Request $request, $id)
    {

        $receipts = InvoiceReceiptConfirm::select(
            'log_invoice_receipt_confirm.*',
            'log_invoice_receipt_header.invoice_receipt_no',
            'log_invoice_receipt_header.kwitansi_no',
            'log_invoice_receipt_header.amount_before_tax',
            'log_invoice_receipt_header.amount_after_tax',
            'log_invoice_receipt_header.amount_pph',
            'log_invoice_receipt_header.amount_ppn',
            'log_invoice_receipt_pr.payment_requisition',
        )
            ->where('log_invoice_receipt_confirm.group_id_report', $id)
            ->whereNotNull('log_invoice_receipt_pr.payment_requisition')
            ->leftjoin('log_invoice_receipt_header', 'log_invoice_receipt_header.invoice_receipt_id', '=', 'log_invoice_receipt_confirm.invoice_receipt_id')
            ->leftjoin('log_invoice_receipt_pr', function ($join) {
                $join->on('log_invoice_receipt_pr.group_id_report', '=', 'log_invoice_receipt_confirm.group_id_report');
                $join->on('log_invoice_receipt_pr.expedition_name', '=', 'log_invoice_receipt_confirm.expedition_name');
            })
            ->get();

        $data['receipts'] = $receipts;

        $view_print = view('web.invoicing.receipt-invoice-accounting._print_receipt_invoice_accounting', $data);
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
