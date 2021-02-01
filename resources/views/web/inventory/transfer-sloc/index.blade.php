@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Transfer SLoc</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Transfer SLoc</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                  <div class="card-content p-1">
                    <!-- Sloc From -->
                    <form class="form-table" id="form-transfer-sloc">
                    <ul class="collapsible">
                     <li class="active">
                       <div class="collapsible-header">SLoc From <i class="material-icons"></i></div>
                       <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12">
                              <table>
                                <tr>
                                  <td width="30%">Storage Type</td>
                                  <td><div class="input-field col m6 s12">
                                    <select name="sloc_from_storage_type" class="select2-data-ajax browser-default" required="">
                                    </select>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>Storage Location</td>
                                  <td><div class="input-field m6 col s12">
                                    <select name="sloc_from" class="select2-data-ajax browser-default" required="">
                                    </select>
                                  </div></td>
                                </tr>
                                <tr id="add-model-wrapper" class="hide">
                                  <td colspan="2"><span class="waves-effect waves-light indigo btn-small mt-1 mb-1" id="btn-add-model">Add Model</span></td>
                                </tr>
                                
                                <tr>
                                  <td>Model</td>
                                  <td><div class="input-field m6 col s12">
                                    <select name="model" class="select2-data-ajax browser-default" required disabled="">
                                    </select>
                                    <input type="hidden" name="model_name">
                                    <input type="hidden" name="ean_code">
                                    <input type="hidden" name="cbm">
                                  </div></td>
                                </tr>
                                <tr>
                                  <td>Available QTY</td>
                                  <td><div class="input-field m6 col s12"><input id="prev_quantity" type="text" class="validate " name="prev_quantity" readonly="readonly"></div></td>
                                </tr>
                                <tr>
                                  <td>QTY</td>
                                  <td><div class="input-field m6 col s12"><input id="qty" type="text" class="validate" name="qty" required></div></td>
                                </tr>
                              </table>
                              <table>
                                
                              </table>
                          </div>
                       </div>
                      </div>
                     </li>
                    </ul>
                    <!-- Sloc To -->
                    <ul class="collapsible">
                     <li class="active">
                       <div class="collapsible-header">SLoc To</div>
                       <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12">
                            <table>
                              <tr>
                                <td width="30%">Storage Type</td>
                                <td><div class="input-field col m6 s12">
                                  <select name="sloc_to_storage_type" class="select2-data-ajax browser-default" required="">
                                  </select>
                                </div></td>
                              </tr>
                              <tr>
                                <td>Storage Location</td>
                                <td><div class="input-field m6 col s12">
                                  <select name="sloc_to" class="select2-data-ajax browser-default" required="">
                                  </select>
                                </div></td>
                              </tr>
                            </table>
                           
                          <div class="row">
                            <div class="input-field col s12 m6">
                            @if(auth()->user()->allowTo('edit'))
                              <button type="submit" class="waves-effect waves-light indigo btn">Save</button>
                              @endif
                              <a class="waves-effect waves-light indigo btn" href="{{ url('transfer-sloc') }}">Clear</a>
                            </div>
                          </div>
                          </div>
                        </div>
                       </div>
                     </li>
                    </ul>
                    </form>
                  </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush


@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    setSelect2SlocFromStorageType()
    setSelect2SlocFromStorageLocation()
    setSelect2SlocToStorageType()
    setSelect2SlocToStorageLocation()
    set_select2_model()
    $("#form-transfer-sloc").validate({
      submitHandler: function(form) {
        $.ajax({
          url: '{{ url("transfer-sloc") }}',
          type: 'POST',
          data: $(form).serialize(),
        })
        .done(function() { // selesai dan berhasil
          set_select2_value('#form-transfer-sloc [name="sloc_from"]', '', '')
          set_select2_value('#form-transfer-sloc [name="sloc_to"]', '', '')
          $(form)[0].reset()
          showSwalAutoClose('Success', 'Transfer successfully.')
        })
        .fail(function(xhr) {
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
  });

  function set_select2_model(filter = {sloc: null}){
    $('#form-transfer-sloc [name="model"] option').remove()
    $('#form-transfer-sloc [name="model"]').select2({
       placeholder: '-- Select Model --',
       ajax: get_select2_ajax_options('/master-model/select2-model-sloc', filter)
    });
    $('#form-transfer-sloc [name="model"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-transfer-sloc [name="prev_quantity"]').val(data.quantity_total)
      $('#form-transfer-sloc [name="model_name"]').val(data.model_name)
      $('#form-transfer-sloc [name="ean_code"]').val(data.ean_code)
      $('#form-transfer-sloc [name="cbm"]').val(data.cbm)
    });
  }

  function setSelect2SlocFromStorageType(){
    $('#form-transfer-sloc [name="sloc_from_storage_type"]').select2({
       placeholder: '-- Select Type --',
       ajax: get_select2_ajax_options('/storage-master/select2-sto-type')
    });
    $('#form-transfer-sloc [name="sloc_from_storage_type"]').change(function(event) {
      /* Act on the event */
      setSelect2SlocFromStorageLocation({sloc_type: $(this).val()})
      set_select2_value('#form-transfer-sloc [name="sloc_from"]', '', '')
      set_select2_value('#form-transfer-sloc [name="sloc_to"]', '', '')
    });
  }

  function setSelect2SlocFromStorageLocation(filter = {sloc_type: null}){
    $('#form-transfer-sloc [name="sloc_from"]').select2({
       placeholder: '-- Select Location --',
       ajax: get_select2_ajax_options('/transfer-sloc/select2-storage-location', filter)
    });
    $('#form-transfer-sloc [name="sloc_from"]').change(function(event) {
      /* Act on the event */
      $('#form-transfer-sloc [name="model"]').removeAttr('disabled')
      set_select2_value('#form-transfer-sloc [name="model"]', '', '')
      set_select2_model({sloc: $(this).val()})
      setSelect2SlocToStorageLocation({sloc_type: $('#form-transfer-sloc [name="sloc_to_storage_type"]').val(), sloc_from: $('#form-transfer-sloc [name="sloc_from"]').val()})
    });
  }

  function setSelect2SlocToStorageType(){
    $('#form-transfer-sloc [name="sloc_to_storage_type"]').select2({
       placeholder: '-- Select Type --',
       ajax: get_select2_ajax_options('/storage-master/select2-sto-type')
    });
    $('#form-transfer-sloc [name="sloc_to_storage_type"]').change(function(event) {
      /* Act on the event */
      setSelect2SlocToStorageLocation({sloc_type: $(this).val(), sloc_from: $('#form-transfer-sloc [name="sloc_from"]').val()})
    });
  }

  function setSelect2SlocToStorageLocation(filter = {sloc_type: null}){
    $('#form-transfer-sloc [name="sloc_to"]').select2({
       placeholder: '-- Select Location --',
       ajax: get_select2_ajax_options('/transfer-sloc/select2-storage-location', filter)
    });
  }
</script>
@endpush