@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master User Mobile</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master User Mobile</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Add Master User Mobile</h4>
                        <form>
					   		<div class="row">
							  <div class="input-field col s12">
								<input id="user" type="text" class="validate" name="user" required>
							    <label for="user">User</label>
							  </div>
							  <div class="input-field col s12">
							    <select>
							        <option value="" disabled selected>-- Select Roles --</option>
							        <option value="1">Admin</option>
							        <option value="2">User</option>
							    </select>
							    <label>Roles</label>
							  </div>
							  <div class="input-field col s12">
							  <p>
							    <label>
							      <input type="checkbox" class="filled-in" checked="checked" />
							      <span>Active</span>
							    </label>
							  </p>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="input-field col s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('master-user-mobile') }}">Cancel</a>
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