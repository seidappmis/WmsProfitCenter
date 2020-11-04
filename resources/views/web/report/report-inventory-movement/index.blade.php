@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Inventory Movement</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Inventory Movement</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-report-inventory-movement">
                               <table>
                                   <tr>
                                       <td>BRANCH</td>
                                       <td>
                                         <div class="input-field col s6">
                                           <select id="kode_cabang"
                                                name="kode_cabang"
                                                class="select2-data-ajax browser-default"
                                                required="">
                                          </select>
                                         </div>
                                       </td>
                                     </tr>
                                 <tr>
                                   <td>TRANSACTION DATE</td>
                                   <td>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         From
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" name="start_date" type="text" class="validate datepicker" required>
                                       </div>
                                     </div>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         To
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" name="end_date" type="text" class="validate datepicker" required >
                                       </div>
                                     </div>
                                   </td>
                                 </tr>
                                
                                 <tr>
                                     <td>MODEL</td>
                                     <td><div class="input-field col s12">
                                        <input id="" type="text" class="validate" name="model" >
                                      </div></td>
                                 </tr>
                                 <tr>
                                    <td>SLOC</td>
                                    <td>
                                      <div class="input-field col s6">
                                        <select id="storage_location"
                                                name="storage_location"
                                                class="select2-data-ajax browser-default"
                                                >
                                          </select>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>MOVEMENT TYPE</td>
                                    <td>
                                      <div class="input-field col s6">
                                        <select id="movement_code"
                                                name="movement_code"
                                                class="select2-data-ajax browser-default"
                                                >
                                          </select>
                                      </div>
                                    </td>
                                  </tr>
                               </table>
                              
                               <div class="input-field col s12">
                                 <button type="submit" class="waves-effect waves-light indigo btn mb-1 mt-1">Submit</button>
                               </div>
                            </form>
                      </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="table_report_inventory_movement" width="100%">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Transaction Date</th>
                                        <th>Model</th>
                                        <th>QTY</th>
                                        <th>Debit/Credit</th>
                                        <th>Branch Code</th>
                                        <th>Branch</th>
                                        <th>Storage Location</th>
                                        <th>Movement Type</th>
                                        <th>Picking No</th>
                                        <th>Manifest No</th>
                                        <th>Ship to Code</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay">
        </div>
    </div>

</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  var dttable_report_inventory_movement;
  jQuery(document).ready(function($) {
    dttable_report_inventory_movement = $('#table_report_inventory_movement').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      scrollY: '60vh',
      buttons: [
        {
          text: 'PDF',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-inventory-movement/export?file_type=pdf')}}" + '&' + $('#form-report-inventory-movement').serialize();
          }
        },
         {
          text: 'EXCEL',
          action: function ( e, dt, node, config ) {
              window.location.href = "{{url('report-inventory-movement/export?file_type=xls')}}" + '&' + $('#form-report-inventory-movement').serialize();
          }
        }
      ],
      ajax: {
          url: '{{ url('report-inventory-movement') }}',
          type: 'GET',
          data: function(d) {
            d.kode_cabang = $('#form-report-inventory-movement [name="kode_cabang"]').val()
            d.start_date = $('#form-report-inventory-movement [name="start_date"]').val()
            d.end_date = $('#form-report-inventory-movement [name="end_date"]').val()
            d.model = $('#form-report-inventory-movement [name="model"]').val()
            d.storage_location = $('#form-report-inventory-movement [name="storage_location"]').val()
            d.movement_code = $('#form-report-inventory-movement [name="movement_code"]').val()
          }
      },
      columns: [
          {data: 'log_id'},
          {data: 'created_at'},
          {data: 'model'},
          {data: 'quantity'},
          {data: 'debit_credit'},
          {data: 'kode_customer'},
          {data: 'long_description'},
          {data: 'storage_location'},
          {data: 'movement_code'},
          {data: 'arrival_no'},
          {data: 'do_manifest_no'},
          {data: 'ship_to_code'},
          {data: 'username'},
      ]
    });

    $('#form-report-inventory-movement [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
    });
    $('#form-report-inventory-movement [name="kode_cabang"]').change(function(event) {
      /* Act on the event */
      set_select2_value('#form-report-inventory-movement [name="storage_location"]', '', '')
      setSLOC({cabang: $(this).val()})
    });

    setSLOC();
    $('#form-report-inventory-movement [name="movement_code"]').select2({
       placeholder: '-- Select Movement Type --',
       allowClear: true,
       ajax: get_select2_ajax_options('/movement-type/select2')
    });

    $('#form-report-inventory-movement').validate({
      submitHandler: function (form){
        dttable_report_inventory_movement.ajax.reload(null, false)
      }
    })
  });

  function setSLOC(filter = {cabang: null}){
    $('#form-report-inventory-movement [name="storage_location"]').select2({
       placeholder: '-- Select Storage Location --',
       allowClear: true,
       ajax: get_select2_ajax_options('/storage-master/select2-storage-cabang', filter)
    });
  }
</script>
@endpush