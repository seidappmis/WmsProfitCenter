@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Incoming Import/OEM</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('incoming-import-oem') }}">Incoming Import/OEM</a></li>
                    <li class="breadcrumb-item active">OEM-WHKRW-200206-005</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select>
                      <option value="" disabled>-- Select Area --</option>
                      <option value="1" selected>KARAWANG</option>
                      <option value="2">SURABAYA HUB</option>
                      <option value="3">SWADAYA</option>
                    </select>
                  </div>
                </div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('incoming-import-oem') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
      <div class="container">
        <div class="section">
          <div class="card">
            <div class="card-content">
              <h4 class="card-title">INPUT INCOMING IMPORT/OEM/OTHERS</h4>
              <hr>
              @include('web.incoming.incoming-import-oem._form_header')
            </div>
            <div class="card-content">
            <div class="section-data-tables">
              <!-- Incoming Detail -->
              <h4 class="card-title">Incoming Detail</h4>
              <hr>
              <form class="form-table">
                <table id="data-table-section-contents" class="display" width="100%">
                  <thead bgcolor="#344b68">
                    <tr>
                      <td data-priority="1" width="30px" class="white-text">NO.</td>
                      <td class="white-text">Model</td>
                      <td class="white-text">Quantity</td>
                      <td class="white-text">CBM</td>
                      <td class="white-text">Total CBM</td>
                      <td class="white-text">No. GR SAP</td>
                      <td class="white-text">Description</td>
                      <td class="white-text">Storage Location</td>
                      <td class="white-text">Created Date</td>
                      <td width="50px;"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>SCH-210PS</td>
                      <td>60</td>
                      <td>0.550</td>
                      <td>33.000</td>
                      <td>5001349066</td>
                      <td>SHOWCASE REFRIGERATOR</td>
                      <td>HQ-1st Class</td>
                      <td>2020-02-06 16:57:49</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </form>
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
  var dtdatatable = $('#data-table-section-contents').DataTable({
      "scrollX": true,
      "ordering": false,
      "paging": false,
    });
  jQuery(document).ready(function($) {
    set_form_data();
});

  function set_form_data() {
    set_select2_value('#form-incoming-import-oem-header [name="vendor_name"]', '{{$incomingManualHeader->vendor_name}}', '{{$incomingManualHeader->vendor_name}}');
    $('input:radio[name="inc_type"]').filter('[value="{{$incomingManualHeader->inc_type}}"]').attr('checked', true);
    $('input:radio[name="inc_type"]').prop('disabled', true);
  }
</script>
@endpush