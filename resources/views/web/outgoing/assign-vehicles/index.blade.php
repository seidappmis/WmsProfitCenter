@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Assign Vehicles</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Assign Vehicles</li>
              </ol>
          </div>
          <div class="col s12 m3">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
          </div>
          <div class="col s12 m4">
            <div class="display-flex">
              <!---- Search ----->
              <div class="app-wrapper mr-2">
                <div class="datatable-search">
                  <i class="material-icons mr-2 search-icon">search</i>
                  <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                </div>
              </div>
            </div>
          </div>
        </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="data-table-section-contents" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">No.</th>
                                    <th>VEHICLE NO.</th>
                                    <th>DRIVER ID</th>
                                    <th>VEHICLE TYPE</th>
                                    <th>CBM</th>
                                    <th>DESTINATION</th>
                                    <th>TRANSPORTER</th>
                                    <th>CHECKIN TIME</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>B 9166 BYT</td>
                                  <td>MTM-19-001 UYE M</td>
                                  <td>Colt Diesel 4 Wheel capacity 10 - 25 Cbm</td>
                                  <td>25.000</td>
                                  <td>Jakarta</td>
                                  <td>MARC TRI MANUNGGAL, PT.</td>
                                  <td>2020-02-06 11:27:25</td>
                                  <td>
                                    {!! get_button_view(url('#'),'Select DO') !!}
                                    {!! get_button_edit() !!}
                                    {!! get_button_delete('Is Leave') !!}
                                  </td>
                                </tr>
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
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
        responsive: true
    });

    dtdatatable.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        title: "Are you sure has living?",
        // text: "You will not be able to recover this imaginary file!",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
          $(".btn-delete").closest("tr").remove();
          swal("Good job!", "You clicked the button!", "success") // alert success
          //datatable memunculkan no data available in table
        }
      })
    });
</script>
@endpush