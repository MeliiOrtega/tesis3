<?php

namespace App\Http\Controllers\Voluntary;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;


class CourseController extends Controller
{
    public function __construct(){
        $this->middleware('can:Leer Actividades')->only('index');
        $this->middleware('can:Crear Actividades')->only('create', 'store');
        $this->middleware('can:Actualizar Actividades')->only('edit', 'update', 'goals');
        $this->middleware('can:Eliminarar Actividades')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('voluntary.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('voluntary.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return view('voluntary.courses.show');
       $request->validate([
           'title' => 'required',
           'slug' => 'required|unique:courses',
           'subtitle' => 'required',
           'description' => 'required',
           'category_id' => 'required',
           'file' => 'image',
           'week' => 'required',
           'hourStart' => 'required',
           'hourEnd' => 'required',
       ]);

       $course = Course::create($request->all());

       if($request->file('file')){
            $url = Storage::put('activity', $request->file('file'));
            $course->image()->create([
                'url' => $url
            ]);
        }
        return redirect()->route('voluntary.courses.edit', $course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('voluntary.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $this->authorize('dicatated', $course);

        $categories = Category::pluck('name', 'id');
        return view('voluntary.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('dicatated', $course);

        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug,'. $course->id,
            'subtitle' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'file' => 'image',
            'week' => 'required',
            'hourStart' => 'required',
            'hourEnd' => 'required',
        ]);
        $course->update($request->all());

        if($request->file('file')){
            $url = Storage::put('activity', $request->file('file'));

            if($course->image){
                Storage::delete([$course->image->url]);
                $course->image->update([
                    'url' => $url
                ]);
            }else{
                $course->image()->create([
                    'url' => $url
                ]);
            }
        }
        return redirect()->route('voluntary.courses.edit', $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function goals(Course $course){
        $this->authorize('dicatated', $course);
        return view('voluntary.courses.goals', compact('course'));
    }

    public function status(Course $course){
        $course->status = 2;
        $course->save();

        return back();
    }
}
