@extends('dashboard')
@section('content')
    {{-- <main class="login-form mt-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-4">

					@if (session()->has('error'))

					<div class="alert alert-danger">
						{{ session()->get('error') }}
					</div>

					@endif

					<div class="card mt-5">
						<h3 class="card-header text-center">Login</h3>

						<div class="card-body">
							<form method="post" action="{{ route('login.custom') }}">

								@csrf

								<div class="form-group mb-3">
									<input type="text" name="email" class="form-control" placeholder="Email" />

									@if ($errors->has('email'))
									<span class="text-danger">{{ $errors->first('email') }}</span>
									@endif
								</div>

								<div class="form-group mb-3">
									<input type="password" name="password" class="form-control" placeholder="Password" />

									@if ($errors->has('password'))
									<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
								</div>

								<div class="d-grid mx-auto">
									<button type="submit" class="btn btn-primary btn-block">Login</button>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main> --}}

    <div class="sidenav">
        <div class="login-main-text">
            <h2>KIST<br> Visitor Management System</h2>
            <p>Login from here to access.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <img src="https://kenyaschoolsdirectory.co.ke/images/schools/KIST.png" alt="KIST">
                <form method="post" action="{{ route('login.custom') }}">

                    @csrf

                    <div class="form-group mb-3">
                        <input type="text" name="email" class="form-control" placeholder="Email" />

                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" />

                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="d-grid mx-auto">
                        <button type="submit" class="btn btn-black btn-block">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
