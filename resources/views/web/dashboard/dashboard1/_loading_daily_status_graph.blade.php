<div id="Chart1_container"></div>

@push('script_css')
<link rel="stylesheet" type="text/css" href="{{ url('vendors/highchart/highcharts.css') }}">
@endpush

@push('vendor_js')
<script src="{{asset('vendors/highchart/highcharts.js')}}"></script>
<script src="{{asset('vendors/highchart/drilldown.src.js')}}"></script>
<script src="{{asset('vendors/highchart/grouped-categories.js')}}"></script>
<script src="{{asset('vendors/highchart/modules/exporting.js')}}"></script>
{{-- <script src="{{asset('vendors/highchart/modules/export-data.js')}}"></script> --}}
<script src="{{asset('vendors/highchart/jquery.highchartTable.js')}}"></script>
{{-- <script src="{{asset('vendors/highchart/modules/accessibility.js')}}"></script> --}}
@endpush

@push('script_js')
<script type="text/javascript">
  var cbm_of_concept = [{ y: 0 }, { y: 780 }, { y: 97 }, { y: 346 }, { y: 6 }, { y: 3149 }, { y: 127 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 315 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 206 }, { y: 0 }, { y: 0 }, { y: 64 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 70 }, { y: 0 }, { y: 0 }, { y: 65 }, { y: 86 }, { y: 16 }, { y: 0 }, { y: 450 }, { y: 0 }];
  var cbm_of_truck = [{ y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 325 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 205 }, { y: 0 }, { y: 0 }, { y: 65 }, { y: 0 }, { y: 0 }, { y: 0 }, { y: 65 }, { y: 0 }, { y: 0 }, { y: 65 }, { y: 108 }, { y: 25 }, { y: 0 }, { y: 490 }, { y: 0 }]

  $('#Chart1_container').highcharts({
    chart: { renderTo: 'Chart1_container', height: 1000, type: 'column' },
    plotOptions: { column: { borderWidth: 0, pointPadding: 150, pointWidth: 16 }, series: { dataLabels: { align: 'left', color: '#FF0000', enabled: true, formatter: function() { if (this.y != 0) return this.y; }, padding: 5, style: { fontSize: '9px', fontFamily: 'Verdana, sans-serif' } } } },
    subtitle: { text: 'KARAWANG {{date("Y-m-d")}}' },
    title: { text: 'Loading Daily Status' },
    tooltip: { formatter: function() { return '' + this.x + ': ' + this.y + ' m3'; } },
    xAxis: {
      categories: [
        { name: 'Waiting Truck', categories: ['8 METER', 'CONTAINER', 'LIGHT TRUCK', 'SMALL TRUCK', 'TRAILER', 'TRONTON', 'WINGBOX'] }, { name: 'Waiting Concept', categories: ['8 METER', 'CONTAINER', 'LIGHT TRUCK', 'SMALL TRUCK', 'TRAILER', 'TRONTON', 'WINGBOX'] }, { name: 'Waiting Loading', categories: ['8 METER', 'CONTAINER', 'LIGHT TRUCK', 'SMALL TRUCK', 'TRAILER', 'TRONTON', 'WINGBOX'] }, { name: 'Loading Process', categories: ['8 METER', 'CONTAINER', 'LIGHT TRUCK', 'SMALL TRUCK', 'TRAILER', 'TRONTON', 'WINGBOX'] }, { name: 'Waiting D/O', categories: ['8 METER', 'CONTAINER', 'LIGHT TRUCK', 'SMALL TRUCK', 'TRAILER', 'TRONTON', 'WINGBOX'] },
      ],
      labels: {
        groupedOptions: [{
            style: {
                color: 'black', // set red font for labels in 1st-Level  
            },
            rotation: 0, // rotate labels for a 2nd-level
            align: 'center'
        }],
        rotation: 90 // 0-level options aren't changed, use them as always
    },
    },
    yAxis: { min: 0, title: { text: '' } },
    series: [{ data: cbm_of_truck, name: 'CBM of Truck' }, { data: cbm_of_concept, name: 'CBM of Concept' }]
  });
</script>
@endpush