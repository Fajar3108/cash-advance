<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReimbursementRequest;
use App\Models\Reimbursement;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class ReimbursementController extends Controller
{
    public function index(): View
    {
        $reimbursements = Reimbursement::with('user', 'admin');

        if (request()->has('q')) {
            $reimbursements = $reimbursements->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('q') . '%');
            });
        }

        if (auth()->user()->role_id !== RoleSeeder::ADMIN_ID) {
            $reimbursements = $reimbursements->where('user_id', auth()->id());
        }

        $reimbursements = $reimbursements->paginate(10);

        return view('reimbursement.index', compact('reimbursements'));
    }

    public function show(Reimbursement $reimbursement): View
    {
        return view('reimbursement.show', compact('reimbursement'));
    }

    public function create(): View
    {
        $reimbursement = new Reimbursement();
        $reimbursement->date = now()->format('Y-m-d');
        return view('reimbursement.create', compact('reimbursement'));
    }

    public function store(ReimbursementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->is_user_signature_showed) {
            $data['is_user_signature_showed'] = true;
        } else {
            $data['is_user_signature_showed'] = false;
        }

        $data['user_id'] = auth()->id();

        $reimbursement = Reimbursement::create($data);

        Alert::success('Success', 'Reimbursement created successfully');

        return redirect()->route('reimbursements.index');
    }

    public function edit(Reimbursement $reimbursement): View
    {
        return view('reimbursement.edit', compact('reimbursement'));
    }

    public function update(ReimbursementRequest $request, Reimbursement $reimbursement): RedirectResponse
    {
        $data = $request->validated();

        if ($request->is_user_signature_showed) {
            $data['is_user_signature_showed'] = true;
        } else {
            $data['is_user_signature_showed'] = false;
        }

        $reimbursement->update($data);

        Alert::success('Success', 'Reimbursement updated successfully');

        return redirect()->route('reimbursements.index');
    }

    public function destroy(Reimbursement $reimbursement): RedirectResponse
    {
        $reimbursement->delete();

        Alert::success('Success', 'Reimbursement deleted successfully');

        return redirect()->route('reimbursements.index');
    }

    public function approve(Reimbursement $reimbursement): RedirectResponse
    {
        $reimbursement->update([
            'is_approved' => true,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        Alert::success('Success', 'Reimbursement approved successfully');

        return back();
    }

    public function note(Reimbursement $reimbursement): RedirectResponse
    {
        $note = request()->note;

        if (empty($note)) {
            Alert::error('Error', 'Note cannot be empty');
            return back();
        }

        $reimbursement->update([
            'note' => $note,
        ]);

        Alert::success('Success', 'Note updated successfully');

        return back();
    }
}
