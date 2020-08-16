@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Report User Mobile</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Report User Mobile</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <form class="form-table">
                               <table id="" class="display" width="100%">
                                   <tr>
                                       <td>Cabang</td>
                                       <td>
                                         <div class="input-field col s4">
                                           <select name="" id="cabang_filter"class="select2-data-ajax browser-default app-filter" >
                                                                              
                                           </select>
       
                                         </div>
                                       </td>
                                     </tr>
                                     <tr>
                                        <td>User Role</td>
                                        <td>
                                          <div class="input-field col s4">
                                            <select name="" id="role">
                                              <option value="" disabled selected>-All-</option>
                                              <option value="1">Admin</option>
                                              <option value="2">User</option>
                                            </select>
        
                                          </div>
                                        </td>
                                      </tr><tr>
                                        <td>User Status</td>
                                        <td>
                                          <div class="input-field col s4">
                                            <select name="" id="userStatus">
                                              <option value="" disabled selected>-All-</option>
                                              <option value="1">Not Active</option>
                                              <option value="2">Active</option>
                                            </select>
        
                                          </div>
                                        </td>
                                      </tr>
                               </table>
                               <br>
                               <div class="input-field col s12">
                                 <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                               </div>
                            </form>
                      </div>
                </div>
            </div>
            <div class="secion">
              <div class="card">
                <div class="card-conten">
                  <table id="master-user-mobile" width="100%">
                    <thead>
                      <tr><th></th></tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection
@push('script_js')
  <script>
    var table_user_mobile;
    jQuery(document).ready(function($){
      table_user_mobile = $('#master-user-mobile').DataTable({
        serverSide: true,
      scrollX: true,
      dom: 'Brtip',
      // pageLength: 1,
      scrollY: '60vh',
      buttons: [
              {
                  text: 'PDF',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-user-mobile/export?file_type=pdf')}}" + '&cabang=' + $('#cabang_filter').val();
                  }
              },
               {
                  text: 'EXCEL',
                  action: function ( e, dt, node, config ) {
                      window.location.href = "{{url('report-user-mobile/export?file_type=xls')}}" + '&cabang=' + $('#cabang_filter').val();
                  }
              }
          ],
      ajax: {
          url: '{{ url('report-user-mobile') }}',
          type: 'GET',
          data: function(d) {
            d.cabang = $('#cabang_filter').val()
            d.role =$('#role').val()
            d.userStatus =$('#userStatus').val()
            d.search['value'] = $('#report-user-filter').val()
          }
      },
      columns: [
          {data: 'tabeldata', className: 'detail'},
      ]
    });
    $('#cabang_filter').select2({
       placeholder: '-- Select Cabang --',
       allowClear: true,
       ajax: get_select2_ajax_options('/master-cabang/select2-cabang-only')
    });


    })
  </script>
    
@endpush