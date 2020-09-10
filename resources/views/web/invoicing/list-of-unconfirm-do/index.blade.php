@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>List of Unconfirm DO</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">List of Unconfirm DO</li>
                </ol>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
                <a class="btn btn-large waves-effect waves-light btn-add" href="{{ url('list-of-unconfirm-do/export-to-excel') }}">
                  {{-- <i class="material-icons right">add</i> --}}
                  Export to Excel
                </a>
              </div>
            </div>
            <div class="col s12 m3">
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
                                    <th>SHIPMENT NO</th>
                                    <th>DELIVERY NO</th>
                                    <th>DO INTERNAL</th>
                                    <th>MODEL</th>
                                    <th>QUANTITY</th>
                                    <th>CBM TOTAL</th>
                                    <th>CUSTOMER</th>
                                    <th>CITY SHIP TO</th>
                                    <th>DO TYPE</th>
                                    <th>ETD</th>
                                    <th>ETA</th>
                                    <th>LEAD TIME</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @if(empty($rs_unconfirmManifesDetail))
                                <tr><td colspan="12" class="center-align">No data available in table</td></tr>
                                @endif
                                @foreach($rs_unconfirmManifesDetail AS $key => $unconfirmManifest)
                                  <tr class="grey lighten-2">
                                    <td colspan="12">{{ $unconfirmManifest['manifest']->do_manifest_no }} - {{ $unconfirmManifest['manifest']->expedition_name }} - {{ $unconfirmManifest['manifest']->city_name }}</td>
                                  </tr>
                                  @foreach($unconfirmManifest['detail'] AS $key => $detail)
                                  <tr>
                                    <td>{{ $detail->invoice_no }}</td>
                                    <td>{{ $detail->delivery_no }}</td>
                                    <td>{{ $detail->do_internal }}</td>
                                    <td>{{ $detail->model }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ $detail->cbm }}</td>
                                    <td>{{ $detail->ship_to }}</td>
                                    <td>{{ $detail->city_name }}</td>
                                    <td>{{ $detail->do_type }}</td>
                                    <td>{{ $detail->do_manifest_date }}</td>
                                    <td>{{ $detail->do_manifest_date }}</td>
                                    <td>{{ $detail->lead_time }}</td>
                                  </tr>
                                  @endforeach
                                @endforeach
                            
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
    // var dtdatatable = $('#data-table-section-contents').DataTable({
    //     serverSide: false,
    //     scrollX: true,
    //     responsive: true,
    //     order: [1, 'asc'],
    // });
</script>
@endpush