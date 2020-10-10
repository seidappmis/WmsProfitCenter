
@include('web.outgoing.manifest-regular._form_new_lcl')
@include('web.outgoing.manifest-regular._form_resend')

<form class="form-table" id="form-manifest">
    <input type="hidden" name="driver_register_id" value="{{$lmbHeader->driver_register_id}}">
    <table class="mb-1">
        <tr>
            <td width="20%">Manifest No.</td>
            <td width="30%">
                <div class="input-field col s8">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_no" 
                        value="{{!empty($manifestHeader) ? $manifestHeader->do_manifest_no : ''}}"
                        readonly 
                        />
              </div>
              <div class="col s4 mt-3">{{!empty($manifestHeader) ? $manifestHeader->manifest_type : ''}}</div>
            </td>
            <td width="20%">Manifest Date</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="do_manifest_date" 
                        value="{{date('Y-m-d')}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Vehicle No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_number" 
                        value="{{$lmbHeader->vehicle_number}}"
                        readonly 
                        required="" 
                        />
              </div>
            </td>
            <td width="20%">Expedition</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input type="hidden" name="expedition_code" value="{{$lmbHeader->expedition_code}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="expedition_name" 
                        value="{{$lmbHeader->expedition_name}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Driver Name</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input type="hidden" name="driver_id" value="{{!empty($manifestHeader) ? $manifestHeader->driver_id : $lmbHeader->driver_id}}">
                    <input 
                        type="text" 
                        class="validate" 
                        name="driver_name" 
                        value="{{!empty($manifestHeader) ? $manifestHeader->driver_name : $lmbHeader->driver_name}}"
                        readonly 
                        />
              </div>
            </td>
            <td width="20%">Vehicle Type</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="hidden" 
                        class="validate" 
                        name="vehicle_code_type" 
                        value="{{$lmbHeader->picking->vehicle_code_type}}"
                        readonly 
                        />
                        <input 
                        type="text" 
                        class="validate" 
                        name="vehicle_description" 
                        value="{{$lmbHeader->picking->vehicle->vehicle_description}}"
                        readonly 
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">Destination City</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="hidden" 
                        class="validate" 
                        name="destination_number_driver" 
                        value="{{$lmbHeader->destination_number}}"
                        readonly 
                        />
                    <input 
                        type="text" 
                        class="validate" 
                        name="destination_name_driver" 
                        value="{{$lmbHeader->destination_name}}"
                        readonly 
                        />
                    <select name="city_code" class="select2-data-ajax browser-default" required>
                    </select>
                    <input type="hidden" name="city_name" value="{{ !empty($pickinglistHeader->city_name) ? $pickinglistHeader->city_name : '' }}">
              </div>
            </td>
            <td width="20%">Container No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="container_no" 
                        value="{{$lmbHeader->container_no}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">No. Seal</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="seal_no" 
                        value="{{$lmbHeader->seal_no}}"
                        />
              </div>
            </td>
            <td width="20%">Checker</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="checker" 
                        value="{{!empty($manifestHeader->checker) ? $manifestHeader->checker : ''}}"
                        />
              </div>
            </td>
        </tr>
        <tr>
            <td width="20%">PDO No.</td>
            <td width="30%">
                <div class="input-field col s12">
                    <input 
                        type="text" 
                        class="validate" 
                        name="pdo_no" 
                        value="{{!empty($manifestHeader->pdo_no) ? $manifestHeader->pdo_no : ''}}"
                        />
              </div>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
    {!! get_button_save('Save', 'btn-save') !!}
    {!! get_button_delete('Delete', 'btn-delete-manifest') !!}
    {!! get_button_print() !!}
    {!! get_button_cancel(url('manifest-regular'), 'Back', '') !!}
</form>

@if(!empty($rsManifest) && $rsManifest->count() > 1)
 @php
 $prevLink = '#!';
 $nextLink = '#!';
 $activeFound = 0;
 foreach ($rsManifest as $key => $value) {
     $rsManifest[$key]->linkActive = $value->do_manifest_no == $manifestHeader->do_manifest_no;
     $rsManifest[$key]->url = url('manifest-regular/' . $value->do_manifest_no . '/edit#!');

     if (!$activeFound && $rsManifest[$key]->linkActive) {
         $activeFound = 1;
         $nextLink = !empty($rsManifest[$key + 1]) ? url('manifest-regular/' . $rsManifest[$key + 1]->do_manifest_no . '/edit#!') : '#!' ;
     } elseif (!$activeFound) {
        $prevLink = $rsManifest[$key]->url;
     }
 }
 @endphp
 <ul class="pagination mt-2">
  <li class="{{$prevLink == '#!' ? 'disabled' : 'waves-effect'}}"><a href="{{$prevLink}}"><i class="material-icons">chevron_left</i></a></li>
  @foreach($rsManifest AS $key => $value)
  <li class="{{ $value->linkActive ? 'active' : 'waves-effect' }}">
    <a href="{{ $value->url }}">{{ ($key + 1) }}</a>
  </li>
  @endforeach
  <li class="{{$nextLink == '#!' ? 'disabled' : 'waves-effect'}}"><a href="{{$nextLink}}"><i class="material-icons">chevron_right</i></a></li>
</ul>
@endif

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print Manifest',
  'url' => 'manifest-regular/' .  (!empty($manifestHeader) ? $manifestHeader->do_manifest_no : '') . '/export',
  'trigger' => '.btn-print'
  ])

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#form-manifest [name="city_code"]').select2({
        placeholder: '-- Select Destination City --',
        allowClear: true,
        ajax: get_select2_ajax_options('/master-expedition/select2-expedition-destination-city', {expedition_code: '{{$lmbHeader->expedition_code}}'})
      })

        $('#form-manifest [name="city_code"]').change(function(event) {
            var data = $(this).select2('data')[0];
          $('#form-manifest [name="city_name"]').val(data == undefined ? '' : data.text);
        });

        @if(!empty($manifestHeader))
        @if($manifestHeader->status_complete)
        $('.btn-delete-manifest').addClass('hide')
        @endif
        $('.btn-delete-manifest').click(function(event) {
            /* Act on the event */
            swal({
              text: "Delete Manifest No. {{$manifestHeader->do_manifest_no}}?",
              icon: 'warning',
              buttons: {
                cancel: true,
                delete: 'Yes, Delete It'
              }
            }).then(function (confirm) { // proses confirm
              if (confirm) { // Bila oke post ajax ke url delete nya
                // Ajax Post Delete
                $.ajax({
                  url: '{{url('manifest-regular/'. $manifestHeader->do_manifest_no)}}',
                  type: 'DELETE',
                })
                .done(function(result) { // Kalau ajax nya success
                  showSwalAutoClose('Success', result.message)
                  window.location.href = '{{url("manifest-regular")}}'
                })
                .fail(function() { // Kalau ajax nya gagal
                  console.log("error");
                });

              }
            })
        });
        @endif
    });
</script>
@endpush