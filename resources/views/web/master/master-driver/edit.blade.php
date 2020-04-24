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
                        			<td width="20%" class="label">Expedition</td>
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
                            <table>
                                <tr>
                                    <td width="20%" class="label">Driver ID</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="driver_id" type="text" class="validate" value="ARS-17-001 ">
                                        </div>
                                    </td>
                                    <td width="30%" rowspan="11" class="center-align">
                                        <div class="col s12">
                                          <p>Maximum upload size 2MB.</p>
                                          <br>
                                          <input type="file" id="input-file-now" class="dropify" name="file" data-default-file="{{asset('images/profil.png')}}" data-height="350"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Driver Name</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="name" type="text" class="validate" value="KIF WAHYUDI">
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
                                            <input id="number" type="text" class="validate" value="800425350945" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">ID (KTP) No.</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="ktp_id" type="text" class="validate" value="1807212104800000">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Phone 1</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="phone" type="text" class="validate" value="082312279597">
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
                        	{!! get_button_save('Update') !!}
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