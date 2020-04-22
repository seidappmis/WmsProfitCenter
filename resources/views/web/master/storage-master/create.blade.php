@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Storage Master</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Storage Master</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Data</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Branch</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">10-HYP-PT. SEID HQ JKT</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Storage Code</td>
                        			<td>
                        				<div class="input-field col s12">
											<input id="code" type="text" class="validate" name="code" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Storage Type</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">1st Class</option>
									        <option value="2">Return All</option>
									        <option value="3">2nd Class Insurance</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Total Pallate</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="total" type="number" class="validate" name="total" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Used Space</td>
                        			<td>
                        				<input id="used" type="number" class="validate" name="used">
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Space WH</td>
                        			<td>
                        				<input id="wh" type="number" class="validate" name="wh">
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Hand Pallet Space</td>
                        			<td>
                        				<input id="space" type="number" class="validate" name="space">
                        			</td>
                        		</tr>
                        	</table>
							<button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
							<a class="waves-effect btn-flat mt-2" href="{{ url('storage-master') }}">Cancel</a>
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