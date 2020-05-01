@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Picking List</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Picking List</li>
                </ol>
            </div>
        </div>
    @endcomponent

    <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">
                <div class="row mb-2">
                    <div class="col s12 m1 pt-2">
                        <p>Storage:</p>
                    </div>
                    <div class="col s12 m4">
                      <!---- Search ----->
                          <div class="app-wrapper">
                            <div class="datatable-search">
                              <select id="area_filter">
                                <option>-Select Storage-</option>
                                <option>[1601]YGY-1st Class</option>
                                <option>[1602]YGY-1st Class</option>
                              </select>
                            </div>
                          </div>
                    </div>
                    <div class="col s12 m6">

                    </div>
                </div>
                  <div class="row">
                    <div class="col s12 ">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>CREATE / EDIT</div>
                          <div class="collapsible-body">
                              <form class="form-table">
                                  <table>
                                    <tr>
                                      <td>Date of Destpatch</td>
                                      <td>
                                        <p>2020-04-27 14:56 PM</p>
                                      </td>
                                      <td>
                                        <p>Gate#</p>
                                      </td>
                                      <td>
                                        <div class="input-field col s12">
                                          <input value="1" id="notag" type="text" class="validate" name="notag" required>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td>WHS</td>
                                        <td>
                                          <P>SHARP W/Y YGY</P>
                                        </td>
                                        <td>
                                            <P>Order No</P>
                                        </td>
                                        <td>
                                            <div class="input-field col s12">
                                                <input value="" id="notag" type="text" class="validate" name="notag" disabled>
                                            </div>
                                        </td>

                                      </tr>
                                      <tr>
                                        <td>Ship To City</td>
                                        <td>
                                            <div class="input-field col s12">
                                                <select>
                                                  <option value="" disabled selected>-Select Area-</option>
                                                  <option value="1">SLEMAN</option>
                                                  <option value="2">YOGYA KOTA</option>
                                                  <option value="3">BANTUL</option>
                                                </select>
                                              </div>
                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>


                                      </tr>
                                </table>
                              </form>
                              <br>


                              <form class="form-table">
                                  <table>
                                    <tr>
                                      <td width="120px;">Expedition</td>
                                        <td>
                                            <div class="input-field col s12">
                                                <select>
                                                <option value="" disabled selected>-Select Area-</option>
                                                <option value="1">SLEMAN</option>
                                                <option value="2">YOGYA KOTA</option>
                                                <option value="3">BANTUL</option>
                                                </select>
                                            </div>


                                        </td>
                                        <td width="120px;">
                                            <P>Driver Name</P>

                                        </td>
                                        <td>
                                            <div class="input-field col s12 m6">
                                                <select>
                                                <option value="" disabled selected>-Select Driver-</option>
                                                <option value="1">SLEMAN</option>
                                                <option value="2">YOGYA KOTA</option>
                                                <option value="3">BANTUL</option>
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input value="" id="notag" type="text" class="validate" name="notag" required>
                                            </div>

                                        </td>


                                    </tr>
                                    <tr>
                                      <td>Vehicle Type</td>
                                      <td>
                                        <div class="input-field col s12">
                                            <select>
                                              <option value="" disabled selected>-Select Area-</option>
                                              <option value="1">SLEMAN</option>
                                              <option value="2">YOGYA KOTA</option>
                                              <option value="3">BANTUL</option>
                                            </select>
                                          </div>
                                      </td>
                                      <td>

                                    </td>
                                    <td>

                                    </td>


                                    </tr>
                                    <tr>
                                      <td>Vehicle No</td>
                                      <td>
                                        <div class="input-field col s12 m6">
                                            <select>
                                              <option value="" disabled selected>-Select Area-</option>
                                              <option value="1">SLEMAN</option>
                                              <option value="2">YOGYA KOTA</option>
                                              <option value="3">BANTUL</option>
                                            </select>
                                          </div>
                                          <div class="input-field col s12 m6">
                                            <input value="" id="notag" type="text" class="validate" name="notag" required>
                                        </div>
                                      </td>
                                      <td>

                                    </td>
                                    <td>

                                    </td>


                                    </tr>
                                </table>

                            </form>
                            <div class="row">
                              <div class="input-field col s12">
                                {!! get_button_view(url('picking-list'),'Save') !!}
                                {!! get_button_view(url('picking-list'),'Back') !!}
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>



                        </div>
                        <div class="content-overlay"></div>


            </div>
          </div>
        </div>
      </div>
    </div>
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
