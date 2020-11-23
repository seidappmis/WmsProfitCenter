@extends('layouts.materialize.index')

@section('content')
<div class="row">


  @component('layouts.materialize.components.title-wrapper')
  <div class="row">
    <div class="col s12 m6">
      <h5 class="breadcrumbs-title mt-0 mb-0"><span>Damage Goods Report</span></h5>
      <ol class="breadcrumbs mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Damage Goods Report</li>
      </ol>
    </div>
  </div>
  @endcomponent

  <div class="col s12">
    <div class="container">
      <div class="section">
        <div class="card mb-0">
          <div class="card-content p-0">
            <ul class="collapsible m-0">
              <li class="active">
                <div class="collapsible-header p-0">
                  <div class="row">
                    <div class="col s12 m8">
                      <div class="collapsible-main-header">
                        <i class="material-icons expand">expand_less</i>
                        <span>Outstanding</span>
                      </div>
                    </div>
                    <div class="col s12 m4">
                      <div class="app-wrapper">
                        <div class="datatable-search mb-0">
                          <i class="material-icons mr-2 search-icon">search</i>
                          <input type="text" placeholder="Search" class="app-filter no-propagation" id="outstanding-search">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="collapsible-body p-0">
                  <div class="section-data-tables">
                    <table id="table-outstanding" class="display" width="100%">
                      <thead>
                        <tr>
                          <th class="center-align" data-priority="1" width="30px"><label><input type="checkbox" class="select-all" /><span></span></label></th>
                          <th class="center-align">Date</th>
                          <th class="center-align">Berita Acara No.</th>
                          <th class="center-align">Invoice No</th>
                          <th class="center-align">B/L No</th>
                          <th class="center-align">Container No</th>
                          <th class="center-align">Vendor</th>
                          <th class="center-align">Model</th>
                          <th class="center-align">POM</th>
                          <th class="center-align">Qty</th>
                          <th class="center-align">NO Serie</th>
                          <th class="center-align">Remark</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </li>
            </ul>

            <button class="btn mt-2 mb-1 ml-1 mr-1 btn-create-dgr" data-type="dgr">Create DGR</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('web.during.damage-goods-report._list_dgr')

  @push('script_js')
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      dtOutstanding = $('#table-outstanding').DataTable({
        paging: false,
        serverSide: true,
        scrollX: true,
        ajax: {
          url: '{{url("/damage-goods-report/list-outstanding")}}',
          type: 'GET',
        },
        order: [1, 'asc'],
        columns: [{
            data: 'id',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
              return '<label><input type="checkbox" name="outstanding[]" value="' + data + '" class="checkbox checkbox-outstanding"><span></span></label>';
            },
            className: "datatable-checkbox-cell"
          },
          {
            data: 'created_at',
            render: function(data, type, row) {
              return moment(data).format('D MMM YYYY');
            }
          },
          {
            data: 'berita_acara_during_no'
          },
          {
            data: 'invoice_no'
          },
          {
            data: 'bl_no'
          },
          {
            data: 'container_no'
          },
          {
            data: 'expedition_name'
          },
          {
            data: 'model_name'
          },
          {
            data: 'pom'
          },
          {
            data: 'qty'
          },
          {
            data: 'serial_number',
            render: function(data, type, row) {
              return data ? data.split(",").join("<br>") : '';
            }
          },
          {
            data: 'damage'
          }
        ]
      });

      set_datatables_checkbox('#table-outstanding', dtOutstanding)

    });

    $("input#outstanding-search").on("keyup click", function() {
      dtOutstanding.search($("#outstanding-search").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
    });

    $('.btn-create-dgr').click(function() {
      var checkedData = $(),
        type = $(this).attr('data-type');
      $('#table-outstanding tbody input[type=checkbox]:checked').each(function() {
        var row = dtOutstanding.row($(this).parents('tr')).data(); // here is the change
        array = generateArray(row, type);
        checkedData.push(array);
      });
      console.log(checkedData.length);
      if (checkedData.length == 0) {
        showSwalAutoClose('Warning', 'Selected data is empty');
        return;
      }

      push(checkedData, type);
    });

    function push(checkedData, type) {
      /* Act on the event */
      setLoading(true);
      $.ajax({
          type: "POST",
          url: '{{ url("/damage-goods-report/create") }}',
          data: {
            data: JSON.stringify(checkedData),
            type: type
          },
          cache: false,
        })
        .done(function(result) {
          if (result.status) {
            swal("Success!", result.message)
              .then((response) => {
                // Kalau klik Ok redirect ke view
                dtOutstanding.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
                dtTableDGR.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
              }) // alert success
          } else {
            setLoading(false);
            showSwalAutoClose('Warning', result.message)
          }
        })
        .fail(function() {
          setLoading(false);
        })
        .always(function() {
          setLoading(false);
        });
    };

    function generateArray(row, type) {
      var array = $();
      array = {
        berita_acara_during_detail_id: row.id,
        berita_acara_during_id: row.berita_acara_during_id,
        berita_acara_during_no: row.berita_acara_during_no,
        description: row.damage,
        qty: row.qty,
        claim: type
      }
      return array;
    }
  </script>
  @endpush


</div>
@endsection