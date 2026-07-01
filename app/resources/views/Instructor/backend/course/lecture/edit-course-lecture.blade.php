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
                    <li class="breadcrumb-item"><a href="{{ route('add.course.lecture', $clecture->course_id) }}">Add Course Lecture</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Course Lecture</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body p-4">
            <h5 class="mb-4">Edit Lecture Form</h5>
            <form id="myForm" action="{{ route('update.lecture') }}" method="POST" class="row g-3">
                @csrf
                <input type="hidden" name="id" value="{{ $clecture->id }}">
                
                <div class="form-group col-md-6">
                    <label for="lecture_title" class="form-label">Lecture Title</label>
                    <input type="text" name="lecture_title" class="form-control" id="lecture_title" value="{{ $clecture->lecture_title }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="lecture_url" class="form-label">Video URL</label>
                    <input type="url" name="lecture_url" class="form-control" id="lecture_url" value="{{ $clecture->url }}">
                </div>

                <div class="form-group col-md-12">
                    <label for="content" class="form-label">Lecture Content</label>
                    <textarea name="content" class="form-control" id="content" rows="5">{{ $clecture->content }}</textarea>
                </div>

                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        <a href="{{ route('add.course.lecture', $clecture->course_id) }}" class="btn btn-secondary px-4">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
