<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Kelola agent. Versi lama menyimpan agent di $_SESSION (hilang & tidak
 * terhubung ke akun login agent).
 */
class AgentController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.agents', [
            'agents' => User::where('role', User::ROLE_AGENT)->withCount('hotels')->orderBy('name')->get(),
            'editing' => $request->filled('edit')
                ? User::where('role', User::ROLE_AGENT)->find($request->integer('edit'))
                : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['role'] = User::ROLE_AGENT;
        User::create($data);

        return redirect()->route('admin.agents.index')->with('success', 'Agent ditambahkan.');
    }

    public function update(Request $request, User $agent): RedirectResponse
    {
        abort_unless($agent->isAgent(), 404);

        $data = $this->validated($request, $agent);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $agent->update($data);

        return redirect()->route('admin.agents.index')->with('success', 'Agent diperbarui.');
    }

    public function destroy(User $agent): RedirectResponse
    {
        abort_unless($agent->isAgent(), 404);

        ImageUpload::delete($agent->avatar);
        $agent->delete(); // hotel tetap ada, agent_id menjadi null

        return redirect()->route('admin.agents.index')->with('success', 'Agent dihapus.');
    }

    private function validated(Request $request, ?User $agent = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($agent?->id)],
            'password' => [$agent ? 'nullable' : 'required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:30'],
            'agency' => ['nullable', 'string', 'max:150'],
            'location' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:2000'],
            'facebook' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'x' => ['nullable', 'url'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
        ]);

        $data['social'] = [
            'facebook' => $data['facebook'] ?? '#',
            'instagram' => $data['instagram'] ?? '#',
            'x' => $data['x'] ?? '#',
        ];
        unset($data['facebook'], $data['instagram'], $data['x']);

        if ($request->hasFile('avatar')) {
            ImageUpload::delete($agent?->avatar);
            $data['avatar'] = ImageUpload::store($request->file('avatar'), 'avatars');
        } else {
            unset($data['avatar']);
        }

        return $data;
    }
}
