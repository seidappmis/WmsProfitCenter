@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>User Roles</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Roles</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-1">
                      <div class="row">
                        <div class="input-field col s12">
                          <input id="rname" type="text" class="validate" name="rname" required>
                            <label for="rname">Roles Name</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 mb-2">
                          <label><input class="filled-in" type="checkbox" onClick="toggle(this)" /><span>Check All</span></label>
                        </div>
                      </div>
                      <br>
                        <div class="section-data-tables"> 
                          <table id="data-table-simple" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th>Menu Name</th>
                                    <th width="100px;">View</th>
                                    <th width="100px;">Modify</th>
                                    <th width="100px;">Delete</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <!-- DASHBOARD -->
                                <tr class="group">
                                  <td colspan="10">DASHBOARD</td>
                                </tr>
                                <tr>
                                <td>Graphic Dashboard</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo" /><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo" /><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo" /><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Graphic Dashboard 2</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Trucking Monitor</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- GROUPNAME -->
                                <tr class="group">
                                  <td colspan="10">GROUPNAME</td>
                                </tr>
                                <tr>
                                <td>ModulName</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                               <!-- INCOMING -->
                                <tr class="group">
                                  <td colspan="10">INCOMING</td>
                                </tr>
                                <tr>
                                <td>Finish Good Production</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Incoming Import/OEM</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>TConform Manifest</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- INVENTORY -->
                                <tr class="group">
                                  <td colspan="10">INVENTORY</td>
                                </tr>
                                <tr>
                                <td>Storage Inventory Monitoring</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Upload Inventory Storage</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Adjust Inventory Movement</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- INVOICING -->
                                <tr class="group">
                                  <td colspan="10">INVOICING</td>
                                </tr>
                                <tr>
                                <td>List Of Unconfirm DO</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Receipt Invoice</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Receipt Invoice Accounting</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- Master Data -->
                                <tr class="group">
                                  <td colspan="10">MASTER DATA</td>
                                </tr>
                                <tr>
                                <td>Master Gate</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Master Destination</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Master Vehicle</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- OTHERS -->
                                <tr class="group">
                                  <td colspan="10">OTHERS</td>
                                </tr>
                                <tr>
                                <td>Clean Concept</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- OUTGOING -->
                                <tr class="group">
                                  <td colspan="10">OUTGOING</td>
                                </tr>
                                <tr>
                                <td>Upload Concept</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>IDCard Scan</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Assign Vehicles</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- PICKING -->
                                <tr class="group">
                                  <td colspan="10">PICKING</td>
                                </tr>
                                <tr>
                                <td>Upload DO for Picking</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Picking List</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Picking to LMB</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- REPORTS -->
                                <tr class="group">
                                  <td colspan="10">REPORTS</td>
                                </tr>
                                <tr>
                                <td>Report Master Users</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Report Master</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Standby</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- RETURN -->
                                <tr class="group">
                                  <td colspan="10">RETURN</td>
                                </tr>
                                <tr>
                                <td>Task Notice</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>List Of SO</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- SETTING -->
                                <tr class="group">
                                  <td colspan="10">SETTING</td>
                                </tr>
                                <tr>
                                <td>User Manager</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>User Roles</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Master Area</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <!-- STOCK TAKE -->
                                <tr class="group">
                                  <td colspan="10">STOCK TAKE</td>
                                </tr>
                                <tr>
                                <td>Stock Take Schedule</td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                  <td>Stock Take Create Tag</td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                  <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                                <tr>
                                    <td>Stock Take Input 1</td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                    <td><label><input type="checkbox" class="filled-in" name="foo"/><span></span></label></td>
                                </tr>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
                        <br>
                        <div class="row">
                          <div class="input-field col s12">
                            {!! get_button_save() !!}
                            {!! get_button_cancel(url('user-roles')) !!}
                          </div>
                      </div>
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
  // Checkbox
  function toggle(source) {
     checkboxes = document.getElementsByName("foo");
     for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
     }
  }
  // var table = $('#data-table-simple').DataTable({
  //   "responsive": true,
  // });
</script>
@endpush
