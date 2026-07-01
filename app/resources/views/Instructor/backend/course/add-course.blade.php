@extends('instructor.index')
@section('addCourse')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Add Course</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}"><i class="bx bx-home-alt"></i></a>
								</li>
                                <li class="breadcrumb-item"><a href="{{ route('all.course') }}">All Courses</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Add Course</li>
							</ol>
						</nav>
					</div>
</div>
<div class="col-xl-12 mx-auto mt-2">
    <div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">Add Course Form</h5>
								<form id="myForm" action="{{ route('store.course') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                                    @csrf
									<div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Name</label>
										<input type="text" name='course_name' class="form-control" id="course_name" placeholder="First Name">
									</div>

                                    <div class="form-group col-md-6">
										<label for="input1" class="form-label">Course Title</label>
										<input type="text" name='course_title' class="form-control" id="course_title" placeholder="Course Title">
									</div>


                                    <div class="col-md-6">
										<label for="input2" class="form-label">Course Category</label>
										<select name="category_id" class="form-select mb-3" aria-label="default select example" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            @foreach($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                            @endforeach
                                        </select>
									</div>

                                     <div class="col-md-6">
										<label for="input2" class="form-label">Course Subcategory</label>
										<select name="subcategory_id" class="form-select mb-3" aria-label="default select example" id="inputGroupSelect01">
                                            <option selected></option>
                                        </select>
									</div>

                                    <div class="col-md-6">
										<label for="input2" class="form-label">Certificate Available</label>
										<select name="certificate" class="form-select mb-3" aria-label="default select example" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
									</div>

                                    <div class="col-md-6">
										<label for="input2" class="form-label">Course Label</label>
										<select name="label" class="form-select mb-3" aria-label="default select example" id="inputGroupSelect01">
                                            <option selected>Choose...</option>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Advanced">Advanced</option>
                                        </select>
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Course Price</label>
										<input type="text" name='selling_price' class="form-control" id="selling_price" placeholder="Course Price">
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Discount Price</label>
										<input type="text" name='discount_price' class="form-control" id="discount_price" placeholder="Discount Price">
									</div>

                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Duration</label>
										<input type="text" name='duration' class="form-control" id="duration" placeholder="Duration">
									</div>


                                    <div class="form-group col-md-3">
										<label for="input1" class="form-label">Resources</label>
										<input type="text" name='resources' class="form-control" id="resources" placeholder="Resources">
									</div>

                                    <div class="form-group col-md-12">
										<label for="input1" class="form-label">Course Prerequisite</label>
										<textarea type="text" name='prerequisites' class="form-control" id="prerequisites" placeholder="Course Prerequisites..." rows="3"></textarea>
									</div>

                                     <div class="form-group col-md-12">
										<label for="input1" class="form-label">Course Description</label>
										<textarea type="text" name='course_description' class="form-control" id="course_description" placeholder="Course Description..." rows="3"></textarea>
									</div>

                                    <div class="col-md-6">
										<label for="input2" class="form-label">Course Intro Video</label>
                                         <input type="file" name="video" class="form-control" id="video" accept="video/mp4,video/x-m4v,video/*">
                                    </div>

                                     <div class="col-md-6">
										<label for="input2" class="form-label">Course Image</label>
										<input type="file" name="course_image" class="form-control" id="course_image">
									</div>

                                    <div class="col-md-6">
                                         <img id="showImage" src=" {{ url('images/admin/img-profile.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
									</div>

                                <hr>
                                <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="bestseller" value="1" id="bestseller">
                                                <label class="form-check-label" for="bestseller">
                                                     BestSelling Course
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured">
                                                <label class="form-check-label" for="featured">
                                                    Featured Course
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="highestrated" value="1" id="highestrated">
                                                <label class="form-check-label" for="highestrated">
                                                Highest Rating Course
                                                </label>
                                            </div>
                                        </div>
                                </div>
                                <p>
                                 <div class="row add_item">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                                <label for="goals" class="form-label"> Goals </label>
                                                <input type="text" name="course_goals[]" id="goals" class="form-control" placeholder="Goals ">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6" style="padding-top: 30px;">
                                        <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add More..</a>
                                    </div>
                                </div>



                                </p>
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

<div style="visibility: hidden">
   <div class="whole_extra_item_add" id="whole_extra_item_add">
      <div class="whole_extra_item_delete" id="whole_extra_item_delete">
         <div class="container mt-2">
            <div class="row">


               <div class="form-group col-md-6">
                  <label for="goals">Goals</label>
                  <input type="text" name="course_goals[]" id="goals" class="form-control" placeholder="Goals  ">
               </div>
               <div class="form-group col-md-6" style="padding-top: 20px">
                  <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                  <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!----For Section-------->
<script type="text/javascript">
   $(document).ready(function(){
      var counter = 0;
      $(document).on("click",".addeventmore",function(){
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
      });
      $(document).on("click",".removeeventmore",function(event){
            $(this).closest("#whole_extra_item_delete").remove();
            counter -= 1
      });
   });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('select[name="category_id"]').on('change', function(){
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/subcategory/ajax') }}/"+category_id,
                    type: "GET",
                    dataType:"json",
                    success:function(data){
                        $('select[name="subcategory_id"]').html('');
                        var d =$('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });

    $(document).ready(function(){
        $('#course_image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                course_name: {
                    required : true,
                },
                course_title: {
                    required : true,
                },

            },
            messages :{
                course_name: {
                    required : 'Please Enter Course Name',
                },
                course_title: {
                    required : 'Please Enter Course Title',
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

<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#course_description',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
        tinymce.init({
            selector: 'textarea#prerequisites',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    });
</script>
@endpush
@endsection
