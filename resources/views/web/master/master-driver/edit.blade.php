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
                    	<h4 class="card-title">Edit Driver</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Expedition</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled>-- Expedition --</option>
									        <option value="1" selected>ALAM RAYA SENTOSA, CV.</option>
									        <option value="2">ALAMUI LOGISTICS, PT.</option>
									        <option value="3">ALISTON TJOKRO EMKL</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
                            <!-- Detail Table -->
                            <table class="mt-2">
                                <tr>
                                    <td>Driver ID</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="driver_id" type="text" class="validate" name="driver_id">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Driver Name</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="name" type="text" class="validate" name="name">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Driving License Type</td>
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
                                    <td>Driving Lisence No.</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="number" type="text" class="validate" name="number" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ID (KTP) No.</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="ktp_id" type="text" class="validate" name="ktp_id">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone 1</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="phone" type="text" class="validate" name="phone1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phone 2</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="phone" type="text" class="validate" name="phone2">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remarks 1</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="remarks" type="text" class="validate" name="remarks1">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remarks 2</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="remarks" type="text" class="validate" name="remarks2">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remarks 3</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="remarks" type="text" class="validate" name="remarks3">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Active</td>
                                    <td>
                                        <div class="input-field col s12">
                                          <p>
                                          <label>
                                            <input type="checkbox" class="filled-in mt-2" checked="checked" />
                                            <span></span>
                                          </label>
                                          </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        	{!! get_button_save() !!}
                            {!! get_button_cancel(url('master-driver'), 'Back') !!}
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
	//Upload Foto
    $('.dropify').dropify();
</script>
@endpush