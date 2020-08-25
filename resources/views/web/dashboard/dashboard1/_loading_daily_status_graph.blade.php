<div id="Chart1_container"></div>

@push('script_css')
<link rel="stylesheet" type="text/css" href="{{ url('vendors/highchart/highchart.css') }}">
@endpush

@push('vendor_js')
<script src="{{asset('vendors/highchart/highcharts.js')}}"></script>
<script src="{{asset('vendors/highchart/drilldown.src.js')}}"></script>
<script src="{{asset('vendors/highchart/grouped-categories.js')}}"></script>
<script src="{{asset('vendors/highchart/exporting.js')}}"></script>
{{-- <script src="{{asset('vendors/highchart/modules/export-data.js')}}"></script> --}}
<script src="{{asset('vendors/highchart/jquery.highchartTable.js')}}"></script>
{{-- <script src="{{asset('vendors/highchart/modules/accessibility.js')}}"></script> --}}
@endpush

@push('script_js')
<script type="text/javascript">

  jQuery(document).ready(function($) {
    loadLoadingDailyStatus()
    setInterval( loadLoadingDailyStatus, 60000 );
  });

  function loadLoadingDailyStatus(){
    $.ajax({
      url: '{{url('dashboard/loading-daily-status')}}',
      type: 'GET',
      dataType: 'json',
      data: {area: $('#area_filter').val()},
    })
    .done(function(result) {
      $('#Chart1_container').highcharts({
        chart: { renderTo: 'Chart1_container', height: 800, type: 'column' },
        plotOptions: { column: { borderWidth: 0, pointPadding: 150, pointWidth: 16 }, series: { dataLabels: { align: 'left', color: '#FF0000', enabled: true, formatter: function() { if (this.y != 0) return this.y; }, padding: 5, style: { fontSize: '9px', fontFamily: 'Verdana, sans-serif' } } } },
        subtitle: { text: result.data.subtitle_text },
        title: { text: 'Loading Daily Status' },
        tooltip: { formatter: function() { return '' + this.x + ': ' + this.y + ' m3'; } },
        xAxis: {
          categories: result.data.rs_chart_categories,
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
        series: [{ data: result.data.rs_cbm_of_truck, name: 'CBM of Truck' }, { data: result.data.rs_cbm_of_concept, name: 'CBM of Concept' }]
      });

      // Load data status CBM of Concept List
      var cbm_total = 0;

      var cbm_waiting_truck = result.data.rs_status_cbm_of_concept_list[0].value;
      cbm_total += parseFloat(cbm_waiting_truck);
      $('#text-status-cbm-concept-waiting-truck').text(cbm_waiting_truck);

      var cbm_waiting_loading = result.data.rs_status_cbm_of_concept_list[2].value;
      cbm_total += parseFloat(cbm_waiting_loading);
      $('#text-status-cbm-concept-waiting-loading').text(cbm_waiting_loading);

      var cbm_loading_process = result.data.rs_status_cbm_of_concept_list[3].value;
      cbm_total += parseFloat(cbm_loading_process);
      $('#text-status-cbm-concept-loading-process').text(cbm_loading_process);

      var cbm_waitng_do = result.data.rs_status_cbm_of_concept_list[4].value;
      cbm_total += parseFloat(cbm_waitng_do);
      $('#text-status-cbm-concept-waiting-do').text(cbm_waitng_do);
      
      var cbm_complete = result.data.rs_status_cbm_of_concept_list[5].value;
      cbm_total += parseFloat(cbm_complete);
      $('#text-status-cbm-concept-complete').text(cbm_complete);

      $('#text-status-cbm-concept-total').text(cbm_total);
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