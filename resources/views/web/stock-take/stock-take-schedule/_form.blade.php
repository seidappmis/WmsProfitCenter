<form class="form-table" id="form-stock-take-schedule">
  <table>
    <tr>
      <td>STO NO.</td>
      <td>
        <div class="input-field col s12 m4">
          <input id="sto_id" type="text" class="validate" name="sto_id" value="{{old('sto_id', !empty($stockTakeSchedule) ? $stockTakeSchedule->sto_id : 'KRW-STO-2232-001')}}" required readonly>
        </div>
      </td>
    </tr>
    <tr>
      <td>AREA</td>
      <td>
        <div class="input-field col s12 m4">
          <input id="area" type="text" class="validate" name="area" value="{{old('area', !empty($stockTakeSchedule) ? $stockTakeSchedule->area : '')}}" readonly>
        </div>
      </td>
    </tr>
    <tr>
      <td>BRANCH</td>
      <td>
        <div class="input-field col s12 m4">
          <input id="kode_cabang" name="kode_cabang" type="text" readonly>
          <input id="desc_cabang" name="desc_cabang" type="text" class="validate" value="{{old('branch', !empty($stockTakeSchedule) ? $stockTakeSchedule->location : ' ')}}" readonly>
        </div>
      </td>
    </tr>
    <tr>
      <td>DESCRIPTION</td>
      <td>
        <div class="input-field col s12">
              <textarea id="description" name="description" class="materialize-textarea">{{old('description', !empty($stockTakeSchedule) ? $stockTakeSchedule->description : '')}}</textarea>
        </div>
      </td>
    </tr>
    <tr>
      <td class="label">SCHEDULE DATE</td>
      <td>
        <div class="input-field col s6">
          <div class="col s3 m2 label">
            START
          </div>
          <div class="col s9 m10">
            <input id="schedule_start_date" name="schedule_start_date" type="text" class="validate datepicker" value="{{old('schedule_start_date', !empty($stockTakeSchedule) ? $stockTakeSchedule->schedule_start_date : '')}}" required>
          </div>
        </div>
        <div class="input-field col s6">
          <div class="col s3 m2 label">
            END
          </div>
          <div class="col s9 m10">
            <input id="schedule_end_date" name="schedule_end_date" type="text" class="validate datepicker" value="{{old('schedule_end_date', !empty($stockTakeSchedule) ? $stockTakeSchedule->schedule_end_date : '')}}" required>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <td class = "label">DATA FILE</td>
      <td>
        <div class="file-field input-field col s12 m5 l5">
          <div class="btn btn-small waves-effect waves-light">
            <span>Browse</span>
            <input type="file" name="file-stock-take-schedule">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Select File..">
          </div>
        </div>
        <div class="col s12 m5 l5 ml-2 mt-2">
        <p>Format File : .csv</p>
      </div>
      </td>
    </tr>
  </table>
  {!! get_button_save() !!}
  {!! get_button_cancel(url('stock-take-schedule')) !!}
</form>

@push('script_js')
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#kode_cabang').hide();
  });
</script>
@endpush