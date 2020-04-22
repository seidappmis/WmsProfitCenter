@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Expedition</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Expedition</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Expedition</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Code</td>
                        			<td>
                        			  <div class="input-field col s12">
										<input id="code" type="text" class="validate" name="code" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Expedition Name</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="name" type="text" class="validate" name="name" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>Address</td>
                        			<td>
                        			  <div class="input-field col s12">
								        <textarea id="address" class="materialize-textarea"></textarea>
								      </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>SAP CODE</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="sapcode" type="text" class="validate" name="sapcode" required>
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>NPWP</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="npwp" type="text" class="validate" name="npwp">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>CONTACT PERSON</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="cp" type="text" class="validate" name="cp">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>PHONE NUMBER 1</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="phone1" type="number" class="validate" name="phone1">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>PHONE NUMBER 2</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="phone2" type="number" class="validate" name="phone2">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>FAX NUMBER</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="fax" type="number" class="validate" name="fax">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>BANK</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="bank" type="text" class="validate" name="bank">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>CURRENCY</td>
                        			<td>
                        			  <div class="input-field col s12">
									    <input id="currency" type="text" class="validate" name="currency">
									  </div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>ACTIVE</td>
                        			<td>
                        			  <div class="input-field col s12 mt-2">
									    <p>
									      <label>
									        <input type="checkbox" class="filled-in" checked="checked"/><span></span>
									      </label>
									    </p>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
                        	<button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
							<a class="waves-effect btn-flat mt-2" href="{{ url('master-expedition') }}">Cancel</a>
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