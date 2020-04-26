@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>User Manager</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Manager</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Edit User</h4>
                        <form class="form-table">
                        	<table id="data-table-simple">
                        		<tr>
                        			<td>USERNAME</td>
                        			<td>
                        				<div class="input-field col s12">
											<input id="uname" type="text" class="validate" value="13wmsadm1">
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>FIRST NAME</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="first" type="text" class="validate" value="Admin">
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>LAST NAME</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="last" type="text" class="validate" value="PNP Bandung 1">
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>ROLES</td>
                        			<td>
                        				<div class="input-field col s12">
										    <select>
										        <option value="" disabled>-- Select Roles--</option>
										        <option value="1">admincheck</option>
										        <option value="2">allocation</option>
										        <option value="3" selected>Transporter</option>
										    </select>
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>PASSWORD</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="pass" type="text" class="validate" name="pass">
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>CONFIRM PASSWORD</td>
                        			<td>
                        				<div class="input-field col s12">
										    <input id="cpass" type="text" class="validate" name="cpass">
										</div>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td>AREA</td>
                        			<td>
                        				<div class="input-field col s12">
										    <select>
										        <option value="" disabled>-- Select Area --</option>
										        <option value="1" selected>All</option>
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
										    <select>
										        <option value="" disabled>-- Select Branch --</option>
										        <option value="1">[HYP]PT. SEID HQ JKT</option>
										        <option value="2">[JKT]PT. SEID CAB. JAKARTA</option>
										        <option value="3"  selected>[BDG]PT. SEID CAB. BANDUNG</option>
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
										      <input type="checkbox" class="filled-in" checked="checked" />
										      <span></span>
										    </label>
										  </p>
										</div>
                        			</td>
                        		</tr>
                                <tr>
                                    <td width="50%">
                                        LIST GRANT BRANCH
                                        <table>
                                        <tr>
                                            <td width=25%">Branch Name : </td>
                                            <td>
                                               <div class="input-field col s12">
                                                <select>
                                                    <option value="" disabled  selected>-- Select Branch --</option>
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
                        	</table>
							{!! get_button_save('Update') !!}
                            {!! get_button_cancel(url('user-manager')) !!}
						</form>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
 	$('#data-table-simple').on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        text: "Delete the Branch PT. SEID CAB. BANDUNG?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
          $(".btn-delete").closest("tr").remove();
          swal("Good job!", "You clicked the button!", "success") // alert success
          //datatable memunculkan no data available in table
        }
      })
    });
</script>
@endpush