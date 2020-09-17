@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Receipt Invoice Accounting</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('receipt-invoice-accounting') }}">Receipt Invoice Accounting</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">Search</h4>
                      <hr>
                      <br>
                      <div class="row">
                      <div class="col s12 m2 mt-1">
                        Receipt Period
                      </div>
                      <div class="app-search col s12 m4">
                        <input type="text" class="datepicker">
                        </div>
                        <div class="col s12 m2">
                          <a class="waves-effect waves-light indigo btn btn-save">
                            Search
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- Result -->
                    <div class="card-content">
                      <h4 class="card-title">Result</h4>
                      <hr>
                      <br>
                      <div class="row">
                      <div class="col s12">
                        {!! get_button_save('Submit') !!}
                        {!! get_button_cancel(url('receipt-invoice-accounting'), 'Back') !!}
                      </div>
                      </div>
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
    
</script>
@endpush