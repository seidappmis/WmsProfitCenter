@extends('layouts.materialize.index')

@section('content')
  @component('layouts.materialize.components.title-wrapper')
      <div class="row">
          <div class="col s12 m8 mb-1">
              <h5 class="breadcrumbs-title mt-0 mb-0"><span>Graphic Dashboard</span></h5>
              <ol class="breadcrumbs mb-0">
                  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                  <li class="breadcrumb-item active">Graphic Dashboard</li>
              </ol>
          </div>
          <div class="col s12 m4">
            <!---- Search ----->
                <div class="app-wrapper">
                  <div class="datatable-search">
                    <select id="area_filter" class="select2-data-ajax browser-default app-filter">
                    </select>
                  </div>
                </div>
          </div>
      </div>
  @endcomponent

<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="card mb-0">
                <div class="card-content">
                    @include('web.dashboard.dashboard1._loading_daily_status_graph')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Status CBM of Concept List</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align: center;">STATUS</th>
                                    <th style="text-align: center;">WAITING TRUCK</th>
                                    <th style="text-align: center;">WAITING LOADING</th>
                                    <th style="text-align: center;">LOADING PROCESS</th>
                                    <th style="text-align: center;">WAITING D/O</th>
                                    <th style="text-align: center;">COMPLETE</th>
                                    <th style="text-align: center;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;"><strong>CBM OF CONCEPT</strong></td>
                                    <td style="text-align: center;"><strong>4504</strong></td>
                                    <td style="text-align: center;"><strong>512</strong></td>
                                    <td style="text-align: center;"><strong>134</strong></td>
                                    <td style="text-align: center;"><strong>617</strong></td>
                                    <td style="text-align: center;"><strong>0</strong></td>
                                    <td style="text-align: center;"><strong>5576</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0">Waiting Truck All Area</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th style="text-align: center;">SUBJECT</th>
                                    <th style="text-align: center;">KARAWANG</th>
                                    <th style="text-align: center;">SURABAYA HUB</th>
                                    <th style="text-align: center;">SWADAYA</th>
                                    <th style="text-align: center;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;"><strong>CBM TOTAL</strong></td>
                                    <td style="text-align: center;"><strong>4504</strong></td>
                                    <td style="text-align: center;"><strong>112</strong></td>
                                    <td style="text-align: center;"><strong>606</strong></td>
                                    <td style="text-align: center;"><strong>5222</strong></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;"><strong>VEHICLE PLAN (UNIT TRUCK)</strong></td>
                                    <td style="text-align: center;"><strong>141</strong></td>
                                    <td style="text-align: center;"><strong>19</strong></td>
                                    <td style="text-align: center;"><strong>56</strong></td>
                                    <td style="text-align: center;"><strong>216</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#area_filter').select2({
           placeholder: '-- Select Area --',
           allowClear: true,
           ajax: get_select2_ajax_options('/master-area/select2-area-only')
        });
        @if (auth()->user()->area != 'All')
        set_select2_value('#area_filter', '{{auth()->user()->area}}', '{{auth()->user()->area}}')
        $('#area_filter').attr('disabled','disabled')
      @endif
    });
</script>
@endpush