@if(!empty($manifestHeader) && !$manifestHeader->have_lcl)
@push('page-modal')
<div id="modal-form-new-lcl" class="modal" style="">
    <div class="modal-content">
      <form id="form-new-lcl" class="form-table">
        <input type="hidden" name="driver_register_id" value="{{$lmbHeader->driver_register_id}}">
        <input type="hidden" name="do_manifest_no" value="{{$manifestHeader->do_manifest_no}}">
        <table class="mb-1">
        <tr>
            <td width="18%">Driver Name</td>
            <td width="32%">
                <div class="input-field col s12">
                    <input type="hidden" name="driver_id" value="{{$lmbHeader->driver_id}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="driver_name" 
                        value=""
                        required="" 
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
                        value="{{$lmbHeader->vehicle_number}}"
                        required="" 
                        />
              </div>
            </td>
            <td width="18%">Expedition</td>
            <td width="32%">
                <div class="input-field col s12">
                    <select name="expedition_code" class="select2-data-ajax browser-default" required="">
                    </select>
                    <input type="hidden" name="expedition_name">
              </div>
            </td>
        </tr>
        <tr>
            
            <td width="18%">Vehicle Type</td>
            <td width="32%">
                <div class="input-field col s12">
                    <select name="vehicle_code_type" class="select2-data-ajax browser-default" required="">
                    </select>
              </div>
            </td>
            <td width="18%">Destination</td>
            <td width="32%">
                <div class="input-field col s12">
                    <select name="city_code" class="select2-data-ajax browser-default" required>
                    </select>
                    <input type="hidden" name="city_name" value="">
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
                        value=""
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
                        value=""
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
                        value=""
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
                        value=""
                        />
              </div>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
    </div>
    <div class="modal-footer">
      {!! get_button_save('Save', 'btn-save') !!}
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </form>
  </div>
@endpush

{!! get_button_save('New Manifest LCL', 'btn-new-manifest-lcl mb-1') !!}
@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.btn-new-manifest-lcl').click(function(event) {
            /* Act on the event */
            swal({
                title: "Are you sure want to create Manifest LCL ?",
                icon: 'warning',
                buttons: {
                  cancel: true,
                  delete: 'OK'
                }
              }).then(function (confirm) { // proses confirm
                if (confirm) { // Bila oke post ajax ke url delete nya
                  // Ajax Post Delete
                  $('#modal-form-new-lcl').modal('open')
                  
                }
              })
        });
        set_lcl_select_expedition();
        set_lcl_select_vehicle_type();
        set_lcl_select_ship_to_city();

        $('#form-new-lcl').validate({
            submitHandler: function(form){
                setLoading(true); // Disable Button when ajax post data
                $.ajax({
                  url: '{{ url("manifest-regular/new-manifest-lcl") }}',
                  type: 'POST',
                  data: $(form).serialize(),
                })
                .done(function(result) { // selesai dan berhasil
                  if (result.status) {
                    showSwalAutoClose("Success", "Manifest LCL created.")
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

        $('#form-new-lcl [name="expedition_code"]').change(function(event) {
          /* Act on the event */
          var data = $(this).select2('data')[0]
          set_lcl_select_ship_to_city({expedition_code: $(this).val()})
          set_lcl_select_vehicle_type({expedition_code: $(this).val()})
          set_select2_value('#form-new-lcl [name="city_code"]', '', '')
          set_select2_value('#form-new-lcl [name="vehicle_code_type"]', '', '')
          $('#form-new-lcl [name="expedition_name"]').val(data.text)
      });
    });

    function set_lcl_select_expedition(){
        $('#form-new-lcl [name="expedition_code"]').select2({
            placeholder: '-- Select Expedition --',
            ajax: get_select2_ajax_options('/master-expedition/select2-all-expedition')
      })
    }

    function set_lcl_select_vehicle_type(filter = {expedition_code: ''}) {
        $('#form-new-lcl [name="vehicle_code_type"]').select2({
          placeholder: '-- Select Vehicle --',
          ajax: get_select2_ajax_options('/master-freight-cost/select2-vehicle', filter)
        })
    }

    function set_lcl_select_ship_to_city(filter = {expedition_code: ''}){
        // filter.tambah_ambil_sendiri = true
      $('#form-new-lcl [name="city_code"]').select2({
        placeholder: '-- Select Destination City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', filter)
      })
    }
</script>
@endpush
@endif