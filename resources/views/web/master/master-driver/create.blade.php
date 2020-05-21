@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Driver</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Driver</h4>
                        @include('web.master.master-driver._form')
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
$(document).ready(function() {
    //Upload Foto
    $('.dropify').dropify();

    $('.select2').change(function(event) {
      /* Act on the event */
      if (this.value == '1') {
          $('#detail-driver').show();
          // console.log('tes');
      } else if (this.value == '0') {
        $('#detail-driver').hide();
      }
    });
});
</script>
@endpush