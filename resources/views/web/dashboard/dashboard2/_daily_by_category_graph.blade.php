<div id="Chart3_container"></div>
<table class="table">
  <thead>
    <tr>
      <th>CATEGORIES</th>
      <th>WAITING TRUCK</th>
      <th>WAITING CONCEPT</th>
      <th>WAITING LOADING</th>
      <th>LOADING PROCESS</th>
      <th>WAITING D/O</th>
    </tr>
  </thead>
  <tbody>
    {{-- <tr>
      <td>TRAILER</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>TRONTON</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>CONTAINER</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>WINGBOX</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>LIGHT TRUCK</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
    <tr>
      <td>SMALL TRUCK</td>
      <td>1</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr> --}}
  </tbody>
  <tfoot>
    <tr>
      <td>TOTAL</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
      <td>0</td>
    </tr>
  </tfoot>
</table>

@push('script_css')
<style type="text/css">
  .table thead tr th {
    font-size: 12px !important; 
    font-weight: 800;
  }

  .table tbody tr td {
    font-size: 12px !important; 
    padding: 5px;
  }
</style>
@endpush

@push('script_js')
<script src="{{asset('vendors/highcharts/highcharts.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/exporting.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/export-data.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/accessibility.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
  Chart3 = new Highcharts.Chart({
    chart: { renderTo:'Chart3_container', marginRight: 40, marginTop: 80, options3d: { alpha: 15, beta: 15, depth: 40, enabled: true, viewDistance: 24 }, type: 'column' }, 
    plotOptions: { column: { depth: 25, stacking: 'normal' } }, 
    subtitle: { text: 'KARAWANG {{date("Y-m-d")}}' }, 
    title: { text: 'Daily by Category' }, 
    tooltip: { headerFormat: '<b>{point.key}</b><br>', pointFormat: '<span style="color:{series.color}">●</span> {series.name}: {point.y} ' }, 
    xAxis: { categories: ['WAITING TRUCK', 'WAITING CONCEPT', 'WAITING LOADING', 'LOADING PROCESS', 'WAITING D/O'] }, 
    yAxis: { allowDecimals: false, stackLabels: { enabled: true }, title: { text: '' } }, 
    series: [
    { data: [{ y: 1 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }], name: 'TRAILER' }, 
    { data: [{ y: 70 }, { y: 0 }, { y: 3 }, { y: 1 }, { y: 7 }], name: 'TRONTON' }, 
    { data: [{ y: 23 }, { y: 0 }, { y: 5 }, { y: 1 }, { y: 1 }], name: 'CONTAINER' }, 
    { data: [{ y: 1 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }], name: 'WINGBOX' }, 
    { data: [{ y: 4 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 3 }], name: 'LIGHT TRUCK' }, 
    { data: [{ y: 42 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 1 }], name: 'SMALL TRUCK' }
    ]
  });
});
</script>
@endpush