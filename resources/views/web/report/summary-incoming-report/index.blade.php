@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Incoming Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Incoming Report</li>
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
                              <tr ">
                                <td>WAREHOUSE</td>
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
                              <tr ">
                                <td>BRANCH</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select>
                                      <option value="" disabled selected>-Select Branch-</option>
                                      <option value="1">[ACH]PT. SAID CAB. JAKARTA</option>
                                      <option value="2">[BDG]PT. SAID CAB. BANDNG</option>
                                      <option value="3">[CRB]PT. SAID CAB. CIREBON</option>
                                      <option value="3">[SMG]PT. SAID CAB. SEMARNG</option>
                                      <option value="3">[YGY]PT. SAID CAB. YOGYAKARTA</option>
                                      <option value="3">[PWK]PT. SAID CAB. PURWOKERTO</option>
                                      <option value="3">[KDR]PT. SAID CAB. KEDIRI</option>
                                      <option value="3">[SBY]PT. SAID CAB. SURABAYA</option>
                                      <option value="3">[DPS]PT. SAID CAB. DENPASAR</option>
                                      <option value="3">[SMR]PT. SAID CAB. SAMARINDA</option>
                                      <option value="3">[BJR]PT. SAID CAB. BANJARMASIN</option>

                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>TYPE</td>
                                <td ><div class="col s12 ">
                                        <label>
                                            <input class="validate inline" required="" name="gender0" type="radio" checked="">
                                            <span>ALL</span>
                                        </label>
                                        <label>
                                            <input class="validate inline" required="" name="gender0" type="radio">
                                            <span>PRODUCTION</span>
                                        </label>
                                        <label>
                                            <input class="validate inline" required="" name="gender0" type="radio">
                                            <span>MANUAL</span>
                                        </label>
                                    
                                </div></td>
                              </tr>
                              <tr>
                                <td>Do NO</td>
                                <td><div class="input-field col s12">
                                  <input id="aqty" type="text" class="validate " name="aqty" disabled>
                                </div></td>
                              </tr>
                              
                              <tr>
                                <td>SELECTION DATE</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      START
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      END
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" id="first_name" type="text" class="validate datepicker" readonly>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>MODEL</td>
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
