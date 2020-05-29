<form class="form-table" id="form-claim-note-detail">
    <table>
        <tr>
            <td>Berita Acara</td>
            <td>
                <select name="berita_acara" class="select2-data-ajax browser-default" required>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Expedition Name</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Driver</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Car No</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Destination</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>DO No</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Model</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Serial No</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Qty</td>
            <td>
                <input type="number" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Location</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Damage Description</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Price</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
    </table>
    {!! get_button_save('Add Detail') !!}
</form>

@push('script_js')
<script type="text/javascript">
    $('#form-claim-note-detail [name="berita_acara"]').select2({
     placeholder: '-- Select Berita Acara --',
  });
</script>
@endpush