<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $this->authorize('view project page');

        return view('project.index');
    }

    public function create(): View
    {
        $this->authorize('create project');
        
        return view('project.create');
    }
}
