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
									<div class="card-title">
										<h3 class="card-label">Create New Admin</h3>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body">
									
                                <form method="post" 
                                action="{{isset($admin) ? route('admin.admins.update',$admin->id) : route('admin.admins.store') }}">
                                    @csrf
                                    
                                    @if(isset($admin))
                                   		@method('PUT')
                                    @endif
                                    
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ isset($admin) ? $admin->name : old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address:</label>
                                        <input type="email" class="form-control" id="email" 
                                        value="{{ isset($admin) ? $admin->email : old('email') }}" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Password:</label>
                                        <input type="password" class="form-control" 
                                       
                                       @if(!isset($admin))
                                       	 required="" 
                                        @endif

                                        id="password" value="{{old('password')}}" name="password">
                                    </div>
                                  
                                    <button type="submit" class="btn btn-primary">
                                        {{isset($admin) ? 'edit' : 'save'}}
                                    </button>
                                </form>  

								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->


@endsection