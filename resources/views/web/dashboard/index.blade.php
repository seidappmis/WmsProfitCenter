@extends('layouts.materialize.index')

@section('content')
<div class="row">
    <div class="col s12">
        sdf
    </div>
</div>
<div class="row">
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                        <h4 class="header m-0">Status CBM of Concept List</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>STATUS</th>
                                    <th>WAITING TRUCK</th>
                                    <th>WAITING LOADING</th>
                                    <th>LOADING PROCESS</th>
                                    <th>WAITING D/O</th>
                                    <th>COMPLETE</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CBM OF CONCEPT</td>
                                    <td>4504</td>
                                    <td>512</td>
                                    <td>134</td>
                                    <td>617</td>
                                    <td>0</td>
                                    <td>5576</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card m-0">
                    <div class="card-content">
                        <h4 class="header m-0">Waiting Truck All Area</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>SUBJECT</th>
                                    <th>KARAWANG</th>
                                    <th>SURABAYA HUB</th>
                                    <th>SWADAYA</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CBM TOTAL</td>
                                    <td>4504</td>
                                    <td>112</td>
                                    <td>606</td>
                                    <td>5222</td>
                                </tr>
                                <tr>
                                    <td>VEHICLE PLAN (UNIT TRUCK)</td>
                                    <td>141</td>
                                    <td>19</td>
                                    <td>56</td>
                                    <td>216</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection