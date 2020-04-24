@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 mb-1">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Freight Cost</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Freight Cost</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card-content p-0">
                <ul class="collapsible">
                  <li>
                    <div class="collapsible-header">UPLOAD DATA</div>
                    <div class="collapsible-body white">
                      <div class="row">
                        <div class="input-field col s12">
                          <div class="col s12 m4 l3">
                            <p>Data File</p>
                          </div>
                          <div class="col s12 m8 l9">
                            <input type="file" required id="input-file-now" class="dropify" name="file" data-default-file="" data-height="100"/>
                            <p>Format File : .csv</p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <button type="submit" class="waves-effect waves-light indigo btn">Upload</button>
                      </div>
                    </div>
                  </li>
                </ul>
                </div>
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">Edit Freight Cost</h4>
                        <form class="form-table">
                          <table>
                            <tr>
                              <td>Origin Area</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="">
                                    <option value="" disabled>-- Area --</option>
                                    <option value="1" selected>KARAWANG</option>
                                    <option value="2">SURABAYA HUB</option>
                                    <option value="3">SWADAYA</option>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Ambil Sendiri</td>
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
                              <td>Destination City</td>
                              <td>
                                <div class="input-field col m6 s12">
                                  <select required="">
                                    <!-- <option value="" disabled>-- Area --</option> -->
                                    <option value="1" selected>LAMPUNG</option>
                                    <!-- <option value="2">SURABAYA HUB</option>
                                    <option value="3">SWADAYA</option> -->
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Expedition</td>
                              <td>
                                <div class="input-field col m6 s12">
                                  <select required="">
                                    <option value="" disabled>-- Expedition --</option>
                                    <option value="1" selected>ALAM RAYA SENTOSA, CV.</option>
                                    <!-- <option value="2">SURABAYA HUB</option>
                                    <option value="3">SWADAYA</option> -->
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Vehicle Type</td>
                              <td>
                                <div class="input-field col m6 s12">
                                  <select required="">
                                    <option value="" disabled selected></option>
                                    <!-- <option value="1">LAMPUNG</option>
                                    <option value="2">SURABAYA HUB</option>
                                    <option value="3">SWADAYA</option> -->
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <p>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio"/>
                                    <span>Ritase</span>
                                  </label>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio" checked/>
                                    <span>CBM</span>
                                  </label>
                                </p>
                              </td>
                              <td>
                                <div class="input-field col s12">
                                  <input id="number" type="text" class="validate" value="145000.000" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Lead Time</td>
                              <td>
                                <div class="input-field col m2 s12">
                                  <input id="description" type="text" class="validate" value="3" required>
                                </div>
                                <div class="col m6 s12 mt-2 ml-2">
                                  <span>Days</span>
                                </div>
                              </td>
                            </tr>
                          </table>
                          {!! get_button_save('Update') !!}
                          {!! get_button_cancel(url('master-freight-cost')) !!}
                        </form>
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
  //Upload File
  $('.dropify').dropify();
</script>
@endpush