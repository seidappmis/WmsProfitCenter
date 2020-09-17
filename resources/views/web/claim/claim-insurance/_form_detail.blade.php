<form class="form-table" id="form-claim-note-detail">
    <table>
        
        <tr>
            <td>Serial Number</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Product</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>UNIT</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Currency</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Price/Unit</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Nature of Loss</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Location</td>
            <td>
                <input type="text" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Photo</td>
            <td>
                <input type="number" class="validate" >
            </td>
        </tr>
        <tr>
            <td>Remarks</td>
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