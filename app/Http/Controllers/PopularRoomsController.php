<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Hotel;
use App\Models\PopularRoom;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PopularRoomsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('PopularRooms/Index', [
            'rooms' => PopularRoom::query()->get(),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = PopularRoom::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'rooms' => $query->get(),
        ]);
    }
}
