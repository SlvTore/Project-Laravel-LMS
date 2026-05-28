@extends('admin.index')
@section('allCategory')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Add Category</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}"><i class="bx bx-home-alt"></i></a>
								</li>
                                <li class="breadcrumb-item"><a href="{{ route('all.category') }}">All Category</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Category</li>
							</ol>
						</nav>
					</div>
</div>
<div class="col-xl-6 mx-auto mt-2">
    <div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Vertical Form</h5>
								<form id="myForm" action="{{ route('store.category') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                    @csrf
									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Category Name</label>
										<input type="text" name='category_name' class="form-control" id="category_name" placeholder="First Name">
									</div>

                                    <div class="col-md-6">
										<label for="input2" class="form-label">Category Image</label>
										<input type="file" name="image" class="form-control" id="image">
									</div>

                                    <div class="col-md-6">
                                         <img id="showImage" src=" {{ url('images/admin/img-profile.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">

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

    <!-- Show Image Before Upload -->
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
    <!-- End Show Image Before Upload -->

</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                category_name: {
                    required : true,
                },
                image: {
                    required : true,
                },

            },
            messages :{
                category_name: {
                    required : 'Please Enter Category Name',
                },
                image: {
                    required : 'Please Upload Category Image',
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
