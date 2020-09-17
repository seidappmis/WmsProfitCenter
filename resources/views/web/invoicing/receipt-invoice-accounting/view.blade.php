@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Receipt Invoice Accounting</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Receipt Invoice Accounting</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">Search</h4>
                      <hr>
                      <br>
                      <div class="row">
                      <div class="col s12 m2 mt-1">
                        Receipt Period
                      </div>
                      <div class="app-search col s12 m4">
                        <input type="text" class="datepicker">
                        </div>
                        <div class="col s12 m2">
                          <a class="waves-effect waves-light indigo btn btn-save">
                            Search
                          </a>
                        </div>
                      </div>
                    </div>
                    <!-- Result -->
                    <div class="card-content">
                      <h4 class="card-title">Result</h4>
                      <hr>
                      <br>
                      <div class="row">
                      <div class="col s12">
                        {!! get_button_save('Submit') !!}
                        {!! get_button_cancel(url('receipt-invoice-accounting'), 'Back') !!}
                      </div>
                      </div>
                    </div>
                </div>
                <!-- Report -->
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">Report Receipt No for Accounting List</h4>
                      <hr>
                      <br>
                      <form class="form-table mb-1">
                        <table id="data-table-section-contents" width="100%">
                          <tr>
                            <td bgcolor="#344b68" class="label white-text center-align">NO TANDA TERIMA</td>
                            <td bgcolor="#344b68" class="label white-text center-align">RECEIPT ID</td>
                            <td bgcolor="#344b68" class="label white-text center-align">RECEIPT DATE</td>
                            <td bgcolor="#344b68" class="label white-text center-align">KWITANSI NO</td>
                            <td bgcolor="#344b68" class="label white-text center-align">EXPEDITION</td>
                            <td bgcolor="#344b68" class="label" width="50px"></td>
                          </tr>
                          <tr>
                            <td>001/XI/DIST.LOG/KU.SEID/17</td>
                            <td>KRW-FAKTUR-171114-NO1</td>
                            <td>11/14/2017 12:00:00 AM</td>
                            <td>064-0/KU-SEID/XI/2017</td>
                            <td>KARYA UTAMA, CV.</td>
                            <td>
                              {!! get_button_delete() !!}
                            </td>
                          </tr>
                        </table>
                      </form>
                      <hr>
                      <br>
                      <div class="row">
                        <div class="input-field col s12 m3">
                          <input type="text" placeholder="" class="">
                          <label>Logistic Staff</label>
                        </div>
                        <div class="input-field col s12 m3">
                          <input type="text" placeholder="" class="">
                          <label>Logistic Ass. SUpervisor</label>
                        </div>
                        <div class="input-field col s12 m3">
                          <input type="text" placeholder="" class="">
                          <label>Logistic Ass. Manager</label>
                        </div>
                        <div class="input-field col s12 m3">
                          <input type="text" placeholder="" class="">
                          <label>Accounting</label>
                        </div>
                      </div>
                      {!! get_button_save() !!}
                      {!! get_button_print(url('#'), 'Print Receipt Accounting') !!}
                    </div>
                </div>
                <!-- Input Payment -->
                <div class="card">
                    <div class="card-content">
                      <h4 class="card-title">INPUT PAYMENT REQUISITION</h4>
                      <hr>
                      <br>
                      <form class="form-table">
                        <table>
                          <tr>
                            <td bgcolor="#344b68" class="label white-text center-align">EXPEDITION NAME</td>
                            <td bgcolor="#344b68" class="label white-text center-align">PAYMENT REQUISITION</td>
                          </tr>
                          <tr>
                            <td>KARYA UTAMA, CV.</td>
                            <td>
                              <div class="input-field col s12 m6">
                                <input id="payment" type="text" class="validate" required>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </form>
                      {!! get_button_save() !!}
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
    // var dtdatatable = $('#data-table-section-contents').DataTable({
    //     serverSide: false,
    //     scrollX: true,
    //     responsive: true,
    //     paging: false,
    //     order: [1, 'asc'],
    // });

    $('#data-table-section-contents').on('click', '.btn-delete', function(event) {
      event.preventDefault();
      /* Act on the event */
      // Ditanyain dulu usernya mau beneran delete data nya nggak.
      swal({
        text: "Delete the receipt?",
        icon: 'warning',
        buttons: {
          cancel: true,
          delete: 'Yes, Delete It'
        }
      }).then(function (confirm) { // proses confirm
        if (confirm) {
          $(".btn-delete").closest("tr").remove();
          swal("Good job!", "You clicked the button!", "success") // alert success
          //datatable memunculkan no data available in table
        }
      })
    });
</script>
@endpush