<?php

namespace App\Http\Controllers;

use App\Models\{Disaster, DisasterLink};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\DisasterLinkRequest;

class DisasterLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','admin']);
    }

    public function index(Disaster $disaster): View
    {
        $links = $disaster->links()->orderBy('sort_order')->get();
        return view('disaster_links.index', compact('disaster','links'));
    }

    public function create(Disaster $disaster): View
    {
        return view('disaster_links.create', compact('disaster'));
    }

    public function store(DisasterLinkRequest $request, Disaster $disaster): RedirectResponse
    {
    $data = $request->validated();
        $data['disaster_id'] = $disaster->id;

        DisasterLink::create($data);

        return back()->with('success', 'Link ditambahkan.');
    }

    public function edit(Disaster $disaster, DisasterLink $disasterLink): View
    {
        return view('disaster_links.edit', compact('disaster','disasterLink'));
    }

    public function update(DisasterLinkRequest $request, Disaster $disaster, DisasterLink $disasterLink): RedirectResponse
    {
        $disasterLink->update($request->validated());
        return redirect()->route('disasters.edit',$disaster)->with('success','Link diperbarui.');
    }

    public function destroy(Disaster $disaster, DisasterLink $link): RedirectResponse
    {
         if ($link->disaster_id !== $disaster->id) {
             abort(404, 'Postingan Bencana belum active');
        }

        $link->delete();

        return back()->with('success', 'Link dihapus.');

    }
}
