@push('css')
    <style>
        .icon-parent i  {
            font-size:25px;
            text-align:center;
            display:inline-block;
            background:#D36872;
            margin:auto;
            color:#fff;
            padding: 20px;
            border-radius: 10px;
        }
        
    </style>
@endpush

@extends('admin.layouts.main')

@section('content')

	<!--begin::Row-->
    <div class="row">

			<div class="col-lg-3 icon-parent">
				<!--begin::Mixed Widget 14-->
				<div class="card card-custom card-stretch gutter-b">
				
					<!--begin::Body-->
					<a href="{{route('admin.admins.index')}}" class="text-dark">
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<i class="fa fa-lock"></i>
							</div>
							<div class="pt-5">
	                            <p class="text-center">{{$adminsCount}}</p>
	                            <h3 class="text-center">Admins</h3>
							</div>
						</div>
					</a>	
					<!--end::Body-->
				</div>
				<!--end::Mixed Widget 14-->
			</div>

		<div class="col-lg-3 icon-parent">
				<!--begin::Mixed Widget 14-->
				<div class="card card-custom card-stretch gutter-b">
				
					<!--begin::Body-->
					<a href="{{route('admin.users.index')}}" class="text-dark">
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<i class="fa fa-users"></i>
							</div>
							<div class="pt-5">
	                            <p class="text-center">{{$usersCount}}</p>
	                            <h3 class="text-center">Users</h3>
							</div>
						</div>
					</a>
					<!--end::Body-->
				</div>
				<!--end::Mixed Widget 14-->
			</div>

			<div class="col-lg-3 icon-parent">
				<!--begin::Mixed Widget 14-->
				<div class="card card-custom card-stretch gutter-b">
				
					<!--begin::Body-->
					<a href="{{route('admin.categories.index')}}" class="text-dark">
						<div class="card-body d-flex flex-column">
							<div class="flex-grow-1 text-center">
								<i class="fa fa-list"></i>
							</div>
							<div class="pt-5">
	                            <p class="text-center">{{$categoriesCount}}</p>
	                            <h3 class="text-center">Categories</h3>
							</div>
						</div>
					</a>
					<!--end::Body-->
				</div>
				<!--end::Mixed Widget 14-->
			</div>

			
		</div>
		<!--end::Row-->


@endsection