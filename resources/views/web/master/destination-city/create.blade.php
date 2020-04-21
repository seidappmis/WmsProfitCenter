@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Destination City</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Destination City</li>
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
							   <div class="collapsible-header">New Destination City</div>
							   <div class="collapsible-body white">
							   		<div class="row">
									  <div class="input-field col s12">
										<input id="code" type="text" class="validate" name="code" required>
									    <label for="code">City Code</label>
									  </div>
									  <div class="input-field col s12">
									    <input id="name" type="text" class="validate" name="name" required>
									    <label for="name">City Name</label>
									  </div>
									</div>
									<br>
									<div class="row">
									  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
									  <a class="waves-effect waves-light btn" href="{{ url('destination-city') }}">Cancel</a>
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