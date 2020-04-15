@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Gate</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Gate</li>
                </ol>
            </div>
            <div class="col s12 m6">
              <div class="display-flex">
                <!---- Search ----->
                <!-- <div class="app-wrapper mr-2">
                  <div class="datatable-search">
                    <i class="material-icons mr-2 search-icon">search</i>
                    <input type="text" placeholder="Search" class="app-filter" id="global_filter">
                  </div>
                </div> -->
              </div>
            </div>
            <div class="col s12 m3">
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <!-- <div class="card"> -->
                    <!-- <div class="card-content p-0"> -->
                        <ul class="collapsible">
						   <li class="active">
							   <div class="collapsible-header">New Gate</div>
							   <div class="collapsible-body"><span>Lorem ipsum dolor sit amet.</span></div>
						   </li>
						</ul>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
 	$('.collapsible').collapsible({
        accordion:true
    });
</script>
@endpush