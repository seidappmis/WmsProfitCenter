@extends('layouts.materialize.index')

@section('content')
<div class="row">

  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m12 mb-0">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Quick Count</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Stock Take Quick Count</li>
              </ol>
          </div>
      </div>


  @endcomponent

  <div class="col s12">
        <div class="container">
            <div class="section">
              <div class="card">
                <div class="card-content">

                  <div class="row">
                    <div class="col s12 m2 pt-2">
                        <p>Periode STO</p>
                    </div>
                    <div class="col s12 m4">
                      <!---- Search ----->
                      <div class="app-wrapper">
                          <div class="datatable-search">
                          <select id="sto_id" name="sto_id">
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6">

                    </div>
                  </div>

                  <div class="filter-wrapper hide">
                    <div class="row">
                      <div class="col s12 m2">
                          <p>Periode</p>
                      </div>
                      <div class="col s12 m4">
                          <p id="text-stocktake-periode"></p>
                      </div>
                      <div class="col s12 m6">

                      </div>
                      <br>
                      <div class="col s12 m2">
                          <p>Description</p>
                      </div>
                      <div class="col s12 m4">
                          <p id="text-stocktake-description"></p>
                      </div>
                      <div class="col s12 m6">

                      </div>

                    </div>

                    <div class="row">
                      <div class="col s12">
                      {!! get_button_save('Load', 'btn-load') !!}
                      </div>
                    </div>
                  </div>


            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col s12">
        <div class="container quick-count-wrapper hide">
            <div class="section">
              <div class="card">
                <div class="card-content">
                <div class="row">
                    <div class="input-field col s12 m6">
                      <input value="Only in Input 1" id="ston1" type="text" class="validate" name="ston1" validated>
                    </div>
                    <div class="input-field col s12 m6 mb-10">
                      <input value="Only in Input 2" id="ston2" type="text" class="validate" name="ston2" validated>
                    </div>

                    <div class="input-field col s12 mb-10">
                      <input value="Diffrent Quantity" id="ston3" type="text" class="validate" name="ston3" validated>
                    </div>
                </div>
                <div class="row">
                  <div class="col s12">
                  <form class="form-table">
                      <table>
                        <tr>
                          <td>Total All Tag no</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="204" id="atn" type="text" class="validate" name="atn" required>
                            </div>
                          </td>
                             <td>Total All Models</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="204" id="tam" type="text" class="validate" name="tam" required>
                            </div>
                          </td>
                             <td>Total All Location</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="14" id="tal" type="text" class="validate" name="tal" required>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2" >Summary tag Compared Match</td>
                          <td colspan="2">
                            <div class="input-field col s12">
                              <input value="201" id="loca" type="text" class="validate" name="loca" required>
                            </div>
                          </td>
                            <td>Diff City</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="0" id="loca" type="text" class="validate" name="loca" required>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2" >Only Input 1</td>
                          <td colspan="2">
                            <div class="input-field col s12">
                              <input value="201" id="loca" type="text" class="validate" name="loca" required>
                            </div>
                          </td>
                            <td>Only Input 2</td>
                          <td>
                            <div class="input-field col s12">
                              <input value="201" id="loca" type="text" class="validate" name="loca" required>
                            </div>
                          </td>
                        </tr>
                    </table>

                </form>
                  </div>

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
  $('#sto_id').select2({
       placeholder: '-- Select Schedule ID --',
       allowClear: true,
       ajax: get_select2_ajax_options('/stock-take-schedule/select2-schedule')
    });
</script>
@endpush
