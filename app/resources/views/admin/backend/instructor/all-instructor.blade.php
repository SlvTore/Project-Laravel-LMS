@extends('admin.index')
@section('allInstructor')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
    .form-check-input.large {
        transform: scale(1.5);
    }
</style>
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Instructor</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Instructor</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{ route('add.category') }}" class="btn btn-primary px-5" >Add Instructor</a>
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
										<th>Instructor Name</th>
                                        <th>Instructor Email</th>
                                        <th>Instructor Phone</th>
                                        <th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ($allinstructor as $key=> $item)
                                    <tr>
                                        <td>{{ $key+1  }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>
                                            @if($item->status == '1')
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check-danger form-check form-switch">
                                                <input class="form-check-input status-toggle large" type="checkbox" id="flexSwitchCheckChecked" data-user-id="{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

<script>
    $(document).ready(function () {
        $('.status-toggle').on('change', function () {
            var userId = $(this).data('user-id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: "{{ route('update.status') }}",
                method: 'POST',
                data: {
                    user_id: userId,
                    is_checked: isChecked ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function () {}
            });

        });
    });
</script>

@endsection
