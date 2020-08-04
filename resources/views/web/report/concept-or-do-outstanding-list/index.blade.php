@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4 l4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept or DO Outstanding List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept or DO Outstanding List</li>
                </ol>
            </div>
           
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form id="form-report-outstanding-list" class="form-table">
                            <table>
                              <tr style="background-color: darkgray">
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="area" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>OR</td>
                                <td></td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="cabang" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Shipment No</td>
                                <td><div class="input-field col s12">
                                  <input id="model" type="text" class="validate" name="shipment_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Do NO</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="do_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Expedition</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="expedition" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Upload Concept Date</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Vahicle Type</td>
                                <td><div class="input-field col s12">
                                  <select name="vehicle_type" class="select2-data-ajax browser-default">
                                    </select>
                                </div></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1 ml-1">Submit</button>
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
  $('#form-report-outstanding-list [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  $('#form-report-outstanding-list [name="cabang"]').select2({
     placeholder: '-- Select Branch --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
  });
  $('#form-report-outstanding-list [name="expedition"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
  $('#form-report-outstanding-list [name="vehicle_type"]').select2({
     placeholder: '-- All --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });
</script>
@endpush