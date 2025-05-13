<?php

namespace App\Http\Controllers;

use App\Models\PopularRoom;
use App\Models\HotelFreeRoomCount;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HotelFreeRoomsCountController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('FreeRooms/Index', [
            'hotels' => HotelFreeRoomCount::query()->get(),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = HotelFreeRoomCount::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'hotels' => $query->get(),
        ]);
    }
}
