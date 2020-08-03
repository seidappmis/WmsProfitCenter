@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Master</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Master</li>
                </ol>
            </div>
        
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <form class="form-table" id="form-report-master">
                            <table>
                              <tr>
                                <td>Report Master</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select class="select2 browser-default" name="report-master" required>
                                      <option>- Select Master -</option>
                                      <option>Master Cabang</option>
                                      <option>Master Destination</option>
                                      <option>Master Destination City</option>
                                      <option>Master Driver</option>
                                      <option>Master Expedition</option>
                                      <option>Master Gate</option>
                                      <option>Master Vehicle</option>
                                      <option>Master Vehicle Expedition</option>
                                      <option>Master Vendor</option>
                                      <option>Master Model</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mb-1">Submit</button>
                            </div>
                          </form>
                    </div>
                   
                </div>
                <div class="card">
                  <div class="card-content">
                    @if(!empty($report_view_name))
                    @include($report_view_name)
                    @endif
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
    $('#form-report-master [name="report-master"]').val('{{$report_master_value}}');
  });
</script>
@endpush