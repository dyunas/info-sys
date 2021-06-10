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
						<h1 class="m-0">Curriculums</h1>
					</div>
					<!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="{{route('curriculums.index')}}">Curriculums</a></li>
							<li class="breadcrumb-item active">{{$curriculum->course->course_name}}</li>
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
									Curriculum Details
								</h5>
							</div>
							<div class="card-body">
								<table class="table table-small">
									<tbody>
										<tr>
											<td>Course Name: {{$curriculum->course->course_name}}</td>
										</tr>
										<tr>
											<td>School Year: {{$curriculum->school_year}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card card-primary card-outline">
							<div class="card-header">
								<a href="{{route('curriculum.add-subjects', $curriculum->id)}}" class="btn btn-sm btn-primary">
									<i class="fas fa-plus"></i>
									Add Subjects
								</a>
							</div>
							<div class="card-body p-0">
								<curriculum-tabs :curriculum="{{$curriculum}}" :subjects="{{$curriculum->subjects}}"></curriculum-tabs>
							</div>
							<!-- /.card -->
						</div>
						<!-- /.card -->
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