@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m8 l8">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Master Users</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Master Users</li>
                </ol>
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
                          <div><p class="center">Master Users</p></div>
                          <div class="section-data-tables"> 
                            <table id="data-table-simple" class="display centered" width="100%">
                                <thead class="grey centered ">
                                    <tr>
                                      <th>USER ID</th>
                                      <th>USER NAME</th>
                                      <th>AREA</th>
                                      <th>STATUS</th>
                                      <th>LAST UPDATE</th>
                                     
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                  <td>mgt9</td>
                                  <td>Bejo Nugroh </td>
                                  <td>KARAWANG</td>
                                  <td>Enabled</td>
                                  <td>24-08-2018 08:28:35</td>
                                 
                                </tbody>
                            </table>
                            <br>
                            <table id="data-table-simple" class="display centered" width="100%">
                              <thead class="grey">
                                  <tr>
                                    <th colspan="2">MODUL</th>
                                    <th>View</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                    
                                  </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Dashboard</td>
                                  <td>Grapihic Dashboard </td>
                                  <td>NO</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                </tr>
                                <tr>
                                  <td>Dashboard</td>
                                  <td>Grapihic Dashboard 2</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                </tr>
                                <tr>
                                  <td>Dashboard</td>
                                  <td>Trucking Monitor </td>
                                  <td>NO</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                </tr>
                                <tr>
                                  <td>Group Name</td>
                                  <td>ModulName </td>
                                  <td>NO</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                </tr>
                                <tr>
                                  <td>Incoming</td>
                                  <td>Comform Impor </td>
                                  <td>NO</td>
                                  <td>NO</td>
                                  <td>NO</td>
                                </tr>
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
