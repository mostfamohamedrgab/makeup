@push('css')
	<style type="text/css">
			form {
				background: #fff;
				padding:20px;
				margin:auto;
				margin-top: 10px ;
				margin-bottom: 10px ;
				width: 70%;
			}
	</style>
@endpush
@push('js')
<script type="text/javascript">
	$('#price').on('click', function (){
		if($(this).is(':checked'))
		{
			$('#percentage_discount').val('');
		}
	});

	$('#percentage').on('click', function (){
		if($(this).is(':checked'))
		{
			$('#price_discount').val('');
		}
	});


	$('#gnerate_code').click(function (e){
		e.preventDefault();
		$('#code').val(makeid(8));
	});

	// gnerate random code 
	function makeid(length) {
	    var result           = '';
	    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	    var charactersLength = characters.length;
	    for ( var i = 0; i < length; i++ ) {
	    result += characters.charAt(Math.floor(Math.random() * charactersLength));
	   }
	   return result;
	} // end gnerate random code 

</script>
@endpush
@extends('admin.layouts.main')

@section('content')

	<!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">


								<form action="{{route('admin.coupons.store')}}" method="post">
									@csrf 
									  <div class="form-group">
									    <label for="">code</label>
									    <div class="row">
								   			<div class="col-10">
									    		<input type="text" class="form-control" id="code" name="code" value="{{old('code')}}">
								   			</div>
								   			<div class="col-2">
								   				<button class="btn btn-primary" id="gnerate_code">Gnerate Random</button>
								   			</div>
									    </div>
									  </div>
									  

									  <!--- price disccount area ------>
									  	<div class="form-check d-flex w-100 justify-content-between">
										 	<div class="">
										 		 <input class="form-check-input" type="radio"  name="type" value="fixed" id="price">
												  <label class="form-check-label" for="price">
												    fixed
												  </label>
										 	</div>
										 	<div class="">
										 		<input type="number" class="form-control" name="price_discount" value="{{old('price_discount')}}" id="price_discount">
										 	</div>
										</div>
										<!---- end price disccount area --->
										<!----- percentage disccount type ---->
									  	<div class="form-check mt-10 d-flex w-100 justify-content-between">
										 	<div class="">
										 		 <input class="form-check-input" type="radio"  name="type" value="percentage" id="percentage">
												  <label class="form-check-label" for="percentage">
												    Percentage
												  </label>
										 	</div>
										 	<div class="">
										 		<input type="number" class="form-control" name="percentage_discount" value="{{old('percentage_discount')}}" id="percentage_discount">
										 	</div>
										</div>
										<!--- end percentage disccount --->

										<div class="row mt-10">
										 	<div class="form-group col-md-6">
											    <label for="" class="form-label">Start Date</label>
											    <input type="date" class="form-control" id=""  name="start_at">
											</div>
											<div class="form-group col-md-6">
											    <label for="" class="form-label">End Date</label>
											    <input type="date" class="form-control" id=""  name="end_at">
											</div>
										</div>


									  <button type="submit" class="btn btn-primary">Save</button>
									</form>

								<!--begin::Card-->
								<div class="card card-custom">
									<!--begin::Header-->
								<div class="card-header flex-wrap border-0 pt-6 pb-0">
									<div class="card-title w-100 d-flex justify-content-between">
										<h3 class="card-label float-left">coupons</h3>
									
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
													<th scope="col">Code</th>
													<th scope="col">Type</th>
													<th scope="col">Discount</th>
													<th scope="col">type</th>
													<th scope="col">start - end</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach($coupons as $coupon)
												<tr>
													<th scope="row">{{$coupon->code}}</th>
													<td>{{$coupon->type}}</td>
													<td>{{$coupon->discount }}</td>
													<td>{{$coupon->type }}</td>
													<td>{{$coupon->start_at }} - {{$coupon->end_at }}</td>
													<td>
													


												
									<a href="{{ route('admin.coupons.destroy',$coupon->id) }}" 
									
      class="btn btn-sm btn-light-danger font-weight-bolder py-2 px-5 delete-form-btn"
      onclick="event.preventDefault();
                    document.getElementById('delete-row-{{$coupon->id}}').submit();"> <i class="fa fa-trash"></i></a>
         
                
    <form id="delete-row-{{$coupon->id}}"
     action="{{ route('admin.coupons.destroy',$coupon->id) }}" method="POST" class="d-none delete-form">
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

@push('js')
	<script type="text/javascript">
			
			$(document).on('submit','.delete-form',function (e){
				alert(1);
			});

	</script>
@endpush