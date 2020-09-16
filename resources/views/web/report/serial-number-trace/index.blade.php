@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Serial Number Trace</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Serial Number Trace</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-filter">
                               <table>
                                 <tr>
                                    <td width="20%">MODEL</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="model" required>
                                     </div></td>
                                 </tr>
                                 <tr>
                                    <td width="20%">SERIAL NUMBER</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="serial_number" required>
                                     </div></td>
                                 </tr>
                                 <tr>
                                    <td width="20%"></td>
                                    <td><div class="input-field col s12">
                                        <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                                      </div></td>
                                 </tr>
                               </table>
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
              <div class="card ">
                <div class="card-content p-0">
                  <table id="data-table-serial-number-trace" class="display" width="100%">
                    <thead>
                        <tr>
                          <th>Serial Number</th>
                          <th>Model</th>
                          <th>EAN</th>
                          <th>Date of LMB</th>
                          <th>Manifest No.</th>
                          <th>Delivery Date</th>
                          <th>Arrival Date</th>
                          <th>From</th>
                          <th>Ship to</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- datatable ends -->
              </div>
              </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>


</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
    var dttable_serial_number_trace;
    jQuery(document).ready(function($) {
        dttable_serial_number_trace = $('#data-table-serial-number-trace').DataTable({
          serverSide: true,
          scrollX: true,
          dom: 'Brtip',
          scrollY: '60vh',
          buttons: [
                  {
                      text: 'PDF',
                      action: function ( e, dt, node, config ) {
                          window.location.href = "{{url('report-master-users/export?file_type=pdf')}}" + '&area=' + $('#area_filter').val();
                      }
                  },
                   {
                      text: 'EXCEL',
                      action: function ( e, dt, node, config ) {
                          window.location.href = "{{url('report-master-users/export?file_type=xls')}}" + '&area=' + $('#area_filter').val();
                      }
                  }
              ],
          ajax: {
              url: '{{ url('serial-number-trace') }}',
              type: 'GET',
              data: function(d) {
                  d.model = $('#form-filter [name="model"]').val()
                  d.serial_number = $('#form-filter [name="serial_number"]').val()
                }
          },
          order: [1, 'asc'],
          columns: [
              {data: 'serial_number'},
              {data: 'model'},
              {data: 'ean_code'},
              {data: 'lmb_date'},
              {data: 'do_manifest_no'},
              {data: 'created_at'},
              {data: 'arrival_date'},
              {data: 'from'},
              {data: 'ship_to_code'},
          ]
        });

        $('#form-filter').validate({
            submitHandler: function(form){
                dttable_serial_number_trace.ajax.reload(null, false)
            }
        })

    });
</script>
@endpush
