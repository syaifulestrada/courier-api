<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $allowedSort = ['name', 'registered_at'];

        $sortBy = in_array($request->query('sort'), $allowedSort) ? $request->query('sort') : 'name';
        $orderBy = $request->query('order') === 'desc' ? 'desc' : 'asc';
        $search = $request->query('search');

        $couriers = Courier::query()
            ->when($search, function ($query, $search) {
                $words = explode(' ', trim($search));
                foreach ($words as $word) {
                    $query->where('name', 'like', "%$word%");
                }
            })
            ->orderBy($sortBy, $orderBy)
            ->paginate(10);

        return response()->json($couriers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
