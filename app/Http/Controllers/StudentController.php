<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the inputs...
        $validated = $request->validate([
            'id' => 'required|digits:12',
            'name' => 'required|string',
            'files.*' => 'required|file|max:102400'
        ]);

        // Check if student exists...
        $student = Student::where('student_id', $validated['id'])
                          ->where('student_name', $validated['name'])
                          ->first();

        // If student exists...
        if ($student) {

            $student->increment('submit_count');

            $folderName = $student->student_id . '_' . $student->student_name;

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileName = $folderName . '-' . Str::random(4) . '-' . $file->getClientOriginalName();
                    $file->storeAs('student_submissions/' . $folderName, $fileName, 'public');
                }
            }

            return redirect()->back()->with('success', 'Files submitted successfully.');
        } else {
            return redirect()->back()->withErrors(['message' => 'Student not found.']);
        }
    }

    public function index()
    {
        $students = Student::all();
        return view('welcome', compact('students'));
    }
}
