<div class="col s12">
    <div class="container">
        <div class="section">
          <div class="card">
            <div class="card-content">
              <form id="form-filter-periode">
                
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
                        <p id="text-stocktake-periode" style="background-color: #ebe060;"></p>
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
                    {!! get_button_print('#', 'Print', 'btn-print hide') !!}
                    </div>
                  </div>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Load Modal Print --}}
@include('layouts.materialize.components.modal-print', [
  'title' => 'Print',
])

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#sto_id').change(function(event) {
      /* Act on the event */
      if ($(this).val() != null) {
        $('.filter-wrapper').removeClass('hide')
        var data = $(this).select2('data')[0]
        $('#text-stocktake-periode').text(data.schedule_start_date + ' S/D ' + data.schedule_end_date)
        $('#text-stocktake-description').text(data.description)
      } else {
        $('.filter-wrapper').addClass('hide')
      }
    });

    $('.btn-print').click(function(event) {
      /* Act on the event */
      initPrintPreviewPrint(
            '{{url("stock-take-quick-count")}}' + '/' + $('#sto_id').val() + '/export',
            $('#form-print').serialize()
          )
    });

    setInterval(function(){ 
      
      if($('#sto_id').val()==''){
        console.log('no periode selected');       
      }
      else{
        $('#form-filter-periode').validate({
          submitHandler: function (form){
            $.ajax({
              url: '{{url("stock-take-quick-count")}}',
              type: 'GET',
              dataType: 'json',
              data: $(form).serialize(),
            })
            .done(function(result) {
              if (result.status) {
                $('.quick-count-wrapper').removeClass('hide');
                $('#form-stock-take-summary [name="total_all_tag_no"]').val(result.data.total_all_tag_no)
                $('#form-stock-take-summary [name="total_all_models"]').val(result.data.total_all_models)
                $('#form-stock-take-summary [name="total_all_location"]').val(result.data.total_all_location)
                $('#form-stock-take-summary [name="summary_tag_compared_matched"]').val(result.data.summary_tag_compared_matched)
                $('#form-stock-take-summary [name="diff_qty"]').val(result.data.diff_qty)
                $('#form-stock-take-summary [name="only_input_1"]').val(result.data.only_input_1)
                $('#form-stock-take-summary [name="only_input_2"]').val(result.data.only_input_2)
                dttable_input_1.ajax.reload(null, false)
                dttable_input_2.ajax.reload(null, false)
                dttable_different_quantity.ajax.reload(null, false)
              } else {
                $('.quick-count-wrapper').addClass('hide')
              }
            })
            .fail(function() {
              console.log("error");
            })
            .always(function() {
              console.log("complete");
            });
            
          }
        })
      }
    }, 30000);    
  });
</script>
@endpush