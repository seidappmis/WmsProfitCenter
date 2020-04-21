@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>User Manager</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Manager</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New User</h4>
                        <form>
					   		<div class="row">
							  <div class="input-field col s12">
								<input id="uname" type="text" class="validate" name="uname" required>
							    <label for="uname">USERNAME</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="first" type="text" class="validate" name="first" required>
							    <label for="first">FIRST NAME</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="last" type="text" class="validate" name="last" required>
							    <label for="last">LAST NAME</label>
							  </div>
							  <div class="input-field col s12">
							    <select>
							        <option value="" disabled selected>-- Select Roles--</option>
							        <option value="1">admincheck</option>
							        <option value="2">allocation</option>
							        <option value="3">Audit</option>
							    </select>
							    <label for="roles">ROLES</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="pass" type="text" class="validate" name="pass" required>
							    <label for="pass">PASSWORD</label>
							  </div>
							  <div class="input-field col s12">
							    <input id="cpass" type="text" class="validate" name="cpass" required>
							    <label for="cpass">CONFIRM PASSWORD</label>
							  </div>
							  <div class="input-field col m6 s12">
							    <select>
							        <option value="" disabled selected>-- Select Area --</option>
							        <option value="1">All</option>
							        <option value="2">KARAWANG</option>
							        <option value="3">SURABAYA HUB</option>
							    </select>
							    <label>AREA</label>
							  </div>
							  <div class="input-field col m6 s12">
							    <select>
							        <option value="" disabled selected>-- Select Branch --</option>
							        <option value="1">[HYP]PT. SEID HQ JKT</option>
							        <option value="2">[JKT]PT. SEID CAB. JAKARTA</option>
							        <option value="3">[JF]PT. SEID CAB. JAKARTA</option>
							    </select>
							    <label>CABANG</label>
							  </div>
							  <div class="input-field col s12">
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
							  <div class="input-field col s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('user-manager') }}">Cancel</a>
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