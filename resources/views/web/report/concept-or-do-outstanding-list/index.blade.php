@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4 l4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept or DO Outstanding List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept or DO Outstanding List</li>
                </ol>
            </div>
           
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form id="form-report-outstanding-list" class="form-table">
                            <table>
                              <tr style="background-color: darkgray">
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>OR</td>
                                <td></td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="cabang" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Shipment No</td>
                                <td><div class="input-field col s12">
                                  <input id="model" type="text" class="validate" name="shipment_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Do NO</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="do_no">
                                </div></td>
                              </tr>
                              <tr class="area-wrapper">
                                <td>Expedition</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="expedition" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Upload Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="area-wrapper">
                                <td>Vahicle Type</td>
                                <td><div class="input-field col s12">
                                  <select name="vehicle_type" class="select2-data-ajax browser-default">
                                    </select>
                                </div></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1 ml-1">Submit</button>
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
                            <table class="display" id="data-concept-or-do-outstanding-list" width="100%">
                                <thead>
                                    <tr>
                                        <th width="150px;">INVOICE NO</th>
                                        <th width="150px;">DELIVERY NO</th>
                                        <th width="150px;">DELIVERY ITEMS</th>
                                        <th width="150px;">DO DATE</th>
                                        <th width="150px;">KODE CUSTOMER</th>
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

  jQuery(document).ready(function($) {
    table = $('#data-concept-or-do-outstanding-list').DataTable({
      serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      pageLength: 1,
      scrollY: '60vh',
      buttons: [
              {
                  text: 'PDF',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=pdf')}}" + '&area=' + $('#area_filter').val();
                  }
              },
               {
                  text: 'EXCEL',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('concept-or-do-outstanding-list/export?file_type=xls')}}" + '&area=' + $('#area_filter').val();
                  }
              }
          ],
      ajax: {
          url: '{{ url('concept-or-do-outstanding-list') }}',
          type: 'GET',
          data: function(d) {
            d.area = $('#area_filter').val()
            d.search['value'] = $('#report-user-filter').val()
          }
      },
      columns: [
          {data: 'invoice_no', className: 'detail'},
          {data: 'delivery_no', className: 'detail'},
          {data: 'delivery_items', className: 'detail'},
          {data: 'do_date', className: 'detail'},
          {data: 'username', className: 'detail'},
      ]
    });

    $('#form-report-outstanding-list').validate({
      submitHandler: function (form){
        alert('Get Outstanding')
      }
    })

    $('#form-report-outstanding-list [name="cabang"]').change(function(event) {
      /* Act on the event */
      if ($(this).val() != '') {
        init_form_branch();
      }
    });

    $('#form-report-outstanding-list [name="area"]').change(function(event) {
      /* Act on the event */
      if ($(this).val() != '') {
        init_form_area();
      }
    });
  });

  function init_form_branch(){
    $('.area-wrapper').addClass('hide')
    set_select2_value('#form-report-outstanding-list [name="area"]', '', '');
    set_select2_value('#form-report-outstanding-list [name="expedition"]', '', '');
    set_select2_value('#form-report-outstanding-list [name="vehicle_type"]', '', '');
  }

  function init_form_area() {
    $('.area-wrapper').removeClass('hide')
    set_select2_value('#form-report-outstanding-list [name="cabang"]', '', '');

  }

  $('#form-report-outstanding-list [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  $('#form-report-outstanding-list [name="cabang"]').select2({
     placeholder: '-- Select Branch --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
  });
  $('#form-report-outstanding-list [name="expedition"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  });
  $('#form-report-outstanding-list [name="vehicle_type"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-vehicle/select2-vehicle')
  });
</script>
@endpush