<form class="form-table" id="form-user-mobile">
    <table>
        <tr>
            <td>User</td>
            <td>
                <div class="input-field col s12">
                    <input id="user" type="text" class="validate" name="userid" value="{{old('userid', !empty($userMobile) ? $userMobile->userid : '')}}" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>Roles</td>
            <td>
                <div class="input-field col s12">
                    <select name="roles" required>
                        <option value="" disabled {{empty($userMobile) ? 'selected' : ''}}>-- Select Roles --</option>
                        <option value="1"{{!empty($userMobile) && $userMobile->roles == 1 ? 'selected' : ''}}>Admin</option>
                        <option value="2"{{!empty($userMobile) && $userMobile->roles == 2 ? 'selected' : ''}}>User</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>Active</td>
            <td>
                <div class="input-field col s12 mt-2">
                    <p>
                    <label>
                      <input type="checkbox" class="filled-in" name="status_active" {{!empty($userMobile) && $userMobile->status_active ? 'checked' : ''}} />
                      <span></span>
                    </label>
                  </p>
                </div>
            </td>
        </tr>
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('master-user-mobile')) !!}
</form>