<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Hotel;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Users/Index', [
            'users' => User::query()->with(['hotel', 'position'])->get(),
            'positions' => Position::all()->map(function ($position) {
                return [
                    'id' => $position->id,
                    'label' => $position->name,
                ];
            }),
            'hotels' => Hotel::all()->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'label' => $hotel->name,
                ];
            }),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = User::query();

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $sortMap[(int) $direction]);
        }

        foreach ($filter as $column => $value) {
            if (!$value) continue;
            $query->where($column, 'LIKE', '%' . $value . '%');
        }

        return response()->json([
            'users' => $query->with(['hotel', 'position'])->get(),
        ]);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => User::find($request->user),
            'positions' => Position::all()->map(function ($position) {
                return [
                    'id' => $position->id,
                    'label' => $position->name,
                ];
            }),
            'hotels' => Hotel::all()->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'label' => $hotel->name,
                ];
            })
        ]);
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        // Removes password field if it's null
        if (!$request->password) {
            unset($request['password']);
        }

        // Update the User details
        User::find($request->user)->update([
            'name' => $request->name,
            'inn' => $request->inn,
            'hotel_id' => $request->input('hotel.id'),
            'position_id' => $request->input('position.id'),
        ]);

        // Redirect to the User Index page
        return Redirect::route('users.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        User::find($request->user)->delete();

        return Redirect::route('users.index');
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'positions' => Position::all()->map(function ($position) {
                return [
                    'id' => $position->id,
                    'label' => $position->name,
                ];
            }),
            'hotels' => Hotel::all()->map(function ($hotel) {
                return [
                    'id' => $hotel->id,
                    'label' => $hotel->name,
                ];
            })
        ]);
    }

    /**
     * Store the user account.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new User();
        $user->fill([
            'name' => $request->name,
            'inn' => $request->inn,
            'hotel_id' => $request->input('hotel.id'),
            'position_id' => $request->input('position.id'),
        ]);
        $user->save();


        return Redirect::route('users.index');
    }
}
