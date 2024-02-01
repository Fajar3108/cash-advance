<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstant;
use App\Http\Requests\StuffRequest;
use App\Models\Stuff;
use App\Models\StuffItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StuffController extends Controller
{
    public function index(): View
    {
        $stuffs = Stuff::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $stuffs = $stuffs->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('q') . '%');
            });
        }

        $stuffs = $stuffs->paginate(10);

        return view('stuff.index', compact('stuffs'));
    }

    public function show(Stuff $stuff): View
    {
        return view('stuff.show', compact('stuff'));
    }

    public function create(): View
    {
        $stuff = new Stuff();
        $stuff->date = now()->format('Y-m-d');
        return view('stuff.create', compact('stuff'));
    }

    public function store(StuffRequest $request)
    {
        if (empty($request->items)) {
            Alert::error('Error', 'Please add at least one item');
            return back()->withInput($request->except('items'));
        }

        $data = $request->validated();
        $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
        $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;
        $data['user_id'] = auth()->id();

        $items = json_decode($request->items);

        DB::transaction(function () use ($data, $items) {
            $stuff = Stuff::create($data);

            for ($i = 0; $i < count($items); $i++) {
                $items[$i] = [
                    'id' => str()->uuid(),
                    'note' => $items[$i]->note,
                    'name' => $items[$i]->name,
                    'quantity' => $items[$i]->quantity,
                    'price' => $items[$i]->price,
                    'stuff_id' => $stuff->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            StuffItem::insert($items);
        });


        Alert::success('Success', 'Stuff created successfully');

        return redirect()->route('stuffs.index');
    }

    public function edit(Stuff $stuff): View
    {
        $this->authorize('update', $stuff);

        return view('stuff.edit', compact('stuff'));
    }

    public function update(StuffRequest $request, Stuff $stuff)
    {
        $this->authorize('update', $stuff);

        $data = $request->validated();
        $data['is_user_signature_showed'] = $request->is_user_signature_showed ? true : false;
        $data['status'] = $request->is_draft ? StatusConstant::DRAFT : StatusConstant::PENDING;

        $stuff->update($data);

        Alert::success('Success', 'Stuff updated successfully');

        return redirect()->route('stuffs.index');
    }

    public function destroy(Stuff $stuff)
    {
        $this->authorize('update', $stuff);

        $stuff->delete();

        Alert::success('Success', 'Stuff deleted successfully');

        return redirect()->route('stuffs.index');
    }

    public function approve(Stuff $stuff)
    {
        $stuff->update([
            'status' => StatusConstant::APPROVED,
            'admin_id' => auth()->id(),
            'is_admin_signature_showed' => request()->is_admin_signature_showed ? true : false,
        ]);

        Alert::success('Success', 'Stuff approved successfully');

        return redirect()->route('stuffs.index');
    }

    public function note(Stuff $stuff)
    {
        $stuff->update([
            'note' => request()->note,
        ]);

        Alert::success('Success', 'Note updated successfully');

        return redirect()->route('stuffs.index');
    }

    public function pdf(Stuff $stuff)
    {
        $pdf = Pdf::loadView('stuff.pdf', compact('stuff'));
        return $pdf->stream('stuff.pdf');
    }

    public function report(Request $request): View
    {
        $stuffsRaw = Stuff::with('user', 'admin')->orderBy('date', 'DESC');

        if (request()->has('q')) {
            $stuffsRaw = $stuffsRaw->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . request('q') . '%');
            });
        } else {
            if ($request->has('requestBy')) {
                $stuffsRaw = $stuffsRaw->where('user_id', $request->requestBy);
            }

            if ($request->has('startDate')) {
                $stuffsRaw = $stuffsRaw->where('date', '>=', $request->startDate);
            } else {
                $stuffsRaw = $stuffsRaw->where('date', '>=', now()->format('Y-m-d'));
            }

            if ($request->has('endDate')) {
                $stuffsRaw = $stuffsRaw->where('date', '<=', $request->endDate);
            } else {
                $stuffsRaw = $stuffsRaw->where('date', '<=', now()->format('Y-m-d'));
            }
        }

        $stuffsRaw = $stuffsRaw->get()->groupBy('user_id');

        $stuffs = collect();

        $stuffsRaw->each(function ($stuff) use ($stuffs) {
            foreach ($stuff as $item) {
                $stuffs->push($item);
            }
        });

        return view('stuff.report', compact('stuffs'));
    }
}
