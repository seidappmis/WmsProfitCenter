@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Stock Inventory</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Stock Inventory</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-report-stock-inventory">
                               <table>
                                   <tr>
                                       <td>BRANCH</td>
                                       <td>
                                         <div class="input-field col s8">
                                           <select id="kode_cabang"
                                                name="kode_cabang"
                                                class="select2-data-ajax browser-default"
                                                required="">
                                          </select>
                                         </div>
                                       </td>
                                     </tr>
                                 </tr>
                                 <tr>
                                    <td>MODEL</td>
                                    <td><div class="input-field col s12">
                                       <input id="model_name" type="text" class="validate" name="" >
                                     </div></td>
                                <tr>
                                
                                    <td>STRORAGE LOCATION</td>
                                    <td>
                                      <div class="input-field col s8">
                                        <select id="storage_location"
                                                name="storage_location"
                                                class="select2-data-ajax browser-default"
                                                >
                                          </select>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>STATUS</td>
                                    <td>
                                      <div class="input-field col s4">
                                        <select name="" id="status" required>
                                          <option value="" selected >-All-</option>
                                          <option value="1" >Intransit</option>
                                          
                                           
                                        </select>
    
                                      </div>
                                    </td>
                                  </tr>
                               </table>
                              
                               <div class="input-field col s12">
                                 <button type="submit" class="waves-effect waves-light indigo btn mb-1 mt-1">Submit</button>
                               </div>
                            </form>
                      </div>
                </div>
            </div>
            <div class="secion">
              <div class="card">
                <div class="card-conten">
                  <div class="section-data-tables"> 
                          <table id="data-stock-inventory" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" width="30px">NO.</th>
                                    <th>Branch Code</th>
                                    <th>Branch</th>
                                    <th>Model</th>
                                    <th>Sloc</th>
                                    <th>Qty</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                </div>
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
  jQuery(document).ready(function($) {
    $('#form-report-stock-inventory [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
    });
    $('#form-report-stock-inventory [name="kode_cabang"]').change(function(event) {
      /* Act on the event */
      set_select2_value('#form-report-stock-inventory [name="storage_location"]', '', '')
      setSLOC({cabang: $(this).val()})
    });

    setSLOC();
    $('#form-report-stock-inventory [name="movement_code"]').select2({
       placeholder: '-- Select Movement Type --',
       allowClear: true,
       ajax: get_select2_ajax_options('/movement-type/select2')
    });
  });

  function setSLOC(filter = {cabang: null}){
    $('#form-report-stock-inventory [name="storage_location"]').select2({
       placeholder: '-- Select Storage Location --',
       allowClear: true,
       ajax: get_select2_ajax_options('/storage-master/select2-storage-cabang', filter)
    });
  }

  var table = $('#table-stock-inventori').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
        url: '{{ url('report-stock-inventory') }}',
        type: 'GET',
        data: function(d) {
            d.search['value'] = $('#global_filter').val()
          }
    },
    order: [1, 'asc'],
    columns: [
        {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
        {data: 'kode_cabang', name: 'kode_cabang', className: 'detail'},
        {data: 'long_description', name: 'ldes', className: 'detail'},
        {data: 'model', name: 'model', className: 'detail'},
        {data: 'ean_code', name: 'ean_code', className: 'detail'},
        {data: 'quality_total', name: 'quality_total', className: 'detail'},
       ]
  });

 

</script>
@endpush