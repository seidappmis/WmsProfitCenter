@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Analysis</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Analysis</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form class="form-table" id="form-summary-freight-cost-analysis">
                        <table>
                          <tr>
                            <td>Expedition</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Manifest Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Date</td>
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
                            <td>DO Manifest</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Recipt ID</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Destination</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="destination_number" class="select2-data-ajax browser-default">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Region</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="region" class="select2-data-ajax browser-default">
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Status</td>
                            <td>
                              <div class="input-field col s12">
                                <select name="status" class="select2-data-ajax browser-default">
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">UNRECEIPT</option>
                                  <option value="2">DRAFT UNRECEIPT</option>
                                  <option value="3">ALREADY UNRECEIPT</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <button class="btn btn-large waves-effect waves-light green darken-4 mt-2" type="submit" name="action">
                          <i class="material-icons left">local_printshop</i>
                          Print
                        </button>
                      </form>
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
    $('#form-summary-freight-cost-analysis [name="expedition_code"]').select2({
        placeholder: '-- Select Expedition --',
        ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
    })
    $('#form-summary-freight-cost-analysis [name="destination_number"]').select2({
        placeholder: '-- All --',
        ajax: get_select2_ajax_options('/master-destination/select2-destination')
    })
    $('#form-summary-freight-cost-analysis [name="region"]').select2({
        placeholder: '-- All --',
        ajax: get_select2_ajax_options('/region/select2-region')
    })
    $('#form-summary-freight-cost-analysis [name="status"]').select2({
        placeholder: '-- All --',
      })

    $("#form-summary-freight-cost-analysis").validate({
      submitHandler: function(form) {
      }
    });
  });
</script>
@endpush