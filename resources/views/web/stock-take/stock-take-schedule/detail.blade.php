@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('stock-take-schedule') }}">Stock Take Schedule</a></li>
                    <li class="breadcrumb-item active">View Detail</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Detail</div>
                          <div class="collapsible-body">
                          
                          <div class="col s12">
                            <div class="container">
                                <div class="section">
                                    <div class="card">
                                        <div class="card-content p-0">
                                            <div class="section-data-tables"> 
                                              <table id="data-table-stocktake-schedule-detail" class="display" width="100%">
                                                  <thead>
                                                      <tr>
                                                        <th data-priority="1" width="30px">No.</th>
                                                        <th>STO NO.</th>
                                                        <th>MATERIAL NO</th>
                                                        <th>QTY</th>
                                                        <th width="50px;"></th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                    <tr>
                                                      <td>1.</td>
                                                      <td>BTM-STO-200202-001</td>
                                                      <td>27-C32B34</td>
                                                      <td>5464</td>
                                                      <th width="50px;">
                                                        {!! get_button_edit(url('stock-take-schedule/edit')) !!}
                                                       </th>
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

                            <div class="row">
                              <div class="input-field col s12 ml-2">
                                {!! get_button_view(url('stock-take-schedule'),'BACK') !!}
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
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
 	$('.collapsible').collapsible({
        accordion:true
    });

  var dtdatatable = $('#data-table-stocktake-schedule-detail').DataTable({
    serverSide: false,
    scrollX: true,
    responsive: true,
  });
</script>
@endpush

