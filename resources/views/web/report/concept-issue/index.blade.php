@extends('layouts.materialize.index')


@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Concept Issue (%)</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Concept Issue</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table" id="form-concept-issue">
                            <table id="data-table-simple" class="display" width="100%">
                                <tr>
                                    <td>Area</td>
                                    <td>
                                      <div class="input-field col s12">
                                        <select name="area" class="select2-data-ajax browser-default">
                                        </select>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Period</td>
                                    <td>
                                        <input placeholder="-Period-" id="first_name" type="text" class="validate datepicker" readonly>
                                    </td>
                                </tr>
                            </table>
                        </form>
                       <br>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content p-3">
                        <form class="form-table">
                            @include('web.report.concept-issue.grap');
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
    jQuery(document).ready(function($) {
        $('#form-concept-issue [name="area"]').select2({
           placeholder: '-- Select Area --',
           allowClear: true,
           ajax: get_select2_ajax_options('/master-area/select2-area-only')
        });
    });
</script>
@endpush