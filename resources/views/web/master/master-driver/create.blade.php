@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Driver</li>
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
							   <div class="collapsible-header">New Driver</div>
							   <div class="collapsible-body white">
							   		<div class="row">
									  <div class="input-field col m6 s12">
									    <select>
									        <option value="" disabled selected>-- Select --</option>
									        <option value="1">ALAM RAYA SENTOSA, CV.</option>
									        <option value="2">ALAMUI LOGISTICS, PT.</option>
									        <option value="3">ALISTON TJOKRO EMKL</option>
									    </select>
									    <label>Expedition</label>
									  </div>
									</div>
									<br>
									<div class="row">
									  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
									  <a class="waves-effect waves-light btn" href="{{ url('master-driver') }}">Back</a>
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