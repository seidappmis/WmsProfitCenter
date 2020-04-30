@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Standby Driver List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Standby Driver List</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
              
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card ">
                <div class="card-content">
                    <form class="form-table">
                        <table>
                          <tr>
                            <td>Area</td>
                            <td>
                              <div class="input-field col s12">
                                <select class="select2 browser-default">
                                  <option>- Select Area -</option>
                                  <option>ALL</option>
                                  <option>KARAWANG</option>
                                  <option>SURABAYA HUB</option>
                                  <option>SWADAYA</option>
                                  
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
                        <table id="data-table-simple" class="display centered" width="100%">
                            <thead class="grey centered ">
                                <tr>
                                  <th>NO</th>
                                  <th>VEHICLE NUMBER</th>
                                  <th>DRIVER ID</th>
                                  <th>DRIVER NAME</th>
                                  <th>VEHICLE DESCRIPTION</th>
                                 
                                  
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>DK 8578 YG</td>
                                <td>PNP-19-062</td>
                                <td>I NENGAH PARDI</td>
                                <td>Tronton 8M capacty 40 -55 cbm</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>H 1792 DP</td>
                                <td>PNP-17-144</td>
                                <td>RANGO</td>
                                <td>Tronton 12 M capacty 70 -80 cbm</td>
                              </tr>
                            </tbody>
                        </table>
                        <br>
                       
                      </div>
                </div>
            </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection
