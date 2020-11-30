<table width="100%" style="font-family: Arial;border-collapse: collapse;">
   <thead>
      <tr>
         <th style="border: 1pt solid #000000;"><strong>#</strong></th>
         <th style="border: 1pt solid #000000;"><strong>UPLOAD DATE</strong></th>
         <th style="border: 1pt solid #000000;"><strong>MODIFIED DATE</strong></th>
         <th style="border: 1pt solid #000000;"><strong>RECEIVE DATE</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO DOC</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO ST or NO URF</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO APPLY</strong></th>
         <th style="border: 1pt solid #000000;"><strong>CUSTOMER CODE</strong></th>
         <th style="border: 1pt solid #000000;"><strong>CUSTOMER NAME</strong></th>
         <th style="border: 1pt solid #000000;"><strong>MODEL PLAN</strong></th>
         <th style="border: 1pt solid #000000;"><strong>QTY PLAN</strong></th>
         <th style="border: 1pt solid #000000;"><strong>CBM</strong></th>
         <th style="border: 1pt solid #000000;"><strong>MODEL ACTUAL</strong></th>
         <th style="border: 1pt solid #000000;"><strong>QTY ACTUAL</strong></th>
         <th style="border: 1pt solid #000000;"><strong>CHECK</strong></th>
         <th style="border: 1pt solid #000000;"><strong>CATEGORY</strong></th>
         <th style="border: 1pt solid #000000;"><strong>DO NUMBER PLAN</strong></th>
         <th style="border: 1pt solid #000000;"><strong>DO NUMBER ACTUAL</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO SO</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO PO</strong></th>
         <th style="border: 1pt solid #000000;"><strong>RR</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO SERIAL</strong></th>
         <th style="border: 1pt solid #000000;"><strong>KONDISI</strong></th>
         <th style="border: 1pt solid #000000;"><strong>REMAK</strong></th>
         <th style="border: 1pt solid #000000;"><strong>NO MOBIL</strong></th>
         <th style="border: 1pt solid #000000;"><strong>EXPEDISI</strong></th>
         <th style="border: 1pt solid #000000;"><strong>DRIVER</strong></th>
      </tr>
   </thead>
   <tbody>
      @php $no=1;@endphp;
      @forelse($data as $k => $v)
      <tr>
         <td style="border: 1pt solid #000000;">{{$no++}}</td>
         <td style="border: 1pt solid #000000;">{{format_tanggal_wms($v['upload_date'])}}</td>
         <td style="border: 1pt solid #000000;">{{!empty($v['modify_date'])?format_tanggal_wms($v['modify_date']):''}}</td>
         <td style="border: 1pt solid #000000;">{{$v['receive_date']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_doc']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_st_or_no_urf']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_apply']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['costumer_code']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['costumer_name']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['model_plan']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['qty_plan']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['cbm']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['model_actual']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['qty_actual']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['check']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['category']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['do_number_plan']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['do_number_actual']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_so']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_po']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['rr']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_serial']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['kondisi']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['remark']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['no_mobil']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['expedisi']}}</td>
         <td style="border: 1pt solid #000000;">{{$v['driver']}}</td>
      </tr>
      @empty
      <tr>
         <td style="border: 1pt solid #000000;" colspan="27"> Empty Data</td>
      </tr>
      @endforelse
   </tbody>
</table>