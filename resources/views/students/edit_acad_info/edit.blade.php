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
							<li class="breadcrumb-item"><a href="{{route('students.show', $student->id)}}">{{$student->last_name}}, {{$student->first_name}}</a></li>
							<li class="breadcrumb-item active">Edit academics</li>
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
						<edit-academics :stud-id="{{$student->id}}" :year-level="{{$student->year_level}}" :course="{{$student->courses}}" :curriculum="{{$student->curriculums}}" :semester="{{'"'.$student->semester.'"'}}" :acad-year="{{ '"'.$student->acad_year.'"' }}"></edit-academics>
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