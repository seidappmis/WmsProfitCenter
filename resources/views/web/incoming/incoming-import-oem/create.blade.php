@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Incoming Import/OEM</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('incoming-import-oem') }}">Incoming Import/OEM</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m2"></div>
            <div class="col s12 m4">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <select>
                <option value="" disabled>-- Select Area --</option>
                <option value="1" selected>KARAWANG</option>
                <option value="2">SURABAYA HUB</option>
                <option value="3">SWADAYA</option>
            </select>
            <!-- <label>Area</label> -->
                  </div>
                </div>
                <!---- Button Back ----->
                <a class="btn btn-large waves-effect waves-light indigo" href="{{ url('incoming-import-oem') }}">Back</a>
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
      <div class="container">
        <div class="section">
          <div class="card">
            <div class="card-content">
              <form>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Arrival No</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <div class="row">
                      <div class="col s12 m4">
                        <label>
                          <input name="group1" type="radio"/>
                          <span>IMPORT</span>
                        </label>
                      </div>
                      <div class="col s12 m4">
                        <label>
                          <input name="group1" type="radio"/>
                          <span>OEM</span>
                        </label>
                      </div>
                      <div class="col s12 m4">
                        <label>
                          <input name="group1" type="radio" checked/>
                          <span>OTHERS</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">PO</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <select>
                      <option value="" disabled selected>Select Vendor Name</option>
                      <option value="1">BIMA GREEN ENERGI, PT.</option>
                      <option value="2">DAEWOO ELECTRONICS (M) SDN.BHD.</option>
                      <option value="3">Option 3</option>
                    </select>
                    <label>Vendor Name</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Invoice No</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Actual Arrive Date</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">No GR SAP</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Expedition Name</label>
                  </div>
                </div>

                <div class="row">
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Document Date</label>
                  </div>
                  <div class="input-field col s12 m6">
                    <input id="first_name" type="text" class="validate">
                    <label for="first_name">Container No</label>
                  </div>
                </div>

                <button type="submit" class="btn btn-large waves-effect waves-light indigo">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
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