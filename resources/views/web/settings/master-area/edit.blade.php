@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Area</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Area</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">Edit Area</h4>
                        <form class="form-table">
                            <table>
                                <tr>
                                    <td>AREA</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="area" type="text" class="validate" value="All" ">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CODE</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="code" type="text" class="validate" value="--No Code--" ">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            {!! get_button_save('Update') !!}
                            {!! get_button_cancel(url('master-area')) !!}
                        </form>
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