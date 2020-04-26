@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Stock Inventory</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Stock Inventory</li>
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
                                       <td>BRANCH</td>
                                       <td>
                                         <div class="input-field col s8">
                                           <select name="" id="" required>
                                             <option value="" disabled selected >[HYP]PT. SEID HG JKT</option>
                                             {{-- <option value="1" >KARAWANG</option>
                                             <option value="2">SURABAYA HUB</option>
                                             <option value="3">SWADAYA</option> --}}
                                              
                                           </select>
       
                                         </div>
                                       </td>
                                     </tr>
                                 </tr>
                                 <tr>
                                    <td>MODEL</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="" >
                                     </div></td>
                                <tr>
                                
                                    <td>STRORAGE LOCATION</td>
                                    <td>
                                      <div class="input-field col s8">
                                        <select name="" id="" required>
                                          <option value="" disabled selected >-Select Storage Location-</option>
                                          <option value="1" >1001</option>
                                          <option value="2">1060</option>
                                          <option value="3">1093</option>
                                          <option value="4">1090</option>
                                           
                                        </select>
    
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>STATUS</td>
                                    <td>
                                      <div class="input-field col s4">
                                        <select name="" id="" required>
                                          <option value="" disabled selected >-All-</option>
                                          <option value="1" >Intransit</option>
                                          
                                           
                                        </select>
    
                                      </div>
                                    </td>
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
