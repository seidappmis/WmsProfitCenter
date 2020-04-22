@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Schedule</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Take Schedule</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Add Stock Take Schedule</div>
                          <div class="collapsible-body">
                          <form class="form-table">
                        <table>
                          <tr>
                            <td class="label">Expedition</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="">-All-</option>
                                  <option value="BMA">BINTAN MEGAH ABADI, PT.</option>
                                  <option value="DSE">DUA SAMUDERA EXPRESS, CV.</option>
                                  <option value="DSE">DUA SAMUDRA EXPRESS, CV.</option>
                                  <option value="DSL">DUA SAMUDRA LOGISTIK, PT.</option>
                                  <option value="DPE">DUNIA PARCEL EXPRESS, PT.</option>
                                  <option value="E8T">EXPRESSINDO 88 NUSANTARA, PT.</option>
                                  <option value="GCL">GCL LOGISTIK INDONESIA, PT.</option>
                                  <option value="GST">GEMA SARANA TRANSPORTASI, PT.</option>
                                  <option value="JTT">JASA TRANS TIRTA, PT.</option>
                                  <option value="KFF">KARURA FREIGHT FORWARDING DAN LOGISTICS, PT.</option>
                                  <option value="KYU">KARYA UTAMA, CV.</option>
                                  <option value="KIT">KUNCI INTI TRANSINDO, PT.</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Manifest Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">DO Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">DO Manifest</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Recipt ID</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Destination</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">JAKARTA-JEMBER</option>
                                  <option value="2">JAKARTA-KARAWANG</option>
                                  <option value="3">JAKARTA-KEDIRI</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Region</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">JABODETABEK</option>
                                  <option value="2">JAWA</option>
                                  <option value="3">KALIMANTAN</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Status</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">UNRECEIPT</option>
                                  <option value="2">DRAFT UNRECEIPT</option>
                                  <option value="3">ALREADY UNRECEIPT</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        
                      </form>
                            <div class="row">
                              <div class="input-field col s12">
                                <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                                <a class="waves-effect waves-light btn" href="{{ url('stock-take-schedule') }}">Cancel</a>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
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