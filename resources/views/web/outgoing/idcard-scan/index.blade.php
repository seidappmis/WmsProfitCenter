@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m5">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>IDCard Scan</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">IDCard Scan</li>
              </ol>
          </div>
      </div>
  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form>
                        <table class="form-table">
                          <tr>
                            <td width="20%">Driver ID</td>
                            <td>
                              <div class="row">
                                <div class="col s12 m6 l3">
                                  <input placeholder="" id="first_name" type="text" class="validate" required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <table class="form-table">
                          <tr>
                            <td width="20%">Driver Name</td>
                            <td>Name</td>
                            <td width="30%" rowspan="7" class="center-align">
                              <img src="{{asset('images/profil.png')}}" width="120px">
                            </td>
                          </tr>
                          <tr>
                            <td>Transporter</td>
                            <td>Trans</td>
                          </tr>
                          <tr>
                            <td>Vehicle No.</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="">-Select Vehicle-</option>
                                  <option value="B 9010 GB">B 9010 GB</option>
                                  <option value="B 9033 SYK">B 9033 SYK</option>
                                  <option value="B 9035 ML">B 9035 ML</option>
                                  <option value="B 9051 BN">B 9051 BN</option>
                                  <option value="B 9089 UIW">B 9089 UIW</option>
                                  <option value="B 9110 KA">B 9110 KA</option>
                                  <option value="B 9132 BEI">B 9132 BEI</option>
                                  <option value="B 9132 LS">B 9132 LS</option>
                                  <option value="B 9143 JS">B 9143 JS</option>
                                  <option value="B 9184 BEK">B 9184 BEK</option>
                                  <option value="B 9185 BEK">B 9185 BEK</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Vehicle Type</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="" selected="selected">-Select Vehicle Type-</option>
                                  <option value="Z3D006">Cont 20 ft capacity 25 - 28 Cbm</option>
                                  <option value="Z3D007">Cont 40 ft STD capacity 55 - 60 Cbm</option>
                                  <option value="Z3D008">Cont 45 ft capacity  55 - 75 cbm</option>
                                  <option value="Z3D009">Cont 40 ft HC capacity 55 - 65 Cbm</option>
                                  <option value="Z3D010">Cont 20 combo capacity  50 - 56 cbm</option>
                                  <option value="Z3D025">Cont 10 ft capacity 10 - 15 cbm</option>
                                  <option value="LCL">Less than Container Load</option>
                                  <option value="Z3D027">Cont 20 ft capacity 25 - 28 Cbm (By Train)</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Capacity (CBM)</td>
                            <td>55.000 to 65.000</td>
                          </tr>
                          <tr>
                            <td>Destination</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="" selected="selected">-Select Destination-</option>
                                  <option value="Z3D006">Cont 20 ft capacity 25 - 28 Cbm</option>
                                  <option value="Z3D007">Cont 40 ft STD capacity 55 - 60 Cbm</option>
                                  <option value="Z3D008">Cont 45 ft capacity  55 - 75 cbm</option>
                                  <option value="Z3D009">Cont 40 ft HC capacity 55 - 65 Cbm</option>
                                  <option value="Z3D010">Cont 20 combo capacity  50 - 56 cbm</option>
                                  <option value="Z3D025">Cont 10 ft capacity 10 - 15 cbm</option>
                                  <option value="LCL">Less than Container Load</option>
                                  <option value="Z3D027">Cont 20 ft capacity 25 - 28 Cbm (By Train)</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Area</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="" selected="selected">-Select Area-</option>
                                  <option value="Z3D006">Cont 20 ft capacity 25 - 28 Cbm</option>
                                  <option value="Z3D007">Cont 40 ft STD capacity 55 - 60 Cbm</option>
                                  <option value="Z3D008">Cont 45 ft capacity  55 - 75 cbm</option>
                                  <option value="Z3D009">Cont 40 ft HC capacity 55 - 65 Cbm</option>
                                  <option value="Z3D010">Cont 20 combo capacity  50 - 56 cbm</option>
                                  <option value="Z3D025">Cont 10 ft capacity 10 - 15 cbm</option>
                                  <option value="LCL">Less than Container Load</option>
                                  <option value="Z3D027">Cont 20 ft capacity 25 - 28 Cbm (By Train)</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <br>
                        <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                        <button type="" class="waves-effect waves-light btn">Clear</button>
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
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
    });
</script>
@endpush