@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Finish Good Production</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('finish-good-production') }}">Finish Good Production</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select>
				        <option value="" disabled>-- Select Area --</option>
				        <option value="1" selected>KARAWANG</option>
				        <option value="2">SURABAYA HUB</option>
				        <option value="3">SWADAYA</option>
				    </select>
				    <!-- <label>Area</label> -->
                  </div>
                </div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('finish-good-production') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                	  <p>Receipt No : <b class="green-text text-darken-3">ARV-WHHYP-181003-019</b class="green-text text-darken-3"></p>
                      <p>Ticket No : <b class="green-text text-darken-3">L-TV-1810010006</b class="green-text text-darken-3"></p>
                      <p>Warehouse : <b class="green-text text-darken-3">SHARP KARAWANG W/H</b class="green-text text-darken-3"></p>
                      <p>Factory : <b class="green-text text-darken-3">TV</b class="green-text text-darken-3"></p>
                      <br>
                    	<div class="row mb-2">
                    	  <div class="col s12">
                    		<h4 class="card-title">List Barcode Detail from Factory</h4>
                    		<div class="card-content col s12">
                    		  <p>No Results Found</p>
                    	  	</div>
                    	  </div>
                    	</div>
                    	<br>
                    	<div class="row">
                    	  <div class="col s12">
                    		<h4 class="card-title">Find Delivery Ticket</h4>
                    	  </div>
                    	  <div class="input-field col s12">
							<select>
						        <option value="" disabled selected>-- Select Plant--</option>
						        <option value="1">ALL PLANT</option>
						        <option value="2">HA</option>
						        <option value="3">TV</option>
						    </select>
						    <label for="number">Choose Plant</label>
						  </div>
						  <div class="input-field col s12">
							<input id="delivery" type="text" class="validate" name="delivery" required>
						    <label for="delivery">Delivery Ticket</label>
						  </div>
						  <div class="input-field col s12 m6">
							<select>
						        <option value="" disabled>-- Select Type--</option>
						        <option value="1" selected>Local</option>
						        <!-- <option value="2">HA</option>
						        <option value="3">TV</option> -->
						    </select>
						    <label for="number">Choose Type</label>
						  </div>
						  <div class="input-field col s12 m6">
						  	<button type="submit" class="waves-effect waves-light indigo btn-small btn">Search Delivery Ticket</button>
						  </div>
                    	</div>
                    	<form>
                    	  <div class="row">
	                    	<div class="col s12">
	                    	  <h4 class="card-title">Assign Delivery Ticket</h4>
	                    	</div>
	                      </div>
	                      <div class="card-content">
	                      <div class="row">
	                      	<div class="col s12 m4 l5">
	                      		<p>s12 m4</p>
	                      	</div>
						    <div class="col s12 m4 l2">
						    	<button type="submit" class="waves-effect waves-light indigo btn">>></button>
						    	<br>
						    	<button type="submit" class="waves-effect waves-light indigo btn"><<</button>
						    </div>
						    <div class="col s12 m4 l5"><p>s12 m4</p></div>
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