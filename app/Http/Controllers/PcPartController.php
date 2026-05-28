<?php

namespace App\Http\Controllers;

use App\Models\PcPart;
use Illuminate\Http\Request;

class PcPartController extends Controller
{
    public function index()
    {
        $parts = PcPart::where('user_id', auth()->id())->latest()->get();
        return view('pcparts.index', compact('parts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'brand'       => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        PcPart::create(array_merge($request->only('name','category','brand','price','quantity','description'), ['user_id' => auth()->id()]));

        return redirect()->route('pcparts.index')->with('toast_success', 'PC Part added successfully!');
    }

    public function update(Request $request, PcPart $pcpart)
    {
        $this->authorize_owner($pcpart);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string',
            'brand'       => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $pcpart->update($request->only('name','category','brand','price','quantity','description'));
        return redirect()->route('pcparts.index')->with('toast_success', 'PC Part updated successfully!');
    }

    public function destroy(PcPart $pcpart)
    {
        $this->authorize_owner($pcpart);
        $pcpart->delete();
        return redirect()->route('pcparts.index')->with('toast_success', 'PC Part deleted successfully!');
    }

    private function authorize_owner(PcPart $pcpart)
    {
        if ($pcpart->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
