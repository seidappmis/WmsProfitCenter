@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m5 l5">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report Concept Coming vs Actual Loading</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report Concept Coming vs Actual Loading</li>
                </ol>
            </div>
            <div class="col s12 m4 l4">
                <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>ALL</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
                <!-- end search -->
            </div>
            <div class="col s12 m3 l3">
                <!---- Search ----->
                <div class="app-wrapper">
                    {{-- <div class="datatable-search"> --}}
                    <div class="col s9 m10">
                        <input placeholder="-Period-" id="first_name" type="text" class="validate datepicker" readonly>
                      </div>
                    {{-- </div> --}}
                </div>
                <!-- end search -->
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection
