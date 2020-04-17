@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">New Data</h4>
                        <form>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="name">
                                <label for="name">Model Name</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="barcode">
                                <label for="barcode">Model From Barcode Prod</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="ean">
                                <label for="ean">Ean Code</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <input type="text" id="cbm">
                                <label for="cbm">CBM</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <select>
							        <option value="" disabled selected>-- Select Material Group --</option>
							        <option value="1">BG - F3 LED Lightning</option>
							        <option value="2">BJ - C1 Energy Solution Japan</option>
							        <option value="3">BP - C1 Energy Sollution Overseas</option>
							    </select>
                                <label for="material">Material Group</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <select>
							        <option value="" disabled selected>-- Select Category --</option>
							        <option value="1">AC</option>
							        <option value="2">AP</option>
							        <option value="3">AU</option>
							    </select>
                                <label for="category">Category</label>
                              </div>
                        	</div>
                        	<div class="row">
                        	  <div class="input-field col s12">
                                <select>
							        <option value="" disabled selected>-- Select Category --</option>
							        <option value="1">IMPORT</option>
							        <option value="2">LOCAL</option>
							        <option value="3">OEM</option>
							    </select>
                                <label for="type">Type</label>
                              </div>
                        	</div>
                        	<div class="input-field col s12">
                              <input type="text" id="description">
                              <label for="description">Description</label>
                            </div>
                            <div class="input-field col s12">
                              <input type="text" id="pieces">
                              <label for="pieces">Max Pieces/Carton</label>
                            </div>
                            <div class="input-field col s12">
                              <input type="text" id="carton">
                              <label for="carton">Max Carton/Palet</label>
                            </div>
                            <div class="input-field col s12">
                              <input type="text" id="palet">
                              <label for="palet">Palet</label>
                            </div>
                            <div class="input-field col s12">
                              <input placeholder="0" type="number" id="price">
                              <label for="price1">Price 1</label>
                            </div>
                            <div class="input-field col s12">
                              <input placeholder="0" type="number" id="price">
                              <label for="price2">Price 2</label>
                            </div>
                            <div class="input-field col s12">
                              <input placeholder="0" type="number" id="price">
                              <label for="price3">Price 3</label>
                            </div>
							<div class="row">
							  <div class="input-field col s12">
								  <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
								  <a class="waves-effect waves-light btn" href="{{ url('master-model') }}">Cancel</a>
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