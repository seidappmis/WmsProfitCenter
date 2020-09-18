@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Create Receipt Invoice</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('receipt-invoice') }}">Receipt Invoice List</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <div class="col s12 m4"></div>
            <div class="col s12 m2">
              <div class="display-flex right">
                <!---- Button Back ----->
                <!-- <a class="waves-effect btn-flat btn-large" href="{{ url('receipt-invoice') }}">Back</a> -->
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                  @include('web.invoicing.receipt-invoice._form')
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
  $('#form-add-manifest').validate({
      submitHandler: function (form){
        setLoading(true); // Disable Button when ajax post data
        var data_manifest = [];
        dttable_manifest.$('input[type="checkbox"]').each(function() {
           /* iterate through array or object */
           if(this.checked){
            var row = $(this).closest('tr');
            var row_data = dttable_manifest.row(row).data();
            data_manifest.push(row_data);
           }
        });
        $.ajax({
          url: '{{ url("receipt-invoice") }}',
          type: 'POST',
          data: $(form).serialize() + '&data_manifest=' + JSON.stringify(data_manifest),
        })
        .done(function(result) { // selesai dan berhasil
          if (result.status) {
            showSwalAutoClose("Success", result.message)
            window.location.href = "{{ url('receipt-invoice') }}" + "/" + result.data.id
          } else {
            setLoading(false)
            showSwalAutoClose("Warning", result.message)
          }
        })
        .fail(function(xhr) {
            setLoading(false); // Enable Button when failed
            showSwalError(xhr) // Custom function to show error with sweetAlert
        });

      }
    })

  M.textareaAutoResize($('#textarea2')); 
</script>
@endpush