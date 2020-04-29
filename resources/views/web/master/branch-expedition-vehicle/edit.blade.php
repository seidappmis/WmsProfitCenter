@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Branch Expedition Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Branch Expedition Vehicle</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<form class="form-table">
                    		<h4 class="card-title">Edit Vehicle Expedition</h4>
                    		<table>
                    			<tr>
                    				<td>Expedition</td>
                    				<td>
                    					<div class="input-field col s12">
										<select required="">
									        <option value="0">-- Select Expedition --</option>
									        <option value="1" selected>P13-PUTRA NAGITA PRATAMA</option>
									        <!-- <option value="2">DUA SAMUDRA EXPRESS, CV.</option>
									        <option value="3">DUA SAMUDRA LOGISTIK, PT.</option> -->
									    </select>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Vehicle No.</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="no" type="text" class="validate" value="B 9864 TAU" required>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Vehicle Type</td>
                    				<td>
                    					<div class="input-field col s12">
								        <select required="">
									        <option value="0">-- Select Vehicle --</option>
									        <option value="1" selected>PICK UP</option>
									        <option value="2">CD 4 BAN (CDE)</option>
									        <option value="3">CD 4 BOX (CDE BOX)</option>
									    </select>
								      </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Destination</td>
                    				<td>
                    					<div class="input-field col s12">
									    <select>
									        <option value="0">-- Select Destination --</option>
									        <option value="1">ACEH</option>
									        <option value="2" selected>BANDUNG</option>
									        <option value="3">BANJARMASIN</option>
									    </select>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Description</td>
                    				<td>
                    					<div class="input-field col s12">
									       <input id="description" type="text" class="validate">
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>STNK Number</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="cp" type="text" class="validate">
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Remarks 1</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="phone1" type="number" class="validate" name="phone1">
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Remarks 2</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="phone2" type="number" class="validate">
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>ACTIVE</td>
                    				<td>
                    					<div class="input-field col s12">
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
                            {!! get_button_cancel(url('branch-expedition-vehicle')) !!}
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
    
</script>
@endpush