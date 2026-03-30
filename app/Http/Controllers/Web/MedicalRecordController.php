<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Repositories\FamilyMemberRepository;
use App\Repositories\MedicalRecordRepository;
use App\Services\MedicalRecordService;
use App\Services\ShareService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function __construct(
        private readonly MedicalRecordRepository $repository,
        private readonly MedicalRecordService $service,
        private readonly FamilyMemberRepository $familyRepo,
        private readonly ShareService $shareService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only([
            'document_type', 'doctor_name', 'hospital_name',
            'from_date', 'to_date', 'family_member_id',
        ]);

        // Tag filter handled separately (JSON column search)
        $tag = $request->input('tag');

        $query = MedicalRecord::with(['familyMember'])
            ->where('user_id', Auth::id())
            ->orderByDesc('visit_date');

        if (! empty($filters['document_type'])) {
            $query->where('document_type', $filters['document_type']);
        }
        if (! empty($filters['doctor_name'])) {
            $query->where('doctor_name', 'like', '%' . $filters['doctor_name'] . '%');
        }
        if (! empty($filters['hospital_name'])) {
            $query->where('hospital_name', 'like', '%' . $filters['hospital_name'] . '%');
        }
        if (! empty($filters['from_date'])) {
            $query->where('visit_date', '>=', $filters['from_date']);
        }
        if (! empty($filters['to_date'])) {
            $query->where('visit_date', '<=', $filters['to_date']);
        }
        if (! empty($filters['family_member_id'])) {
            $query->where('family_member_id', $filters['family_member_id']);
        }
        if ($tag) {
            $query->whereJsonContains('tags', $tag);
        }

        $records = $query->paginate(15)->withQueryString();

        return view('records.index', compact('records'));
    }

    public function create(): View
    {
        $familyMembers = $this->familyRepo->getForUser(Auth::id());

        return view('records.create', compact('familyMembers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'document_type'    => ['required', 'in:prescription,lab,invoice,report,other'],
            'hospital_name'    => ['nullable', 'string', 'max:255'],
            'doctor_name'      => ['nullable', 'string', 'max:255'],
            'visit_date'       => ['nullable', 'date'],
            'family_member_id' => ['nullable', 'integer', 'exists:family_members,id'],
            'tags'             => ['nullable', 'array'],
            'tags.*'           => ['string', 'max:50'],
            'file'             => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,gif,webp', 'max:20480'],
        ]);

        $record = $this->service->store(Auth::id(), $request->file('file'), collect($data)->except('file')->toArray());

        return redirect()->route('records.show', $record)->with('success', 'Record uploaded successfully.');
    }

    public function show(int $id): View|RedirectResponse
    {
        $record = $this->repository->findForUser($id, Auth::id());

        if (! $record) {
            return redirect()->route('records.index')->with('error', 'Record not found.');
        }

        return view('records.show', compact('record'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $record = $this->repository->findForUser($id, Auth::id());

        if (! $record) {
            return redirect()->route('records.index')->with('error', 'Record not found.');
        }

        $this->service->delete($record);

        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }

    public function share(Request $request, int $id): RedirectResponse
    {
        $record = $this->repository->findForUser($id, Auth::id());

        if (! $record) {
            return redirect()->route('records.index')->with('error', 'Record not found.');
        }

        $data = $request->validate([
            'expires_in_hours' => ['nullable', 'integer', 'min:1'],
        ]);

        $shared = $this->shareService->create($record, Auth::id(), $data['expires_in_hours'] ?? null);

        $shareUrl    = url('/api/shared/' . $shared->token);
        $shareExpiry = $shared->expires_at ? $shared->expires_at->format('d M Y H:i') : null;

        return redirect()->route('records.show', $record)
            ->with('share_url', $shareUrl)
            ->with('share_expires', $shareExpiry);
    }
}
