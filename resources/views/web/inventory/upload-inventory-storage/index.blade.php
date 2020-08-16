@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6 mb-1">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Upload Inventory Storage</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Upload Inventory Storage</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                  <form id="form-upload-inventory-storage">
                      <div class="row">
                        <div class="input-field col s12">
                          <div class="col s12 m4 l3">
                            <p>Data File</p>
                          </div>
                          <div class="col s12 m8 l9">
                            <input type="file" required id="input-file-now" class="dropify" name="file_inventory_storage" data-default-file="" data-height="150"/>
                            <br>
                            <p>Format File : .csv</p>
                          </div>
                        </div>
                        <div class="input-field col s12">
                          <div class="col s12 m4 l3">
                            <p>Format Layout Column :</p>
                          </div>
                          <div class="col s12 m8 l9">
                            <p>[Storage Location],[Material No/Model],[Stock]</p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <button type="submit" class="waves-effect waves-light indigo btn">Submit</button>
                        </div>
                      </div>
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
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}">
</script>
@endpush

@push('script_js')
<script type="text/javascript">
  $("#form-upload-inventory-storage").validate({
      submitHandler: function(form) {
        setLoading(true); // Disable Button when ajax post data
        var fdata = new FormData(form);
        $.ajax({
          url: '{{ url("upload-inventory-storage") }}',
          type: 'POST',
          data: fdata,
          contentType: "application/json",
          dataType: "json",
          contentType: false,
          processData: false
        })
        .done(function(data) { // selesai dan berhasil
          data_concept = data;
          if (data.status == false) {
            $('#table-concept tbody').empty();
            setLoading(false); // Enable Button when failed
            swal("Failed!", data.message, "warning");
            return;
          }
          showSwalAutoClose('Success', 'Data uploaded.')
          $('#concept-wrapper').show();
          $('#table-concept tbody').empty();
        })
        .fail(function(xhr) {
          setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });
      }
    });
</script>
@endpush