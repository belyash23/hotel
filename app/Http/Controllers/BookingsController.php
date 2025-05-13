<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Position;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class BookingsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Bookings/Index', [
            'bookings' => Booking::query()->with(['guest', 'room'])->get(),
            'guests' => Guest::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->email,
                ];
            }),
            'rooms' => Room::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->num,
                ];
            }),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = Booking::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'bookings' => $query->with(['guest', 'room'])->get(),
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Bookings/Edit', [
            'booking' => Booking::find($request->booking),
            'guests' => Guest::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->email,
                ];
            }),
            'rooms' => Room::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->num,
                ];
            }),
        ]);
    }

    public function update(GuestUpdateRequest $request): RedirectResponse
    {
        // Update the User details
        Booking::find($request->booking)->update([
            'prepayment' => $request->prepayment,
            'arrival_date' => $request->inn,
            'departure_date' => $request->address,
            'guest_id' => $request->input('guest.id'),
            'room_id' => $request->input('room.id'),
        ]);

        // Redirect to the User Index page
        return Redirect::route('bookings.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Booking::find($request->booking)->delete();

        return Redirect::route('bookings.index');
    }

    public function create(): Response
    {
        return Inertia::render('Bookings/Create', [
            'guests' => Guest::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->email,
                ];
            }),
            'rooms' => Room::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->num,
                ];
            }),
        ]);
    }

    /**
     * Store the user account.
     */
    public function store(BookingStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new Booking();
        $user->fill([
            'prepayment' => $request->prepayment,
            'arrival_date' => $request->arrival_date,
            'departure_date' => $request->departure_date,
            'guest_id' => $request->input('guest.id'),
            'room_id' => $request->input('room.id'),
        ]);
        $user->save();


        return Redirect::route('bookings.index');
    }
}
