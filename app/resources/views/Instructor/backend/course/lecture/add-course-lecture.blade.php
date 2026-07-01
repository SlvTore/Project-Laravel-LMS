@extends('instructor.index')
@section('instructorContent')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Edit Course Lecture</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('all.course') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Course Lecture</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase mb-2">Course Lecture Management</h6>

    <!-- Top Media Card -->
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="{{ asset($course->course_image) }}" class="rounded-circle p-1 border" width="90" height="90" alt="...">
                <div class="flex-grow-1 ms-3">
                    <h5 class="mt-0">{{ $course->course_name }}</h5>
                    <p class="mb-0">
                        {{ $course->course_title }}
                    </p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Section</button>
            </div>
        </div>
    </div>

    <!-- Section Cards -->
    @foreach ($section as $key=> $item)
    <div class="card shadow-none border mt-3">
        <div class="card-body p-3 d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">{{ $item->section_title }}</h6>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('delete.section', $item->id) }}" class="btn btn-danger btn-sm px-2" id="delete">Delete Section</a>
                <a class="btn btn-primary btn-sm px-2" onClick="addLectureDiv({{ $course->id }}, {{ $item->id }}, 'lectureContainer{{ $key }}')" id="addLectureBtn({{ $key }})">Add Lecture</a>
            </div>
        </div>
        <div class="courseHide" id="lectureContainer{{ $key }}">
            <div class="px-3 pb-3">
                @foreach ($item->lectures as $lecture)
                <div class="lectureDiv mb-3 d-flex align-items-center justify-content-between p-2 border rounded bg-white">
                    <div>
                        <strong>{{ $lecture->lecture_title }}</strong>
                    </div>
                    <div class="btn-group gap-1">
                        <a href="{{ route('edit.lecture', ['id' => $lecture->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('delete.lecture', $lecture->id) }}" class="btn btn-sm btn-danger" id="delete">Delete</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('add.course.section') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="form-group mb-3">
                        <label for="section_title" class="form-label">Section Name</label>
                        <input type="text" class="form-control" id="section_title" name="section_title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    function addLectureDiv(courseId, sectionId, containerId) {
        var container = document.getElementById(containerId);

        // Prevent duplicate add forms under the same section
        if (container.querySelector('.add-lecture-form')) {
            return;
        }

        var lectureFormDiv = document.createElement('div');
        lectureFormDiv.classList.add('add-lecture-form', 'p-3', 'border', 'rounded', 'bg-light', 'mb-3');
        lectureFormDiv.innerHTML = `
            <h6>Lecture Title</h6>
            <input type="text" class="form-control mb-3" placeholder="Enter Lecture Title" required>

            <textarea class="form-control mt-2 mb-3" placeholder="Enter Lecture Content" rows="3"></textarea>

            <h6>Add Lecture Video</h6>
            <input type="url" name="url" class="form-control mb-3" placeholder="Enter Video URL">

            <button class="btn btn-primary btn-sm mt-2" onclick="saveLecture('${courseId}', '${sectionId}', '${containerId}', this)">Save Lecture</button>
            <button class="btn btn-secondary btn-sm mt-2" onclick="cancelAddLecture(this)">Cancel</button>
        `;

        container.appendChild(lectureFormDiv);
    }

    function cancelAddLecture(button) {
        var formDiv = button.closest('.add-lecture-form');
        if (formDiv) {
            formDiv.remove();
        }
    }
</script>

<script type="text/javascript">
    function saveLecture(courseId, sectionId, containerId, button){
        const formDiv = button.closest('.add-lecture-form');
        const lectureTitle = formDiv.querySelector('input[type="text"]').value;
        const lectureContent = formDiv.querySelector('textarea').value;
        const lectureUrl = formDiv.querySelector('input[type="url"]').value;

        if (!lectureTitle) {
            alert("Please enter a lecture title.");
            return;
        }

        fetch('{{ route('save-lecture') }}', {
            method: 'POST',
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                course_id: courseId,
                section_id: sectionId,
                lecture_title: lectureTitle,
                lecture_url: lectureUrl,
                content: lectureContent,
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000
            });

            if (!data.error) {
                Toast.fire({
                    icon: 'success',
                    title: data.success || 'Lecture saved successfully',
                }).then(() => {
                    location.reload();
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.error,
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong while saving the lecture.');
        });
    }
</script>
@endpush
@endsection
