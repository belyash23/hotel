<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Hotel;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class HotelsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Hotels/Index', [
            'hotels' => Hotel::query()->with(['owner', 'director'])->get(),
            'users' => User::all()->map(function ($user) {
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

        $query = Hotel::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'hotels' => $query->with(['owner', 'director'])->get(),
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Hotels/Edit', [
            'hotel' => Hotel::find($request->hotel),
            'users' => User::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'label' => $user->name,
                ];
            }),
        ]);
    }

    public function update(GuestUpdateRequest $request): RedirectResponse
    {
        // Update the User details
        Hotel::find($request->hotel)->update([
            'name' => $request->name,
            'inn' => $request->inn,
            'address' => $request->address,
            'owner_id' => $request->input('owner.id'),
            'director_id' => $request->input('director.id'),
        ]);

        // Redirect to the User Index page
        return Redirect::route('hotels.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Hotel::find($request->hotel)->delete();

        return Redirect::route('hotels.index');
    }

    public function create(): Response
    {
        return Inertia::render('Hotels/Create', [
            'users' => User::all()->map(function ($user) {
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
    public function store(HotelStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new Hotel();
        $user->fill([
            'name' => $request->name,
            'inn' => $request->inn,
            'address' => $request->address,
            'owner_id' => $request->input('owner.id'),
            'director_id' => $request->input('director.id'),
        ]);
        $user->save();


        return Redirect::route('hotels.index');
    }
}
