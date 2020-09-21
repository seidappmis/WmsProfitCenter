@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary DO Confirmed</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary DO Confirmed</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-summary-do-confirmed">
                               <table>
                                   <tr>
                                       <td>Branch</td>
                                       <td>
                                         <div class="input-field col s12">
                                            <select name="cabang" class="select2-data-ajax browser-default" required="">
                                            </select>
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
                                         <input placeholder="" name="do_date_from" type="text" class="validate datepicker" required>
                                       </div>
                                     </div>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         To
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" name="do_date_to" type="text" class="validate datepicker" required >
                                       </div>
                                     </div>
                                   </td>
                                 </tr>
                                 <tr>
                                    <td>DO No</td>
                                    <td>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          From
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="delivery_no_from" type="text" >
                                        </div>
                                      </div>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          To
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="delivery_no_to" type="text" >
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Internal DO</td>
                                    <td>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          From
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="do_internal_from" type="text" >
                                        </div>
                                      </div>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          To
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="do_internal_to" type="text" >
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Confirm Date</td>
                                    <td>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          From
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="confirm_date_from" type="text" class="validate datepicker" >
                                        </div>
                                      </div>
                                      <div class="input-field col s6">
                                        <div class="col s3 m2 label">
                                          To
                                        </div>
                                        <div class="col s9 m10">
                                          <input placeholder="" name="confirm_date_to" type="text" class="validate datepicker"  >
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                 
                                 <tr>
                                    <td>Confirm Status</td>
                                    <td>
                                      <div class="input-field col s4">
                                        <select name="status_confirm" id="" required>
                                          <option value="">-All-</option>
                                          <option value="1">Confirm</option>
                                          <option value="0">Unconfirm</option>
                                        </select>
    
                                      </div>
                                    </td>
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

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print',
])

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-summary-do-confirmed').validate({
      submitHandler: function(form){
        initPrintPreviewPrint(
            '{{url("summary-do-confirmed")}}' + '/export',
            $(form).serialize()
          )
      }
    })
  });

  $('#form-summary-do-confirmed [name="cabang"]').select2({
     placeholder: '-- Select Branch --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
  });
</script>
@endpush