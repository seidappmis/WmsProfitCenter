@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Loading Lead Time</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Loading Lead Time</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-loading-lead-time">
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="-Period-" id="first_name" type="text" class="validate datepicker" readonly>
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
                            <table>
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="-Period-" id="first_name" type="text" class="validate datepicker" readonly>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <div class="section-data-tables"> 
                                <table  class="display centered" width="100%">
                                <thead>
                                    <tr>
                                      <th>NO</th>
                                      <th>Vahicle Description</th>
                                      <th>Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>CD 4 BAN (CDE)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>CD 4 BAN (CDE BOX)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>CD 6 BAN (CDD)</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>CON 20</td>
                                        <td><input type="text"></td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection
