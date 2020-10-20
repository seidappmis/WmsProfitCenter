@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m9">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Update Manifest</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Update Manifest</li>
              </ol>
          </div>
          @if(auth()->user()->cabang->hq)
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                    </select>
                  </div>
                </div>
          </div>
          @else
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="branch_filter">
                      <option value="{{auth()->user()->cabang->kode_cabang}}">{{auth()->user()->cabang->long_description}}</option>
                    </select>
                  </div>
                </div>
          </div>
          @endif
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card pl-1 pt-2">
                    <form id="form-search-manifest">
                      <div class="row">
                        <div class="input-field col s6 m4 l3">
                          <input placeholder="No. Manifest" id="manifest_no" name="manifest_no" type="text" class="validate" autocomplete="off">
                          <label for="manifest_no">No. Manifest</label>
                        </div>
                        <div class="input-field col s6 m4 l3">
                          <input placeholder="No. DO" id="delivery_no" name="delivery_no" type="text" class="validate" autocomplete="off">
                          <label for="delivery_no">No. DO</label>
                        </div>
                        <div class="col s6 m3">
                          {!!get_button_save('Search', 'btn-search-manifest mt-5')!!}
                        </div>
                      </div>
                    </form>
                    @include('web.outgoing.update-manifest._form_update_manifest')
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
  $('#area_filter').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('{{url('/master-area/select2-area-only')}}')
  });
  $('#branch_filter').select2({
     placeholder: '-- Select Branch --',
  });
  var dttable_do;

  jQuery(document).ready(function($) {
    @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif

    $("#form-search-manifest").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("update-manifest") }}',
          type: 'POST',
          data: $(form).serialize() + '&area=' + $('#area_filter').val() + '&branch=' + $('#branch_filter').val(),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            var manifestHeader = result.data.manifestHeader;
            $('#manifest_type').text(manifestHeader.manifest_type);
            $('#form-update-manifest [name="type"]').val(manifestHeader.type);
            $('#form-update-manifest [name="do_manifest_no"]').val(manifestHeader.do_manifest_no);
            $('#form-update-manifest [name="do_manifest_date"]').val(manifestHeader.do_manifest_date);
            $('#form-update-manifest [name="vehicle_number"]').val(manifestHeader.vehicle_number);
            $('#form-update-manifest .text-expedition_name').val(manifestHeader.expedition_name);
            $('#form-update-manifest [name="expedition_code"]').val(manifestHeader.expedition_code);
            $('#form-update-manifest [name="expedition_name"]').val(manifestHeader.expedition_name);
            $('#form-update-manifest [name="driver_name"]').val(manifestHeader.driver_name);
            $('#form-update-manifest [name="text_vehicle_description"]').val(manifestHeader.vehicle_description);
            $('#form-update-manifest [name="destination_name_driver"]').val(manifestHeader.destination_name_driver);
            $('#form-update-manifest [name="container_no"]').val(manifestHeader.container_no);
            $('#form-update-manifest [name="seal_no"]').val(manifestHeader.seal_no);
            $('#form-update-manifest [name="pdo_no"]').val(manifestHeader.pdo_no);
            $('#form-update-manifest [name="city_name"]').val(manifestHeader.city_name);
            $('#form-update-manifest [name="city_code"]').val(manifestHeader.city_code);
            $('#form-update-manifest [name="vehicle_description"]').val(manifestHeader.vehicle_description);
            $('#form-update-manifest [name="checker"]').val(manifestHeader.checker);
            set_select2_destination(manifestHeader.expedition_code)

            set_select2_value('#form-update-manifest [name="expedition_code"]', manifestHeader.expedition_code, manifestHeader.expedition_name)
            set_select2_value('#form-update-manifest [name="vehicle_code_type"]', manifestHeader.vehicle_code_type, manifestHeader.vehicle_description)
            set_select2_value('#form-update-manifest [name="city_code"]', manifestHeader.city_code, manifestHeader.city_name)

            if (manifestHeader.type == 'HQ') {
              setManifestHQ(manifestHeader);
            } else {
              setManifestBranch(manifestHeader);
            }

            $('#filter-do-or-shipment').val($("#form-search-manifest [name='delivery_no']").val());
            dttable_do.ajax.reload(null, false)

            $('#form-search-manifest').addClass('hide');
            $('.form-update-manifest-wrapper').removeClass('hide');
          } else {
            showSwalAutoClose('', result.message);
          }
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });

    $('#form-update-manifest .btn-print').click(function(event) {
      /* Act on the event */
      var base_modul = $('#form-update-manifest [name="type"]').val() == "HQ" ? "manifest-regular" : "branch-manifest";
      initPrintPreviewPrintManifest(base_modul + "/" + $('#form-update-manifest [name="do_manifest_no"]').val() + '/export')
    });
    $('#form-update-manifest').validate({
      submitHandler: function(form){
        $.ajax({
          url: '{{ url("update-manifest") }}',
          type: 'PUT',
          data: $(form).serialize() + '&area=' + $('#area_filter').val(),
        })
        .done(function(result) { // selesai dan berhasil
          showSwalAutoClose('', result.message);

        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    })

    dttable_do = $('#table-do').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('update-manifest/list-do')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#filter-do-or-shipment').val()
              d.do_manifest_no = $('#form-update-manifest [name="do_manifest_no"]').val()
              d.type = $('#form-update-manifest [name="type"]').val()
          }
      },
      order: [0, 'asc'],
      columns: [
          { data: 'DT_RowIndex' , orderable:false, searchable: false, width: '5px'},
          { data: 'invoice_no' },
          { data: 'delivery_no' },
          { data: 'do_internal' },
          { data: 'ship_to' },
          { data: 'delivery_items' },
          { data: 'model' },
          { data: 'quantity' },
          { data: 'description' },
          { data: 'status' },
          { data: 'sold_to_code' },
          { data: 'action', className: 'center-align', orderable: false, searchable: false },
      ]
    });

    $('#btn-search-do').click(function(event) {
      /* Act on the event */
      dttable_do.ajax.reload(null, false)
    });
  });

function setManifestHQ(manifestHeader){
  set_hq_select_expedition({expedition_code: manifestHeader.expedition_code})
  set_hq_select_vehicle_type({expedition_code: manifestHeader.expedition_code})
  set_hq_select_ship_to_city({expedition_code: manifestHeader.expedition_code})

  $('#form-update-manifest [name="expedition_code"]').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    set_select2_value('#form-update-manifest [name="vehicle_code_type"]', '', '')
    set_hq_select_vehicle_type({expedition_code: $(this).val()})
    $('#form-update-manifest [name="expedition_name"]').val(data.text)
  });

  $('#form-update-manifest [name="vehicle_code_type"]').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    set_select2_value('#form-update-manifest [name="city_code"]', '', '')
    set_hq_select_ship_to_city({expedition_code: $('#form-update-manifest [name="expedition_code"]').val()})
    $('#form-update-manifest [name="vehicle_description"]').val(data.text)
  });

  $('#form-update-manifest [name="city_code"]').change(function(event) {
    var data = $(this).select2('data')[0]
    $('#form-update-manifest [name="city_name"]').val(data.text)
  })
}

function set_hq_select_expedition(filter = {expedition_code: ''}){
    $('#form-update-manifest [name="expedition_code"]').select2({
        placeholder: '-- Select Expedition --',
        ajax: get_select2_ajax_options('{{url('/master-expedition/select2-all-expedition')}}', filter)
  })
}

function set_hq_select_vehicle_type(filter = {expedition_code: ''}) {
  $('#form-update-manifest [name="vehicle_code_type"]').select2({
    placeholder: '-- Select Vehicle --',
    ajax: get_select2_ajax_options('{{url('/master-freight-cost/select2-vehicle')}}', filter)
  })
}

function set_hq_select_ship_to_city(filter = {expedition_code: ''}){
  filter.tambah_ambil_sendiri = true
  $('#form-update-manifest [name="city_code"]').select2({
    placeholder: '-- Select Destination City --',
    allowClear: true,
    ajax: get_select2_ajax_options('{{url('/master-expedition/select2-expedition-destination-city')}}', filter)
  })

  $('#form-edit-do [name="city_code"]').select2({
      placeholder: '-- Select Ship to City --',
      allowClear: true,
      ajax: get_select2_ajax_options('{{url('/master-expedition/select2-expedition-destination-city')}}', filter)
    })
}

function setManifestBranch(manifestHeader){
set_branch_select_expedition({expedition_code: manifestHeader.expedition_code});
set_branch_select_vehicle_type({expedition_code: manifestHeader.expedition_code});
set_branch_select_ship_to_city({expedition_code: manifestHeader.expedition_code});
$('#form-update-manifest [name="expedition_code"]').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    set_select2_value('#form-update-manifest [name="vehicle_code_type"]', '', '')
    set_branch_select_vehicle_type({expedition_code: $(this).val()})
    $('#form-update-manifest [name="expedition_name"]').val(data.text)
  });

  $('#form-update-manifest [name="vehicle_code_type"]').change(function(event) {
    /* Act on the event */
    var data = $(this).select2('data')[0]
    set_select2_value('#form-update-manifest [name="city_code"]', '', '')
    set_branch_select_ship_to_city({expedition_code: $('#form-update-manifest [name="expedition_code"]').val()})
    $('#form-update-manifest [name="vehicle_description"]').val(data.text)
  });

  $('#form-update-manifest [name="city_code"]').change(function(event) {
    var data = $(this).select2('data')[0]
    $('#form-update-manifest [name="city_name"]').val(data.text)
  })
}

function set_branch_select_expedition(filter = {expedition_code: ''}){
    $('#form-update-manifest [name="expedition_code"]').select2({
        placeholder: '-- Select Expedition --',
        //ajax: get_select2_ajax_options('{{url('/master-branch-expedition/select2-active-expedition', {onetime: true})}}')
        ajax: get_select2_ajax_options('{{url('/master-branch-expedition/select2-active-expedition')}}', filter)
  })
}


function set_branch_select_vehicle_type(filter = {expedition_code: ''}) {
    $('#form-update-manifest [name="vehicle_code_type"]').select2({
      placeholder: '-- Select Vehicle --',
      ajax: get_select2_ajax_options('{{url('/branch-expedition-vehicle/select2-vehicle')}}', filter)
    })
}

function set_branch_select_ship_to_city(filter = {expedition_code: ''}){
  filter.tambah_ambil_sendiri = true
  $('#form-update-manifest [name="city_code"]').select2({
    placeholder: '-- Select Destination City --',
    allowClear: true,
    ajax: get_select2_ajax_options('{{url('/destination-city-of-branch/select2')}}', filter)
  })

   $('#form-edit-do [name="city_code"]').select2({
      placeholder: '-- Select Ship to City --',
      allowClear: true,
      ajax: get_select2_ajax_options('{{url('/destination-city-of-branch/select2')}}', filter)
    })
}

</script>
@endpush

@include('web.outgoing.update-manifest._edit_do')