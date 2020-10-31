@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Summary Freight Cost Report Per Manifest</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Summary Freight Cost Report Per Manifest</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content ">
                     <form class="form-table">
                            <table>
                              <tr>
                                <td>Date of Manifest</td>
                                <td>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      From
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_date" type="text" class="validate datepicker" readonly required>
                                    </div>
                                  </div>
                                  <div class="input-field col s6">
                                    <div class="col s3 m2 label">
                                      To
                                    </div>
                                    <div class="col s9 m10">
                                      <input placeholder="" name="start_end" type="text" class="validate datepicker" readonly required>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              
                              <tr>
                                <td>DO Manifest</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="do_manifest_no">
                                </div></td>
                              </tr>
                              <tr>
                                <td>ReceiptID</td>
                                <td><div class="input-field col s5">
                                  <input id="" type="text" class="validate " name="receipt_id">
                                </div></td>
                              </tr>
                              <tr>
                                <td>Expeditions</td>
                                <td>
                                    <div class="input-field col s12">
                                    <select name="expedition" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                  </td>
                              </tr>
                              <tr >
                                <td>Destination</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="city_code" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Region</td>
                                <td>
                                  <div class="input-field col s12">
                                    <select name="region" class="select2-data-ajax browser-default">
                                    </select>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Status Receipt</td>
                                <td>
                                  <div class="input-field col s4">
                                    <select name="status_region" id="">
                                      <option value="" disabled selected>-All-</option>
                                      <option value="1">Unreceipt</option>
                                      <option value="2">Draft Receipt</option>
                                      <option value="3">Already Receipt</option> 
                                    </select>

                                  </div>
                                </td>
                              </tr>
                             
                            </table>
                            <div class="input-field col s12">
                              <button type="submit" class="waves-effect waves-light indigo btn mt-1 mb-1">Print</button>
                            </div>
                          </form>
                   </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>

    <div class="col s12 summary-freight-cost-report-per-manifest-wrapper">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                        <div class="section-data-tables">
                            <table class="display" id="data-concept-or-do-outstanding-list-area" width="100%">
                                <thead>
                                    <tr>
                                        <th>ReceiptID</th>
                                        <th>ReceiptNum</th>
                                        <th>Invoice Number</th>
                                        <th>ReceiptDate</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Paid Status</th>
                                        <th>Bulan</th>
                                        <th>ACC Code</th>
                                        <th>Branch Code</th>
                                        <th>SLOC</th>
                                        <th>Manifest No</th>
                                        <th>Tgl Manifest</th>
                                        <th>Transporter</th>
                                        <th>Destination</th>
                                        <th>Vehicle Type</th>
                                        <th>Vehicle No</th>
                                        <th>DO No</th>
                                        <th>Branch Short Description</th>
                                        <th>Ship To Code</th>
                                        <th>Ship to Description</th>
                                        <th>Destination City DO</th>
                                        <th>Total CBM DO</th>
                                        <th>SumOfTotalCBM</th>
                                        <th>BaseCostCBM</th>
                                        <th>CostPerDO</th>
                                        <th>BaseCostRitase</th>
                                        <th>RitaseCost</th>
                                        <th>Ritase2Cost</th>
                                        <th>MultiDrop</th>
                                        <th>Unloading</th>
                                        <th>OverStay</th>
                                        <th>Total</th>
                                        <th>Region</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- datatable ends -->
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay">
        </div>
    </div>
</div>
@endsection
