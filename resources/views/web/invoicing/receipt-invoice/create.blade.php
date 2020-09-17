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
  var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
        scrollY: true,
        scrollX: true,
        // responsive: true,
        order: [1, 'asc'],
    });

  M.textareaAutoResize($('#textarea2')); 
</script>
@endpush