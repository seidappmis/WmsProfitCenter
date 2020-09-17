@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Claim Notes</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Claim Notes</li>
                </ol>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    @include('web.claim.claim-notes._carton_box')
    @include('web.claim.claim-notes._unit')
 
</div>
@endsection