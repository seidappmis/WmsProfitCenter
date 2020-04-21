@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Destination</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Destination</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">New Destination</h4>
                        <form>
					   		<div class="row">
							  <div class="input-field col s12">
								<input id="number" type="text" class="validate" name="number" required>
							    <label for="number">Destination Number</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="description" type="text" class="validate" name="description" required>
							    <label for="description">Description</label>
							  </div>
                              <div class="row">
                              <div class="input-field col s12 p-1">
                                <label for="region">
                                    <span>Region</span>
                                </label>
                              </div>
                              <div class="input-field col 12">
                                <p>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio" checked/>
                                    <span>New Region</span>
                                  </label>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio" />
                                    <span>Current</span>
                                  </label>
                                </p>
                              </div>
                              </div>
							  <div class="input-field col s12">
                                <input id="cabang" type="text" class="validate" name="cabang" required>
                                <label for="cabang">Cabang</label>
                              </div>
							</div>
                            <br>
							<div class="row">
                              <div class="input-field col s12">
    							  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
    							  <a class="waves-effect waves-light btn" href="{{ url('master-destination') }}">Cancel</a>
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