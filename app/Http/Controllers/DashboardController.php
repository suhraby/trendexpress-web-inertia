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

        if ($request->has('statusIds') && is_array($request->statusIds)) {
            $statusIds = $request->statusIds;

            $query->whereHas('statuses', function ($q) use ($statusIds) {
                $q->whereIn('status_id', $statusIds)
                    ->whereRaw('cargo_status_history.status_at = (
                        SELECT MAX(csh.status_at)
                        FROM cargo_status_history csh
                        WHERE csh.cargo_id = cargo_status_history.cargo_id
                    )');
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
