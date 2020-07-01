@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Clean Concept</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Clean Concept</li>
                </ol>
            </div>
            <div class="col s12 m3">
                <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter">
                      <option>-Select Area-</option>
                      <option>KARAWANG</option>
                      <option>SURABAYA HUB</option>
                      <option>SWADAYA</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="col s12 m5">
              <div class="display-flex">
                <!---- Search ----->
                <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div>
                <button class="btn btn-large waves-effect waves-light red darken-4 btn-multi-delete-selected-item" type="submit" name="action">
                  Delete
                </button>
              </div>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables"> 
                          <table id="clean-concept-table" class="display" width="100%">
                              <thead>
                                  <tr>
                                    <th data-priority="1" class="datatable-checkbox-cell" width="30px">
                                      <label>
                                          <input type="checkbox" class="select-all" />
                                          <span></span>
                                      </label>
                                    </th>
                                    <th>SHIPMENT NO</th>
                                    <th>DELIVERY NO</th>
                                    <th>CBM</th>
                                    <th>DESTINATION</th>
                                    <th>EXPEDITION NAME</th>
                                    <th>TOTAL DO ITEMS</th>
                                    <th width="50px;"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                        </div>
                        <!-- datatable ends -->
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
  @if (auth()->user()->area != 'All')
    set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
    $('#area_filter').attr('disabled','disabled')
  @endif
  var dttable_clean_concept;
  jQuery(document).ready(function($) {
    dttable_clean_concept = $('#clean-concept-table').DataTable({
      serverSide: true,
      scrollX: true,
      responsive: true,
      ajax: {
          url: '{{ url('clean-concept') }}',
          type: 'GET',
          data: function(d) {
              d.search['value'] = $('#global_filter').val(),
              d.area = $('#area_filter').val()
            }
      },
      order: [2, 'asc'],
      columns: [
          {
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<label><input type="checkbox" name="id[]" value="" class="checkbox"><span></span></label>';
                }
                return data;
            },
            className: "datatable-checkbox-cell"
          },
          // {data: 'DT_RowIndex', orderable:false, searchable: false, className: 'center-align'},
          {data: 'invoice_no', name: 'invoice_no', className: 'detail'},
          {data: 'delivery_no', name: 'delivery_no', className: 'detail'},
          {data: 'cbm', name: 'cbm', className: 'detail'},
          {data: 'destination_name', name: 'tr_destination.destination_description', className: 'detail'},
          {data: 'expedition_name', name: 'expedition_name', className: 'detail'},
          {data: 'delivery_items', name: 'delivery_items', className: 'detail'},
          {data: 'action', className: 'center-align', searchable: false, orderable: false},
      ],
    });

    $('#area_filter').change(function(event) {
      /* Act on the event */
      dttable_clean_concept.ajax.reload(null, false)
    });

    $("input#global_filter").on("keyup click", function () {
      filterGlobal();
    });

    set_datatables_checkbox('#clean-concept-table', dttable_clean_concept)

    $('.btn-multi-delete-selected-item').click(function(event) {
      /* Act on the event */
      swal({
        title: "Are you sure?",
        text: "Are you sure clean selected Concept?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        var data_concept = [];
        dttable_clean_concept.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dttable_clean_concept.row(row).data();
            data_concept.push(row_data);
           }
        });
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('clean-concept/multi-delete-selected-item') }}' ,
            type: 'DELETE',
            data: 'data_concept=' + JSON.stringify(data_concept),
          })
          .done(function() { // Kalau ajax nya success
            swal("Good job!", "You clicked the button!", "success") // alert success
            if ($('thead input[type="checkbox"]', dttable_clean_concept.table().container()).attr("checked")) {
              $('thead input[type="checkbox"]', dttable_clean_concept.table().container()).trigger('click')
            }
            dttable_clean_concept.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });

    dttable_clean_concept.on('click', '.btn-delete', function(event) {
      event.preventDefault();
      var tr = $(this).parent().parent();
      var data = dttable_clean_concept.row(tr).data();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) { // Bila oke post ajax ke url delete nya
          // Ajax Post Delete
          $.ajax({
            url: '{{ url('clean-concept') }}',
            type: 'DELETE',
            data: 'invoice_no=' + data.invoice_no + '&line_no=' + data.line_no
          })
          .done(function() { // Kalau ajax nya success
            swal("Good job!", "You clicked the button!", "success") // alert success
            dttable_clean_concept.ajax.reload(null, false); // reload datatable
          })
          .fail(function() { // Kalau ajax nya gagal
            console.log("error");
          });
          
        }
      })
    });
  });

// Custom search
  function filterGlobal() {
      dttable_clean_concept.search($("#global_filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
  }
</script>
@endpush