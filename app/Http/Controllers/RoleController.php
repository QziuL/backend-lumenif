<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct()
    {
        $this->roleService = new RoleService();
    }


    public function index()
    {
        $roles = $this->roleService->getAll();
        return response()->json($roles, 200);
    }
}
