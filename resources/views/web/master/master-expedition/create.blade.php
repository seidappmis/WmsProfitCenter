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
                        <form>
					   		<div class="row">
							  <div class="input-field col s12">
								<input id="code" type="text" class="validate" name="code" required>
							    <label for="code">Code</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="name" type="text" class="validate" name="name" required>
							    <label for="name">Expedition Name</label>
							  </div>
							  <div class="input-field col s12">
						        <textarea id="address" class="materialize-textarea"></textarea>
						        <label for="address">Address</label>
						      </div>
						      <div class="input-field col s12">
							    <input id="sapcode" type="text" class="validate" name="sapcode" required>
							    <label for="sapcode">SAP CODE</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="npwp" type="text" class="validate" name="npwp">
							    <label for="npwp">NPWP</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="cp" type="text" class="validate" name="cp">
							    <label for="cp">CONTACT PERSON</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="phone1" type="number" class="validate" name="phone1">
							    <label for="phone1">PHONE NUMBER 1</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="phone2" type="number" class="validate" name="phone2">
							    <label for="phone2">PHONE NUMBER 2</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="fax" type="number" class="validate" name="fax">
							    <label for="fax">FAX NUMBER</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="bank" type="text" class="validate" name="bank">
							    <label for="bank">BANK</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="currency" type="text" class="validate" name="currency">
							    <label for="currency">CURRENCY</label>
							  </div>
							  <div class="input-field col m6 s12">
							    <p>
							      <label>
							        <input type="checkbox" class="filled-in" checked="checked" />
							        <span>ACTIVE</span>
							      </label>
							    </p>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="input-field col m6 s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('master-expedition') }}">Cancel</a>
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
 	$('.collapsible').collapsible({
        accordion:true
    });

    // $('#address').val('New Text');
    M.textareaAutoResize($('#address'));
  
</script>
@endpush