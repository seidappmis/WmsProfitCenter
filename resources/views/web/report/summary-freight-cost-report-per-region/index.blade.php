@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Report Per Region</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Report Per Region</li>
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
                                <td>Periode</td>
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
                                <td>Region</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="" id="">
                                      <option value="" disabled selected>-All-</option>
                                      <option value="1">JABODETABEK</option>
                                      <option value="2">JAWA</option>
                                      <option value="3">KALIMANTAN</option>
                                      <option value="4">SULAWESI</option>
                                      <option value="5">SUMATRA</option> 
                                    </select>

                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Branch</td>
                                <td>
                                    <div class="input-field col s5">
                                      <select>
                                        <option value="" disabled selected>-All-</option>
                                        <option value="1">BDG</option>
                                        <option value="2">BGR</option>
                                        <option value="3">BJR</option>
                                        <option value="4">BTM</option>
                                        <option value="5">CRB</option>
                                        <option value="6">DPS</option>
                                        <option value="7">HQ</option>
                                        <option value="8">HUB</option>
                                      </select>
                                    </div>
                                  </td>
                              </tr>
                              <tr >
                                <td>Sales Code</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select>
                                      <option value="" disabled selected>-All-</option>
                                      <option value="1">BR</option>
                                      <option value="2">DS</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              
                              <tr >
                                <td>Destinations</td>
                                <td>
                                  <div class="input-field col s5">
                                    <select>
                                      <option value="" disabled selected>-All-</option>
                                      <option value="1">AMBON</option>
                                      <option value="2">BALIKPAPAPAN</option>
                                      <option value="3">BANDUNG</option>
                                      <option value="4">BANAJARMASIN</option>
                                      <option value="5">BANYUWANINGI</option>
                                      <option value="6">BATAM</option>
                                      <option value="7">BAUBAU</option>
                                      <option value="8">BATAM</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                             
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Print</button>
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
