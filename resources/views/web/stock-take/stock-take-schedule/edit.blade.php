@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Take Schedule</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Edit Stock Take Schedule</div>
                          <div class="collapsible-body">
                          <form class="form-table">
                        <table>
                          <tr>
                            <td>STO NO</td>
                            <td>
                              <div class="input-field col s12">
                                <input value="SBY-STO-2232-001" id="ston" type="text" class="validate" name="ston" required>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>AREA</td>
                            <td>
                              <div class="input-field col s12">
                                <input value="SURABAYA" id="area" type="text" class="validate" name="area" disabled>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>BRANCH</td>
                            <td>
                              <div class="input-field col s12">
                                <input value="" id="branch" type="text" class="validate" name="branch" validated>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DESCRIPTION</td>
                            <td>
                              <div class="input-field col s12">
                                    <textarea  id="desc" class="materialize-textarea"></textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">SCHEDULE DATE</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  START
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  END
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class = "label">DATA FILE</td>
                            <td>
                              <div class="file-field input-field">
                                <div class="btn indigo btn">
                                  <span>Browse</span>
                                  <input type="file">
                                </div>
                                <div class="file-path-wrapper">
                                  <input class="file-path validate" type="text" placeholder="Select File       Format File : csv">
                                </div>
                              </div>
                            </td>
                          </tr>
                          
                        </table>
                        
                      </form>
                            <div class="row">
                              <div class="input-field col s12">
                                {!! get_button_cancel(url('stock-take-schedule')) !!}
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>

</div>
@endsection

@push('script_js')
<script type="text/javascript">
 	$('.collapsible').collapsible({
        accordion:true
    });
</script>
@endpush