@push('stylesheets')
	<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush
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
						<h1 class="m-0">Dashboard</h1>
					</div>
					<!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
							<li class="breadcrumb-item active">{{$info->username}}</li>
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
									User Information:
								</h5>
							</div>

							<div class="card-body">
								@if ($info->roles[0]->name === 'Admin')
								@endif

								@if ($info->roles[0]->name === 'Registrar')
								@endif

								@if ($info->roles[0]->name === 'Instructor')
								@endif
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
	@push('scripts')
		<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
		<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

		<script type="text/javascript">
			$(function () {
				$.noConflict();
				
				const table = $('#userDataTable').DataTable({
					processing: true,
					serverSide: true,
					ajax: "http://localhost:8000/api/users",
					columns: [
						{data: 'id', name: 'id'},
						{data: 'username', name: 'username'},
						{data: 'email', name: 'email'},
						{data: 'role', name: 'role'},
						{data: 'action', name: 'action', orderable: false, searchable: false},
					]
				});
				
			});
		</script>
	@endpush
	<x-layouts.main-footer></x-layouts.main-footer>
</x-layouts.main-layout>