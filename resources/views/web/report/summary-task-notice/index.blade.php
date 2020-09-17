@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Task Notice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Task Notice</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table" id="form-summary-task-notice">
                               <table>
                                   <tr>
                                     <td width="20%">Area</td>
                                     <td>
                                       <div class="input-field col s4">
                                         <select id="area"
                                                name="area"
                                                class="select2-data-ajax browser-default">
                                        </select>
                                       </div>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td width="20%">No Document</td>
                                     <td>
                                       <div class="input-field col s4">
                                         <input type="text" name="">
                                       </div>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td width="20%">Upload Date</td>
                                     <td>
                                       <div class="input-field col 12">
                                         <table>
                                           <tr>
                                             <td>START :</td>
                                             <td><input type="text" name="" class="validate datepicker"></td>
                                             <td>END :</td>
                                             <td><input type="text" name="" class="validate datepicker"></td>
                                           </tr>
                                         </table>
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

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-summary-task-notice [name="area"]').select2({
       placeholder: '-- Select Area --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-area/select2-area-only')
    });
    @if (auth()->user()->area != 'All')
      set_select2_value('#form-summary-task-notice [name="area"]', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
      $('#form-summary-task-notice [name="area"]').attr('disabled','disabled')
    @endif
  });
</script>
@endpush