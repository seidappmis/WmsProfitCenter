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
                    	<form class="form-table">
                            <table>
                                <tr>
                                    <td>User</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="user" type="text" class="validate" name="user" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Roles</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select required>
										        <option value="" disabled selected>-- Select Roles --</option>
										        <option value="1">Admin</option>
										        <option value="2">User</option>
										    </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Active</td>
                                    <td>
                                        <div class="input-field col s12 mt-2">
                                            <p>
										    <label>
										      <input type="checkbox" class="filled-in" checked="checked" />
										      <span></span>
										    </label>
										  </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
                            <a class="waves-effect btn-flat mt-2" href="{{ url('master-user-mobile') }}">Cancel</a>
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
 	
</script>
@endpush