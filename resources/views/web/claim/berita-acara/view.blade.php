@extends('layouts.materialize.index')
@include('web.claim.berita-acara.modal-upload-bulk')

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
          <div class="card-content form-berita-acara-detail-wrapper hide">
            <!-- Berita Acara Detail -->
            <button class="btn float-right modal-trigger" id="upload-bulk-excel" href="#modal-upload-bulk">Upload Bulk</button>
            <a href='{{ url("berita-acara/". $beritaAcara->id . "/bulk-template")}}' class="btn float-right indigo">Download Template</a>
            <h4 class="card-title">Berita Acara Detail</h4>
            <hr>
            <!-- Add Detail -->
            <div class="card-content p-0">
              <ul class="collapsible">
                <li class="">
                  <div class="collapsible-header">Add New Detail</div>
                  <div class="collapsible-body white pt-1 pb-1">
                    @include('web.claim.berita-acara._form_detail')
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-content pt-0">
            <div class="section-data-tables">
              <table id="data-table-berita-acara-detail" class="display" width="100%">
                <thead>
                  <tr>
                    <th class="center-align" data-priority="1" width="30px">No.</th>
                    <th class="center-align">No DO</th>
                    <th class="center-align">Model/Item No.</th>
                    <th class="center-align">No Seri</th>
                    <th class="center-align">Qty</th>
                    <th class="center-align">Jenis Kerusakan</th>
                    <th class="center-align">Keterangan</th>
                    <th class="center-align">Damaged Unit Photo</th>
                    <th class="center-align" width="50px;"></th>
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
  if ("{{empty($beritaAcara->submit_date)?'true':'false'}}" == 'true')
    $('.form-berita-acara-detail-wrapper').removeClass('hide');

  jQuery(document).ready(function($) {
    $('.collapsible').collapsible({
      accordion: true
    });

    set_form_data();
    add_detail_handler();

    // serialize image viewer
    $('.materialboxed').materialbox();
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
        data: 'do_no'
      },
      {
        data: 'model_name'
      },
      {
        data: 'serial_number',
        render: function(data) {
          return data ? data.split(",").join("<br>") : '';
        }
      },
      {
        data: 'qty'
      },
      {
        data: 'description'
      },
      {
        data: 'keterangan'
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
            showSwalAutoClose('Success', "Berita Acara Detail with No. Do " + data.do_no + " has been deleted.")
            dtdatatable_detail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
          })
          .fail(function() {
            console.log("error");
          });
      }
    })
  });

  function set_form_data() {
    // $('#form-berita-acara .input-field').hide();
    $('#form-berita-acara select').attr('disabled', 'disabled');
    // $('#form-berita-acara .btn-save').hide();
    $('#form-berita-acara-detail .btn-cancel').hide();
    $('#form-berita-acara [name="id"]').val('{{$beritaAcara->id}}');
    $('#form-berita-acara [name="berita_acara_no"]').val("{{isset($beritaAcara)?$beritaAcara->berita_acara_no:''}}").attr("readonly", "readonly");
    $('#form-berita-acara [name="date_of_receipt"]').val("{{isset($beritaAcara)?$beritaAcara->date_of_receipt:''}}").attr("readonly", "readonly").removeClass("datepicker");

    if ('{{$beritaAcara->do_manifest}}') {
      $('#form-berita-acara #img_file_do_manifest').show();
      $('#form-berita-acara #img_file_do_manifest img').attr("src", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->do_manifest):''}}");
      $('#form-berita-acara #img_file_do_manifest a').attr("href", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->do_manifest):''}}");
    }
    $('#form-berita-acara #img_file_internal_do').show();
    if ('{{$beritaAcara->internal_do}}') {
      $('#form-berita-acara #img_file_internal_do img').attr("src", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->internal_do):''}}");
      $('#form-berita-acara #img_file_internal_do a').attr("href", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->internal_do):''}}");
    }

    if ('{{$beritaAcara->lmb}}') {
      $('#form-berita-acara #img_file_lmb').show();
      $('#form-berita-acara #img_file_lmb img').attr("src", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->lmb):''}}");
      $('#form-berita-acara #img_file_lmb a').attr("href", "{{!empty($beritaAcara)?asset('storage/'.$beritaAcara->lmb):''}}");
    }
    set_select2_value('#form-berita-acara [name="expedition_code"]', '{{$beritaAcara->expedition_code}}', '{{$beritaAcara->expedition_code}}');
    set_select2_value('#form-berita-acara [name="driver_name"]', '{{$beritaAcara->driver_name}}', '{{$beritaAcara->driver_name}}');
    set_select2_value('#form-berita-acara [name="vehicle_number"]', '{{$beritaAcara->vehicle_number}}', '{{$beritaAcara->vehicle_number}}');
  }

  function add_detail_handler() {
    // POST request to store detail
    // data dikirim dalam form data 
    $("#form-berita-acara-detail").validate({
      submitHandler: function(form) {
        var formBiasa = $(form).serialize(); // form biasa
        var isiForm = new FormData($(form)[0]); // form data untuk browse file
        setLoading(true);
        $.ajax({
            url: '{{ url("berita-acara/". $beritaAcara->id . "/detail") }}',
            type: 'POST',
            data: isiForm,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
          })
          .done(function(result) { // selesai dan berhasil
            // $('#table-concept tbody').empty();
            if (result.status) {
              showSwalAutoClose('success', result.message)
              dtdatatable_detail.ajax.reload(null, false); // (null, false) => user paging is not reset on reload
              $('#form-berita-acara-detail')[0].reset(); // reset form
              set_select2_value('#form-berita-acara-detail [name="description"]', '', '');
            } else {
              showSwalAutoClose('Warning', result.message)
            }

            setLoading(false);
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

    $("#form-berita-acara").validate({
      submitHandler: function(form) {
        var formBiasa = $(form).serialize(); // form biasa
        var isiForm = new FormData($(form)[0]); // form data untuk browse file
        // console.log(isiForm);
        // return;
        /* Act on the event */
        setLoading(true);
        $.ajax({
            url: '{{ url("berita-acara/". $beritaAcara->id) }}',
            type: 'POST',
            data: isiForm,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
          })
          .done(function(result) {
            if (result.status) {
              swal("Success!", 'No Berita Acara : ' + result.meta.berita_acara_no, "success")
                .then((response) => {
                  // Kalau klik Ok redirect ke view
                  location.reload();
                }) // alert success
            } else {
              setLoading(false);
              showSwalAutoClose('Warning', result.msg)
            }
          })
          .fail(function() {
            setLoading(false);
          })
          .always(function() {
            setLoading(false);
          });
      }
    });
  };

  // upload bulk excell
  $("#form-upload-bulk").validate({
    submitHandler: function(form) {
      var fdata = new FormData(form);
      setLoading(true);
      $.ajax({
          url: '{{ url("berita-acara/". $beritaAcara->id . "/upload-bulk") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          data_concept = data;
          $(form)[0].reset();
          $('#modal-upload-bulk').modal('close');
          if (data.status == false) {
            // $('#table-concept tbody').empty();
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('Success', 'Data uploaded.')
          dtdatatable_detail.ajax.reload(null, false);
          setLoading(false);
        })
        .fail(function(xhr) {
          setLoading(false);
          showSwalError(xhr) // Custom function to show error with sweetAlert
        });
    }
  });
</script>
@endpush