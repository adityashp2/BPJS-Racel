<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JobDivisionController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => JobDivision::withCount('users')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $division = JobDivision::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Divisi berhasil dibuat.', 'data' => $division], 201);
    }

    public function show(JobDivision $jobDivision)
    {
        return response()->json(['data' => $jobDivision->load('users')]);
    }

    public function update(Request $request, JobDivision $jobDivision)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $jobDivision->fill($request->only('description'));

        if ($request->filled('name')) {
            $jobDivision->name = $request->name;
            $jobDivision->slug = Str::slug($request->name);
        }

        $jobDivision->save();

        return response()->json(['message' => 'Divisi berhasil diperbarui.', 'data' => $jobDivision]);
    }

    public function destroy(JobDivision $jobDivision)
    {
        $jobDivision->delete();

        return response()->json(['message' => 'Divisi berhasil dihapus.']);
    }
}
