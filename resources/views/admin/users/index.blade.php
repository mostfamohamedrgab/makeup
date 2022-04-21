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
									<div class="row">
										<div class="col-5">
											<a class="btn-sm btn btn-primary" href="?search=true&account_type=beauty_expert">
												<i class="fa fa-spa"></i>
											</a>
										</div>
										<div class="col-5">
											<a class="btn-sm btn btn-primary" href="?search=true&account_type=user">
												<i class="fa fa-users"></i>
											</a>
										</div>
									</div>
									<div class="card-title w-100 d-flex justify-content-between">
										<h3 class="card-label float-left">Users [{{$usersCount}}]</h3>
										<a href="{{route('admin.users.create')}}" class="btn  btn-success d-block float-right">
											 New User <i class="fa fa-user"></i>
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
													<th scope="col">Phone</th>
													<th scope="col">Image</th>
													<th scope="col">Account Type</th>
													<th scope="col">Created At</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($users as $user)
												<tr>

													<th scope="row">
														{{$user->name}}

														@if($user->account_type == 'beauty_expert')
														<br /> 
															@foreach($user->categories as $user_cat)
																<li class="text-primary">{{$user_cat->name_en}}</li>
															@endforeach
														@endif
													</th>
													<td>{{$user->phone}}</td>
													<td>
														<img src="{{ files_path($user->image) }}" style="width:40px;height:40px;border-radius: 50%">
													</td>
													<td>{{$user->account_type}}</td>
													<td>{{$user->created_at->diffForHumans()}}</td>
													<td>
														<a href="{{route('admin.users.edit',$user->id)}}" class="btn-sm btn btn-info btn-sm">
															<i class="fa fa-edit"></i>
														</a>

														@if($user->is_active)
															<a href="{{route('admin.users.swith',$user)}}" class="btn-sm btn btn-danger">
																<i class="fa fa-times"></i>
															</a>
														@else 	
															<a href="{{route('admin.users.swith',$user)}}" class="btn-sm btn btn-success">
																<i class="fa fa-check"></i>
															</a>
														@endif


												
									<a href="{{ route('admin.users.destroy',$user->id) }}"
									
      class="btn-sm btn btn-sm btn-light-danger font-weight-bolder py-2 px-5"
      onclick="event.preventDefault();
                    document.getElementById('delete-admin-{{$user->id}}').submit();"> <i class="fa fa-trash"></i></a>
         
                
    <form id="delete-admin-{{$user->id}}"
    	onsubmit="return confirm('Are you sure?')"
     action="{{ route('admin.users.destroy',$user->id) }}" method="POST" class="d-none delete-form">
        @csrf
        @method('DELETE')
    </form>	



													</td>
                                                </tr>
												@endforeach
											</tbody>
											{{$users->links()}}
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