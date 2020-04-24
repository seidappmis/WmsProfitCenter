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
                    	<h4 class="card-title">Edit Gate</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Gate Number</td>
                        			<td>
                        				<div class="input-field col s12">
											<input id="number" type="number" class="validate" name="gate_number" value="101" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Description</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="description" type="text" class="validate" name="description" value="GATE NO.1-A KARAWANG WAREHOUSE" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Area</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled>-- Select --</option>
									        <option value="1" selected>KARAWANG</option>
									        <option value="2">SURABAYA HUB</option>
									        <option value="3">SWADAYA</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
							{!! get_button_save('Update') !!}
                            {!! get_button_cancel(url('master-gate')) !!}
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