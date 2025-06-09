{{--
    Display a table of learners with filtering and sorting controls.
    - @var \Illuminate\Support\Collection $learners: List of learners to display
    - @var \Illuminate\Support\Collection $courses: List of all courses for filtering
    - @var string|null $courseId: Selected course for filtering (optional)
    - @var string|null $sort: Selected sort order (optional)
--}}
@php($hasData = isset($learners) && count($learners))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Progress</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/university-table.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">    
    <div class="logo-container">
        <img src="{{ asset('media/Valenture-Institute-logo-white.svg') }}" alt="Valenture Institute" class="logo">
    </div>
    <h1 class="mb-4">Learner Progress</h1>
    <form method="GET" action="" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <label for="course_id" class="col-form-label">Filter by Course:</label>
        </div>
        <div class="col-auto">
            <select name="course_id" id="course_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @if(isset($courseId) && $courseId == $course->id) selected @endif>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label for="sort" class="col-form-label">Sort by:</label>
        </div>
        <div class="col-auto">
            <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                <option value="">Default</option>
                <option value="progress_asc" @if(isset($sort) && $sort == 'progress_asc') selected @endif>Progress (Ascending)</option>
                <option value="progress_desc" @if(isset($sort) && $sort == 'progress_desc') selected @endif>Progress (Descending)</option>
            </select>
        </div>
    </form>    @if($hasData)
        <div class="table-responsive">            
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Courses Enrolled</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($learners as $learner)
                        <tr>
                            <td>{{ $learner->id }}</td>
                            <td><strong>{{ $learner->firstname }} {{ $learner->lastname }}</strong></td>
                            <td>
                                @if($learner->enrolments->count())
                                    <ul class="list-unstyled mb-0">
                                        @foreach($learner->enrolments as $enrolment)                                            
                                            @if(!$courseId || $enrolment->course_id == $courseId)
                                                <li>
                                                    <span>{{ $enrolment->course->name ?? 'N/A' }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">No courses enrolled</span>
                                @endif
                            </td>
                            <td>
                                @foreach($learner->enrolments as $enrolment)
                                    @if(!$courseId || $enrolment->course_id == $courseId)
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <span>{{ $enrolment->progress }}%</span>
                                            </li>
                                        </ul>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $learners->appends(request()->query())->links() }}
        </div>
    @else
        <div class="alert alert-info">No learners found.</div>
    @endif
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>