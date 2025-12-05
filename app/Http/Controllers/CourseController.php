<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index()
    {
        $courses = Course::withCount('materials')
            ->with('creator')
            ->latest()
            ->paginate(12);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tipo' => 'required|in:Inglés,Programas técnicos laborales',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $validated['created_by'] = auth()->id();

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Curso creado exitosamente');
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load(['materials' => function ($query) {
            $query->orderBy('order');
        }, 'creator']);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tipo' => 'required|in:Inglés,Programas técnicos laborales',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Curso actualizado exitosamente');
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        // Delete all materials and their files
        foreach ($course->materials as $material) {
            Storage::disk('public')->delete($material->file_path);
        }

        // Delete thumbnail if exists
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado exitosamente');
    }

    /**
     * Upload material to a course
     */
    public function uploadMaterial(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:video,pdf,image,document',
            'file' => 'required|file|max:102400', // 100MB max
        ]);

        // Validate file based on type
        $mimeRules = [
            'video' => ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime'],
            'pdf' => ['application/pdf'],
            'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        ];

        $file = $request->file('file');
        
        // Store file
        $path = $file->store('courses/' . $course->id . '/' . $validated['type'], 'public');

        // Create material record
        CourseMaterial::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'order' => $course->materials()->max('order') + 1,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Material subido exitosamente');
    }

    /**
     * Delete a material
     */
    public function deleteMaterial(Course $course, CourseMaterial $material)
    {
        // Verify material belongs to course
        if ($material->course_id !== $course->id) {
            abort(403);
        }

        // Delete file
        Storage::disk('public')->delete($material->file_path);

        // Delete record
        $material->delete();

        return back()->with('success', 'Material eliminado exitosamente');
    }

    /**
     * Update material order
     */
    public function updateMaterialOrder(Request $request, Course $course)
    {
        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:course_materials,id',
            'materials.*.order' => 'required|integer',
        ]);

        foreach ($validated['materials'] as $materialData) {
            CourseMaterial::where('id', $materialData['id'])
                ->where('course_id', $course->id)
                ->update(['order' => $materialData['order']]);
        }

        return response()->json(['success' => true]);
    }
}
