@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary WH Transporter Report</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary WH Transporter Report</li>
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
                                    <td width="20%">Destination City Header</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="" required>
                                     </div></td>
                                 </tr>
                                 <tr>
                                    <td width="20%">Transporter</td>
                                    <td><div class="input-field col s12">
                                       <input id="" type="text" class="validate" name="" required>
                                     </div></td>
                                 </tr>
                                 <tr>
                                    <td width="20%">Periode</td>
                                    <td><div class="col s9 m10">
                                        <input placeholder="" id="first_name" type="text" class="validate datepicker" required>
                                      </div></td>
                                 </tr>
                               </table>
                               <div class="input-field col s12">
                               <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Submit</button>
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
