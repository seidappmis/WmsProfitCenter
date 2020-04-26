@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report User Mobile</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report User Mobile</li>
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
                                       <td>Cabang</td>
                                       <td>
                                         <div class="input-field col s4">
                                           <select name="" id="">
                                             
                                             <option value="1">PT. SEID HG JKT</option>
                                             <option value="2">PT. SEID CAB. JAKARTA</option>
                                             <option value="3">PT. SEID CAB. SAMARINDA</option>
                                             <option value="3">PT. SEID CAB. MANADO</option>
                                             <option value="3">PT. SEID CAB. KARAWANG</option>
                                             <option value="3">PT. SEID CAB. HG</option>
                                             <option value="3">PT. SEID CAB. BATAM</option>
                                  
                                           </select>
       
                                         </div>
                                       </td>
                                     </tr>
                                     <tr>
                                        <td>User Role</td>
                                        <td>
                                          <div class="input-field col s4">
                                            <select name="" id="">
                                              <option value="" disabled selected>-All-</option>
                                              <option value="1">Admin</option>
                                              <option value="2">User</option>
                                              
                                               
                                            </select>
        
                                          </div>
                                        </td>
                                      </tr><tr>
                                        <td>User Status</td>
                                        <td>
                                          <div class="input-field col s4">
                                            <select name="" id="">
                                              <option value="" disabled selected>-All-</option>
                                              <option value="1">Not Active</option>
                                              <option value="2">Active</option>
                                            </select>
        
                                          </div>
                                        </td>
                                      </tr>
                                  
                                  
                                 
                               </table>
                               <br>
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
