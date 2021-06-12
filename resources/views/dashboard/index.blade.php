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
							<li class="breadcrumb-item active">Dashboard</li>
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
				@role('Registrar')
				<div class="row">
					<div class="col-lg-4 col-6">
            <!-- small card -->
            <student-count-card></student-count-card>
          </div>

					<div class="col-lg-4 col-6">
            <!-- small card -->
            <instructor-count-card></instructor-count-card>
          </div>

					<div class="col-lg-4 col-6">
            <!-- small card -->
            <academic-year-card></academic-year-card>
          </div>
				</div>
				@endrole

				@role('Student')
				<div class="row">
					<div class="col-lg-12">
						<view-student-information :auth="{{auth()->user()}}"></view-student-information>
					</div>
				</div>
				@endrole
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<x-layouts.main-footer></x-layouts.main-footer>
</x-layouts.main-layout>