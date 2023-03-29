@extends('dashboard')

@section('content')

<h2 class="mt-3">Visitor Management</h2>
<nav aria-label="breadcrumb">
  	<ol class="breadcrumb">
    	<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    	<li class="breadcrumb-item"><a href="{{ route('visitor') }}">Visitor Management</a></li>
    	<li class="breadcrumb-item active">Edit Visitor</li>
  	</ol>
</nav>
<div class="row mt-4">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">Edit Visitor</div>
			<div class="card-body">
				<form method="POST" action="{{ route('visitor.edit_validation') }}">
					@csrf
					<div class="form-group mb-3">
		        		<label><b>Visitor Name</b></label>
		        		<input type="text" name="visitor_name" value="{{ $data->visitor_name }}" class="form-control" />
		        		@if($errors->has('visitor_name'))
		        			<span class="text-danger">{{ $errors->first('visitor_name') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Visitor ID</b></label>
		        		<input type="text" name="visitor_id" value="{{ $data->visitor_id }}" class="form-control" />
		        		@if($errors->has('visitor_id'))
		        			<span class="text-danger">{{ $errors->first('visitor_id') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Vistor Email</b></label>
		        		<input type="email" name="visitor_email" value="{{ $data->visitor_email }}" class="form-control" />
		        		@if($errors->has('visitor_email'))
		        			<span class="text-danger">{{ $errors->first('visitor_email') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Visitor Phone</b></label>
		        		<input type="text" name="visitor_mobile_no" value="{{ $data->visitor_mobile_no }}" class="form-control" />
		        		@if($errors->has('visitor_mobile_no'))
		        			<span class="text-danger">{{ $errors->first('visitor_mobile_no') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Department</b></label>
		        		<select name="visitor_department" id="visitor_department" class="form-control" required>
							<option selected>{{ $data->visitor_department }}</option>
							@foreach($departments as $department)
								<option>{{ $department['department_name'] }}</option>
							@endforeach
						</select>
		        		@if($errors->has('visitor_department'))
		        			<span class="text-danger">{{ $errors->first('visitor_department') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Person to Meet</b></label>
		        		<select name="visitor_meet_person_name" id="visitor_meet_person_name" class="form-control" required>
							<option  selected>{{ $data->visitor_meet_person_name }}</option>
						</select>
		        		@if($errors->has('visitor_meet_person_name'))
		        			<span class="text-danger">{{ $errors->first('visitor_meet_person_name') }}</span>
		        		@endif
		        	</div>
					<div class="form-group mb-3">
		        		<label><b>Reason to Visit</b></label>
		        		<textarea  name="visitor_reason_to_meet" class="form-control" required> {{ $data->visitor_reason_to_meet }} </textarea>
		        		@if($errors->has('visitor_reason_to_meet'))
		        			<span class="text-danger">{{ $errors->first('visitor_reason_to_meet') }}</span>
		        		@endif
		        	</div>
		        	<div class="form-group mb-3">
		        		<input type="hidden" name="hidden_id" value="{{ $data->id }}" />
		        		<input type="submit" class="btn btn-primary" value="Update Details" />
		        	</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script>

	$(document).ready(function(){
		$('#visitor_department').on('change', function () {
		var department_name = this.value;
		$('#visitor_meet_person_name').html('');
			$.ajax({
				url: '{{ route('visitor.get-contact-person') }}?department_name='+department_name,
				type: 'get',
				success: function (res) {
					$('#visitor_meet_person_name').html('<option value="">Select Contact Person</option>');
					$.each(res, function (key, value) {
						$('#visitor_meet_person_name').append('<option>' + value + '</option>');
					});
					$('#visitor_meet_person_name').append('<option> Other </option>');
				}
			});
		});
	});
	
	</script>
@endsection