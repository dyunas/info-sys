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
						<h1 class="m-0">Students</h1>
					</div>
					<!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="{{route('students.index')}}">Students</a></li>
							<li class="breadcrumb-item active">{{$student[0]->last_name}}, {{$student[0]->first_name}}</li>
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
						<div class="card card-primary">
							<div class="card-header">
								<h5 class="card-title">
									Student Information:
								</h5>

								<div class="card-tools">
									<a href="{{route('students.edit', $student[0]->id)}}" class="btn btn-sm btn-primary">
										<i class="fas fa-pencil-alt mr-1"></i>
										Edit student infomation
									</a>
								</div>
							</div>

							<div class="card-body">					
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="comp_name">
												COMPLETE NAME
											</label>
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
													<div class="form-control form-outline">
														{{$student[0]->last_name}}
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
													<div class="form-control form-outline">
														{{$student[0]->first_name}}
													</div>
												</div>
												<div class="col-lg-4 col-md-4 col-sm-12 mb-2">
													<div class="form-control form-outline">
														{{$student[0]->middle_name}}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="gender">
												GENDER
											</label>
											<div class="form-control form-outline">
												{{$student[0]->gender}}
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="bdate">
												BIRTHDATE
											</label>
											<div class="form-control form-outline">
												{{$student[0]->bdate}}
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="age">
												AGE
											</label>
											<div class="form-control form-outline">
												{{$student[0]->age}}
											</div>
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="email">EMAIL ADDRESS</label>
											<div class="form-control form-outline">
												{{$student[0]->email}}
											</div>
										</div>
									</div>
				
									<div class="col-lg-6">
										<div class="form-group">
											<label for="contactNumber">CONTACT NUMBER</label>
											<div class="form-control form-outline">
												{{$student[0]->contact_number}}
											</div>
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="address">ADDRESS</label>
											<div class="form-control form-outline">
												{{$student[0]->address}}
											</div>
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="province">PROVINCE</label>
											<div class="form-control form-outline">
												{{$student[0]->province}}
											</div>
										</div>
									</div>
				
									<div class="col-lg-4">
										<div class="form-group">
											<label for="municipality">CITY/MUNICIPALITY</label>
											<div class="form-control form-outline">
												{{$student[0]->municipal}}
											</div>
										</div>
									</div>
				
									<div class="col-lg-4">
										<div class="form-group">
											<label for="barangay">BARANGAY</label>
											<div class="form-control form-outline">
												{{$student[0]->barangay}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card card-primary">
							<div class="card-header">
								<h5 class="card-title">Academic Information:</h5>
								<div class="card-tools">
									<a href="{{route('students.edit_academics', $student[0]->id)}}" class="btn btn-sm btn-primary">
										<i class="fas fa-pencil-alt mr-1"></i>
										Edit academic infomation
									</a>
								</div>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<label for="course">COURSE</label>
											<div class="form-control form-outline">
												{{$student[0]->courses->course_name}}
											</div>
										</div>
									</div>
								</div>
				
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="yearLevel">YEAR LEVEL</label>
											<div class="form-control form-outline">
												{{$student[0]->year_level}}
											</div>
										</div>
									</div>
				
									<div class="col-lg-4">
										<div class="form-group">
											<label for="curriculum">CURRICULUM</label>
											<div class="form-control form-outline">
												{{$student[0]->curriculums->school_year}}
											</div>
										</div>
									</div>
				
									<div class="col-lg-4">
										<div class="form-group">
											<label for="semester">SEMESTER</label>
											<div class="form-control form-outline">
												{{$student[0]->semester}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card card-primary">
							<div class="card-header">
								<h5 class="card-title">
									Subjects:
								</h5>

								<div class="card-tools">
									<a href="{{route('students.add_subjects', $student[0]->id)}}" class="btn btn-sm btn-primary">
										<i class="fas fa-pencil-alt mr-1"></i>
										Add subjects
									</a>
								</div>
							</div>

							<div class="card-body p-0">
								<student-grades :year-levels="{{$student[0]->courses->year_levels}}" :subjects="{{$student[0]->graded_subjects}}"></student-grades>
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