@extends('layouts.materialize.index')

@section('content')
  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m8 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Graphic Dashboard 2</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Graphic Dashboard 2</li>
              </ol>
          </div>
          <div class="col s12 m4">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent

<div class="row">
    <div class="col s12 m6">
        <div class="">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Daily By Destination</h4>
                        @include('web.dashboard.dashboard2._daily_by_destination_graph')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Daily By Category</h4>
                        @include('web.dashboard.dashboard2._daily_by_category_graph')
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection