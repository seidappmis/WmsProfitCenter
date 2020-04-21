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

                        .form-table .input-field {
                          margin-top: 2px;
                          margin-bottom: 2px;
                        }

                        .form-table input:not([type]), input[type=text]:not(.browser-default), input[type=password]:not(.browser-default), input[type=email]:not(.browser-default), input[type=url]:not(.browser-default), input[type=time]:not(.browser-default), input[type=date]:not(.browser-default), input[type=datetime]:not(.browser-default), input[type=datetime-local]:not(.browser-default), input[type=tel]:not(.browser-default), input[type=number]:not(.browser-default), input[type=search]:not(.browser-default), textarea.materialize-textarea {
                          margin: 0;
                          height: 2rem;
                          border-bottom: 1px solid #e0e0e0;
                        }

                        .form-table input:required,
                         textarea.materialize-textarea:required {
                          background-color: #f5da438f;
                        }

                        .form-table .dropdown-content li {
                          min-height: 30px;
                        }

                        .form-table .dropdown-content li > a, .form-table .dropdown-content li > span {
                            padding: 5px 24px;
                        }
                        .form-table .label {
                          padding: 5px;
                        }
                      </style>

                      @endpush
                      <form class="form-table">
                        <table>
                          <tr>
                            <td>Expedition</td>
                            <td>
                              <div class="input-field col s12">
                                <select required="">
                                  <option value="">-All-</option>
                                  <option value="BMA">BINTAN MEGAH ABADI, PT.</option>
                                  <option value="DSE">DUA SAMUDERA EXPRESS, CV.</option>
                                  <option value="DSE">DUA SAMUDRA EXPRESS, CV.</option>
                                  <option value="DSL">DUA SAMUDRA LOGISTIK, PT.</option>
                                  <option value="DPE">DUNIA PARCEL EXPRESS, PT.</option>
                                  <option value="E8T">EXPRESSINDO 88 NUSANTARA, PT.</option>
                                  <option value="GCL">GCL LOGISTIK INDONESIA, PT.</option>
                                  <option value="GST">GEMA SARANA TRANSPORTASI, PT.</option>
                                  <option value="JTT">JASA TRANS TIRTA, PT.</option>
                                  <option value="KFF">KARURA FREIGHT FORWARDING DAN LOGISTICS, PT.</option>
                                  <option value="KYU">KARYA UTAMA, CV.</option>
                                  <option value="KIT">KUNCI INTI TRANSINDO, PT.</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Manifest Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate" required="">
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate" required="">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>DO Date</td>
                            <td>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  From
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                </div>
                              </div>
                              <div class="input-field col s6">
                                <div class="col s3 m2 label">
                                  To
                                </div>
                                <div class="col s9 m10">
                                  <input placeholder="" id="first_name" type="text" class="validate">
                                </div>
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
                                  <option value="1">JAKARTA-JEMBER</option>
                                  <option value="2">JAKARTA-KARAWANG</option>
                                  <option value="3">JAKARTA-KEDIRI</option>
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
                                  <option value="1">JABODETABEK</option>
                                  <option value="2">JAWA</option>
                                  <option value="3">KALIMANTAN</option>
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
                                  <option value="1">UNRECEIPT</option>
                                  <option value="2">DRAFT UNRECEIPT</option>
                                  <option value="3">ALREADY UNRECEIPT</option>
                                </select>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <button class="btn btn-large waves-effect waves-light green darken-4 mt-2" type="submit" name="action">
                          <i class="material-icons left">local_printshop</i>
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