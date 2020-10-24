@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m10">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Billing Return</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('billing-return') }}">Billing Return</a></li>
                    <li class="breadcrumb-item active">{{$manifest->do_manifest_no}}</li>
                </ol>
            </div>
            <div class="col s12 m2">
              <div class="display-flex">
                {{-- @component('layouts.materialize.components.back-button')
                @endcomponent --}}
              </div>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form id="form-billing-return">
                      <div class="row">
                        <div class="col s12 m3">
                          @if($type_show == 'showSubmit')
                          <span class="waves-effect waves-light btn blue darken-2 btn-conform">Conform</span>
                          <div class="input-field col s12">
                            <input id="doc_do_return_date" type="text" class="validate datepicker" name="doc_do_return_date" required>
                            <label for="doc_do_return_date">Document DO Return Date</label>
                          </div>
                          @endif
                        </div>
                      </div>
                      <div class="section-data-tables"> 
                        <table id="data-table-section-contents" class="bordered" width="100%">
                            <thead>
                                <tr>
                                  <th>DO MANIFEST</th>
                                  <th>EXPEDITION NAME</th>
                                  <th>DESTINATION CITY</th>
                                  <th>MODEL</th>
                                  <th>QUANTITY</th>
                                  <th width="50px;">
                                    @if($type_show == 'showSubmit')
                                    <label>
                                      <input class="checkbox_header" type="checkbox" />
                                      <span class="red-text"></span>
                                    </label>
                                    @endif
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($manifest->details AS $key => $detail)
                              <tr>
                                @if($key == 0)
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->do_manifest_no}}</td>
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->expedition_name}}</td>
                                <td rowspan="{{$manifest->details->count()}}">{{$manifest->city_name}}</td>
                                @endif
                                <td>{{$detail->model}}</td>
                                <td>{{$detail->quantity}}</td>
                                <td>
                                  @if($type_show == 'showSubmit')
                                  <label>
                                    <input class="checkbox_detail" type="checkbox" name="manifest_detail[{{$detail->id}}]"/>
                                    <span class="red-text"></span>
                                  </label>
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                      <!-- datatable ends -->
                      </form>
                      {!! get_button_cancel(url('billing-return'), 'Back') !!}
                    </div>
                    <div class="card-content p-0">

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
    jQuery(document).ready(function($) {

        $('.checkbox_header').click(function(event) {
          /* Act on the event */
          if ($(this).is(':checked')) {
            $('.checkbox_detail').prop('checked', true)
          } else {
            $('.checkbox_detail').prop('checked', false)
          }
        });
          
        $('.btn-conform').click(function(event) {
          /* Act on the event */
          setLoading(true);
          $.ajax({
            url: '{{url('billing-return/' . $manifest->do_manifest_no)}}',
            type: 'PUT',
            dataType: 'json',
            data: $('#form-billing-return').serialize(),
          })
          .done(function(result) {
            if (result.status) {
              window.location.href = '{{url('billing-return')}}'
            } else {
              setLoading(false);
              showSwalAutoClose('Warning', result.message)
            }
          })
          .fail(function() {
            setLoading(false);
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
        });
    });
</script>
@endpush