@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Gate</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Gate</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Gate</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Gate Number</td>
                        			<td>
                        				<div class="input-field col s12">
											<input id="number" type="text" class="validate" name="gate_number" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Description</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="description" type="text" class="validate" name="description" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Area</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">KARAWANG</option>
									        <option value="2">SURABAYA HUB</option>
									        <option value="3">SWADAYA</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
							<button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
							<a class="waves-effect waves-light btn mt-2" href="{{ url('master-gate') }}">Cancel</a>
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