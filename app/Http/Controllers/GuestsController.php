<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Hotel;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GuestsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Guests/Index', [
            'guests' => Guest::query()->get(),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = Guest::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'guests' => $query->get(),
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Guests/Edit', [
            'guest' => Guest::find($request->guest),
        ]);
    }

    public function update(GuestUpdateRequest $request): RedirectResponse
    {
        // Update the User details
        Guest::find($request->guest)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redirect to the User Index page
        return Redirect::route('guests.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Guest::find($request->guest)->delete();

        return Redirect::route('guests.index');
    }

    public function create(): Response
    {
        return Inertia::render('Guests/Create', [
        ]);
    }

    /**
     * Store the user account.
     */
    public function store(GuestStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new Guest();
        $user->fill([
            'email' => $request->email,
            'name' => $request->name,
        ]);
        $user->save();


        return Redirect::route('guests.index');
    }
}
