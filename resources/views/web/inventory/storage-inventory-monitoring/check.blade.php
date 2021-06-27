@extends('layouts.materialize.index')

@section('content')
<div class="row">
	@component('layouts.materialize.components.title-wrapper')
		<div class="row">
			<div class="col s12 m6">
				<h5 class="breadcrumbs-title mt-0 mb-0"><span>Stock Check</span></h5>
				<ol class="breadcrumbs mb-0">
					<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
					<li class="breadcrumb-item active">Stock Check</li>
				</ol>
			</div>
			<div class="col s12 m6">
				<div class="display-flex">
					<div class="app-wrapper mr-2">
						<div class="datatable-search">
							<i class="material-icons mr-2 search-icon">search</i>
							<input type="text" placeholder="Search" class="app-filter" id="stock-check-filter">
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
							<table id="stock-check-table" class="display" width="100%">
								<thead>
									<tr>
										<th data-priority="1" width="30px">NO.</th>
										<th class="center-align">
											STORAGE LOC. CODE
											<p><input type="text" id="filter-storage_location_code" class="input-filter-column"></p>
										</th>
										<th class="center-align">
											MODEL NAME
											<p><input type="text" id="filter-model" class="input-filter-column"></p>
										</th>
										<th>QTY</th>
										<th>QTY in LOG</th>
										<th>SELISIH</th>
										<th width="100px;"></th>
									</tr>
								</thead>
							</table>
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
	var dttable_stock_check

	jQuery(document).ready(function($){
		dttable_stock_check = $('#stock-check-table').DataTable({
			serverSide: true,
			scrollX: true,
			responsive: true,
			ajax: {
				url: '{{ url("stock-check") }}',
				type: 'GET',
				data: function(d) {
					d.search['value'] = $('#stock-check-filter').val()
					d.columns[2]['search']['value'] = $('#filter-storage_location_code').val()
					d.columns[3]['search']['value'] = $('#filter-model').val()
				}
			},
			columns: [
				{data: 'DT_RowIndex', orderable:false, searchable:false, className: 'center-align'},
				{data: 'storage_id', className: 'detail'},
				{data: 'model_name', className: 'detail'},
				{data: 'quantity_total', className: 'detail'},
				{data: 'quantity_log', className: 'detail'},
				{data: 'selisih_log', classname: 'detail'},
				{data: 'action', className: 'center-align', searchable: false, orderable: false},
			]
		});

		$(dttable_stock_check.table().container()).on('keyup', 'thead input', function(){
			dttable_stock_check.ajax.reload(null, false);
		});
	});

	$("input#stock-check-filter").on('keyup click', function(){
		filterGlobal();
	});

	function filterGlobal(){
		dttable_stock_check.search($("#stock-check-filter").val(), $("#global_regex").prop("checked"), $("#global_smart").prop("checked")).draw();
	}
</script>
@endpush