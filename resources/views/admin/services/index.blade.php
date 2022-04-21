@extends('admin.layouts.main')

@section('content')

<!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
          	new service
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="post" action="{{route('admin.services.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label>name ar</label>
              <input type="text" class="form-control" required name="name_ar" value="{{old('name_ar')}}">
            </div>
            <div class="form-group">
              <label>name en</label>
              <input type="text" class="form-control" required name="name_en" value="{{old('name_en')}}">
            </div>




             <div class="form-group">
              <label>
                  image
              </label>
              <input type="file" accept="image/*" class="form-control" required name="image" value="{{old('image')}}">
            </div>


            <div class="form-group">
              <label> parent Service </label>
              <select class="form-control" name="parent_id">
                <option value="">select </option>
                @foreach($services as $service)
                <option
                {{old('parent_id') == $service->id ? 'selected' : ''}}
                value="{{$service->id}}"
                >{{$service->name_ar}}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">save</button>
            <div class="clear"></div>
          </form>

        </div>
      </div>
    </div>
  </div>
    <!-- end add model --->

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
										<h3 class="card-label float-left">Services</h3>
										<button style="display:block;text-align:right" type="button" class=" float-right btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      <i class="fa fa-plus"></i>
                    </button>

									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body">
									<!--begin: Datatable-->
										<!--begin::Table-->
  										<div class="table-responsive">
  											<table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
  												<thead>
  													<tr class="text-center">
  														<th class="pr-0" style="width: 50px">#</th>
  														<th style="min-width: 200px">name ar</th>
                              <th style="min-width: 200px">name en</th>
                              <th style="min-width: 400px">parent</th>
  														<th style="min-width: 400px">image</th>
  														<th class="pr-0 text-right" style="min-width: 150px">action</th>
  													</tr>
  												</thead>
                          @foreach($rows as $row)
  												<tbody class="text-center">
  													<tr>
  														<td class="pl-0">
  															<label class="checkbox checkbox-lg checkbox-inline">
															     {{$row->id}}
  															</label>
  														</td>

  														<td class="pr-0">
  															<div class="symbol symbol-50 symbol-light mt-1">
  															 {{$row->name_ar}} <br />
  															</div>
  														</td>

                              <td class="pr-0">
                                <div class="symbol symbol-50 symbol-light mt-1">
                                 {{$row->name_en}} <br />
                                </div>
                              </td>


                              <td class="pr-0">
                                <div class="symbol symbol-50 symbol-light mt-1">
                                 {{$row->parent ? $row->parent->name_ar : ''}} <br />
                                </div>
                              </td>


                               <td class="pr-0">
                                <img src="{{files_path($row->image)}}" style="width:50px;height:50px;border-radius: 50%">
                              </td>

  														<td class="pr-0 text-right">


                                <button type="button" class="btn btn-icon btn-light btn-hover-primary btn-sm"
                                data-toggle="modal" data-target="#edit-{{$row->id}}">
                                  <span class="svg-icon svg-icon-md svg-icon-primary">
  																	<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
  																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
  																			<rect x="0" y="0" width="24" height="24"></rect>
  																			<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
  																			<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
  																		</g>
  																	</svg>
  																	<!--end::Svg Icon-->
  																</span>
                                </button>
  															<a href="{{ route('admin.services.destroy',$row->id) }}"
                                onclick="event.preventDefault();
                                                document.getElementById('destory-{{$row->id}}').submit();"
                                class="delete btn btn-icon btn-light btn-hover-primary btn-sm">
  																<span class="svg-icon svg-icon-md svg-icon-primary">
  																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
  																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
  																			<rect x="0" y="0" width="24" height="24"></rect>
  																			<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
  																			<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
  																		</g>
  																	</svg>
  																	<!--end::Svg Icon-->
  																</span>
  															</a>
                                <form id="destory-{{$row->id}}"
                                  class="delete"
                                  action="{{ route('admin.services.destroy',$row->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

  														</td>
  													</tr>

  												</tbody>

                          <!--edit  Modal -->
                          <div class="modal fade" id="edit-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">تعديل {{$row->name}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="text-right modal-body">

                                  <form method="post" action="{{route('admin.services.update',$row->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                      <label>name ar</label>
                                      <input type="text" class="form-control" required name="name_ar" value="{{ $row->name_ar }}">
                                    </div>

                                    <div class="form-group">
                                      <label>name  en</label>
                                      <input type="text" class="form-control" required name="name_en" value="{{ $row->name_en }}">
                                    </div>

                                 
                                     <div class="form-group">
                                    <label>
                                        image
                                    </label>
                                    <input type="file" accept="image/*" class="form-control" required name="image" value="{{old('image')}}">
                                  </div>
                         

                                      <div class="form-group">
                                        <label> parent Service </label>
                                        <select class="form-control" name="parent_id">
                                          <option value="">select </option>
                                          @foreach($services as $service)
                                          <option
                                          {{$row->parent_id == $service->id ? 'selected' : ''}}
                                          value="{{$service->id}}"
                                          >{{$service->name_ar}}</option>
                                          @endforeach
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                  </form>

                                </div>
                              </div>
                            </div>
                          </div>
                            <!-- end edit model --->
                          @endforeach
  											</table>
  										</div>
  										<!--end::Table-->
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