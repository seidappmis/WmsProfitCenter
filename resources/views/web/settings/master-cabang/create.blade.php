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
                    	<form class="form-table">
                            <table>
                                <tr>
                                    <td>Kode Customer</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="customer" type="text" class="validate" name="customer" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kode Cabang</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="cabang" type="text" class="validate" name="cabang" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Short Description</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="sdes" type="text" class="validate">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Long Description</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="ldes" type="text" class="validate">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Region</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select>
										        <option value="" disabled selected></option>
										        <!-- <option value="1">admincheck</option>
										        <option value="2">allocation</option>
										        <option value="3">Audit</optio -->
										    </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type Code</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select>
										        <option value="" disabled selected>-- Select Type --</option>
										        <option value="1">BR</option>
										        <option value="2">DS</option>
										    </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>HQ</td>
                                    <td>
                                        <div class="input-field col s12 mt-2">
                                            <p>
										    <label>
										      <input type="checkbox" class="filled-in" />
										      <span></span>
										    </label>
										  </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>START WMS</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="wms" type="text" class="validate" name="wms">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
                            <a class="waves-effect btn-flat mt-2" href="{{ url('master-cabang') }}">Cancel</a>
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