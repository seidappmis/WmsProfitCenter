@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Overload Concept or DO</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Overload Concept or DO</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                     <form class="form-table">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s4">
                                        <select name="" id="">
                                          <option value="" disabled selected>-Select Area-</option>
                                          <option value="1">KARAWANG</option>
                                          <option value="2">SURABAYA HUB</option>
                                          <option value="3">SWADAYA</option>
                                           
                                        </select>
    
                                      </div>
                                    </td>
                                  </tr>
                              <tr>
                                <td>Overload Concept Date</td>
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
                            </table>
                            <br>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                            </div>
                            <br>
                         </form>
                   </div>
                </div>
                <div class="card">
                  <div class="card-content p-3">
                      <form class="form-table">
                          <table id="data-table-simple" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>INVOICE</th>
                                    <th>LINE NO</th>
                                    <th>OUTPUT DATE</th>
                                    <th>OUTPUT TIME</th>
                                    <th>DESTINATION NUMBER</th>
                                    <th>VEHICLE CODE TYPE</th>
                                    <th>CARD NO</th>
                                    <th>CONT NO</th>
                                    <th>CHECKIN DATE</th>
                                    <th>CHECKIN TIME</th>
                                    <th>EXPEDITION ID</th>
                                    <th>DELEVERY NO</th>
                                    <th>DELEVERY ITEMS</th>
                                    <th>MODEL</th>
                                    <th>QUANTITY</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                               
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              </tbody>
                          </table>
                      </form>
                   </div>
               </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection
