<form class="form-table" id="form-model-exception">
  <table>
    <tr>
      <td>Model Exception</td>
      <td>
        <div class="input-field col s12">
          <input type="text" id="model" name="model" required>
        </div>
      </td>
    </tr>
  </table>
  {!! get_button_save() !!}
  {!! get_button_cancel(url('master-model-exception')) !!}
</form>