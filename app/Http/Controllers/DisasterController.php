<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterStoreRequest;
use App\Http\Requests\DisasterUpdateRequest;
use App\Models\Disaster;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DisasterController extends Controller
{
    public function __construct()
    {
        // index, show, searchAjax publik; lain-lain butuh login & verifikasi
        $this->middleware(['auth', 'verified'])
            ->except(['index', 'show', 'searchAjax']);
    }

    public function index(Request $request): View
    {
        $query = Disaster::query()->latest();

        // Bukan admin => hanya active
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('status', 'active');
        } else {
            // Admin bisa filter status via ?status=
            if ($request->filled('status') && in_array($request->status, ['draft', 'active', 'closed'])) {
                $query->where('status', $request->status);
            }
        }

        $disasters = $query->paginate(9);

        return view('disasters.index', compact('disasters'));
    }

    public function show(Disaster $disaster): View
    {
        // Kalau mau batasi show untuk non-active, boleh tambahkan pengecekan di sini
        return view('disasters.show', compact('disaster'));
    }

    public function create(): View
    {
        $user = auth()->user();
        abort_unless($user && ($user->isAdmin() || $user->isPartner()), 403);

        // form create sama untuk admin & partner (status di-handle di store)
        return view('disasters.create');
    }

    public function store(DisasterStoreRequest $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user && ($user->isAdmin() || $user->isPartner()), 403);

        $data = $request->validated();

        // upload gambar
        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->storePublicly('disasters', 'public');
        }

        // slug unik
        $data['slug'] = $this->makeUniqueSlug($data['title']);

        // pemilik bencana
        $data['user_id'] = $user->id;

        // dana terkumpul default 0 jika tidak dikirim
        $data['collected_amount'] = $data['collected_amount'] ?? 0;

        // Partner selalu create sebagai draft
        if ($user->isPartner()) {
            $data['status'] = 'draft';
        } else {
            // Admin boleh set status dari form, default draft
            $data['status'] = $data['status'] ?? 'draft';
        }

        $disaster = Disaster::create($data);

        if ($user->isAdmin()) {
            return redirect()
                ->route('disasters.edit', $disaster)
                ->with('success', 'Bencana berhasil dibuat.');
        }

        return redirect()
            ->route('disasters.my')
            ->with('success', 'Draft bencana kamu berhasil dibuat.');
    }

    public function edit(Disaster $disaster): View
    {
        $user = auth()->user();
        abort_unless($user, 403);

        // Admin: boleh edit apa saja, pakai form lengkap
        if ($user->isAdmin()) {
            return view('disasters.edit', compact('disaster'));
        }

        // Partner: hanya boleh edit bencana miliknya sendiri
        abort_unless($user->isPartner() && $disaster->user_id === $user->id, 403);

        // view edit khusus partner (tanpa status & collected_amount)
        return view('disasters.edit_partner', compact('disaster'));
    }

    public function update(DisasterUpdateRequest $request, Disaster $disaster): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user, 403);

        // selain admin & partner dilarang
        abort_unless($user->isAdmin() || $user->isPartner(), 403);

        // partner hanya boleh edit bencana miliknya
        if ($user->isPartner() && $disaster->user_id !== $user->id) {
            abort(403);
        }

        $data = $request->validated();

        // ganti gambar jika ada file baru
        if ($request->hasFile('img')) {
            if ($disaster->img) {
                Storage::disk('public')->delete($disaster->img);
            }
            $data['img'] = $request->file('img')->storePublicly('disasters', 'public');
        }

        // Kalau judul berubah, slug ikut diupdate (unik)
        if (isset($data['title']) && $data['title'] !== $disaster->title) {
            $data['slug'] = $this->makeUniqueSlug($data['title'], $disaster->id);
        }

        // Partner tidak boleh ubah status & collected_amount
        if (! $user->isAdmin()) {
            unset($data['status'], $data['collected_amount']);
        }

        // isi field lain
        $disaster->fill($data);

        // admin boleh set status dari request (fallback ke nilai lama)
        if ($user->isAdmin()) {
            $disaster->status = $request->input('status', $disaster->status);
        }

        $disaster->save();

        // === BEHAVIOR SESUDAH UPDATE ===
        if ($user->isAdmin()) {
            // admin tetap di halaman edit
            return back()->with('success', 'Postingan diperbarui.');
        }

        // partner balik ke "Bencana Saya"
        return redirect()
            ->route('disasters.my')
            ->with('success', 'Draft bencana kamu sudah diperbarui.');
    }

    public function destroy(Disaster $disaster): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user && ($user->isAdmin() || $user->isPartner()), 403);

        if ($user->isPartner() && $disaster->user_id !== $user->id) {
            abort(403);
        }

        if ($disaster->img) {
            Storage::disk('public')->delete($disaster->img);
        }

        $disaster->delete();

        if ($user->isAdmin()) {
            return redirect()
                ->route('disasters.index')
                ->with('success', 'Bencana berhasil dihapus.');
        }

        return redirect()
            ->route('disasters.my')
            ->with('success', 'Bencana kamu berhasil dihapus.');
    }

    /**
     * Halaman "Bencana Saya" untuk partner
     */
    public function my(Request $request): View
    {
        $user = auth()->user();
        abort_unless($user && $user->isPartner(), 403);

        $disasters = Disaster::where('user_id', $user->id)
            ->latest()
            ->paginate(9);

        return view('disasters.my', compact('disasters'));
    }

    /**
     * Contoh sederhana endpoint searchAjax (kalau memang dipakai).
     */
    public function searchAjax(Request $request)
    {
        $q = trim($request->get('q', ''));

        $query = Disaster::query()->where('status', 'active');

        if ($q !== '') {
            $query->where('title', 'like', "%{$q}%");
        }

        $disasters = $query->limit(10)->get(['id', 'title', 'slug']);

        return response()->json($disasters);
    }

    /**
     * Generate slug unik.
     */
    protected function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $i = 1;

        while (
            Disaster::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }
}
