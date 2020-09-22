@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary WH Transporter Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary WH Transporter Report</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-summary-wh-transporter-report">
                               <table>
                                 <tr>
                                    <td width="20%">Destination City Header</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="destination_city" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="20%">Transporter</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="20%">Periode</td>
                                    <td><div class="col s9 m10">
                                        <input placeholder="" name="periode" type="text" class="validate monthpicker" required autocomplete="off">
                                      </div></td>
                                 </tr>
                               </table>
                               <div class="input-field col s12">
                               <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
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

@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
@endpush

@push('vendor_js')
<script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('page-modal')
<div id="modal-form-print" class="modal" style="">
    <div class="modal-content">
      <form id="form-print" class="form-table">
        <input type="hidden" name="arrival_no">
        <table>
          <tr>
            <td width="150px">GENERAL MGR</td>
            <td>
              <div class="input-field">
                <input type="text" name="general_mgr">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">SR MANAGER</td>
            <td>
              <div class="input-field">
                <input type="text" name="sr_manager">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">MANAGER</td>
            <td>
              <div class="input-field">
                <input type="text" name="manager">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">ASST MAN</td>
            <td>
              <div class="input-field">
                <input type="text" name="asst_man">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">DIREKTUR</td>
            <td>
              <div class="input-field">
                <input type="text" name="direktur">
              </div>
            </td>
          </tr>
          <tr>
            <td width="150px">STAFF ADMIN</td>
            <td>
              <div class="input-field">
                <input type="text" name="staff_admin">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </div>
    <div class="modal-footer">
      <a href="#!" class="btn waves-effect waves-green btn-show-print-preview btn green darken-4">Print Report</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
@endpush

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print',
])

@push('script_js')
<script type="text/javascript">

    jQuery(document).ready(function($) {
        $('#form-summary-wh-transporter-report').validate({
            submitHandler: function (form){
                $('#modal-form-print').modal('open')
            }
        })

        $('.btn-show-print-preview').click(function(event) {
          /* Act on the event */
          initPrintPreviewPrint(
            '{{url("summary-wh-transporter-report")}}' + '/export',
            $('#form-summary-wh-transporter-report').serialize() + '&' + $('#form-print').serialize()
          )
        });
    });

    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoHide: true
    });

  $('#form-summary-wh-transporter-report [name="destination_city"]').select2({
     placeholder: '',
     allowClear: true,
     ajax: get_select2_ajax_options('/destination-city/select2-destination-city-with-city-code')
  });
  $('#form-summary-wh-transporter-report [name="expedition_code"]').select2({
     placeholder: '',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
  });
</script>
@endpush