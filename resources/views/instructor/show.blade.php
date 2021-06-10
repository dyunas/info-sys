<x-layouts.main-layout>
	<x-layouts.header></x-layouts.header>
	<x-layouts.side-nav></x-layouts.side-nav>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Users</h1>
					</div>
					<!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="{{route('instructor.index')}}">Instructors</a></li>
							<li class="breadcrumb-item active">{{$data[0]->instructor->first_name}} {{$data[0]->instructor->last_name}}</li>
						</ol>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">
									Information:
								</h5>
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label for="username" class="col-sm-2 col-form-label">Username:</label>
									<div class="col-lg-10">
										<div class="form-control form-control-border">{{ $data[0]->username }}</div>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label">Email Address:</label>
									<div class="col-lg-10">
										<div class="form-control form-control-border">{{ $data[0]->email }}</div>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="firstName" class="col-sm-2 col-form-label">Firstname:</label>
									<div class="col-lg-10">
										<div class="form-control form-control-border">{{ $data[0]->instructor->first_name }}</div>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="middleName" class="col-sm-2 col-form-label">Middlename:</label>
									<div class="col-lg-10">
										<div class="form-control form-control-border">{{ $data[0]->instructor->middle_name }}</div>
									</div>
								</div>
				
								<div class="form-group row">
									<label for="lastName" class="col-sm-2 col-form-label">Lastname:</label>
									<div class="col-lg-10">
										<div class="form-control form-control-border">{{ $data[0]->instructor->last_name }}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title">
									Subjects Handle:
								</h5>

								<div class="card-tools">
									<a href="{{route('instructor.tagSubject', $data[0]->instructor->id)}}" class="btn btn-sm btn-primary">
										<i class="fas fa-tag mr-1"></i>
										Tag subject
									</a>
								</div>
							</div>

							<div class="card-body p-0 table-responsive">
								<table class="table table-bordered table-sm table-hover text-nowrap">
									<thead>
										<tr>
											<th width="10%">Code:</th>
											<th width="70">Subject Name:</th>
											<th width="10%">Units</th>
											<th width="10%">Pre-Req</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($data[0]->instructor->subjects as $subject)
										<tr>
											<td>
												{{$subject->code}}
											</td>
											<td>
												{{$subject->name}}
											</td>
											<td>
												{{$subject->units}}
											</td>
											<td>
												{{$subject->pre_req}}
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<x-layouts.main-footer></x-layouts.main-footer>
</x-layouts.main-layout>