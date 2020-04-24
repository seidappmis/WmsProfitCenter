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
                                                <input id="category" type="text" class="validate" name="category" value="8 METER">
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
                                <form class="form-table">
                                    <table>
                                        <tr>
                                            <td>Vehicle Code Type</td>
                                            <td>
                                                <input id="category" type="text" class="validate">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>
                                                <input id="description" type="text" class="validate"">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SAP Description</td>
                                            <td>
                                                <input id="sap" type="text" class="validate"">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CBM MIN</td>
                                            <td>
                                                <input id="min" type="number" class="validate"">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CBM MAX</td>
                                            <td>
                                                <input id="max" type="number" class="validate"">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Number</td>
                                            <td>
                                                <input id="numb" type="number" class="validate"">
                                            </td>
                                        </tr>
                                    </table>
                                    {!! get_button_save() !!}
                                    {!! get_button_cancel(url('master-vehicle/1'),'Back') !!}
                                </form>
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