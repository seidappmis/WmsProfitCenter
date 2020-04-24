@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Driver</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Driver</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                    	<h4 class="card-title">New Driver</h4>
                        <form class="form-table">
                        	<table>
                        		<tr>
                        			<td>Expedition</td>
                        			<td>
                        				<div class="input-field col s12">
									    <select required="">
									        <option value="" disabled selected>-- Expedition --</option>
									        <option value="1">ALAM RAYA SENTOSA, CV.</option>
									        <option value="2">ALAMUI LOGISTICS, PT.</option>
									        <option value="3">ALISTON TJOKRO EMKL</option>
									    </select>
									  </div>
                        			</td>
                        		</tr>
                        	</table>
                        	{!! get_button_save() !!}
                            {!! get_button_cancel(url('master-driver')) !!}
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