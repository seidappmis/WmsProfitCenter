@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Master Model</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Master Model</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">New Data</h4>
                        <form class="form-table">
                          <table>
                            <tr>
                              <td>Model Name</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="name" class="validate" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Model From Barcode Prod</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="barcode" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Ean Code</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="ean" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>CBM</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="cbm" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Material Group</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="">
                                    <option value="" disabled selected>-- Select Material Group --</option>
                                    <option value="1">BG - F3 LED Lightning</option>
                                    <option value="2">BJ - C1 Energy Solution Japan</option>
                                    <option value="3">BP - C1 Energy Sollution Overseas</option>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="">
                                    <option value="" disabled selected>-- Select Category --</option>
                                    <option value="1">AC</option>
                                    <option value="2">AP</option>
                                    <option value="3">AU</option>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Type</td>
                              <td>
                                <div class="input-field col s12">
                                  <select required="">
                                    <option value="" disabled selected>-- Select Category --</option>
                                    <option value="1">IMPORT</option>
                                    <option value="2">LOCAL</option>
                                    <option value="3">OEM</option>
                                  </select>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Description</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="description">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Max Pieces/Carton</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="pieces">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Max Carton/Palet</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="carton">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Palet</td>
                              <td>
                                <div class="input-field col s12">
                                  <input type="text" id="palet" required>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Price 1</td>
                              <td>
                                <div class="input-field col s12">
                                  <input placeholder="0" type="number" id="price">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Price 2</td>
                              <td>
                                <div class="input-field col s12">
                                  <input placeholder="0" type="number" id="price2">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>Price 3</td>
                              <td>
                                <div class="input-field col s12">
                                  <input placeholder="0" type="number" id="price3">
                                </div>
                              </td>
                            </tr>
                          </table>
                          <button type="submit" class="waves-effect waves-light indigo btn mt-2 mr-2">Save</button>
                          <a class="waves-effect btn-flat mt-2" href="{{ url('master-model') }}">Cancel</a>
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