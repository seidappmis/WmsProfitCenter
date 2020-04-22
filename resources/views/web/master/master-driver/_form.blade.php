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
									        <option value="" disabled selected>-- Expedition --</option>
									        <option value="1">ALAM RAYA SENTOSA, CV.</option>
									        <option value="2">ALAMUI LOGISTICS, PT.</option>
									        <option value="3">ALISTON TJOKRO EMKL</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
						</form>
                    </div>
                </div>
                <div class="card">
                	<div class="card-content">
                        <form>
					   		<div class="row">
					   		<div class="col m6 s12">
					   		  <div class="input-field col s12">
								<input id="driver_id" type="text" class="validate" name="driver_id" required>
							    <label for="driver_id">Driver ID</label>
							  </div>
							  <div class="input-field col s12">
								<input id="name" type="text" class="validate" name="name" required>
							    <label for="name">Driver Name</label>
							  </div>
							  <div class="input-field col s12">
							    <select>
							        <option value="" disabled selected>-- Select Type --</option>
							        <option value="1">SIM A</option>
							        <option value="2">SIM B</option>
							        <option value="3">SIM B1</option>
							    </select>
							    <label>Driving License Type</label>
							  </div>
							  <div class="input-field col s12">
								<input id="number" type="text" class="validate" name="number" required>
							    <label for="number">Driving Lisence No.</label>
							  </div>
							  <div class="input-field col s12">
								<input id="ktp_id" type="text" class="validate" name="ktp_id" required>
							    <label for="ktp_id">ID (KTP) No.</label>
							  </div>
							  <div class="input-field col s12">
								<input id="phone" type="text" class="validate" name="phone1" required>
							    <label for="phone1">Phone 1</label>
							  </div>
							  <div class="input-field col s12">
								<input id="phone" type="text" class="validate" name="phone2" required>
							    <label for="phone2">Phone 2</label>
							  </div>
							  <div class="input-field col s12">
								<input id="remarks" type="text" class="validate" name="remarks1" required>
							    <label for="remarks1">Remarks 1</label>
							  </div>
							  <div class="input-field col s12">
								<input id="remarks" type="text" class="validate" name="remarks2" required>
							    <label for="remarks2">Remarks 2</label>
							  </div>
							  <div class="input-field col s12">
								<input id="remarks" type="text" class="validate" name="remarks3" required>
							    <label for="remarks3">Remarks 3</label>
							  </div>
							  <div class="input-field col s12">
							    <p>
							      <label>
							        <input type="checkbox" class="filled-in" checked="checked" />
							        <span>ACTIVE</span>
							      </label>
							    </p>
							  </div>
							</div>
							<div class="col m6 s12">
							  <p>Maximum upload size 2MB.</p>
							  <br>
							  <input type="file" required id="input-file-now" class="dropify" name="file" data-default-file="" data-height="500"/>
							</div>
							</div>
							<br>
							<div class="row">
							  <div class="input-field col m6 s12">
							  <button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Update</button>
							  <a class="waves-effect btn-flat mt-2" href="{{ url('master-driver') }}">Back</a>
							</div>
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
	//Upload Foto
    $('.dropify').dropify();
</script>
@endpush