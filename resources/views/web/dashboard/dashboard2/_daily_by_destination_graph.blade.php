<div id="Chart2_container"></div>

@push('script_js')
<script src="{{asset('vendors/highcharts/highcharts.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/exporting.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/export-data.js')}}"></script>
<script src="{{asset('vendors/highcharts/modules/accessibility.js')}}"></script>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    Chart2 = new Highcharts.Chart({
      chart: { renderTo:'Chart2_container', height: 500, margin: [75, 5, 75, 5], plotShadow: false, type: 'pie' }, 
      legend: { align: 'center', backgroundColor: '#FFFFFF', itemStyle: { fontSize: '15px', fontFamily: 'Verdana', fontBold: 'true', color: 'Black' }, labelFormat: 'function() { return this.point.name + '- ' +this.percentage.toFixed(0) +' %'; }', layout: 'horizontal', shadow: false, useHTML: true }, 
      plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { color: '#000000', connectorColor: '#000000', enabled: true, formatter: function() { return this.percentage.toFixed(0) +' %'; }, style: { fontSize: '20px', fontFamily: 'Verdana', fontBold: 'true', color: 'Black' } }, showInLegend: true } }, 
      subtitle: { text: 'KARAWANG {{date("Y-m-d")}}' }, 
      title: { text: 'Daily Status by Destination' }, 
      tooltip: { headerFormat: '<b>{point.key}</b><br>', pointFormat: '{series.name}: <b>{point.y}</b>' }, 
      series: [{ data: [['JAVA & BALI', 49], ['JABODETABEK', 62], ['SULAWESI', 14], ['SUMATERA', 27], ['KALIMANTAN', 10], ['OTHERS', 1]], name: 'By Destination', type: 'pie' }]
    });
  });
</script>
@endpush