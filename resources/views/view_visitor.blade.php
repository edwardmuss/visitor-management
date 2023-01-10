@extends('dashboard')

@section('content')
    <h2 class="mt-3">View Visitor</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('visitor') }}">Visitor Management</a></li>
            <li class="breadcrumb-item active">View Visitor Details</li>
        </ol>
    </nav>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">View Visitor Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('visitor.view_validation') }}">
                        @csrf
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Visitor Name</b></label>
								<div class="col-md-8">
									<span id="visitor_name_detail">{{ $data->visitor_name }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Visitor ID</b></label>
								<div class="col-md-8">
									<span id="visitor_name_detail">{{ $data->visitor_id }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Visitor Email</b></label>
								<div class="col-md-8">
									<span id="visitor_email_detail">{{ $data->visitor_email }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Visitor Mobile No.</b></label>
								<div class="col-md-8">
									<span id="visitor_mobile_no_detail">{{ $data->visitor_mobile_no }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Visitor Address</b></label>
								<div class="col-md-8">
									<span id="visitor_address_detail">{{ $data->visitor_address }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Department</b></label>
								<div class="col-md-8">
									<span id="visitor_department_detail">{{ $data->visitor_department }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Person To Meet</b></label>
								<div class="col-md-8">
									<span
										id="visitor_meet_person_name_detail">{{ $data->visitor_meet_person_name }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-4 text-right"><b>Reason to Visit</b></label>
								<div class="col-md-8">
									<span id="visitor_reason_to_meet_detail">{{ $data->visitor_reason_to_meet }}</span>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<div class="row">
								<label class="col-md-12 text-right pb-3"><b>Visitor Outing Remark</b></label>
								<div class="col-md-12">
									<textarea name="visitor_outing_remark" id="visitor_outing_remark" class="form-control" required="">{{ $data->visitor_outing_remark }}</textarea>
								</div>
							</div>
						</div>
						<div class="form-group mb-3">
							<input type="hidden" name="hidden_id" value="{{ $data->id }}" />
							<input type="submit" class="btn btn-primary" value="Checkout Visitor" />
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#visitor_department').on('change', function() {
                var department_name = this.value;
                $('#visitor_meet_person_name').html('');
                $.ajax({
                    url: '{{ route('visitor.get-contact-person') }}?department_name=' +
                        department_name,
                    type: 'get',
                    success: function(res) {
                        $('#visitor_meet_person_name').html(
                            '<option value="">Select Contact Person</option>');
                        $.each(res, function(key, value) {
                            $('#visitor_meet_person_name').append('<option>' + value +
                                '</option>');
                        });
                        $('#visitor_meet_person_name').append('<option> Other </option>');
                    }
                });
            });
        });
    </script>
@endsection
