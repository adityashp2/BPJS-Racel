<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobDivisionRequest;
use App\Http\Requests\UpdateJobDivisionRequest;
use App\Models\JobDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JobDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobDivisions = JobDivision::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('apps.job-divisions.index', compact('jobDivisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('apps.job-divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobDivisionRequest $request)
    {
        try {
            $jobDivision = JobDivision::make($request->all());
            $jobDivision->slug = Str::slug($jobDivision->name);
            $jobDivision->saveOrFail();

            return redirect()->route('job-divisions.index')->with('success', 'Job Division created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('job-divisions.create')->with('error', 'Failed to create job division');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JobDivision $jobDivision)
    {
        return view('apps.job-divisions.edit', compact('jobDivision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobDivision $jobDivision)
    {
        return view('apps.job-divisions.edit', compact('jobDivision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobDivisionRequest $request, JobDivision $jobDivision)
    {
        try {
            $jobDivision->update($request->all());
            $jobDivision->slug = Str::slug($jobDivision->name);
            $jobDivision->saveOrFail();

            return redirect()->route('job-divisions.index')->with('success', 'Job Division updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('job-divisions.edit', $jobDivision)->with('error', 'Failed to update job division');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobDivision $jobDivision)
    {
        try {
            $jobDivision->delete();

            return redirect()->route('job-divisions.index')->with('success', 'Job Division deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('job-divisions.index')->with('error', 'Failed to delete job division');
        }
    }
}
