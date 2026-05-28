@extends('admin.index')
@section('allSubCategory')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Edit SubCategory</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}"><i class="bx bx-home-alt"></i></a>
								</li>
                                <li class="breadcrumb-item"><a href="{{ route('all.category') }}">All Category</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit SubCategory</li>
							</ol>
						</nav>
					</div>
</div>
<div class="col-xl-6 mx-auto mt-2">
    <div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Vertical Form</h5>
								<form id="myForm" action="{{ route('update.subcategory', $subcategory->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="id" value="{{ $subcategory->id }}">

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Category Name</label>
										<select name="category_id" class="form-select mb-3" aria-label="default select example" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $subcategory->category_id ? 'selected' : '' }}>{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">SubCategory Name</label>
										<input type="text" name='subcategory_name' class="form-control" id="subcategory_name" value="{{ $subcategory->subcategory_name }}" placeholder="SubCategory Name">
									</div>

									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3">
											<button type="submit" class="btn btn-primary px-4">Submit</button>

										</div>
									</div>
								</form>
							</div>
						</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                subcategory_name: {
                    required : true,
                },
                category_id: {
                    required : true,
                },

            },
            messages :{
                subcategory_name: {
                    required : 'Please Enter SubCategory Name',
                },
                category_id: {
                    required : 'Please Select Category Name',
                },

            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>

@endsection
