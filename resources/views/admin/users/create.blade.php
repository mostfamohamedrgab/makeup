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
										<h3 class="card-label">
                                            {{isset($user) ? 'edit '.$user->name : 'Create New User'}}
                                        </h3>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body">
									
                                <form method="post" 
                                action="{{isset($user) ? route('admin.users.update',$user->id) : route('admin.users.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    @if(isset($user))
                                   		@method('PUT')
                                    @endif
                                    
                                    <div class="form-group">
                                        <label for="name">phone:</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                        value="{{ isset($user) ? $user->name : old('name') }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">phone :</label>
                                        <input type="phone" class="form-control" id="phone" 
                                        value="{{ isset($user) ? $user->phone : old('phone') }}" name="phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="pwd">Password:</label>
                                        <input type="password" class="form-control" 
                                       @if(!isset($user))
                                       	 required="" 
                                        @endif
                                        id="password" value="{{old('password')}}" name="password">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Account Type :</label>
                                        <select class="form-control" required="" name="account_type" id="account_type">
                                          <option 
                                          @if(isset($user))
                                            {{$user->account_type == 'user' ? 'selected' : ''}}
                                          @else
                                            {{old('account_type') == 'user' ? 'selected' : ''}} 
                                          @endif

                                          value="user">user</option>
                                          <option
                                          @if(isset($user))
                                            {{$user->account_type == 'beauty_expert' ? 'selected' : ''}}
                                          @else 
                                            {{old('account_type') == 'user' ? 'selected' : ''}} 
                                          @endif
                                           value="beauty_expert">beauty xpert</option>
                                        </select>
                                    </div>


                                     <div class="form-group">
                                        <label for="image">Image:
                                            @if(isset($user))
                                                @if($user->image)
                                                    <img src="{{files_path($user->image)}}" style="width: 40px;height: 40px;border-radius: 50%">
                                                @endif
                                            @endif
                                        </label>
                                        <input type="file" accept="image/*" class="form-control" 
                                         id="image" value="{{old('image')}}" name="image">
                                    </div>




                                     <div class="form-group ">
                                        <label for="phone">Active :</label>
                                       <input type="checkbox" name="is_active"

                                       @if(isset($user))
                                        {{$user->is_active ? 'checked' : ''}}
                                       @endif

                                        value="1">
                                    </div>

                                  
                                    <button type="submit" class="btn btn-primary">
                                        {{isset($user) ? 'edit' : 'save'}}
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
