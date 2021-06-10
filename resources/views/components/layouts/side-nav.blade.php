<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('dashboard') }}" class="brand-link">
		<img src="{{ asset('img/cdsplogo.png') }}" alt="CDSP Logo" class="brand-image" style="opacity: 0.8" />
		<span class="brand-text font-weight-light">Information System</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="info">
				<a href="#" class="d-block">{{ Auth::user()->username }}</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ route('dashboard') }}"
						class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
						<i class="nav-icon fas fa-home"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>

				@role('Instructor')
				<li class="nav-item">
					<a href="{{route('instructor.subjects.index')}}" class="nav-link {{ Request::segment(2) == 'subjects' ? 'active' : '' }}">
						<i class="nav-icon fas fa-user-graduate"></i>
						<p>Subjects</p>
					</a>
				</li>
				@endrole

				@role('Admin')
				<li class="nav-item">
					<a href="{{route('students.index')}}" class="nav-link {{ Request::segment(1) == 'students' ? 'active' : '' }}">
						<i class="nav-icon fas fa-user-graduate"></i>
						<p>Students</p>
					</a>
				</li>

				<li class="nav-item has-treeview {{ Request::segment(1) == 'users' ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::segment(1) == 'users' ? 'active' : '' }}">
						<i class="nav-icon fas fa-users"></i>
						<p>
							Users
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{route('instructor.index')}}" class="nav-link {{ Request::segment(2) == 'instructors' ? 'active' : '' }}">
								<i class="fas fa-chalkboard-teacher	nav-icon"></i>
								<p>Instructors</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('registrar.index')}}" class="nav-link {{ Request::segment(2) == 'registrars' ? 'active' : '' }}">
								<i class="fas fa-chalkboard-teacher nav-icon"></i>
								<p>Registrars</p>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item">
					<a href="{{route('academic.index')}}" class="nav-link {{ Request::segment(1) == 'academic-year' ? 'active' : '' }}">
						<i class="fas fa-calendar-alt nav-icon"></i>
						<p>Academic Year</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{route('curriculums.index')}}" class="nav-link {{ Request::segment(1) == 'curriculums' ? 'active' : '' }}">
						<i class="fas fa-book-open nav-icon"></i>
						<p>Curriculum</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{route('courses.index')}}" class="nav-link {{ Request::segment(1) == 'courses' ? 'active' : '' }}">
						<i class="fas fa-book-open nav-icon"></i>
						<p>Courses</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{route('subjects.index')}}" class="nav-link {{ Request::segment(1) == 'subjects' ? 'active' : '' }}">
						<i class="fas fa-book-open nav-icon"></i>
						<p>Subjects</p>
					</a>
				</li>
				@endrole

				<li class="nav-header">MANAGE ACCOUNT</li>
				<li class="nav-item">
					<a href="{{ route('logout') }}" class="nav-link"
						onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<i class="nav-icon fas fa-lock"></i>
						<p>
							Sign out
						</p>
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>