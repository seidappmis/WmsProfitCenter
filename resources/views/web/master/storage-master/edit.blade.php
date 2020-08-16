@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Storage Master</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Storage Master</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Edit Data</h4>
                        @include('web.master.storage-master._form')
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
        set_initial_form_data();
        @if ($storageMaster->isUsed())
        $('.btn-save').hide();
     	swal({
            text: 'Cannot be update, used by another data',
            icon: 'warning'
          })
        @endif

        $("#form-storage-master").validate({
          submitHandler: function(form) {
            setLoading(true); // Disable Button when ajax post data
            $.ajax({
              url: '{{ url("storage-master/" . $storageMaster->id ) }}',
              type: 'PUT',
              data: $(form).serialize(),
            })
            .done(function() { // selesai dan berhasil
                showSwalAutoClose('Success', 'Data updated.')
              window.location.href = "{{ url('storage-master') }}"
            })
            .fail(function(xhr) {
                setLoading(false); // Enable Button when failed
                showSwalError(xhr) // Custom function to show error with sweetAlert
            });
          }
        });
    });

    function set_initial_form_data(){
        set_select2_value('#kode_cabang', '{{$storageMaster->kode_cabang}}', '{{$storageMaster->MasterCabang->kode_cabang . "-" . $storageMaster->MasterCabang->short_description . "-" . $storageMaster->MasterCabang->long_description}}');

        set_select2_value('#sto_type_id', '{{$storageMaster->sto_type_id}}', '{{$storageMaster->StorageType->storage_type}}');
    };

</script>
@endpush