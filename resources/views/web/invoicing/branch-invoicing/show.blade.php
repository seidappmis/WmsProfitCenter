@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Branch Invoicing</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Branch Invoicing</li>
                </ol>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                       {!! get_button_cancel(url('branch-invoicing'), 'Back', 'mt-0') !!}
                      @include('web.invoicing.branch-invoicing._form_search_manifest')
                      @include('web.invoicing.branch-invoicing._form_new_manifest_detail')
                      @include('web.invoicing.branch-invoicing._branch_invoice')
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

