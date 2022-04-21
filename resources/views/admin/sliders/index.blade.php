@extends('admin.layouts.main')
@section('content')

    <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Slider</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="post" action="{{route('admin.sliders.store')}}" enctype="multipart/form-data">
            @csrf

            

            <div class="form-group">
              <label>
                Cover
              </label>
              <input type="file" accept="image/*" class="form-control" required name="image" value="{{old('image')}}">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <div class="clear"></div>
          </form>

        </div>
      </div>
    </div>
  </div>
    <!-- end add model --->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            
              <!--begin::Entry-->
              <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                  <!--begin::Advance Table Widget 1-->
                  <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 py-5">
                      <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">{{ count($rows) }} Slider</span>
                      </h3>

                         <button type="button" class="btn btn-icon btn-light btn-hover-primary btn-sm"
                                data-toggle="modal" data-target="#exampleModal">
                          <i class="fa fa-plus"></i>
                        </button>
                        
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-0">
                      <!--begin::Table-->
                      <div class="table-responsive">
                        <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                          <thead>
                            <tr class="text-center">
                              <th class="pr-0" style="width: 50px">#</th>
                              <th style="min-width: 200px">Cover</th>
                              <th class="pr-0 text-right" style="min-width: 150px">Action</th>
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
                                  <a href="{{files_path($row->image)}}">
                                     <img src="{{files_path($row->image)}}" width="90px" height="90px" />
                                   </a>
                                </div>
                              </td>



                              <td class="pr-0 text-right">


                                <button type="button" class="btn btn-icon btn-light btn-hover-primary btn-sm"
                                data-toggle="modal" data-target="#edit-{{$row->id}}">
                                  <i class="fa fa-edit"></i>
                                </button>

                                <a href="{{ route('admin.sliders.destroy',$row->id) }}"
                                onclick="event.preventDefault();
                                                document.getElementById('destory-{{$row->id}}').submit();"
                                class="delete btn btn-icon btn-light btn-hover-primary btn-sm">
                                  <span class="svg-icon svg-icon-md svg-icon-primary">
                                   <i class="fa fa-trash"></i>
                                  </span>
                                </a>
                                <form id="destory-{{$row->id}}"
                                  class="delete"
                                  action="{{ route('admin.sliders.destroy',$row->id) }}" method="POST" class="d-none">
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
                                  <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="text-right modal-body">

                                  <form method="post" action="{{route('admin.sliders.update',$row->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                   


                                    <div class="form-group">
                                      <label>
                                        Image
                                      </label>
                                      <input type="file" accept="image/*" class="form-control"  name="image" value="{{old('image')}}">
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
                    </div>
                    <!--end::Body-->
                  </div>
                  <!--end::Advance Table Widget 1-->

                </div>
                <!--end::Container-->
              </div>
              <!--end::Entry-->
            </div>
@stop
@push('css')
  <style type="text/css">
      form {
        text-align: right !important
      }
  </style>
@endpush
@push('js')
  <script>

    $(document).on('click','.delete', function (e){
      if( confirm('تاكيد ؟') )
      {
        return true;
      }else{
        return false;
      }
    });

    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    })

  </script>
@endpush
