@extends('layouts.materialize.index')

@section('content')
<div class="row">
    @component('layouts.materialize.components.title-wrapper')
    <div class="row">
        <div class="col s12 m12 mb-0">
            <h5 class="breadcrumbs-title mt-0 mb-0">
                <span>
                    Stock Take Input 1
                </span>
            </h5>
            <ol class="breadcrumbs mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Stock Take Input 1
                </li>
            </ol>
        </div>
    </div>
    @endcomponent
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <div class="row mb-2">
                            <div class="col s12 m2 pt-2">
                                <p>
                                    Periode STO
                                </p>
                            </div>
                            <div class="col s12 m4">
                                <!---- Search ----->
                                <div class="app-wrapper">
                                    <div class="datatable-search">
                                        <select class="select2-data-ajax browser-default" id="sto_id" name="sto_id" required="">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row hide" id="input-wrapper">
                            <div class="col s12 ">
                                <ul class="collapsible m-0">
                                    <li class="active">
                                        <div class="collapsible-header">
                                            <i class="material-icons">
                                                keyboard_arrow_right
                                            </i>
                                            Input Stok Take 1
                                        </div>
                                        <div class="collapsible-body">
                                            <form class="form-table" id="form-input">
                                                <table>
                                                    <tr>
                                                        <td width="30%">
                                                            No Tag
                                                        </td>
                                                        <td>
                                                            <div class="input-field col s12">
                                                                <select class="select2-data-ajax browser-default" name="id" required="">
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                    <table>
                                                        <tr>
                                                            <td width="30%">
                                                                Model
                                                            </td>
                                                            <td>
                                                                <div class="input-field col s12">
                                                                    <input class="validate" disabled="" id="model" name="model" type="text" value="">
                                                                    </input>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Location
                                                            </td>
                                                            <td>
                                                                <div class="input-field col s12">
                                                                    <input class="validate" disabled="" id="loca" name="location" type="text" value="">
                                                                    </input>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Quantity
                                                            </td>
                                                            <td>
                                                                <div class="input-field col s12">
                                                                    <input class="validate" id="qty" name="quantity" required="" type="number" value="">
                                                                    </input>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            {!! get_button_save('Save', 'mt-1') !!}
                                                            {!! get_button_delete('Clear', 'btn-clear mt-1') !!}
                                                        </div>
                                                    </div>
                                                </br>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="container">
                            <div class="section">
                                <div class="card">
                                    <div class="card-content p-0">
                                        <div class="row mb-0 mt-2">
                                            <div class="col m6"></div>
                                            <div class="col m6">
                                                <input type="text" placeholder="Search" class="app-filter" id="input_filter">
                                            </div>
                                        </div>
                                        <div class="section-data-tables">
                                            <table class="display" id="data-table-section-contents" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1" width="30px">
                                                            No.
                                                        </th>
                                                        <th>
                                                            No Tag
                                                        </th>
                                                        <th>
                                                            Model
                                                        </th>
                                                        <th>
                                                            Location
                                                        </th>
                                                        <th>
                                                            Quantity
                                                        </th>
                                                        <th width="50px;">
                                                        </th>
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
            </div>
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
    var dtdatatable;
    jQuery(document).ready(function($) {
      set_select2_sto_id();
      set_select2_no_tag();

      $('.btn-clear').click(function(event) {
        /* Act on the event */
        clear_input()
      });

      $("#form-input").validate({
        submitHandler: function(form) {
          $.ajax({
            url: '{{ url("stock-take-input-1") }}',
            type: 'POST',
            data: $(form).serialize(),
          })
          .done(function(result) { // selesai dan berhasil
            if (result.status) {
                showSwalAutoClose("Success", result.message)
                clear_input()
                dtdatatable.ajax.reload(null, false)
            }
          })
          .fail(function(xhr) {
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
        }
      });
      dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: true,
        scrollX: true,
        responsive: true,
        ajax: {
            url: '{{ url('stock-take-input-1') }}',
            type: 'GET',
            data: function(d) {
                d.search['value'] = $('#input_filter').val(),
                d.sto_id = $('#sto_id').val()
              }
        },
        order: [1, 'asc'],
        columns: [
            {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
            {data: 'no_tag', name: 'no_tag', className: 'detail'},
            {data: 'model', name: 'model', className: 'detail'},
            {data: 'location', name: 'location', className: 'detail'},
            {data: 'quantity', name: 'quantity', className: 'detail'},
            {data: 'action', className: 'center-align', searchable: false, orderable: false},
        ]
      });
      dtdatatable.on('click', '.btn-edit', function(event) {
        event.preventDefault();
        /* Act on the event */
        var tr = $(this).parent().parent();
        var data = dtdatatable.row(tr).data();
        $('#form-input [name="id"]').attr('readonly', 'readonly');
        set_select2_value('#form-input [name="id"]', data.id, data.no_tag)
        $('#form-input [name="model"]').val(data.model)
        $('#form-input [name="location"]').val(data.location)
        $('#form-input [name="quantity"]').val(data.quantity)
      });

      dtdatatable.on('click', '.btn-delete', function(event) {
        event.preventDefault();
        /* Act on the event */
        var tr = $(this).parent().parent();
        var data = dtdatatable.row(tr).data();

        // Ask user confirmation to delete the data.
        swal({
          text: "Delete the No Tag  " + data.no_tag + "?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Delete It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // if CONFIRMED send DELETE Request to endpoint
            $.ajax({
              url: '{{ url('stock-take-input-1') }}' + '/' + data.id ,
              type: 'DELETE',
              dataType: 'json',
            })
            .done(function() {
              showSwalAutoClose('Success', 'Success delete no Tag.')
              dtdatatable.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
            })
            .fail(function() {
              console.log("error");
            });
          }
        })
      });

      $("input#input_filter").on("keyup click", function () {
        filterGlobal();
      });
    });

    function filterGlobal() {
      dtdatatable.search($("#input_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }

    function clear_input(){
      set_select2_value('#form-input [name="id"]', '', '')
      $('#form-input [name="quantity"]').val('')
    }

    function set_select2_no_tag(filter = {sto_id: null}){
      $('#form-input [name="id"]').select2({
         placeholder: '-- Select Tag --',
         ajax: get_select2_ajax_options('/stock-take-create-tag/select2-no-tag-1', filter)
      });

      $('#form-input [name="id"]').change(function(event) {
        /* Act on the event */
        var data = $(this).select2('data')[0];
        $('#form-input [name="model"]').val(data.model)
        $('#form-input [name="location"]').val(data.location)
      });
    }

    function set_select2_sto_id(){
      $('#sto_id').select2({
         placeholder: '-- Select Schedule ID --',
         allowClear: true,
         ajax: get_select2_ajax_options('/stock-take-schedule/select2-schedule')
      });
      $('#sto_id').change(function(event) {
        /* Act on the event */
        if ($(this).val() != null) {
          $('#input-wrapper').removeClass('hide')
        } else {
          $('#input-wrapper').addClass('hide')
        }
        set_select2_no_tag({sto_id: $(this).val()})
        dtdatatable.ajax.reload(null, false)
      });
    }
</script>
@endpush
