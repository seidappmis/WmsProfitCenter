@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Vehicle</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Vehicle</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <!-- <div class="card"> -->
                    <div class="card-content">
                        <ul class="collapsible">
						   <li class="active">
							   <div class="collapsible-header">Edit Vehicle Group Category</div>
							   <div class="collapsible-body white">
                                <form class="form-table">
                                    <table>
                                        <tr>
                                            <td>VEHICLE GROUP CATEGORY</td>
                                            <td>
                                                <input id="group_name" type="text" class="validate" name="group_name" value="{{old('group_namep', !empty($vehicleGroup) ? $vehicleGroup->group_name : '')}}">
                                            </td>
                                        </tr>
                                    </table>
                                    {!! get_button_save('Update') !!}
                                    {!! get_button_cancel(url('master-vehicle'),'Back') !!}
                                </form>
							   </div>
						   </li>
						</ul>
                    </div>
                <!-- </div> -->
                    <div class="card-content">
                        <ul class="collapsible">
                           <li class="active">
                               <div class="collapsible-header">Detail</div>
                               <div class="collapsible-body white">
                                <a class="waves-effect waves-light indigo btn" href="{{ url('master-vehicle/detail') }}">Add New Detail</a>
                               </div>
                           </li>
                        </ul>
                    </div>
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