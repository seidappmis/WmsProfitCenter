@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Picking List</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">

            <div class="section">

              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>CREATE / EDIT</div>
                      <div class="collapsible-body padding-1">
                          @include('web.picking.picking-list._form_picking_list')
                          @include('web.picking.picking-list._table_picking_list_detail')
                          @include('web.picking.picking-list._form_assign_item_picking')
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('script_js')
<script type="text/javascript">
 	jQuery(document).ready(function($) {
    set_select2_value('#form-picking-list [name="storage_id"]', '{{$pickinglistHeader->storage_id}}', '{{$pickinglistHeader->storage_type}}')
    $('#form-picking-list [name="storage_id"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="expedition_code"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="city_code"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="vehicle_code_type"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="destination_number"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="driver_id"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="vehicle_number"]').attr('disabled', 'disabled');
    $('#form-picking-list [name="driver_name"]').attr('disabled', 'disabled');
    $('#select-gate-number').attr('disabled', 'disabled');
    @if ($pickinglistHeader->city_code != 'AS')
      set_select2_value('#form-picking-list [name="expedition_code"]', '{{$pickinglistHeader->expedition_code}}', '{{$pickinglistHeader->expedition_name}}')
      set_select2_value('#select-gate-number', '{{$pickinglistHeader->gate_number}}', '{{$pickinglistHeader->gate_number}}')

      @if (!empty($pickinglistHeader->vehicle_code_type))
      set_select2_value('#form-picking-list [name="vehicle_code_type"]', '{{$pickinglistHeader->vehicle_code_type}}', '{{$pickinglistHeader->vehicle->vehicle_description}}')
      @endif
      set_select2_value('#form-picking-list [name="destination_number"]', '{{$pickinglistHeader->destination_number}}', '{{$pickinglistHeader->destination_name}}')

      set_select2_value('#form-picking-list [name="vehicle_number"]', '{{$pickinglistHeader->vehicle_number}}', '{{$pickinglistHeader->vehicle_number}}')
      set_select2_value('#form-picking-list [name="driver_id"]', '{{$pickinglistHeader->driver_id}}', '{{$pickinglistHeader->driver_name}}')
    @endif
    set_select2_value('#form-picking-list [name="city_code"]', '{{$pickinglistHeader->city_code}}', '{{$pickinglistHeader->city_name}}')
  });

</script>
@endpush
