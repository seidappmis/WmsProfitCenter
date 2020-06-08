@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Berita Acara</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Berita Acara</li>
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
                <a href="{{ url('berita-acara/create') }}" class="btn btn-large waves-effect waves-light btn-add">
                  New Berita Acara
                </a>
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
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>BERITA ACARA</th>
                                    <th>DATE</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>DRIVER</th>
                                    <th>VEHICLE NO.</th>
                                    <th>STATUS</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1.</td>
                                  <td>01/BA-HQ/02/2015</td>
                                  <td>May 21, 2020</td>
                                  <td>Expedition 1</td>
                                  <td>Driver 1</td>
                                  <td>B 1231 DE</td>
                                  <td>PENDING</td>
                                  <td>
                                    {!! get_button_print() !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>2.</td>
                                  <td>02/BA-HQ/02/2015</td>
                                  <td>May 21, 2020</td>
                                  <td>Expedition 2</td>
                                  <td>Driver 2</td>
                                  <td>B 5486 DE</td>
                                  <td>COMPLETE</td>
                                  <td>
                                    {!! get_button_print() !!}
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
        order: [1, 'asc'],
    });
</script>
@endpush