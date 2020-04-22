@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Destination City</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Destination City</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <h4 class="card-title">New Destination City</h4>
                        <form class="form-table">
                            <table>
                                <tr>
                                    <td>City Code</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="number" type="text" class="validate" name="gate_number" required>
                                      </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>City Name</td>
                                    <td>
                                        <div class="input-field col s12">
                                            <input id="description" type="text" class="validate" name="description">
                                      </div>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
                            <a class="waves-effect btn-flat mt-2" href="{{ url('destination-city') }}">Cancel</a>
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