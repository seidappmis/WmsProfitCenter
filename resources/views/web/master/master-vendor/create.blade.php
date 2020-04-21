@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vendor</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vendor</li>
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
                        <form>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="code">
                                <label for="code">Vendor Code</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="vname">
                                <label for="vname">Vendor Name</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <textarea id="description" class="materialize-textarea"></textarea>
                                <label for="description">Description</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <textarea id="address" class="materialize-textarea"></textarea>
                                <label for="address">Address</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="name">
                                <label for="name">Name</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="number" id="phone">
                                <label for="phone">Phone</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="email" id="email">
                                <label for="email">Email</label>
                              </div>
                        	</div>
							<div class="row">
							  <div class="input-field col s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('master-vendor') }}">Cancel</a>
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