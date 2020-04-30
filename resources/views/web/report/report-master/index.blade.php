@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Master</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Master</li>
                </ol>
            </div>
        
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card large">
                    <div class="card-content">
                        <form class="form-table">
                            <table>
                              <tr>
                                <td>Report Master</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select class="select2 browser-default">
                                      <option>- Select Master -</option>
                                      <option>Master Cabang</option>
                                      <option>Master Destination</option>
                                      <option>Master Destination</option>
                                      <option>Master Driver</option>
                                      <option>Master Expedition</option>
                                      <option>Master Gate</option>
                                      <option>Master Vehicle</option>
                                      <option>Master Vehicle</option>
                                      <option>Master Vendor</option>
                                      <option>Master Model</option>
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                            </div>
                          </form>
                          <br><br><br>
                          <div class="section-data-tables"> 
                            <table id="data-table-simple" class="display" width="100%">
                                <thead>
                                    <tr>
                                      <th>KODE CUSTOMER</th>
                                      <th>KODE CABANG</th>
                                      <th>SORT DESTINATION</th>
                                      <th>LONG DESTINATION</th>
                                      <th>TYPE</th>
                                      <th>REGION</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                  <td>1000000</td>
                                  <td>10</td>
                                  <td>HYP</td>
                                  <td>PY.HEID HQ JKT</td>
                                  <td>BR</td>
                                  <td>JABODETABEK</td>
                                </tbody>
                            </table>
                          </div>
                          
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

