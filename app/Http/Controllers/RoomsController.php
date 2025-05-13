<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class RoomsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Rooms/Index', [
            'rooms' => Room::query()->with(['hotel'])->get(),
            'hotels' => Hotel::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->name,
                ];
            }),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = Room::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'rooms' => $query->with(['hotel'])->get(),
            'hotels' => Hotel::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->name,
                ];
            }),
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Rooms/Edit', [
            'room' => Room::find($request->room),
            'hotels' => Hotel::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->name,
                ];
            }),
        ]);
    }

    public function update(RoomUpdateRequest $request): RedirectResponse
    {
        // Update the User details
        Room::find($request->room)->update([
            'num' => $request->num,
            'description' => $request->description,
            'count' => $request->count,
            'cost' => $request->cost,
            'status' => $request->status,
            'hotel_id' => $request->input('hotel.id'),
            'is_free' => $request->is_free,
        ]);

        // Redirect to the User Index page
        return Redirect::route('rooms.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Room::find($request->room)->delete();

        return Redirect::route('rooms.index');
    }

    public function create(): Response
    {
        return Inertia::render('Rooms/Create', [
            'hotels' => Hotel::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->name,
                ];
            }),
        ]);
    }

    /**
     * Store the user account.
     */
    public function store(RoomStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new Room();
        $user->fill([
            'num' => $request->num,
            'description' => $request->description,
            'count' => $request->count,
            'cost' => $request->cost,
            'status' => $request->status,
            'hotel_id' => $request->input('hotel.id'),
            'is_free' => true,
        ]);
        $user->save();


        return Redirect::route('rooms.index');
    }
}
