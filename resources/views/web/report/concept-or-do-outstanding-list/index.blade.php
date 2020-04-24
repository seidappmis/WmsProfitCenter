@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4 l4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept or DO Outstanding List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept or DO Outstanding List</li>
                </ol>
            </div>
           
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <form class="form-table">
                            <table>
                              <tr style="background-color: darkgray">
                                <td>Area</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-Select Area-</option>
                                      <option value="1">KARAWANG</option>
                                      <option value="2">SURABAYA HUB</option>
                                      <option value="3">SWADAYA</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>OR</td>
                                <td></td>
                              </tr>
                              <tr style="background-color: darkgray">
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-Select Branch-</option>
                                      <option value="1">PT. SAID CAB. JAKARTA</option>
                                      <option value="2">PT. SAID CAB. BANDNG</option>
                                      <option value="3">PT. SAID CAB. CIREBON</option>
                                      <option value="3">PT. SAID CAB. SEMARNG</option>
                                      <option value="3">PT. SAID CAB. YOGYAKARTA</option>
                                      <option value="3">PT. SAID CAB. PURWOKERTO</option>
                                      <option value="3">PT. SAID CAB. KEDIRI</option>
                                      <option value="3">PT. SAID CAB. SURABAYA</option>
                                      <option value="3">PT. SAID CAB. DENPASAT</option>
                                      <option value="3">PT. SAID CAB. SAMARINDA</option>
                                      <option value="3">PT. SAID CAB. BANJARMASIN</option>

                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Shipment No</td>
                                <td><div class="input-field col s12">
                                  <input id="model" type="text" class="validate" name="model" required>
                                </div></td>
                              </tr>
                              <tr>
                                <td>Do NO</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="aqty" disabled>
                                </div></td>
                              </tr>
                              <tr>
                                <td>Expediotion</td>
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
                                <td>Upload Concept Date</td>
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
                                <td>Vahicle Type</td>
                                <td><div class="input-field col s12">
                                  <input id="" type="text" class="validate" name="model" required>
                                </div></td>
                              </tr>
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
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
