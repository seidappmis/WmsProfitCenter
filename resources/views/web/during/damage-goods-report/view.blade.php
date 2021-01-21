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

@push('page-modal')
<div id="modal-update-detail" class="modal modal-fixed-footer" style="">
    <form id="form-update-detail" class="form-table">
        <div class="modal-content">
            <input type="hidden" name="berita_acara_during_detail_id" readonly>
            <table>
                <tr>
                    <td>MODEL</td>
                    <td>
                        <select name="model_name" class="select2-data-ajax browser-default">
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>POM</td>
                    <td>
                        <input type="text" name="pom">
                    </td>
                </tr>
                <tr>
                    <td>QTY</td>
                    <td>
                        <input type="number" name="qty">
                    </td>
                </tr>
                <tr>
                    <td>SERIAL NO</td>
                    <td>
                        <input type="text" name="serial_number">
                    </td>
                </tr>
                <tr>
                    <td>KERUSAKAN</td>
                    <td>
                        <textarea class="materialize-textarea" name="damage" placeholder="damage" style="resize: vertical;"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="waves-effect waves-light indigo btn-small btn-save">Save</button>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </form>
</div>
@endpush

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
   var dttable_detail;
   $(document).ready(function(){
      $('#form-update-detail [name="model_name"]').select2({
        placeholder: '-- Select Model/Item No. --',
        ajax: get_select2_ajax_options('/master-model/select2-model2')
      });
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

      dttable_detail.on('click', '.btn-edit', function(){
         var tr = $(this).parent().parent();
         var data = dttable_detail.row(tr).data();
         
         set_select2_value('#form-update-detail [name="model_name"]', data.model_name, data.model_name);
         $('#form-update-detail [name="berita_acara_during_detail_id"]').val(data.berita_acara_during_detail_id);
         $('#form-update-detail [name="pom"]').val(data.pom);
         $('#form-update-detail [name="qty"]').val(data.qty);
         $('#form-update-detail [name="serial_number"]').val(data.serial_number);
         $('#form-update-detail [name="damage"]').val(data.damage);
         
         $('#modal-update-detail').modal('open');
      });

      $('#form-update-detail').validate({
         submitHandler: function(form){
            $.ajax({
               url: '{{ url("/damage-goods-report/details") }}',
               type: 'PUT',
               dataType: 'json',
               data: $(form).serialize()
            })
            .done(function(result) {
               if(result.status){
                  showSwalAutoClose('success', result.message)// alert success
                  dttable_detail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                  $('#modal-update-detail').modal('close');
               }
               
            })
            .fail(function() {
               console.log("error");
            });
         }
      })

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