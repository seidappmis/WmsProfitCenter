@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Create Tag</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Take Create Tag</li>
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
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Input Manual Tag</div>
                          <div class="collapsible-body">
                            <form class="form-table" id="form-input-manual-tag">
                              <input type="hidden" name="sto_id" value="{{$schedule->sto_id}}">
                              <table>
                                <tr>
                                  <td width="30%">Model</td>
                                  <td>
                                    <div class="input-field col s12">
                                      <input type="hidden" name="model">
                                      <select name="model_id" required="" class="select2-data-ajax browser-default">
                                        <option value=""></option>
                                      </select>
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="30%">Location</td>
                                  <td>
                                    <div class="input-field col s12">
                                      <select name="location" required="" class="select2-data-ajax browser-default">
                                        <option value=""></option>
                                      </select>
                                    </div>
                                  </td>
                                </tr>
                                
                                
                              </table>
                              <div class="row">
                                <div class="input-field col s12">
                                  {!! get_button_save() !!}
                                  {!! get_button_cancel(url('stock-take-create-tag')) !!}
                                </div>
                              </div>
                            </form>
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

@push('script_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
 	$('.collapsible').collapsible({
        accordion:true
    });

  jQuery(document).ready(function($) {
    $('#form-input-manual-tag [name="model_id"]').select2({
      placeholder: '-- Select Model --',
      ajax: get_select2_ajax_options('/stock-take-create-tag/select2-model?sto_id={{$schedule->sto_id}}')
    })

    $('#form-input-manual-tag [name="model_id"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0];
      $('#form-input-manual-tag [name="model"]').val(data.model_name);
    });

    $('#form-input-manual-tag [name="location"]').select2({
      placeholder: '-- Select Location --',
      ajax: get_select2_ajax_options('/stock-take-create-tag/select2-location?sto_id={{$schedule->sto_id}}')
    })

    $('#form-input-manual-tag').validate({
      submitHandler: function(form){
        setLoading(true)
        $.ajax({
          url: '{{url('stock-take-create-tag/create')}}',
          type: 'POST',
          dataType: 'json',
          data: $(form).serialize(),
        })
        .done(function(result) {
          if (result.status) {
            showSwalAutoClose('Success', result.message)
            setTimeout(function() {
              window.location.href = '{{url("stock-take-create-tag")}}' + '?sto_id=' + result.data.sto_id
            }, 1000);
          } else {
            setLoading(false)
          }
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
      }
    })
  });
</script>
@endpush