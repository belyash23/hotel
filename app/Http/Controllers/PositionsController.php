<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\GuestUpdateRequest;
use App\Http\Requests\GuestStoreRequest;
use App\Http\Requests\PositionUpdateRequest;
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

class PositionsController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Positions/Index', [
            'positions' => Position::query()->get(),
        ]);
    }

    public function sort(Request $request)
    {
        $sort = json_decode($request->get('sort'), true);
        $filter = json_decode($request->get('filter'), true);

        $sortMap = ['DESC', 'ASC'];

        $query = Position::query();

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

    public function edit(Request $request): Response
    {
        return Inertia::render('Positions/Edit', [
            'position' => Position::find($request->position),
        ]);
    }

    public function update(PositionUpdateRequest $request): RedirectResponse
    {
        // Update the User details
        Position::find($request->position)->update([
            'name' => $request->name,
        ]);

        // Redirect to the User Index page
        return Redirect::route('positions.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Position::find($request->position)->delete();

        return Redirect::route('positions.index');
    }

    public function create(): Response
    {
        return Inertia::render('Positions/Create', [
        ]);
    }

    /**
     * Store the user account.
     */
    public function store(GuestStoreRequest $request): RedirectResponse
    {
        // Store the User details
        $user = new Position();
        $user->fill([
            'name' => $request->name,
        ]);
        $user->save();


        return Redirect::route('positions.index');
    }
}
