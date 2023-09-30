<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;


class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = Plan::with('images');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $plans = $query->get();

        return view('plans.index', compact('plans'));
    }


    public function show(Plan $plan)
    {
        $plan->load('images');
        return view('plans.show', compact('plan'));
    }
}
