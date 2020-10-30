@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Loading Lead Time</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Loading Lead Time</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-filter">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default" required="">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="" name="periode" type="text" class="validate monthpicker" required autocomplete="off">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <form class="form-table hide" id="form-normal-time">
                            <br>
                            <div class="section-data-tables"> 
                                <table  class="display centered" width="100%">
                                <thead>
                                    <tr>
                                      <th>NO</th>
                                      <th>Vahicle Description</th>
                                      <th>Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>CD 4 BAN (CDE)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>CD 4 BAN (CDE BOX)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>CD 6 BAN (CDD)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>CON 20</td>
                                        <td><input type="text"></td>
                                       
                                    </tr> --}}
                                </tbody>
                            </table>
                            </div>
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

@push('script_js')
<script type="text/javascript">
    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoHide: true
    });

    $('#form-filter [name="area"]').select2({
     placeholder: '-- Select Area --',
     allowClear: true,
     ajax: get_select2_ajax_options('/master-area/select2-area-only')
  });

    jQuery(document).ready(function($) {
        $('#form-filter').change(function(event) {
            /* Act on the event */
            $.ajax({
                url: '{{url("report-loading-lead-time")}}',
                type: 'GET',
                dataType: 'json',
                data: $(this).serialize(),
            })
            .done(function(result) {
                if (result.status) {
                    loadFormNormalTime(result.data)
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        });
    });

    function loadFormNormalTime(data){
        if (data.length > 0) {
            $('#form-normal-time tbody').empty();
            $.each(data, function(index, val) {
                 /* iterate through array or object */
                var row = '';
                row += '<tr>';
                row += '<td>' + (index+1) + '</td>';
                row += '<td>' + val.reg_vehicle_type + '</td>';
                row += '<td><input type="text"></td>';
                row += '</tr>';

                $('#form-normal-time tbody').append(row)
            });
            $('#form-normal-time').removeClass('hide')
        } else {
            $('#form-normal-time').addClass('hide')
        }
    }
</script>
@endpush


