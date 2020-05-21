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
                    <select name="last_name">
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
                    <select name="area">
                        <option value="" disabled selected>-- Select Area --</option>
                        <option value="1">All</option>
                        <option value="2">KARAWANG</option>
                        <option value="3">SURABAYA HUB</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>CABANG</td>
            <td>
                <div class="input-field col s12">
                    <select name="cabang">
                        <option value="" disabled selected>-- Select Branch --</option>
                        <option value="1">[HYP]PT. SEID HQ JKT</option>
                        <option value="2">[JKT]PT. SEID CAB. JAKARTA</option>
                        <option value="3">[JF]PT. SEID CAB. JAKARTA</option>
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
                                <select>
                                    <option value="" disabled selected>-- Select Branch --</option>
                                    <option value="1">[HYP]PT. SEID HQ JKT</option>
                                    <option value="2">[JKT]PT. SEID CAB. JAKARTA</option>
                                    <option value="3">[BDG]PT. SEID CAB. BANDUNG</option>
                                </select>
                            </div>
                        </td>
                        <td width="30px">
                            <a class="waves-effect waves-light indigo btn-small"><i class="material-icons">add</i></a>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%">
                <table id="data-table-simple" class="mt-2 mb-2">
                    <tr>
                        <td bgcolor="#344b68" class="white-text">NO.</td>
                        <td bgcolor="#344b68" class="center-align white-text">BRANCH</td>
                        <td bgcolor="#344b68"></td>
                    </tr>
                    <tr>
                        <td width="30px">1</td>
                        <td>PT. SEID CAB. BANDUNG</td>
                        <td width="50px">{!! get_button_delete() !!}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @endif
    </table>
    {!! get_button_save() !!}
    {!! get_button_cancel(url('user-manager')) !!}
</form>
