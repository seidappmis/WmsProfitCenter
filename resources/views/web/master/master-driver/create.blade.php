@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Driver</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Driver</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Expedition</td>
                        			<td>
                        				<div class="input-field select2 col s12">
									    <select class="select2" id="expedition" required="">
									        <option value="0"selected>-- Expedition --</option>
									        <option value="1">ALAM RAYA SENTOSA, CV.</option>
									        <option value="1">ALAMUI LOGISTICS, PT.</option>
									        <option value="1">ALISTON TJOKRO EMKL</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
                            <!-- Detail Table -->
                            <div id="detail-driver">
                            <table class="mt-1">
                                <tr>
                                    <td width="20%" class="label">Driver ID</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="driver_id" type="text" class="validate">
                                        </div>
                                    </td>
                                    <td width="30%" rowspan="11" class="center-align">
                                        <div class="col s12">
                                          <p>Maximum upload size 2MB.</p>
                                          <br>
                                          <input type="file" id="input-file-now" class="dropify" name="file" data-default-file="" data-height="350"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Driver Name</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="name" type="text" class="validate">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Driving License Type</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select>
                                                <option value="" disabled selected>-- Select Type --</option>
                                                <option value="1">SIM A</option>
                                                <option value="2">SIM B</option>
                                                <option value="3">SIM B1</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Driving Lisence No.</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="number" type="text" class="validate" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">ID (KTP) No.</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="ktp_id" type="text" class="validate">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Phone 1</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="phone" type="text" class="validate">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Phone 2</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="phone" type="text" class="validate" name="phone2">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Remarks 1</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="remarks" type="text" class="validate" name="remarks1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Remarks 2</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="remarks" type="text" class="validate" name="remarks2">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Remarks 3</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="remarks" type="text" class="validate" name="remarks3">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Active</td>
                                    <td>
                                        <div class="input-field col s12 mt-2">
                                          <p>
                                          <label>
                                            <input type="checkbox" class="filled-in" checked="checked" />
                                            <span></span>
                                          </label>
                                          </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        	{!! get_button_save() !!}
                            {!! get_button_cancel(url('master-driver')) !!}
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
$(document).ready(function() {
    //Upload Foto
    $('.dropify').dropify();

    $('.select2').change(function(event) {
      /* Act on the event */
      if (this.value == '1') {
          $('#detail-driver').show();
          // console.log('tes');
      } else if (this.value == '0') {
        $('#detail-driver').hide();
      }
    });
});
</script>
@endpush