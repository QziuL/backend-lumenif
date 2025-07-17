<?php

namespace App\Http\Controllers;

use App\Services\ContentTypeService;
use Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    private ContentTypeService $service;

    public function __construct()
    {
        $this->service = new ContentTypeService();
    }

    public function index()
    {
        return $this->service->getAll();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
