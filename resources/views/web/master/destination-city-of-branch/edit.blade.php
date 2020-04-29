@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Destination City of Branch</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Destination City of Branch</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                        <h4 class="card-title">Edit Data</h4>
                        <form class="form-table">
                            <table>
                                <tr>
                                    <td>Destination City Name</td>
                                    <td>
                                        <div class="input-field col s12 m6">
                                            <input id="description" type="text" class="validate" value="Andir" required>
                                      </div>
                                    </td>
                                </tr>
                            </table>
                            {!! get_button_save('Update') !!}
                            {!! get_button_cancel(url('destination-city-of-branch')) !!}
                        </form>
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