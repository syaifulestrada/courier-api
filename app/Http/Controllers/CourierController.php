<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourierRequest;
use App\Http\Requests\UpdateCourierRequest;
use App\Models\Courier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $allowedSort = ['name', 'registered_at'];

            $sortBy = in_array($request->query('sort'), $allowedSort) ? $request->query('sort') : 'name';
            $orderBy = $request->query('order') === 'desc' ? 'desc' : 'asc';
            $search = $request->query('search');
            $levels = $request->filled('level') ? array_filter(explode(',', $request->query('level')), 'is_numeric') : null;

            $couriers = Courier::query()
                ->when($search, function ($query, $search) {
                    $words = explode(' ', trim($search));
                    foreach ($words as $word) {
                        $query->where('name', 'like', "%$word%");
                    }
                })
                ->when($levels, fn ($query) => $query->whereIn('level', $levels))
                ->orderBy($sortBy, $orderBy)
                ->paginate(10);

            return response()->json($couriers);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'traces' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourierRequest $request)
    {
        try {
            $courier = Courier::create($request->validated());

            return response()->json([
                'message' => 'Data successfully created',
                'data' => $courier,
            ], 201);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'traces' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $courier = Courier::findOrFail($id);

            return response()->json($courier);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'traces' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourierRequest $request, string $id)
    {
        try {
            $courier = Courier::findOrFail($id);
            $courier->update($request->validated());

            return response()->json([
                'message' => 'Data updated successfully',
                'data' => $courier,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'traces' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Courier::findOrFail($id)->delete();

            return response()->json([
                'message' => 'Data deleted successfully',
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'traces' => $e->getTraceAsString()]);

            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
}
