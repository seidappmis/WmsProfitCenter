@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vehicle Expedition</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vehicle Expedition</li>
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
									        <option value="" disabled>-- Select Expedition --</option>
									        <option value="1">BINTAN MEGAH ABADI, PT.</option>
									        <option value="2">DUA SAMUDRA EXPRESS, CV.</option>
									        <option value="3" selected>EXPRESSINDO 88 NUSANTARA, PT.</option>
									    </select>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Vehicle No.</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="no" type="text" class="validate" value="A 8218 Z" required>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Vehicle Type</td>
                    				<td>
                    					<div class="input-field col s12">
								        <select required="">
									        <option value="" disabled>-- Select Vehicle --</option>
									        <option value="1">AMBIL SENDIRI</option>
									        <option value="2">CD 4 BAN (CDE)</option>
									        <option value="3"  selected>TRONTON 8 M</option>
									    </select>
								      </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Destination</td>
                    				<td>
                    					<div class="input-field col s12">
									    <select>
									        <option value="" disabled selected>-- Select Destination --</option>
									        <option value="1">ACEH</option>
									        <option value="2">BANDUNG</option>
									        <option value="3">BANJARMASIN</option>
									    </select>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Description</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="npwp" type="text" class="validate" name="npwp">
									    <label for="npwp"></label>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>STNK Number</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="cp" type="text" class="validate" name="cp">
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Remarks 1</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="phone1" type="number" class="validate" name="phone1">
									    <label for="phone1"></label>
									  </div>
                    				</td>
                    			</tr>
                    			<tr>
                    				<td>Remarks 2</td>
                    				<td>
                    					<div class="input-field col s12">
									    <input id="phone2" type="number" class="validate" name="phone2">
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
                            {!! get_button_cancel(url('master-vehicle-expedition')) !!}
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
    // $('#address').val('New Text');
    M.textareaAutoResize($('#address'));
</script>
@endpush