@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Conform Manifest</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Conform Manifest</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
       @include('web.incoming.conform-manifest._manifest_hq')
       @include('web.incoming.conform-manifest._manifest_branch')
        
        <div class="content-overlay"></div>
    </div>
@endsection
