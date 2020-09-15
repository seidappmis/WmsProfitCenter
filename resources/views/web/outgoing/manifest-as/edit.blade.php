@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Manifest</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('manifest-as') }}">Manifest AS</a></li>
                    <li class="breadcrumb-item active">Create Manifest</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">

            <div class="section">

              <div class="card">
                <div class="card-content p-0">
                  <ul class="collapsible m-0">
                    <li class="active">
                      <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Detail</div>
                      <div class="collapsible-body padding-1">
                        @include('web.outgoing.manifest-as._form_manifest')
                        @include('web.outgoing.manifest-as._list_do')
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="content-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
    set_select2_value('#form-manifest [name="city_code"]', '{{$manifestHeader->city_code}}', '{{$manifestHeader->city_name}}')
    set_select2_value('#form-assign-do [name="ship_to"]', '{{$manifestHeader->city_code}}', '{{$manifestHeader->city_name}}')

    $('.btn-delete').removeClass('hide')
    $('.btn-print').removeClass('hide')

    $('.btn-delete').click(function(event) {
      /* Act on the event */
      swal({
          text: "Delete manifest {{$manifestHeader->do_manifest_no}}?",
          icon: 'warning',
          buttons: {
            cancel: true,
            delete: 'Yes, delete It'
          }
        }).then(function (confirm) { // proses confirm
          if (confirm) { // Bila oke post ajax ke url delete nya
            // Ajax Post Delete
            $.ajax({
              url: '{{url('manifest-as/' . $manifestHeader->do_manifest_no)}}',
              type: 'DELETE',
            })
            .done(function(result) { // Kalau ajax nya success
              showSwalAutoClose('Success', result.message)
              window.location.href = '{{url("manifest-as")}}'
            })
            .fail(function() { // Kalau ajax nya gagal
              console.log("error");
            });

          }
        })
    });

  });
    $("#form-assign-do").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var selected_list = [];
        dtdatatable_submit_to_logsys.$('tr').each(function() {
          var row_data = dtdatatable_submit_to_logsys.row(this).data()
          selected_list.push(row_data);
        });
        $.ajax({
          url: '{{ url("manifest-as/" . $manifestHeader->do_manifest_no . "/assign-do") }}',
          type: 'POST',
          data: $(form).serialize() + '&selected_list=' + JSON.stringify(selected_list),
        })
        .done(function(data) { // selesai dan berhasil
          window.location.href = '{{ url("manifest-as/" . $manifestHeader->do_manifest_no . "/edit") }}'
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush
