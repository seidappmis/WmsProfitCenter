@if(!empty($manifestHeader) && $manifestHeader->status_complete)
{!! get_button_save('Resend', 'btn-resend mb-1') !!}
@endif

@push('page-modal')
<div id="modal-form-resend" class="modal" style="">
    <div class="modal-content">
      <form id="form-resend" class="form-table">
        <input type="hidden" name="driver_register_id" value="{{$lmbHeader->driver_register_id}}">
        <input type="hidden" name="do_manifest_no" value="{{$manifestHeader->do_manifest_no}}">
        <table class="mb-1">
        <tr>
            <td width="18%">Change Vehicle</td>
            <td width="32%" colspan="3">
                <div class="input-field col s12">
                    <select name="change_vehicle" class="select2-data-ajax browser-default" required="">
                    </select>
              </div>
            </td>
        </tr>
        <tr>
            <td width="18%">Driver Name</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input type="hidden" name="driver_id" value="{{$manifestHeader->driver_id}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="driver_name" 
                        value="{{$manifestHeader->driver_name}}"
                        required="" 
                        readonly="" 
                        />
              </div>
            </td>
            <td width="18%">Manifest Date</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_date" 
                        value="{{date('Y-m-d')}}"
                        readonly 
                        required="" 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="18%">Vehicle No.</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_number" 
                        value="{{$manifestHeader->vehicle_number}}"
                        required="" 
                        readonly="" 
                        />
              </div>
            </td>
            <td width="18%">Expedition</td>
            <td width="32%">
                <div class="input-field col s12">
                  <input type="hidden" name="expedition_code" value="{{$manifestHeader->expedition_code}}">
                    <input type="text" class="validate"  name="expedition_name" value="{{$manifestHeader->expedition_name}}" readonly="" required="">
              </div>
            </td>
        </tr>
        <tr>
            
            <td width="18%">Vehicle Type</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input type="hidden" name="vehicle_code_type" value="{{$manifestHeader->vehicle_code_type}}">
                    <input type="text" name="vehicle_description" value="{{ $manifestHeader->vehicle_description }}" readonly="" required="">
              </div>
            </td>
            <td width="18%">Destination</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input type="hidden" name="city_code" value="{{$manifestHeader->city_code}}" required="" readonly="">
                    <input type="text" name="city_name" value="{{$manifestHeader->city_name}}" required="" readonly="">
              </div>
            </td>
        </tr>
        <tr>
            <td width="18%">Container No.</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="container_no" 
                        value="{{$manifestHeader->container_no}}"
                        />
              </div>
            </td>
            <td width="18%">No. Seal</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="seal_no" 
                        value="{{$manifestHeader->seal_no}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="18%">Checker</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="checker" 
                        value="{{$manifestHeader->checker}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="18%">PDO No.</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="pdo_no" 
                        value="{{$manifestHeader->pdo_no}}"
                        />
              </div>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
    </div>
    <div class="modal-footer">
      {!! get_button_save('Save', 'btn-save-lcl') !!}
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </form>
  </div>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#form-resend [name="change_vehicle"]').select2({
      placeholder: '-- Select Driver --',
      ajax: get_select2_ajax_options('/manifest-regular/select2-resend-driver', {area: '{{$manifestHeader->area}}'})
    })

    $('#form-resend [name="change_vehicle"]').change(function(event) {
      /* Act on the event */
      var data = $(this).select2('data')[0]
      $('#form-resend [name="driver_name"]').val(data.driver_name)
      $('#form-resend [name="vehicle_code_type"]').val(data.vehicle_code_type)
      $('#form-resend [name="vehicle_description"]').val(data.vehicle_description)
      $('#form-resend [name="vehicle_number"]').val(data.vehicle_number)
      $('#form-resend [name="expedition_code"]').val(data.expedition_code)
      $('#form-resend [name="expedition_name"]').val(data.expedition_name)
    });

    $('#form-resend').validate({
      submitHandler: function(form){
        setLoading(true); // Disable Button when ajax post data
          $.ajax({
            url: '{{ url("manifest-regular/resend") }}',
            type: 'POST',
            data: $(form).serialize(),
          })
          .done(function(result) { // selesai dan berhasil
            if (result.status) {
              showSwalAutoClose("Success", "Manifest Resend created.")
                window.location.href = "{{ url('manifest-regular') }}" + '/' + result.data.do_manifest_no + '/edit';
            } else {
                setLoading(false); // Enable Button when failed
              showSwalAutoClose("Warning", result.message)
          }
          })
          .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
              showSwalError(xhr) // Custom function to show error with sweetAlert
          });
      }
    })

    $('.btn-resend').click(function(event) {
        /* Act on the event */
        swal({
            title: "Are you sure want to create Manifest Resend ?",
            icon: 'warning',
            buttons: {
              cancel: true,
              delete: 'OK'
            }
          }).then(function (confirm) { // proses confirm
            if (confirm) { // Bila oke post ajax ke url delete nya
              // Ajax Post Delete
              $('#modal-form-resend').modal('open')
              
            }
          })
    });
  });
</script>
@endpush