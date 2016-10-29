<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Group;

class GroupsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha|unique:groups',
        ]);

        $group = new Group();

        $group->name = $request['name'];

        $group->save();

        return response()->json([
            'id'   => $group->id,
            'name' => $group->name,
        ], 200);
    }
}
