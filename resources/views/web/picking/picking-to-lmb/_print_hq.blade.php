<html>
<head>
<link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/print1-hq.css') }}">
</head>
<body style="font-family: Arial;">
    <htmlpageheader name="myHeader1">
        <div style="position: absolute;top: 38mm;left: 156mm;font-size: 10pt;">
            {{$lmbHeader->picking->picking_no}}
        </div>
        <div style="position: absolute;top: 48mm">
            <table  style="font-size: 10pt;line-height: 1.4">
                
                <tr>
                    <td style="width: 63mm;"></td>
                    <td style="width: 93mm;">{{ date('d/m/Y h:i:s A', strtotime($lmbHeader->created_at)) }}</td>
                    <td>{{$lmbHeader->expedition_name}}</td>
                    
                </tr>
                <tr>
                    <td ></td>
                    <td >- </td>
                    <td >{{$lmbHeader->vehicle_number}}/{{$lmbHeader->destination_number != 'AS' ? $lmbHeader->picking->vehicle->vehicle_description : ''}}</td>

                </tr>
                <tr>
                    <td ></td>
                    <td >{{$lmbHeader->destination_name}}</td>

                    @if($lmbHeader->cabang->hq)
                    <td >{{$lmbHeader->container_no}}</td>
                    @else 
                    <td >{!! $lmbHeader->getCustomer() !!}</td>
                    @endif
                </tr>
                <tr>
                    <td ></td>
                    <td >{{$lmbHeader->short_description_cabang}}</td>
                    <td >{{$lmbHeader->seal_no}}</td>

                </tr>
            </table>
        </div>
    </htmlpageheader>
    <sethtmlpageheader name="myHeader1" value="on" show-this-page="1"/>

    <div style="padding-left: 25mm;padding-right: 20mm;">
    {{-- Main Table --}}
    
    <table width="100%" style="border-collapse: collapse; font-size: 10pt;margin-top: 88mm;">
        <tr>
            <td style="text-align: center; width: 13mm;"></td>
            <td style="text-align: center; width: 36mm;"></td>
            <td style="text-align: center; width: 18mm;"></td>
            <td style="text-align: center; " colspan="12" ></td>
        </tr>
        {{-- Table Body --}}
        @php
        $row_no = 1;
        @endphp
        @foreach($rs_details AS $k_model => $v_model)
        @php 
        $row_serial_pointer = 1;
        $row_serial_total = ceil(count($v_model['serial_numbers']) / 3);
        $serial_pointer = 0;
        $qty = count($v_model['serial_numbers']);
        @endphp
        <tr>
            <td rowspan="{{$row_serial_total}}" style="
            text-align: center;  
            vertical-align: top;
            {{$row_no == count($rs_details) ? '' : ''}}">
                {{$row_no}}
            </td>
            <td rowspan="{{$row_serial_total}}"  style="
            text-align: center;  
            vertical-align: top;
            {{$row_no == count($rs_details) ? '' : ''}}">
                {{$k_model}}
            </td>
            <td rowspan="{{$row_serial_total}}"  style="
            text-align: center;  
            vertical-align: top;
            {{$row_no == count($rs_details) ? '' : ''}}">
                {{$qty}}
            </td>
            <td style="text-align: center; width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
            <td style="text-align: center; width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
            <td style="text-align: center; width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
        </tr>

        @while($row_serial_pointer < $row_serial_total)
        <tr>
            <td style="text-align: center;  width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
            <td style="text-align: center;  width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
            <td style="text-align: center;  width: 34mm" >
                {{!empty($v_model['serial_numbers'][$serial_pointer]) ? serial_no_explode($v_model['serial_numbers'][$serial_pointer++]) : ''}}
            </td>
        </tr>

        @php
        $row_serial_pointer ++;
        @endphp
        @endwhile

        @php
        $row_no++;
        @endphp
        @endforeach
    </table>
    {{-- End Main Table --}}
    </div>
</body>
