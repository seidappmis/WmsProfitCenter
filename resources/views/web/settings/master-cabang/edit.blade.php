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
                    	<h4 class="card-title">Edit Cabang</h4>
                    	<form class="form-table">
                            <table>
                                <tr>
                                    <td>Kode Customer</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="customer" type="text" class="validate" value="10000000" required disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kode Cabang</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="cabang" type="text" class="validate" value="10" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Short Description</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="sdes" type="text" class="validate" value="HYP">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Long Description</td>
                                    <td>
                                        <div class="input-field col s12">
                                           <input id="ldes" type="text" class="validate" value="PT. SEID HQ JKT">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Region</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select>
										        <option value="" >-Select Region-</option>
										        <option value="1"  selected>JABODETABEK</option>
										        <option value="2">JAWA</option>
										        <option value="3">KALIMANTAN</option>
										    </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type Code</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <select>
										        <option value="" disabled>-- Select Type --</option>
										        <option value="1" selected>BR</option>
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
										      <input type="checkbox" class="filled-in" checked />
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
                            {!! get_button_save('Update') !!}
                            {!! get_button_cancel(url('master-cabang')) !!}
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