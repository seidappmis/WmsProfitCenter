@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Outgoing Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Outgoing Report</li>
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
                              <tr>
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
                                 <label>
                                    <input type="checkbox" class="filled-in " checked="checked" />
                                 <span><b>Include HG</b></span>
                                 </label>
                                </td>
                              </tr>
                              <tr>
                                  <td>Do Received</td>
                                  <td> <label>
                                    <input type="checkbox" class="filled-in " checked="checked" />
                                 <span><b></b></span>
                                 </label> </td>
                              </tr>
                              <tr>
                                <td>Branch</td>
                                <td>
                                  <div class="input-field col s4">
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
                                <td>Date of Manifest</td>
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
                                <td>Do Date</td>
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
                                <td>Actual Time Arrival ( ATA )</td>
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
                                <td>Unloading Date</td>
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
                                <td>Document DO Return Date</td>
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
                                <td>MANIFEST NO.</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="">
                                </div></td>
                              </tr>
                              <tr>
                                <td>SHIPMENT NO.</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="">
                                </div></td>
                              </tr>
                              <tr>
                                <td>DO NO.</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="">
                                </div></td>
                              </tr>
                              <tr ">
                                <td>OUTGOING TYPE</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select>
                                      <option value="" disabled selected>-Select Type-</option>
                                      <option value="1">MANUAL</option>
                                      <option value="2">NORMAL</option>
                                      <option value="3">RESEND</option>
                                      <Option value="4">LCL</Option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Status</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="" id="">
                                      <option value="" disabled selected>-select status-</option>
                                      <option value="1">ALL</option>
                                      <option value="2">UNCONFIRM</option>
                                      <option value="3">HOLD</option>
                                      <option value="4">CONFIRMED RECEIPT</option>
                                      <option value="5">CONFIRMED REJECTED</option>
                                      <option value="6">NO DETAIL</option>   
                                    </select>

                                  </div>
                                </td>
                              </tr>
                              <tr>
                                  <td></td>
                                  <td> <label>
                                    <input type="checkbox" class="filled-in " checked="checked" />
                                 <span><b>Not Include Manifest AS</b></span>
                                 </label></td>
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
