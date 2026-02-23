<?php

namespace App\Http\Controllers;

use App\Http\Resources\CargoResource;
use App\Http\Resources\UserResource;
use App\Models\Cargo;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->fresh();
        $statuses = Status::orderBy('sort_order')->get();

        $query = Cargo::where('user_id', $user->id);

        if ($request->has('status_ids') && is_array($request->status_ids)) {
            $query->whereHas('statusHistories', function ($q) use ($request) {
                $q->whereIn('status_id', $request->status_ids);
            });
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('number', 'LIKE', "%{$searchTerm}%");
        }

        $sort = $request->get('sort', 'desc');
        $sort = in_array(strtolower($sort), ['asc', 'desc']) ? strtolower($sort) : 'desc';

        if ($sort === 'asc') {
            $query->orderBy('created_at', 'ASC');
        } else {
            $query->orderBy('created_at', 'DESC');
        }

        $cargos = $query->with(['orderedHistories', 'media'])->paginate(10)->toResourceCollection();

        return Inertia::render('Dashboard', [
            'statuses' => $statuses,
            'cargos' => CargoResource::collection($cargos),
            'user' => new UserResource($user),
        ]);
    }
}
