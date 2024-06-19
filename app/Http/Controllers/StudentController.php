<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;


class StudentController extends Controller
{
    
    public function index()
    {
        $studentQuery = Students::query();
        $studentQuery = $this->applySearch($studentQuery, request('search'));
        
        return inertia('Student/Index', [
            'students' => StudentResource::collection($studentQuery->paginate(5)),
            'search' => request('search') ?? ''
        ]);
    }

    protected function applySearch(Builder $query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function create()
    {
        $classes = ClassesResource::collection(Classes::all());
        return inertia('Student/Create', [
            'classes' => $classes
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        Students::create($request->validated());
        return redirect()->route('students.index');
    }

    public function edit(Students $student)
    {
        $classes = ClassesResource::collection(Classes::all());
        return inertia('Student/Edit', [
            'student' => StudentResource::make($student),
            'classes' => $classes
        ]);
    }

    public function update(UpdateStudentRequest $request, Students $student)
    {
        $student->update($request->validated());
        return redirect()->route('students.index');
    }

    public function destroy(Students $student)
    {
        $student->delete();
        return redirect()->route('students.index');
    }

}
