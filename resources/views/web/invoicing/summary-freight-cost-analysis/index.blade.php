@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Analysis</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Analysis</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      @push('script_css')
                      <style type="text/css">
                        .form-table th, .form-table td {
                          font-size: 14px;
                          padding: 0 !important;
                        }
                        /*.select-wrapper input.select-dropdown {
                          margin: 0 !important;
                        }
                        input[type=text] {
                          margin: 0 !important;
                        }
                        .input-field {
                          margin-top: 0 !important;
                          margin-bottom: .5rem;
                        }*/
                      </style>

                      @endpush
                      <form class="form-table">
                        <table>
                          <tr>
                            <td>Expedition</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">Option 1</option>
                                  <option value="2">Option 2</option>
                                  <option value="3">Option 3</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Manifest Date</td>
                            <td>
                              <div class="input-field col s6">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  <label for="first_name">From</label>
                              </div>
                              <div class="input-field col s6">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  <label for="first_name">To</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Date</td>
                            <td>
                              <div class="input-field col s6">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  <label for="first_name">From</label>
                              </div>
                              <div class="input-field col s6">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  <label for="first_name">To</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Manifest</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Recipt ID</td>
                            <td>
                              <div class="input-field col s12">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                  {{-- <label for="first_name">From</label> --}}
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Destination</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">Option 1</option>
                                  <option value="2">Option 2</option>
                                  <option value="3">Option 3</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Region</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">Option 1</option>
                                  <option value="2">Option 2</option>
                                  <option value="3">Option 3</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Status</td>
                            <td>
                              <div class="input-field col s12">
                                <select>
                                  <option value="" disabled selected>-All-</option>
                                  <option value="1">Option 1</option>
                                  <option value="2">Option 2</option>
                                  <option value="3">Option 3</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <button class="btn btn-large waves-effect waves-light green darken-4 mt-2" type="submit" name="action">
                          <i class="material-icons right">local_printshop</i>
                          Print
                        </button>
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
    var dtdatatable = $('#data-table-section-contents').DataTable({
        serverSide: false,
        scrollX: true,
        responsive: true,
        order: [1, 'asc'],
    });
</script>
@endpush