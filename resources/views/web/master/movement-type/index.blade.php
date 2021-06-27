@extends('layouts.materialize.index')

@section('content')
<div class="row">

	@component('layouts.materialize.components.title-wrapper')
		<div class="row">
			<div class="col s12 m6">
				<h5 class="breadcrumbs-title mt-0 mb-0"><span>Movement Type</span></h5>
				<ol class="breadcrumbs mb-0">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
					<li class="breadcrumb-item active">Movement Type</li>
				</ol>
			</div>
			<div class="col s12 m6">
				<div class="display-flex">
					<div class="app-wrapper mr-2">
						<div class="datatable-search">
							<i class="material-icons mr-2 search-icon">search</i>
							<input type="text" class="app-filter" id="movement-type-filter" placeholder="Search">
						</div>
					</div>
				</div>
			</div>
		</div>
	@endcomponent

	<div class="col s12">
		<div class="container">
			<div class="section">
				<div class="card">
					<div class="card-content p-0">
						<div class="section-data-tables">
							<table id="movement-type-table" class="display" width="100%">
								<thead>
									<tr>
										<th data-priority="1" width="30px">NO.</th>
										<th>TRANSACTION</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>FROM</th>
										<th>TO</th>
										<th>MODUL</th>
										<th>LOG COUNT</th>
										<th width="100px"></th>
									</tr>
								</thead>
							</table>
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
	var dttable_movement_type;

	jQuery(document).ready(function($){
		dttable_movement_type = $('#movement-type-table').DataTable({
			serverSide: true,
			scrollX: true,
			//responsive: true,
			pageLength: 50,
			ajax: {
				url: '{{ url("log-check") }}',
				type: 'GET',
				data: function(d){
					d.search['value'] = $('#movement-type-filter').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', orderable:false, searchable:false, className: 'center-align'},
				{data: 'transactions', className: 'detail'},
				{data: 'jenis', className: 'detail'},
				{data: 'action_description', className: 'detail'},
				{data: 'from_desc', className: 'detail'},
				{data: 'to_desc', className: 'detail'},
				{data: 'modul_name', className: 'detail'},
				{data: 'log_count', className: 'detail right-align'},
				{data: 'action', className: 'center-align', searchable: false, orderable: false},
			]
		});
	});

	$("input#movement-type-filter").on('keyup click', function(){
		dttable_movement_type.search($("#movement-type-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
	});

</script>
@endpush