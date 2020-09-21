@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Occupancy</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Occupancy</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <table>
                            <tr>
                                <td width="45%" style="vertical-align: top;">
                                <b>Select Branch</b>
                                <table id="table-select-branch" class="table-pick-list-result display">
                                    <thead><tr><th></th></tr></thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </td>
                                <td width="10%" class="center-align">
                                  <div class="col s12">
                                      <p><span class="waves-effect waves-light indigo btn" onclick="pickRowData()">>></span></p>
                                      <br>
                                      <p><span class="waves-effect waves-light indigo btn" onclick="removeRowData()"><<</span></p>
                                  </div>
                                </td>
                                <td width="45%" style="vertical-align: top;">
                                <b>Unselect Branch</b>
                                <table id="table-unselect-branch" class="table-pick-list-result display">
                                    <thead><tr><th></th></tr></thead>
                                    <tbody></tbody>
                                </table>
                                </td>
                            </tr>
                        </table>
                        {!! get_button_save('Submit', 'btn-submit ml-1 mt-1 mb-1') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print',
])

@push('script_js')
<script type="text/javascript">
    var dttable_select_branch, dttable_unselect_branch;
    jQuery(document).ready(function($) {
        dttable_unselect_branch = $('#table-unselect-branch').DataTable({
          scrollY: '60vh',
          scrollCollapse: true,
          paging:   false,
          ordering: false,
          searching: false,
          info:     false,
          data: [],
          columns: [
            {
              render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.kode_cabang + ' - ' 
                        + row.long_description
                        ;
                    }
                    return data;
                },
              }
          ]
        });

        dttable_unselect_branch.on('click', 'tr', function(event) {
          event.preventDefault();
          /* Act on the event */
          $(this).toggleClass('selected');
        });

        dttable_select_branch = $('#table-select-branch').DataTable({
          scrollY: '60vh',
          scrollCollapse: true,
          paging:   false,
          ordering: false,
          searching: false,
          info:     false,
          data: {!!$rs_branch->toJson()!!},
          columns: [
            {
              render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return row.kode_cabang + ' - ' 
                        + row.long_description
                        ;
                    }
                    return data;
                },
              }
          ]
        });

        dttable_select_branch.on('click', 'tr', function(event) {
          event.preventDefault();
          /* Act on the event */
          $(this).toggleClass('selected');
        });

        $('.btn-submit').click(function(event) {
            /* Act on the event */
            var selected_list = [];
            dttable_unselect_branch.$('tr').each(function() {
              var row_data = dttable_unselect_branch.row(this).data()
              selected_list.push(row_data);
            });
            initPrintPreviewPrint(
            '{{url("report-occupancy")}}' + '/export',
            'selected_list=' + JSON.stringify(selected_list)
          )
        });
    });

    function pickRowData(){
    dttable_select_branch.$('tr.selected').each(function(index, el) {
        var row_data = dttable_select_branch.row(this).data();
        dttable_unselect_branch.row.add(row_data) 
    });
    dttable_select_branch.rows( '.selected' )
        .remove()
        .draw();

    dttable_unselect_branch.draw()
   }
   function removeRowData(){
    dttable_unselect_branch.$('tr.selected').each(function(index, el) {
        var row_data = dttable_unselect_branch.row(this).data();
        dttable_select_branch.row.add(row_data) 
    });
    dttable_unselect_branch.rows( '.selected' )
        .remove()
        .draw();

    dttable_select_branch.draw()
   }
</script>
@endpush