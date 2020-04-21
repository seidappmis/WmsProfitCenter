@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Cabang</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Cabang</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Cabang</h4>
                        <form>
					   		<div class="row">
							  <div class="input-field col s12">
								<input id="customer" type="text" class="validate" name="customer" required>
							    <label for="customer">Kode Customer</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="cabang" type="text" class="validate" name="cabang" required>
							    <label for="cabang">Kode Cabang</label>
							  </div>
							  <div class="input-field col s12">
							    <textarea id="textarea2" class="materialize-textarea"></textarea>
							    <label for="short">Short Description</label>
							  </div>
							  <div class="input-field col s12">
							    <textarea id="textarea2" class="materialize-textarea"></textarea>
							    <label for="long">Long Description</label>
							  </div>
							  <div class="input-field col s12">
							    <select>
							        <option value="" disabled selected></option>
							        <!-- <option value="1">admincheck</option>
							        <option value="2">allocation</option>
							        <option value="3">Audit</optio -->n>
							    </select>
							    <label for="region">Region</label>
							  </div>
							  <div class="input-field col s12">
							    <select>
							        <option value="" disabled selected>-- Select Type --</option>
							        <option value="1">BR</option>
							        <option value="2">DS</option>
							    </select>
							    <label>Type Code</label>
							  </div>
							  <div class="input-field col s12">
							  <p>
							    <label>
							      <input type="checkbox" class="filled-in" />
							      <span>HQ</span>
							    </label>
							  </p>
							  </div>
							  <div class="input-field col s12">
							    <input id="wms" type="text" class="validate" name="wms" required>
							    <label for="wms">START WMS</label>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="input-field col s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('master-cabang') }}">Cancel</a>
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
</script>
@endpush