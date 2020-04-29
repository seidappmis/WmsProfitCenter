@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Destination</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Destination</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Edit Destination</h4>
                        <form class="form-table">
                          <table>
                            <tr>
                              <td>Destination Number</td>
                              <td>
                                <div class="input-field col s12">
                                  <input id="number" type="text" class="validate" name="number" value="3D1010" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Description</td>
                              <td>
                                <div class="input-field col s12">
                                  <input id="description" type="text" class="validate" name="description" value="Jakarta">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Region</td>
                              <td>
                                <div class="input-field col 12">
                                <p>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio" id="1"/>
                                    <span>New Region</span>
                                  </label>
                                  <label>
                                    <input class="with-gap" name="group1" type="radio" id="2" checked/>
                                    <span>Current</span>
                                  </label>
                                </p>
                                </div>
                                <div id="current" class="input-field col s12">
                                  <input type="text" class="validate" name="group1">
                                </div>
                                <div id="newr" class="input-field col s12">
                                  <select>
                                    <option value="0" selected>JABODETABEK</option>
                                    <option value="1">JAWA & BALI</option>
                                    <option value="2">KALIMANTAN</option>
                                    <option value="3">OTHERS</option>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Cabang</td>
                              <td>
                                <div class="input-field col s12">
                                  <input id="cabang" type="text" class="validate" name="cabang" required>
                                </div>
                              </td>
                            </tr>
                          </table>
          							  {!! get_button_save('Update') !!}
                          {!! get_button_cancel(url('master-destination')) !!}
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
 	$(document).ready(function() {
    $('.with-gap').click(function(event) {
      /* Act on the event */
      if ($(this).attr('id') == "2") {
          $('#newr').show();
          $('#current').hide();
      } else {
          $('#newr').hide();
          $('#current').show();
      }
    });
  });
</script>
@endpush