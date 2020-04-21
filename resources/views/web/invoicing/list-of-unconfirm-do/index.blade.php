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
                <button class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                  {{-- <i class="material-icons right">add</i> --}}
                  Export to Excel
                </button>
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
                                <tr class="grey lighten-2">
                                  <td colspan="12">JKT-180903-035-MARC TRI MANUNGGAL, PT. - Jakarta</td>
                                </tr>
                                <tr>
                                  <td>1000323670</td>
                                  <td>2101070126</td>
                                  <td></td>
                                  <td>AH-A95SAY</td>
                                  <td>58</td>
                                  <td>5.046</td>
                                  <td>PT. MULIA ADHI PERKASA</td>
                                  <td>JAKARTA</td>
                                  <td>NORMAL</td>
                                  <td>2018-09-03</td>
                                  <td>2018-09-04</td>
                                  <td>1</td>
                                </tr>
                                <tr>
                                  <td>1000323670</td>
                                  <td>2101070126</td>
                                  <td></td>
                                  <td>AH-A95SAY</td>
                                  <td>58</td>
                                  <td>5.046</td>
                                  <td>PT. MULIA ADHI PERKASA</td>
                                  <td>JAKARTA</td>
                                  <td>NORMAL</td>
                                  <td>2018-09-03</td>
                                  <td>2018-09-04</td>
                                  <td>1</td>
                                </tr>
                                <tr class="grey lighten-2">
                                  <td colspan="12">JKT-180903-035-MARC TRI MANUNGGAL, PT. - Jakarta</td>
                                </tr>
                                <tr>
                                  <td>1000323670</td>
                                  <td>2101070126</td>
                                  <td></td>
                                  <td>AH-A95SAY</td>
                                  <td>58</td>
                                  <td>5.046</td>
                                  <td>PT. MULIA ADHI PERKASA</td>
                                  <td>JAKARTA</td>
                                  <td>NORMAL</td>
                                  <td>2018-09-03</td>
                                  <td>2018-09-04</td>
                                  <td>1</td>
                                </tr>
                                <tr>
                                  <td>1000323670</td>
                                  <td>2101070126</td>
                                  <td></td>
                                  <td>AH-A95SAY</td>
                                  <td>58</td>
                                  <td>5.046</td>
                                  <td>PT. MULIA ADHI PERKASA</td>
                                  <td>JAKARTA</td>
                                  <td>NORMAL</td>
                                  <td>2018-09-03</td>
                                  <td>2018-09-04</td>
                                  <td>1</td>
                                </tr>
                                <tr>
                                  <td>1000323670</td>
                                  <td>2101070126</td>
                                  <td></td>
                                  <td>AH-A95SAY</td>
                                  <td>58</td>
                                  <td>5.046</td>
                                  <td>PT. MULIA ADHI PERKASA</td>
                                  <td>JAKARTA</td>
                                  <td>NORMAL</td>
                                  <td>2018-09-03</td>
                                  <td>2018-09-04</td>
                                  <td>1</td>
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
        scrollX: true,
        responsive: true,
        order: [1, 'asc'],
    });
</script>
@endpush