<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.promos', [
            'promos' => Promo::latest()->get(),
            'editing' => $request->filled('edit') ? Promo::find($request->integer('edit')) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Promo::create($this->validated($request));

        return redirect()->route('admin.promos.index')->with('success', 'Kode promo dibuat.');
    }

    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $promo->update($this->validated($request, $promo));

        return redirect()->route('admin.promos.index')->with('success', 'Kode promo diperbarui.');
    }

    public function destroy(Promo $promo): RedirectResponse
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Kode promo dihapus.');
    }

    private function validated(Request $request, ?Promo $promo = null): array
    {
        $request->merge(['code' => strtoupper(trim((string) $request->input('code')))]);

        $data = $request->validate([
            'code' => ['required', 'alpha_dash', 'max:30', Rule::unique('promos')->ignore($promo?->id)],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'integer', 'min:1', Rule::when($request->input('type') === 'percent', ['max:100'])],
            'max_discount' => ['nullable', 'integer', 'min:0'],
            'min_amount' => ['nullable', 'integer', 'min:0'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ]);
        $data['min_amount'] ??= 0;
        $data['active'] = $request->boolean('active');

        return $data;
    }
}
