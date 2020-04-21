@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Transfer SLoc</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Transfer SLoc</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                  <div class="card-content p-1">
                    <ul class="collapsible">
                     <li class="active">
                       <div class="collapsible-header"><i class="material-icons">filter_drama</i>SLoc From</div>
                       <div class="collapsible-body">
                        <div class="row">
                         <div class="input-field col s12">
                          <select>
                              <option value="" disabled selected>-- Select Type --</option>
                              <option>1st Class</option>
                              <option>Return All</option>
                              <option>2nd Class Insurance</option>
                          </select>
                          <label>Storage Type</label>
                          </div>
                          <div class="input-field col s12">
                            <select>
                                <option value="" disabled selected>-- Select Location --</option>
                                <!-- <option>1st Class</option>
                                <option>Return All</option>
                                <option>2nd Class Insurance</option> -->
                            </select>
                            <label>Storage Location</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="model" type="text" class="validate" name="model" required>
                            <label for="model">MODEL</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="aqty" type="text" class="validate " name="aqty" disabled>
                            <label for="aqty">AVAILABLE QTY</label>
                          </div>
                          <div class="input-field col s12">
                            <input id="qty" type="text" class="validate" name="qty" required>
                            <label for="qty">QTY</label>
                          </div>
                       </div>
                      </div>
                     </li>
                      </ul>
                      <ul class="collapsible">
                       <li class="active">
                         <div class="collapsible-header"><i class="material-icons">filter_drama</i>SLoc To</div>
                         <div class="collapsible-body">
                          <div class="row">
                            <div class="input-field col s12">
                              <select>
                                  <option value="" disabled selected>-- Select Type --</option>
                                  <option>1st Class</option>
                                  <option>Return All</option>
                                  <option>2nd Class Insurance</option>
                              </select>
                              <label>Storage Type</label>
                          </div>
                          <div class="input-field col s12">
                            <select>
                                <option value="" disabled selected>-- Select Location --</option>
                                <!-- <option>1st Class</option>
                                <option>Return All</option>
                                <option>2nd Class Insurance</option> -->
                            </select>
                            <label>Storage Location</label>
                          </div>
                          </div>
                         </div>
                       </li>
                    </ul>
                    <div class="row">
                      <div class="col s12">
                        <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                        <a class="waves-effect waves-light btn" href="{{ url('transfer-sloc') }}">Clear</a>
                    </div>
                    </div>
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