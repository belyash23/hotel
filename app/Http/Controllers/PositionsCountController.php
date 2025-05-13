<?php

namespace App\Http\Controllers;

use App\Models\PopularRoom;
use App\Models\HotelFreeRoomCount;
use App\Models\PositionCount;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PositionsCountController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('PositionsCount/Index', [
            'positions' => PositionCount::query()->get(),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = PositionCount::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'positions' => $query->get(),
        ]);
    }
}
