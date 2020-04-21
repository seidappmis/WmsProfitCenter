@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 mb-1">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Adjust Inventory Movement</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Adjust Inventory Movement</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  <form>
                      <div class="row">
                         <div class="col s12">
                            <table id="borderd-table" class="bordered" width="100%">
                              <thead></thead>
                              <tbody>
                                <tr>
                                  <td>Branch</td>
                                  <td><div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-- Select Branch --</option>
                                      <option>[HYP]PT. SEID HQ JKT</option>
                                      <option>[JKT]PT. SEID CAB. JAKARTA</option>
                                      <option>[JF]PT. SEID CAB. JAKARTA</option>
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>STORAGE LOCATION</td>
                                  <td><div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-- Please Select Location --</option>
                                      <option value="1">1001-YP-1st Class</option>
                                      <option value="2">1060-HYP-Return All</option>
                                      <option value="3">1090-HYP-Intransit BR</option>
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>MODEL</td>
                                  <td><div class="input-field col s12">
                                    <input id="model" type="text" class="validate" name="model" required>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>AVAILABLE QTY</td>
                                  <td><div class="input-field col s12">
                                    <input id="aqty" type="text" class="validate " name="aqty" disabled>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>QTY</td>
                                  <td><div class="input-field col s12">
                                    <input id="qty" type="text" class="validate" name="qty" required>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>MOVEMENT TYPE</td>
                                  <td><div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-- Select Movement--</option>
                                      <option value="1">965 - Adjust plus</option>
                                      <option value="2">966 - Adjust minus</option>
                                      <option value="3">701 - Adjust Stock Taking plus</option>
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>REMARKS</td>
                                  <td><div class="input-field col s12">
                                    <textarea id="textarea2" class="materialize-textarea"></textarea>
                                  </div></td>
                                </tr>
                              </tbody>
                        </table>
                        <div class="row">
                        <div class="input-field col s12">
                          <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                        </div>
                        </div>
                      </div>
                  </div>
                  </form>
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
  var table = $('#data-table-simple').DataTable({
    "responsive": true,
  });

  $("input#global_filter").on("keyup click", function () {
    filterGlobal();
  });

  // Custom search
  function filterGlobal() {
      table.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush