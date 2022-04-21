@extends('admin.layouts.main')

@section('content')

	<!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Card-->
								<div class="card card-custom">
									<!--begin::Header-->
								<div class="card-header flex-wrap border-0 pt-6 pb-0">
									<div class="card-title w-100 d-flex justify-content-between">
										<h3 class="card-label float-left">Admins</h3>
										<a href="{{route('admin.admins.create')}}" class="btn  btn-success d-block float-right">
											 New Admin <i class="fa fa-plus"></i>
										</a>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body">
									<!--begin: Datatable-->
									<div class="table datatable-bordered datatable-head-custom" id="">
									<table class="table">
											<thead>
												<tr>
													<th scope="col">Name</th>
													<th scope="col">Email</th>
													<th scope="col">Created At</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($admins as $admin)
												<tr>
													<th scope="row">{{$admin->name}}</th>
													<td>{{$admin->email}}</td>
													<td>{{$admin->created_at->diffForHumans()}}</td>
													<td>
														<a href="{{route('admin.admins.edit',$admin->id)}}" class="btn btn-info btn-sm">
															<i class="fa fa-edit"></i>
														</a>


												
									<a href="{{ route('admin.admins.destroy',$admin->id) }}"
									
      class="btn btn-sm btn-light-danger font-weight-bolder py-2 px-5"
      onclick="event.preventDefault();
                    document.getElementById('delete-admin-{{$admin->id}}').submit();"> <i class="fa fa-trash"></i></a>
         
                
    <form id="delete-admin-{{$admin->id}}"
    	onsubmit="return confirm('Are you sure?')"
     action="{{ route('admin.admins.destroy',$admin->id) }}" method="POST" class="d-none delete-form">
        @csrf
        @method('DELETE')
    </form>

													</td>
                                                </tr>
												@endforeach
											</tbody>
										</table>
                                        </div>
										<!--end: Datatable-->
									</div>
									<!--end::Body-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->


@endsection