<form class="form-table" id="form-user-roles">
    <table>
        <tr>
            <td>Roles Name</td>
            <td>
                <div class="input-field col s12">
                    <input id="rname" name="roles_name" type="text" class="validate" required="" value="{{!empty($userRole) ? $userRole->roles_name : ''}}">
                </div>
            </td>
        </tr>
    </table>
    <!-- Check All -->
    <div class="row">
        <div class="input-field col s12 mb-2">
            <label><input id="checkbox-check-all" class="filled-in" type="checkbox"/><span>Check All</span></label>
        </div>
    </div>
    <!-- Table Group Dashboard-->
    @foreach($modules as $group_name => $group_modules)
    <div class="col s12 mt-2">
        <table width="100%">
            <tr bgcolor="#344b68">
                <td class="center-align white-text">{{$group_name}}</td>
                <td width="10%" class="center-align white-text">View</td>
                <td width="10%" class="center-align white-text">Modify</td>
                <td width="10%" class="center-align white-text">Delete</td>
            </tr>
            @foreach($group_modules as $key => $module)
            <tr>
                <td>{{$module->modul_name}}</td>
                <td>
                    <div class="input-field col s12 center-align">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" name="view[{{$module->id}}]" {{(!empty($role_details[$module->id]) && $role_details[$module->id]->view) ? 'checked' : ''}} />
                                <span></span>
                            </label>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="input-field col s12 center-align">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" name="edit[{{$module->id}}]" {{(!empty($role_details[$module->id]) && $role_details[$module->id]->edit) ? 'checked' : ''}} />
                                <span></span>
                            </label>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="input-field col s12 center-align">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" name="delete[{{$module->id}}]" {{(!empty($role_details[$module->id]) && $role_details[$module->id]->delete) ? 'checked' : ''}} />
                                <span></span>
                            </label>
                        </p>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endforeach
    {!! get_button_save('Save', 'mt-1') !!}
    {!! get_button_cancel(url('user-roles'), 'Cancel', 'mt-1') !!}
</form>

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#checkbox-check-all').click(function(event) {
            /* Act on the event */
            var check_all = $(this).is(':checked');
            $.each($('#form-user-roles [type="checkbox"]'), function(index, val) {
                 /* iterate through array or object */
                 if (check_all) {
                    if ($(val).is(':checked') != check_all) {
                        $(val).trigger('click');
                    }
                 } else {
                    if ($(val).is(':checked') != check_all) {
                        $(val).trigger('click');
                    }
                }
            });
        });
    });
</script>
@endpush
