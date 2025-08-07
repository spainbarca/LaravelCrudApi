<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();

        $data = [
            'students' => $students,
            'status' => 200
        ];
        
        return response()->json($data, 200);
    }

    public function store (Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:student,email',
            'phone' => 'required|digits_between:10,15',
            'language' => 'required|string|max:50|in:English,Spanish,French,German',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'We encountered some errors in validating your request.',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $student = Student::create($request->all());

        if (!$student) {
            return response()->json([
                'message' => 'Failed to create student.',
                'status' => 500
            ], 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id) {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.',
                'status' => 404
            ], 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id) {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.',
                'status' => 404
            ], 404);
        }

        $student->delete();

        $data = [
            'message' => 'Student deleted successfully.',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Student not found.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:student,email,' . $id,
            'phone' => 'required|digits_between:10,15',
            'language' => 'required|string|max:50|in:English,Spanish,French,German',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'We encountered some errors in validating your request.',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        $student->update($request->all());

        $data = [
            'message' => 'Student updated successfully.',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id) {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Student not found.',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:student,email,' . $id,
            'phone' => 'digits_between:10,15',
            'language' => 'string|max:50|in:English,Spanish,French,German',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'We encountered some errors in validating your request.',
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }

        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }
        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }
        if ($request->has('language')) {
            $student->language = $request->language;
        }
        $student->save();

        $data = [
            'message' => 'Student updated successfully.',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
