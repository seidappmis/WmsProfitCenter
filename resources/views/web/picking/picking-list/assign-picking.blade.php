@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Assign Picking</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('picking-list') }}">Picking List</a></li>
                    <li class="breadcrumb-item active">Assign Picking</li>
                </ol>
            </div>
            <div class="col s12 m2">
              <div class="display-flex">
                @component('layouts.materialize.components.back-button')
                @endcomponent
              </div>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Picking List Item</h4>
                        <p><b class="green-text text-darken-3"> Vehicle No : {{$driverRegistered->vehicle_number}} | {{$driverRegistered->driver_name}}</b></p>
                      <p>Expedition : <b class="green-text text-darken-3">{{$driverRegistered->expedition_code}} | {{$driverRegistered->expedition_name}}</b></p>

                      @include('web.picking.picking-list._find_transporter_picking_no')
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">

</script>
@endpush
