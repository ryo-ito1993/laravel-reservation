<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePlanRequest;


class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function show(Plan $plan)
    {
        $plan->load('images');
        return view('admin.plans.show', compact('plan'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(PlanRequest $request)
    {
        $plan = Plan::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('plans', 'public');

                $plan->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('admin.plans.index')->with('success', 'プランを作成しました。');
    }

    public function edit(Plan $plan)
    {
        $plan->load('images');
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        if ($request->hasFile('image')) {
            foreach ($plan->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image);
                $oldImage->delete();
            }

            foreach ($request->file('image') as $image) {
                $path = $image->store('plans', 'public');
                $plan->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('admin.plans.index')->with('message', 'プランを更新しました。');
    }


    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect(route('admin.plans.index'))->with('message', 'プランを削除しました。');
    }
}
