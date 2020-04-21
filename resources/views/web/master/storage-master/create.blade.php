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
                <!-- <div class="card"> -->
                    <div class="card-content p-0">
                        <ul class="collapsible">
						   <li class="active">
							   <div class="collapsible-header">New Gate</div>
							   <div class="collapsible-body white">
							   		<div class="row">
									  <div class="input-field col s12">
										<select>
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">10-HYP-PT. SEID HQ JKT</option>
									    </select>
									    <label for="branch">Branch</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="code" type="text" class="validate" name="code" required>
									    <label for="code">Storage Code</label>
									  </div>
									  <div class="input-field col s12">
									    <select>
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">1st Class</option>
									        <option value="2">Return All</option>
									        <option value="3">2nd Class Insurance</option>
									    </select>
									    <label>Storage Type</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="total" type="number" class="validate" name="total" required>
									    <label for="total">Total Pallate</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="used" type="number" class="validate" name="used" required>
									    <label for="used">Used Space</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="wh" type="number" class="validate" name="wh" required>
									    <label for="wh">Space WH</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="space" type="number" class="validate" name="space" required>
									    <label for="space">Hand Pallet Space</label>
									  </div>
									</div>
									<br>
									<div class="row">
									  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
									  <a class="waves-effect waves-light btn" href="{{ url('storage-master') }}">Cancel</a>
									</div>
							   </div>
						   </li>
						</ul>
                    </div>
                <!-- </div> -->
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