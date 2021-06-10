@extends('layouts.login')

@section('content')
<div class="container">
	<div class="row d-flex justify-content-center mb-md-4 mb-sm-3">
		<div class="login-box">
			<div class="login-logo" style="line-height: 0.7;">
				<a href="{{ route('login') }}">
					<b>Information</b> System<br/>
					<small class="lead ">Colegio de San Pedro</small>
				</a>
			</div>
			<!-- /.login-logo -->
			<div class="card card-primary card-outline">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Sign in to start your session</p>

					<form action="{{ route('login') }}" method="POST">
						@csrf
						<div class="input-group mb-3">
							<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" autocomplete="username" autofocus>
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user @error('username') text-red @enderror"></span>
								</div>
							</div>

							@error('username')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="input-group mb-3">
							<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock @error('password') text-red @enderror"></span>
								</div>
							</div>

							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="row">
							<div class="col-12">
								<button type="submit" class="btn btn-primary btn-block">
									<span class="fas fa-lock"></span> Sign In
								</button>
							</div>
							<!-- /.col -->
						</div>
					</form>
				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
		<!-- /.login-box -->
	</div>
</div>
@endsection