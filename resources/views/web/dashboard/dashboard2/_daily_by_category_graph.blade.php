<div id="Chart3_container"></div>
<table class="table" id="table-daily-by-category">
  <thead>
    <tr>
      <th style="text-align: center;">CATEGORIES</th>
      <th style="text-align: center;">WAITING TRUCK</th>
      <th style="text-align: center;">WAITING CONCEPT</th>
      <th style="text-align: center;">WAITING LOADING</th>
      <th style="text-align: center;">LOADING PROCESS</th>
      <th style="text-align: center;">WAITING D/O</th>
    </tr>
  </thead>
  <tbody>
   {{--  <tr>
      <td style="text-align: center;">TRAILER</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center;">TRONTON</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center;">CONTAINER</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center;">WINGBOX</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center;">LIGHT TRUCK</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr>
    <tr>
      <td style="text-align: center;">SMALL TRUCK</td>
      <td style="text-align: center;">1</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
      <td style="text-align: center;">0</td>
    </tr> --}}
  </tbody>
  <tfoot>
    <tr>
      <td style="text-align: center;">TOTAL</td>
      <th style="text-align: center;"><span id="text-total-waiting-truck"></span></th>
      <th style="text-align: center;"><span id="text-total-waiting-concept"></span></th>
      <th style="text-align: center;"><span id="text-total-waiting-loading"></span></th>
      <th style="text-align: center;"><span id="text-total-loading-process"></span></th>
      <th style="text-align: center;"><span id="text-total-waiting-do"></span></th>
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

@push('vendor_js')
<script src="{{asset('vendors/highcharts/highcharts.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/exporting.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/export-data.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/accessibility.js')}}"></script>
@endpush

@push('script_js')
<script type="text/javascript">
$(document).ready(function() {
  loadDailyByCategory()
  setInterval( loadDailyByCategory, 60000 );
});

function loadDailyByCategory(){
  $.ajax({
    url: '{{url('dashboard2/daily-by-category')}}',
    type: 'GET',
    dataType: 'json',
    data: {area: $('#area_filter').val()},
  })
  .done(function(result) {
    if (result.status) {
      Chart3 = new Highcharts.Chart({
        chart: { renderTo:'Chart3_container', marginRight: 40, marginTop: 80, options3d: { alpha: 15, beta: 15, depth: 40, enabled: true, viewDistance: 24 }, type: 'column' }, 
        plotOptions: { column: { depth: 25, stacking: 'normal' } }, 
        subtitle: { text: result.data.subtitle_text }, 
        title: { text: 'Daily by Category' }, 
        tooltip: { headerFormat: '<b>{point.key}</b><br>', pointFormat: '<span style="color:{series.color}">●</span> {series.name}: {point.y} ' }, 
        xAxis: { categories: result.data.rs_daily_by_category_categories }, 
        yAxis: { allowDecimals: false, stackLabels: { enabled: true }, title: { text: '' } }, 
        series: result.data.rs_daily_by_category_series
      });

      // Load Table
      $('#table-daily-by-category tbody').empty();
      var row = '';
      var total = [];
      $.each(result.data.rs_daily_by_category_series, function(index, val) {
         /* iterate through array or object */
         total[0] = (total[0] == undefined) ? parseInt(val.data[0]) : (total[0] + parseInt(val.data[0]));
         total[1] = (total[1] == undefined) ? parseInt(val.data[1]) : (total[1] + parseInt(val.data[1]));
         total[2] = (total[2] == undefined) ? parseInt(val.data[2]) : (total[2] + parseInt(val.data[2]));
         total[3] = (total[3] == undefined) ? parseInt(val.data[3]) : (total[3] + parseInt(val.data[3]));
         total[4] = (total[4] == undefined) ? parseInt(val.data[4]) : (total[4] + parseInt(val.data[4]));
         row += '<tr>';
         row += '<td> ' + val.name + ' </td>';
         row += '<td style="text-align: center;"> ' + val.data[0] + ' </td>';
         row += '<td style="text-align: center;"> ' + val.data[1] + ' </td>';
         row += '<td style="text-align: center;"> ' + val.data[2] + ' </td>';
         row += '<td style="text-align: center;"> ' + val.data[3] + ' </td>';
         row += '<td style="text-align: center;"> ' + val.data[4] + ' </td>';
         row += '</tr>';
      });
      $('#table-daily-by-category tbody').append(row)
      $('#text-total-waiting-truck').text(total[0])
      $('#text-total-waiting-concept').text(total[1])
      $('#text-total-waiting-loading').text(total[2])
      $('#text-total-loading-process').text(total[3])
      $('#text-total-waiting-do').text(total[4])

      // Load Pie Chart
      Chart2 = new Highcharts.Chart({
        chart: { renderTo:'Chart2_container', height: 500, margin: [75, 5, 75, 5], plotShadow: false, type: 'pie' }, 
        legend: { align: 'center', backgroundColor: '#FFFFFF', itemStyle: { fontSize: '15px', fontFamily: 'Verdana', fontBold: 'true', color: 'Black' }, labelFormat: 'function() { return this.point.name + '- ' +this.percentage.toFixed(0) +' %'; }', layout: 'horizontal', shadow: false, useHTML: true }, 
        plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { color: '#000000', connectorColor: '#000000', enabled: true, formatter: function() { return this.percentage.toFixed(0) +' %'; }, style: { fontSize: '20px', fontFamily: 'Verdana', fontBold: 'true', color: 'Black' } }, showInLegend: true } }, 
        subtitle: { text: result.data.subtitle_text }, 
        title: { text: 'Daily Status by Destination' }, 
        tooltip: { headerFormat: '<b>{point.key}</b><br>', pointFormat: '{series.name}: <b>{point.y}</b>' }, 
        series: [{ data: result.data.rs_by_destination_series_data, name: 'By Destination', type: 'pie' }]
      });
    }
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  
}
</script>
@endpush