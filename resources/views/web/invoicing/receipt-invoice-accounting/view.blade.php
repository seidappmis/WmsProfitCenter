@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Receipt Invoice Accounting</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Receipt Invoice Accounting</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    {!! get_button_cancel(url('receipt-invoice-accounting'), 'Back') !!}
                    @include('web.invoicing.receipt-invoice-accounting._form-receipt-period')
                    @include('web.invoicing.receipt-invoice-accounting._form-report-receipt')
                    @include('web.invoicing.receipt-invoice-accounting._form-input-payment-requisition')
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_css')
<link rel="stylesheet" href="{{ asset('vendors/datepicker/datepicker.css') }}">
@endpush

@push('vendor_js')
<script src="{{ asset('vendors/datepicker/datepicker.js') }}"></script>
<script src="{{ asset('materialize/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

