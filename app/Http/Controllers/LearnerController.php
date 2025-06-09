<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Learner;
use App\Models\Course;
use App\Models\Enrolment;

class LearnerController extends Controller
{
    /**
     * Display a listing of learners, with optional filtering by course and sorting by progress.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     *
     * Query Parameters:
     * - course_id: (optional) Filter learners by course ID.
     * - sort: (optional) Sort learners by progress. Accepts 'progress_asc' or 'progress_desc'.
     *
     * The method loads all learners, optionally filtered by course, and sorts them by progress if requested.
     * It passes the learners, courses, selected course, and sort order to the view.
     */
    public function index(Request $request)
    {
        $courseId = $request->input('course_id');
        $sort = $request->input('sort');
        $courses = \App\Models\Course::all();        $query = \App\Models\Learner::with(['enrolments.course']);
        if ($courseId) {
            $query->whereHas('enrolments', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }
        
        // First get all learners for sorting by progress
        $allLearners = $query->get();
        
        if ($sort === 'progress_asc' || $sort === 'progress_desc') {
            $allLearners = $allLearners->sortBy(function($learner) use ($courseId) {
                // Get progress for the filtered course or average if no filter
                if ($courseId) {
                    $enrol = $learner->enrolments->where('course_id', $courseId)->first();
                    return $enrol ? $enrol->progress : 0;
                } else {
                    $count = $learner->enrolments->count();
                    return $count ? $learner->enrolments->avg('progress') : 0;
                }
            });
            if ($sort === 'progress_desc') {
                $allLearners = $allLearners->reverse();
            }
            $allLearners = $allLearners->values();
        }
        
        // Paginate the sorted collection
        $perPage = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
          $learners = new \Illuminate\Pagination\LengthAwarePaginator(
            $allLearners->slice($offset, $perPage),
            $allLearners->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('learner-progress', compact('learners', 'courses', 'courseId', 'sort'));
    }
}
