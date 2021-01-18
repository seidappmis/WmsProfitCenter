@extends('layouts.materialize.index')

@section('content')
<div class="row">


   @component('layouts.materialize.components.title-wrapper')
   <div class="row">
      <div class="col s12 m6">
         <h5 class="breadcrumbs-title mt-0 mb-0"><span>Damage Goods Report</span></h5>
         <ol class="breadcrumbs mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('damage-goods-report') }}">Damage Goods Report</a></li>
            <li class="breadcrumb-item active">{{ $dgr->dgr_no }}</li>
         </ol>
      </div>
   </div>
   @endcomponent

   <div class="col s12">
      <div class="container">
         <div class="section">
            <div class="card">
               <div class="card-content pl-1 pr-1 pt-1 pb-1">
                  <table class="form-table">
                     <tr>
                        <td width="20%">DGR NO.</td><td>{{ $dgr->dgr_no }}</td>
                     </tr>
                  </table>
               </div>
               <div class="card-content p-0">
                  <div class="section-data-tables">
                     <table id="table_detail" class="display" width="100%">
                        <thead>
                           <tr>
                              <th><strong>NO</strong></th>
                              <th><strong>DATE</strong></th>
                              <th><strong>NO. BERITA ACARA</strong></th>
                              <th><strong>INVOICE NO</strong></th>
                              <th><strong>B/L NO</strong></th>
                              <th><strong>CONTAINER NO</strong></th>
                              <th><strong>MODEL</strong></th>
                              <th><strong>POM</strong></th>
                              <th><strong>QTY</strong></th>
                              <th><strong>NO. SERI</strong></th>
                              <th><strong>REMARKS</strong></th>
                              <th><strong></strong></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
@endsection



@push('script_js')
<script type="text/javascript">
   var dttable_detail;
   $(document).ready(function(){
      dttable_detail = $('#table_detail').DataTable({
         paging: false,
         serverSide: true,
         scrollX: true,
         ajax: {
           url: '{{url("/damage-goods-report/" . $dgr->id)}}',
           type: 'GET',
         },
         order: [1, 'asc'],
         columns: [
            { data: 'DT_RowIndex', orderable: false, searchable:false, width: '20px', className: 'center-align' },
            { data: 'berita_acara_date', width: '70px', render: function(data){
               return moment(data).format('ll');
            }},
            { data: 'berita_acara_during_no' },
            { data: 'invoice_no' },
            { data: 'bl_no' },
            { data: 'container_no' },
            { data: 'model_name' },
            { data: 'pom' },
            { data: 'qty' },
            { data: 'serial_number' },
            { data: 'damage' },
            { data: 'action', orderable: false, searchable: false }
         ]
      });

      dttable_detail.on('click', '.btn-delete', function(){
         var tr = $(this).parent().parent();
         var data = dttable_detail.row(tr).data();

         swal({
            text: "Are you sure want to delete serial number " + data.serial_number + " in " + data.berita_acara_during_no + "?",
            icon: 'warning',
            buttons: {
               cancel: true,
               delete: 'Yes, Delete It'
            }
         }).then(function(confirm) { // proses confirm
            if (confirm) {
               $.ajax({
                     url: ('{{ url("/damage-goods-report/details/:id") }}').replace(':id', data.dur_dgr_detail_id),
                     type: 'DELETE',
                     dataType: 'json',
                  })
                  .done(function(result) {
                     showSwalAutoClose('success', result.message)// alert success
                     dttable_detail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                  })
                  .fail(function() {
                     console.log("error");
                  });
            }
         })
      })
   })
</script>
@endpush