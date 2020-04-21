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
                    <!-- Sloc From -->
                    <ul class="collapsible">
                     <li class="active">
                       <div class="collapsible-header">SLoc From <i class="material-icons"></i></div>
                       <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12">
                            <table class="bordered">
                              <thead></thead>
                              <tbody>
                                <tr>
                                  <td>Storage Type</td>
                                  <td><div class="input-field col m6 s12">
                                    <select>
                                        <option value="" disabled selected>-- Select Type --</option>
                                        <option>1st Class</option>
                                        <option>Return All</option>
                                        <option>2nd Class Insurance</option>
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>Storage Location</td>
                                  <td><div class="input-field m6 col s12">
                                    <select>
                                      <option value="" disabled selected>-- Select Location --</option>
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>Model</td>
                                  <td><div class="input-field m6 col s12"><input id="model" type="text" class="validate" name="model" required></div></td>
                                </tr>
                                <tr>
                                  <td>Available QTY</td>
                                  <td><div class="input-field m6 col s12"><input id="aqty" type="text" class="validate " name="aqty" disabled></div></td>
                                </tr>
                                <tr>
                                  <td>QTY</td>
                                  <td><div class="input-field m6 col s12"><input id="qty" type="text" class="validate" name="qty" required></div></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                       </div>
                      </div>
                     </li>
                    </ul>
                    <!-- Sloc To -->
                    <ul class="collapsible">
                     <li class="active">
                       <div class="collapsible-header">SLoc To</div>
                       <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12">
                          <table class="bordered">
                            <thead></thead>
                            <tbody>
                              <tr>
                                <td>Storage Type</td>
                                <td><div class="m6 col s12">
                                  <select>
                                      <option value="" disabled selected>-- Select Type --</option>
                                      <option>1st Class</option>
                                      <option>Return All</option>
                                      <option>2nd Class Insurance</option>
                                  </select>
                                </div></td>
                              </tr>
                              <tr>
                                <td>Storage Location</td>
                                <td><div class="col m6 s12">
                                  <select>
                                    <option value="" disabled selected>-- Select Location --</option>
                                  </select>
                                </div></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="row">
                            <div class="input-field col s12 m6">
                              <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                              <a class="waves-effect waves-light indigo btn" href="{{ url('transfer-sloc') }}">Clear</a>
                            </div>
                          </div>
                          </div>
                        </div>
                       </div>
                     </li>
                    </ul>
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