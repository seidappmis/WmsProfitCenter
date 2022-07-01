<div class="container">
    <div class="section">
      <div class="card mt-0">
        <div class="card-content p-0">
          <ul class="collapsible m-0">
            <li class="active">
              <div class="collapsible-header p-0">
                <div class="row">
                  <div class="col s12 m8">
                    <div class="collapsible-main-header">
                      <i class="material-icons expand">expand_less</i>
                      <span>Data Manifest AS</span>
                    </div>
                  </div>
                  <div class="col s12 m4">
                    <div class="app-wrapper">
                      <div class="datatable-search mb-0">
                        <i class="material-icons mr-2 search-icon">search</i>
                        <input type="text" placeholder="Search" class="app-filter no-propagation" id="data_manifest_normal_filter">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="collapsible-body p-0">
              {!! get_button_create(url('manifest-as/create'), 'New Ambil Sendiri', ' btn-add ml-1 mt-1 mb-1') !!}
              {{-- <a href="{{ url('manifest-as/create') }}" class="btn btn-sm waves-effect waves-light btn-add ml-1 mt-1 mb-1">New Ambil Sendiri</a> --}}
                <div class="section-data-tables"> 
                  <table id="data_manifest_normal_table" class="display" width="100%">
                    <thead>
                      <tr>
                        <th width="10px">No.</th>
                        <th>Manifest</th>
                        <th>Remarks 1</th>
                        <th>Remarks 2</th>
                        <th>Picking No</th>
                        <th>Status</th>
                        <th width="5px;"></th>
                        <th width="5px;"></th>
                        <th width="5px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
                  <!-- datatable ends -->
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
</div>

@include('layouts.materialize.components.modal-print', [
  'title' => 'Print',
])

@push('script_js')
<script type="text/javascript">
var dtdatatable_data_manifest_normal;

jQuery(document).ready(function($) {
  
  dtdatatable_data_manifest_normal = $('#data_manifest_normal_table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: "{{url('manifest-as')}}",
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#data_manifest_normal_filter').val()
              d.area = $('#area_filter').val()
          }
      },
      order: [1, 'desc'],
      columns: [
          { data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          { data: 'do_manifest_no', name: 'do_manifest_no', className: 'detail' },
          { data: 'seal_no', name: 'seal_no', className: 'detail' },
          { data: 'pdo_no', name: 'pdo_no', className: 'detail' },
          { data: 'picking_no', name: 'picking_no', className: 'detail' },
          { data: 'status', name: 'status', className: 'detail' },
          { data: 'actionEdit', className: 'center-align', orderable: false, searchable: false },
          { data: 'actionDelete', className: 'center-align', orderable: false, searchable: false },
          { data: 'actionPrint', className: 'center-align', orderable: false, searchable: false },
      ]
  });

  dtdatatable_data_manifest_normal.on('click', '.btn-print', function(event) {
    var tr = $(this).parent().parent();
    var data = dtdatatable_data_manifest_normal.row(tr).data();
    initPrintPreviewPrint(
      '{{url("manifest-as")}}' + '/' + data.do_manifest_no + '/export'
    )
  });

  dtdatatable_data_manifest_normal.on('click', '.btn-delete', function(event) {
        var tr = $(this).parent().parent();
        var data = dtdatatable_data_manifest_normal.row(tr).data();
        id = data.do_manifest_no
        event.preventDefault();
        /* Act on the event */
        // Ditanyain dulu usernya mau beneran delete data nya nggak.
        swal({
          text: "Delete this manifest?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, delete It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('manifest-as')}}' + '/' + id,
              type: 'DELETE',
            })
            .done(function(result) { // Kalau ajax nya success
              showSwalAutoClose('Success', result.message)
              dtdatatable_data_manifest_normal.ajax.reload(null, false); // reload datatable
              dtdatatable_truck_waiting_manifest.ajax.reload(null, false); // reload datatable
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
      });

  $("input#data_manifest_normal_filter").on("keyup click", delay(function () {
    filterGlobalDataManifestNormal();
  }, 1500));

});
function delay(fn, ms) {
  let timer = 0;
  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(fn.bind(this, ...args), ms || 0);
  }
}
function filterGlobalDataManifestNormal() {
  dtdatatable_data_manifest_normal.search($("#data_manifest_normal_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
}

</script>
@endpush
