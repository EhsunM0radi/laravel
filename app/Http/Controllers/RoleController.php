<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function fetchRoles()
    {
        $roles = ['developer', 'tester', 'project manager']; // Fetch all roles from the database
        return response()->json(['roles' => $roles]);
    }
}
