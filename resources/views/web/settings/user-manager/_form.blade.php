<form class="form-table" id="form-user-manager">
    <table>
        <tr>
            <td>USERNAME</td>
            <td>
                <div class="input-field col s12">
                    <input id="username" type="text" class="validate" name="username" value="{{!empty($user) ? $user->username : ''}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>FIRST NAME</td>
            <td>
                <div class="input-field col s12">
                    <input id="first_name" type="text" class="validate" name="first_name" value="{{!empty($user) ? $user->first_name : ''}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>LAST NAME</td>
            <td>
                <div class="input-field col s12">
                    <input id="last_name" type="text" class="validate" name="last_name" value="{{!empty($user) ? $user->last_name : ''}}">
                </div>
            </td>
        </tr>
        <tr>
            <td>ROLES</td>
            <td>
                <div class="input-field col s12">
                    <select name="roles_id" class="select2-data-ajax browser-default">
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>PASSWORD</td>
            <td>
                <div class="input-field col s12">
                    <input id="password" type="password" class="validate" name="password">
                </div>
            </td>
        </tr>
        <tr>
            <td>CONFIRM PASSWORD</td>
            <td>
                <div class="input-field col s12">
                    <input id="cpassword" type="password" class="validate" name="confirm_password">
                </div>
            </td>
        </tr>
        <tr>
            <td>AREA</td>
            <td>
                <div class="input-field col s12">
                    <select name="area" class="select2-data-ajax browser-default ">
                        
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>CABANG</td>
            <td>
                <div class="input-field col s12">
                    <select name="kode_customer" class="select2-data-ajax browser-default ">
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>ACTIVE</td>
            <td>
                <div class="input-field col s12 mt-2">
                    <p>
                        <label>
                            <input name="status" type="checkbox" class="filled-in" {{!empty($user) && $user->status ? 'checked' : ''}} />
                            <span></span>
                        </label>
                    </p>
                </div>
            </td>
        </tr>
        @if(!empty($user))
        <tr>
            <td width="50%">
                LIST GRANT BRANCH
                <table>
                    <tr>
                        <td width="25%">Branch Name : </td>
                        <td>
                            <div class="input-field col s12">
                                <select id="select-cabang" class="select2-data-ajax browser-default">
                                   {{--  <option value="" disabled selected>-- Select Branch --</option>
                                    <option value="1">[HYP]PT. SEID HQ JKT</option>
                                    <option value="2">[JKT]PT. SEID CAB. JAKARTA</option>
                                    <option value="3">[BDG]PT. SEID CAB. BANDUNG</option> --}}
                                </select>
                            </div>
                        </td>
                        <td width="30px">
                            <a class="waves-effect waves-light indigo btn-small" id="btn-add-branch"><i class="material-icons">add</i></a>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table id="table-grant-cabang" class="mt-2 mb-2">
                    <thead>
                        <tr>
                            <td bgcolor="#344b68" class="white-text" width="50px">NO.</td>
                            <td bgcolor="#344b68" class="center-align white-text">BRANCH</td>
                            <td bgcolor="#344b68"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($user))
                            @foreach($user->grantCabangs AS $key => $grant_cabang)
                            <tr>
                                <td>
                                  <input type="hidden" name="kode_cabang_grant" value="{{$grant_cabang->kode_cabang_grant}}">
                                  <span class="row-number">{{$key+1}}.</span>
                                </td>
                                <td><span class="branch-description">{{$grant_cabang->cabang->long_description}}</span></td>
                                <td width="50px">{!! get_button_delete() !!}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    {{-- <tr>
                        <td width="30px">1</td>
                        <td>PT. SEID CAB. BANDUNG</td>
                        <td width="50px">{!! get_button_delete() !!}</td>
                    </tr> --}}
                </table>
            </td>
        </tr>
        @endif
    </table>
    {!! get_button_save('Save', 'btn-save mt-2') !!}
    {!! get_button_cancel(url('user-manager'), 'Cancel', 'mt-2') !!}
</form>

@push('script_js')
<script type="text/javascript">

   jQuery(document).ready(function($) {
      // Loading region data
      $('#form-user-manager [name="kode_customer"]').select2({
         placeholder: '-- Select Branch--',
         ajax: get_select2_ajax_options('/master-cabang/select2-all-cabang')
      });
      $('#form-user-manager [name="roles_id"]').select2({
         placeholder: '-- Select Role --',
         ajax: get_select2_ajax_options('/user-roles/select2-roles')
      });
      $('#form-user-manager [name="area"]').select2({
         placeholder: '-- Select Area --',
         ajax: get_select2_ajax_options('/master-area/select2-areas-all')
      });
      $('#select-cabang').select2({
         placeholder: '-- Select Branch --',
         ajax: get_select2_ajax_options('/user-manager/select2-all-cabang', {user_id: "{{!empty($user) ? $user->username : ''}}"})
      });
      @if(!empty($user))
      $('#btn-add-branch').click(function(event) {
          /* Act on the event */
          var selected_branch = $('#select-cabang').select2('data')[0]
          $.ajax({
              url: '/user-manager/{{$user->id}}/grant-cabang',
              type: 'POST',
              dataType: 'json',
              data: {kode_cabang_grant: selected_branch.id},
          })
          .done(function(result) {
              set_select2_value('#select-cabang', '', '');

              if (result.status) {
                var row = '';
                row += '<tr>';
                row += '<td>';
                row += '<input type="hidden" name="kode_cabang_grant" value="' + result.data.kode_cabang_grant + '">';
                row += '<span class="row-number"></span>';
                row += '</td>';
                row += '<td><span class="branch-description">' + result.data.cabang.long_description + '</span></td>';
                row += '<td>{!! get_button_delete() !!}</td>';
                row += '</tr>';

                $('#table-grant-cabang tbody').append(row)

                // Urutkan Nomor Tabel
                $('#table-grant-cabang tbody tr').each(function(index, el) {
                    $(this).find('.row-number').text((index + 1) + '.');
                });
              }
          })
          .fail(function() {
              console.log("error");
          });
      });

      $('#table-grant-cabang').on('click', '.btn-delete', function(event) {
        event.preventDefault();
        /* Act on the event */
        var tr = $(this).parent().parent();
        var branch_description = tr.find('.branch-description').text();
        var kode_cabang_grant = tr.find('[name="kode_cabang_grant"]').val();
        // Ask user confirmation to delete the data.
          swal({
            text: "Delete the Grant Branch " + branch_description + "?",
            icon: 'warning',
            buttons: {
              cancel: true,
              delete: 'Yes, Delete It'
            }
          }).then(function (confirm) { // proses confirm
            if (confirm) { // if CONFIRMED send DELETE Request to endpoint
              $.ajax({
                url: '{{ url('user-manager') }}' + '/{{$user->id}}/grant-cabang/' + kode_cabang_grant,
                type: 'DELETE',
                dataType: 'json',
              })
              .done(function() {
                tr.remove();
                // Urutkan Nomor Tabel
                $('#table-grant-cabang tbody tr').each(function(index, el) {
                    $(this).find('.row-number').text((index + 1) + '.');
                });
              })
              .fail(function() {
                console.log("error");
              });
            }
          })
      });
      @endif
   });
</script>
@endpush
