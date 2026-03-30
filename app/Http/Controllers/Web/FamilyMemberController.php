<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\FamilyMemberRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FamilyMemberController extends Controller
{
    public function __construct(
        private readonly FamilyMemberRepository $repository,
    ) {}

    public function index(): View
    {
        $members = $this->repository->getForUser(Auth::id());

        return view('family.index', compact('members'));
    }

    public function create(): View
    {
        return view('family.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'relationship'  => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'blood_group'   => ['nullable', 'string', 'max:10'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'phone'         => ['nullable', 'string', 'max:15'],
        ]);

        $this->repository->create(Auth::id(), $data);

        return redirect()->route('family.index')->with('success', 'Family member added successfully.');
    }

    public function edit(int $id): View|RedirectResponse
    {
        $member = $this->repository->findForUser($id, Auth::id());

        if (! $member) {
            return redirect()->route('family.index')->with('error', 'Family member not found.');
        }

        return view('family.edit', compact('member'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $member = $this->repository->findForUser($id, Auth::id());

        if (! $member) {
            return redirect()->route('family.index')->with('error', 'Family member not found.');
        }

        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'relationship'  => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'blood_group'   => ['nullable', 'string', 'max:10'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'phone'         => ['nullable', 'string', 'max:15'],
        ]);

        $this->repository->update($member, $data);

        return redirect()->route('family.index')->with('success', 'Family member updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $member = $this->repository->findForUser($id, Auth::id());

        if (! $member) {
            return redirect()->route('family.index')->with('error', 'Family member not found.');
        }

        $this->repository->delete($member);

        return redirect()->route('family.index')->with('success', 'Family member removed.');
    }
}
