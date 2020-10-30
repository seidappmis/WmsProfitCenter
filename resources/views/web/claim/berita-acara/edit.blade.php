@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
  <div class="row">
    <div class="col s12 m6">
      <h5 class="breadcrumbs-title mt-0 mb-0"><span>Berita Acara</span></h5>
      <ol class="breadcrumbs mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item">Berita Acara</li>
        <li class="breadcrumb-item active">Create Berita Acara</li>
      </ol>
    </div>
  </div>
  @endcomponent

  <div class="col s12">
    <div class="container">
      <div class="section">
        <div class="card">
          <div class="card-content">
            <h4 class="card-title">BERITA ACARA</h4>
            <hr>
            @include('web.claim.berita-acara._form_berita_acara')
          </div>
          <div class="card-content">
            <!-- Berita Acara Detail -->
            <h4 class="card-title">Berita Acara Detail</h4>
            <hr>
            <!-- Detail -->
            <div class="card-content p-0">
              <ul class="collapsible">
                <li class="active">
                  <div class="collapsible-header">Edit Detail</div>
                  <div class="collapsible-body white pt-1 pb-1">
                    @include('web.claim.berita-acara._form_detail')
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-content">
            <div class="section-data-tables">
              <table id="data-table-berita-acara-detail" class="display" width="100%">
                <thead>
                  <tr>
                    <th data-priority="1" width="30px">No.</th>
                    <th>No DO</th>
                    <th>Model/Item No.</th>
                    <th>No Seri</th>
                    <th>Qty</th>
                    <th>Jenis Kerusakan</th>
                    <th>Keterangan</th>
                    <th class="center-align">Damaged Unit Photo</th>
                    <th width="50px;"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-overlay"></div>
  </div>
</div>
@endsection

@push('vendor_js')
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.collapsible').collapsible({
      accordion: true
    });

    set_form_data();
    edit_detail_handler();
  });

  var dtdatatable_detail = $('#data-table-berita-acara-detail').DataTable({
    serverSide: true,
    scrollX: true,
    responsive: true,
    ajax: {
      url: '{{ url("berita-acara", $beritaAcara->id) }}',
      type: 'GET',
      data: function(d) {
        d.search['value'] = $('#global_filter').val()
      }
    },
    order: [1, 'asc'],
    columns: [{
        data: 'DT_RowIndex',
        orderable: false,
        searchable: false,
        className: 'center-align'
      },
      {
        data: 'do_no',
        name: 'do_no',
        className: 'detail'
      },
      {
        data: 'model_name',
        name: 'model_name',
        className: 'detail'
      },
      {
        data: 'serial_number',
        name: 'serial_number',
        className: 'detail'
      },
      {
        data: 'qty',
        name: 'qty',
        className: 'detail'
      },
      {
        data: 'description',
        name: 'description',
        className: 'detail'
      },
      {
        data: 'keterangan',
        name: 'keterangan',
        className: 'detail'
      },
      {
        data: 'photo_url',
        orderable: false,
        render: function(data, type, row) {
          if (data) {
            return '<img class="materialboxed center-align" width="200" height="200" src="' + "{{asset('storage/')}}/" + data + '">';
          }
          return '-';
        },
        className: "center-align"
      },
      {
        data: 'action',
        className: 'center-align',
        searchable: false,
        orderable: false
      },
    ]
  });

  dtdatatable_detail.on('click', '.btn-delete', function(event) {
    event.preventDefault();
    /* Act on the event */
    // Ditanyain dulu usernya mau beneran delete data nya nggak.
    var tr = $(this).parent().parent();
    var data = dtdatatable_detail.row(tr).data();
    swal({
      text: "Are you sure want to delete " + data.do_no + " ?",
      icon: 'warning',
      buttons: {
        cancel: true,
        delete: 'Yes, Delete It'
      }
    }).then(function(confirm) { // proses confirm
      if (confirm) {
        $.ajax({
            url: "{{ url('berita-acara', $beritaAcara->id) }}" + '/detail/' + data.id,
            type: 'DELETE',
            dataType: 'json',
          })
          .done(function() {
            swal({
              icon: "success",
              title: "Good job!",
              text: "Berita Acara Detail with No. Do " + data.do_no + " has been deleted.",
              timer: 1000,
              buttons: false
            }) // alert success
            dtdatatable_detail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
      }
    })
  });

  function set_form_data() {
    $('#form-berita-acara .input-field').hide();
    $('#form-berita-acara select').attr('disabled', 'disabled');
    $('#form-berita-acara .btn-save').hide();
    $('#form-berita-acara-detail .btn-save').html('Update Detail');
    set_select2_value('#form-berita-acara [name="expedition_code"]', '{{$beritaAcara->expedition_code}}', '{{$beritaAcara->Expedition->expedition_name}}');
    set_select2_value('#form-berita-acara [name="driver_name"]', '{{$beritaAcara->driver_name}}', '{{$beritaAcara->driver_name}}');
    set_select2_value('#form-berita-acara [name="vehicle_number"]', '{{$beritaAcara->vehicle_number}}', '{{$beritaAcara->Vehicle->vehicle_number}}');
    set_select2_value('#form-berita-acara-detail [name="model_name"]', '{{$beritaAcaraDetail->model_name}}', '{{$beritaAcaraDetail->Model->model_name}}');

    $('#form-berita-acara [name="berita_acara_no"]').val("{{isset($beritaAcara)?$beritaAcara->berita_acara_no:''}}").attr("readonly", "readonly");
    $('#form-berita-acara [name="date_of_receipt"]').val("{{isset($beritaAcara)?$beritaAcara->date_of_receipt:''}}").attr("readonly", "readonly").removeClass("datepicker");
    set_select2_value('#form-berita-acara-detail [name="description"]', '{{$beritaAcaraDetail->description}}', '{{$beritaAcaraDetail->description}}');

    $('#form-berita-acara #img_file_do_manifest').show();
    $('#form-berita-acara #img_file_do_manifest img').attr("src", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->do_manifest):''}}");
    $('#form-berita-acara #img_file_do_manifest a').attr("href", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->do_manifest):''}}");

    $('#form-berita-acara #img_file_internal_do').show();
    $('#form-berita-acara #img_file_internal_do img').attr("src", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->internal_do):''}}");
    $('#form-berita-acara #img_file_internal_do a').attr("href", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->internal_do):''}}");

    $('#form-berita-acara #img_file_lmb').show();
    $('#form-berita-acara #img_file_lmb img').attr("src", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->lmb):''}}");
    $('#form-berita-acara #img_file_lmb a').attr("href", "{{isset($beritaAcara)?asset('storage/'.$beritaAcara->lmb):''}}");

    $('#form-berita-acara-detail #img_file_photo').show();
    $('#form-berita-acara-detail #img_file_photo img').attr("src", "{{isset($beritaAcaraDetail)?asset('storage/'.$beritaAcaraDetail->photo_url):''}}");
  }

  function edit_detail_handler() {
    // PUT request to update detail
    // data dikirim dalam form data 
    $("#form-berita-acara-detail").validate({
      submitHandler: function(form) {
        var formBiasa = $(form).serialize(); // form biasa
        var isiForm = new FormData($(form)[0]); // form data untuk browse file
        setLoading(true);
        $.ajax({
            url: '{{ url("berita-acara/". $beritaAcara->id . "/detail/" . $beritaAcaraDetail->id ) }}',
            type: 'POST',
            data: isiForm,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
          })
          .done(function(data) { // selesai dan berhasil
            swal({
                icon: "success",
                title: "Success",
                text: "Detail has been edited!",
                timer: 1500,
                buttons: false
              })
              .then((result) => {
                // Kalau klik Ok redirect ke index
                // dtdatatable_detail.ajax.reload(null, false);  // (null, false) => user paging is not reset on reload
                window.location.href = "{{ url('berita-acara/' . $beritaAcara->id ) }}"
              }) // alert success
          })
          .fail(function(xhr) {
            setLoading(false);
            showSwalError(xhr) // Custom function to show error with sweetAlert
          })
          .always(function() {
            setLoading(false);
          });
      }
    });
  }
</script>
@endpush