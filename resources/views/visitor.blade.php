@extends('dashboard')

@section('content')
{{-- <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}


{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>

<style>
	div.dt-buttons {
	position: relative;
	float: left;
	margin-bottom: 10px;
	}
</style>


<h2 class="mt-3">Visitor Management</h2>
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    	<li class="breadcrumb-item active">Visitor Management</li>	
  	</ol>
</nav>

<div class="mt-4 mb-4">
	@if(session()->has('success'))
		<div class="alert alert-success">
			{{ session()->get('success') }}
		</div>
	@endif
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-4">
					<select id='filter' class="form-control form-control-sm" style="width: 200px">
						<option value="">--Filter Data--</option>
						<option value="today">Today</option>
						<option value="yesterday">Yesterday</option>
						<option value="week">Last 7 days</option>
						<option value="month">Last 30 days</option>
						<option value="year">Last 1 Year</option>
					</select>
				</div>
				<div class="col-sm-4">
					<div class="row input-daterange">
						<div class="col-md-6">
							<input type="text" name="from_date" id="from_date" class="form-control form-control-sm" placeholder="From Date" readonly="">
						</div>
						<div class="col-md-6">
							<input type="text" name="to_date" id="to_date" class="form-control form-control-sm" placeholder="To Date" readonly="">
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<button type="button" name="search" id="search" class="btn btn-info btn-sm"><i class="fa fa-filter"></i></button>
					&nbsp;
					<button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fa fa-sync-alt"></i></button>
				</div>
				<div class="col-md-2" align="right">
					<a href="{{ route('visitor.export') }}" name="export" id="export" class="text-success"><i class="fa fa-file-excel fa-2x"></i></a>
					&nbsp;
					{{-- <button type="button" name="add_visitor" id="add_visitor" class="btn btn-success btn-sm" style="margin-top: -15px;"><i class="fas fa-user-plus"></i></button> --}}
					<a href="{{ route('visitor.add') }}" class="btn btn-success btn-sm float-end">Add</a>
				</div>
			</div>
		</div>
		<div class="card-body">
			{{-- <div class="panel-body"> {!! $dataTable->table() !!} {!! $dataTable->scripts() !!} </div> --}}
			<div class="table-responsive">
				<table class="table table-bordered" id="visitor_table">
					<thead>
						<tr>
							<th>Visitor ID</th>
							<th>Visitor Name</th>
							<th>Meet Person Name</th>
							<th>Department</th>
							<th>In Time</th>
							<th>Out Time</th>
							<th>Status</th>
							{{-- <th>Enter By</th> --}}
							<th>Action</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	var filter = $('#filter').val();
	$('.input-daterange').datepicker({
		todayBtn:'linked',
		format:'yyyy-mm-dd',
		todayHighlight: true,
		autoclose:true
	});

	load_data();

function load_data(from_date = '', to_date = '')
 {
	var table = $('#visitor_table').DataTable({
	pageLength: 100,
	processing:true,
	serverSide:true,
	"bDestroy": true,
	// "order": [[ 3, "desc" ]], //or asc 
    // "columnDefs" : [{"targets":3, "type":"date"}],
	dom: 'Bfrtip',
	buttons: [{
      "extend": 'excel',
      "text": 'Export Excel',
      'className': 'btn btn-success',
	  exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index', // 'current', 'applied',
                    //'index', 'original'
                    page : 'all', // 'all', 'current'
                    search : 'none' // 'none', 'applied', 'removed'
                },
                columns: [ 0, 1, 2, 3, 4, 5 ]
            },
    },
    {
      "extend": 'csv',
      "text": 'CSV',
      'className': 'btn btn-info',
	  exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index', // 'current', 'applied',
                    //'index', 'original'
                    page : 'all', // 'all', 'current'
                    search : 'none' // 'none', 'applied', 'removed'
                },
                columns: [ 0, 1, 2, 3, 4, 5 ]
            },
    },
    {
      "extend": 'pdf',
      "text": 'PDF',
      'className': 'btn btn-danger',
	  exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index', // 'current', 'applied',
                    //'index', 'original'
                    page : 'all', // 'all', 'current'
                    search : 'none' // 'none', 'applied', 'removed'
                },
                columns: [ 0, 1, 2, 3, 4, 5 ]
            },
    },
    {
      "extend": 'print',
      "text": 'Print',
      'className': 'btn btn-primary',
	  exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index', // 'current', 'applied',
                    //'index', 'original'
                    page : 'all', // 'all', 'current'
                    search : 'none' // 'none', 'applied', 'removed'
                },
                columns: [ 0, 1, 2, 3, 4, 5 ]
            },
    }
  ],
  initComplete: function() {
    var btns = $('.dt-button');
    btns.removeClass('dt-button');
  },
	ajax: {
		url:'{{ route('visitor.fetchall') }}',
		// data:{filter:filter}
		data: function (d) {
		d.filter = $('#filter').val()
		d.from_date = from_date, 
		d.to_date = to_date
		}
	},

	columns:[
		{
			data:'visitor_id',
			id: 'visitor_id'
		},
		{
			data:'visitor_name',
			name: 'visitor_name'
		},
		{
			data: 'visitor_meet_person_name',
			name: 'visitor_meet_person_name'
		},
		{
			data:'visitor_department',
			name:'visitor_department'
		},
		{
			data:'visitor_enter_time',
			name: 'visitor_enter_time'
		},
		{
			data:'visitor_out_time',
			name:'visitor_out_time'
		},
		{
			data:'visitor_status',
			name:'visitor_status'
		},
		// {
		// 	data:'name',
		// 	name:'name'
		// },
		{
			data:'action',
			name:'action',
			orderable:false
		}
	]
	});

	$('#filter').change(function(){
	table.draw();
	});

	$('#search').click(function(){
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	if(from_date != '' &&  to_date != '')
	{
		$('#visitor_table').DataTable().destroy();

		load_data(from_date, to_date);
	}
	else
	{
		alert('Both Date is required');
	}
	});

		$('#refresh').click(function(){
		$('#from_date').val('');
		$('#to_date').val('');
		$('#vistor_table').DataTable().destroy();
		load_data();
	});
	}
});

$(document).on('click', '.delete', function(){

var id = $(this).data('id');
var url = '{{ route("visitor.delete", ":id") }}';
   delete_url = url.replace(':id', id);

if(confirm("Are you sure you want to remove it?"))
{
	window.location.href = delete_url;
}

});
</script>

@endsection