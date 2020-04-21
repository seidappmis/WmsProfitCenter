@extends('layouts.materialize.index')
{{-- @include('admin.materi.modal_form_materi') --}}

@section('content')
<div class="row">

    @component('layouts.materialize.components.title-wrapper')
        <div class="row">
            <div class="col s12 m4">
                <h5 class="breadcrumbs-title mt-0 mb-0"><span>Upload Concept</span></h5>
                <ol class="breadcrumbs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Upload Concept</li>
                </ol>
            </div>
        </div>
    @endcomponent
    
    <div class="col s12">
        <div class="container">
            <div class="section">
                <div class="card">
                    <div class="card-content">
                      <form action="#">
                        <div class="file-field input-field">
                          <div class="btn">
                            <span>Data File</span>
                            <input type="file">
                          </div>
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                          </div>
                        </div>
                        <div class="input-field col s12 m6">
                          <select>
                            <option value="" disabled selected>-Select Area-</option>
                            <option>KARAWANG</option>
                            <option>SURABAYA HUB</option>
                            <option>SWADAYA</option>
                          </select>
                          <label>Area</label>
                        </div>
                        <div class="input-field col s12 m12 mb-2">
                          <button class="btn btn-large waves-effect waves-light btn-add" type="submit" name="action">
                            UPLOAD
                          </button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>
@endsection

@push('script_js')
<script type="text/javascript">
    var dtdatatable = $('#data-table-1').DataTable({
        serverSide: false,
        order: [1, 'asc'],
    });
    var dtdatatable2 = $('#data-table-2').DataTable({
        serverSide: false,
        order: [1, 'asc'],
    });
</script>
@endpush