@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary LMB Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary LMB Report</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-summary-lmb-report">
                               <table>
                                   <tr>
                                       <td>Branch</td>
                                       <td>
                                         <div class="input-field col s5">
                                           <select id="kode_cabang"
                                                name="kode_cabang"
                                                class="select2-data-ajax browser-default"
                                                required="">
                                          </select>
                                         </div>
                                       </td>
                                     </tr>
                                 <tr>
                                   <td>Picking List Date</td>
                                   <td>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         From
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" id="first_name" type="text" class="validate datepicker" required>
                                       </div>
                                     </div>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         To
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" id="first_name" type="text" class="validate datepicker" required >
                                       </div>
                                     </div>
                                   </td>
                                 </tr>
                                 <tr>
                                    <td>LMB Date</td>
                                   <td>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         From
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" id="first_name" type="text" class="validate datepicker" >
                                       </div>
                                     </div>
                                     <div class="input-field col s6">
                                       <div class="col s3 m2 label">
                                         To
                                       </div>
                                       <div class="col s9 m10">
                                         <input placeholder="" id="first_name" type="text" class="validate datepicker" >
                                       </div>
                                     </div>
                                   </td>
                                 </tr>
                                 <tr>
                                     <td>Picking List NO.</td>
                                     <td><div class="input-field col s12">
                                        <input id="" type="text" class="validate" name="" >
                                      </div></td>
                                 </tr>
                                 <tr>
                                    <td>Model</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="" >
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

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-summary-lmb-report [name="kode_cabang"]').select2({
       placeholder: '-- Select Branch --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-grant-cabang')
    });
  });
</script>
@endpush