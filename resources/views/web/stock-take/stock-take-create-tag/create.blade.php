@extends('layouts.materialize.index')

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m6">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Take Create Tag</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stock Take Create Tag</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="row">
      <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content p-0">
                      <ul class="collapsible m-0">
                        <li class="active">
                          <div class="collapsible-header"><i class="material-icons">keyboard_arrow_right</i>Input Manual Tag</div>
                          <div class="collapsible-body">
                            <form class="form-table">
                              <table>
                                <tr>
                                  <td>Model</td>
                                  <td>
                                    <div class="input-field col s12">
                                      <select>
                                        <option value="" disabled selected>-- Select Model --</option>
                                      </select>
                                    </div>
                                  </td>
                                </tr>
                                
                                
                              </table>
                              <div class="row">
                                <div class="input-field col s12">
                                  {!! get_button_save() !!}
                                  {!! get_button_cancel(url('stock-take-create-tag')) !!}
                                </div>
                              </div>
                            </form>
                          </div>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>
      </div>

</div>
@endsection

@push('script_js')
<script type="text/javascript">
 	$('.collapsible').collapsible({
        accordion:true
    });
</script>
@endpush