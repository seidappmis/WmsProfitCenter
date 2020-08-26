@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Picking List</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
                <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
            </div>
        </div>
    @endcomponent

      @if(auth()->user()->cabang->hq)
        @include('web.picking.picking-list._transporter_list')
      @endif

      <div class="col s12">
          <div class="container">
              <div class="section">
                  <div class="card">
                      <div class="card-content p-0">
                          <div class="row mb-1 mt-1">
                              <div class="col s12 m6 mt-0">
                                <div class="display-flex ml-1">
                                  <!---- Search ----->
                                  <a href="{{ url('picking-list/create') }}" class="btn btn-large waves-effect waves-light btn-add">New Picking List</a>
                                </div>
                              </div>
                              <div class="col m6">
                                <div class="app-wrapper ml-2 mr-2">
                                  <div class="datatable-search mb-0">
                                    <i class="material-icons mr-2 search-icon">search</i>
                                    <input type="text" placeholder="Search" class="app-filter" id="picking_list_filter">
                                  </div>
                                </div>
                              </div>
                          </div>

                          <div class="section-data-tables">
                            <table id="picking-list-table" class="display" width="100%">
                                <thead>
                                    <tr>
                                      <th data-priority="1">PICKING DATE</th>
                                      <th>PICKING NO.</th>
                                      <th>DRIVER NAME</th>
                                      <th>SHIP TO CITY</th>
                                      <th>EXPEDITION NAME</th>
                                      <th>STORAGE</th>
                                      <th>DO STATUS</th>
                                      <th>LMB</th>
                                      <th></th>
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
          <div class="content-overlay"></div>
      </div>
    </div>

</div>
@endsection


@push('script_js')
<script type="text/javascript">

    var dtdatatable;
    jQuery(document).ready(function($) {
      dtdatatable = $('#picking-list-table').DataTable({
          serverSide: true,
          scrollX: true,
          responsive: true,
          ajax: {
              url: '{{url('picking-list')}}',
              type: 'GET',
              data: function(d) {
                d.search['value'] = $('#picking_list_filter').val()
              }
          },
          order: [1, 'desc'],
          columns: [
              {data: 'picking_date', name: 'picking_date', className: 'detail'},
              {data: 'picking_no', name: 'picking_no', className: 'detail'},
              {data: 'driver_name', name: 'driver_name', className: 'detail'},
              {data: 'city_name', name: 'city_name', className: 'detail'},
              {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
              {data: 'storage_type', name: 'storage_type', className: 'detail'},
              {data: 'do_status', name: 'do_status', className: 'detail'},
              {data: 'lmb', name: 'lmb', className: 'detail'},
              {data: 'action', className: 'center-align', orderable:false, searchable: false},
          ],
          'createdRow': function(row, data, dataIndex){
           // Use empty value in the "Office" column
           // as an indication that grouping with COLSPAN is needed
           if(data.city_code === 'AS'){
              // Add COLSPAN attribute
              $('td:eq(2)', row).attr('colspan', 3);
              $('td:eq(2)', row).addClass('center-align');

              // Hide required number of columns
              // next to the cell with COLSPAN attribute
              $('td:eq(3)', row).css('display', 'none');
              $('td:eq(4)', row).css('display', 'none');
           }
        }   
      });

      dtdatatable.on('click', '.btn-delete', function(event) {
        var tr = $(this).parent().parent();
        var data = dtdatatable.row(tr).data();
        id = data.id
        event.preventDefault();
        /* Act on the event */
        // Ditanyain dulu usernya mau beneran delete data nya nggak.
        swal({
          text: "Cancel pickinglist for Picking No. " + data.picking_no + "?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, Cancel It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('picking-list')}}' + '/' + id,
              type: 'DELETE',
            })
            .done(function() { // Kalau ajax nya success
              showSwalAutoClose('Success', 'Cancel picking no ' + data.picking_no + '.')
              dtdatatable.ajax.reload(null, false); // reload datatable
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
      });
    });
</script>
@endpush
