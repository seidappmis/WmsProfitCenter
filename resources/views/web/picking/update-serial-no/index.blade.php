@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Update Serial No</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Update Serial No</li>
                </ol>
            </div>

        </div>
    @endcomponent

    <div class="row">
        <div class="col s12">
          <div class="container">
              <div class="section">
                  <div class="card">
                      <div class="card-content p-0">
                        <ul class="collapsible m-0">
                          <li class="active">
                            <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Upload Serial Number for Update</div>
                            <div class="collapsible-body">
                              @include('web.picking.update-serial-no._upload_serial_number')
                              {{-- @include('web.picking.picking-to-lmb._picking_list') --}}
                              {{-- @include('web.picking.picking-to-lmb._picking_to_lmb') --}}
                            </div>
                          </li>
                        </ul>
                      </div>
                  </div>
              </div>
              </div>
          </div>
    </div>
</div>
@endsection
