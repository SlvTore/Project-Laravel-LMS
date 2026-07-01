@extends('instructor.index')
@section('allCourses')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Courses</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Courses</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{ route('add.course') }}" class="btn btn-primary px-5" >Add Course</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">DataTable</h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sl</th>
										<th>Course Image</th>
										<th>Course Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Label</th>
                                        <th>Duration</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($courses as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1  }}</td>
                                        <td><img src="{{ asset($item->course_image) }}" alt="" style="width: 70px; height:40px; "/> </td>
                                        <td>{{ $item->course_name }}</td>
                                        <td>{{ $item['category']['category_name'] }}</td>
                                        <td>{{ $item->selling_price }}</td>
                                        <td>{{ $item->discount_price }}</td>
                                        <td>{{ $item->label }}</td>
                                        <td>{{ $item->duration }}</td>
                                        <td>
                                            <a href="{{ route('edit.course',$item->id) }}" class="btn btn-info px-5" title="Edit Course"><i class="bx bx-eraser"></i></a>
                                            <a href="{{ route('delete.course',$item->id) }}" class="btn btn-danger px-5" id="delete" title="Delete Course"><i class="bx bx-trash"></i></a>
                                            <a href="{{ route('add.course.lecture',$item->id) }}" class="btn btn-outline-warning px-5" title="Add Lecture"><i class="bx bx-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

@endsection
