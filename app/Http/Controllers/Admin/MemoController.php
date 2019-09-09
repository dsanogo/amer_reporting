<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Memo;
use App\Models\MemoType;
use App\Models\SupervisingOrg;
use App\Models\Office;
use App\Models\MemoOffice;
use App\Http\Requests\StoreMemo;
use App\Http\Requests\UpdateMemo;
use Illuminate\Support\Facades\Input;
use DB;

class MemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memos = Memo::with('memoType', 'org')->get();
        return view('admin.memos.index')->with('memos', $memos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $memoTypes = MemoType::all();
        $orgs = SupervisingOrg::all();
        $offices = Office::all();
        return view('admin.memos.create', compact('memoTypes', 'orgs', 'offices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreMemo  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Origin' => 'required|integer',
            'Number' => 'required|unique:Memos|max:20',
            'Time' => 'required|date',
            'MemoTypeId' => 'required|integer',
            'SuperVisingOrgId' => 'required|integer',
            'Brief' => 'nullable|string',
            'offices' => 'array',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $input = $request->all();
        // The incoming request is valid...

        // Retrieve the validated input data...
        // $validated = $request->validated();

        /**Start Transaction */
        DB::transaction(function () use ($input, $request) {
            $memo = (new Memo)->create($input);

            if (!empty($request->offices)) {
                foreach ($request->offices as $office_id) {
                    (new MemoOffice)->create(['MemoId' => $memo->Id, 'OfficeId' => $office_id]);
                }
            }

            if (Input::file('PhotoId')) {
                $file = Input::file('PhotoId');
                $path = $file->getRealPath();
                $photo = file_get_contents($path);
                $base64 = base64_encode($photo);
                $file = (new File)->create(['File' => $base64]);
                $memo->PhotoId = $file->Id;
                $memo->save();
            }
        });
        /**End Transaction */

        return redirect('admin.memos.index')->with(['success' => 'تم ادراج التعميم بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $memo = Memo::with('memoType')->with('org')->findOrFail($id);
        // dd($memo->attachment);
        $memo_offices_ids = MemoOffice::where('MemoId', $id)->get();
        $offices = Office::whereIn('Id', $memo_offices_ids->pluck('OfficeId'))->get();
        return view('admin.memos.show')
            ->with('memo', $memo)
            ->with('offices', $offices);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $memo = Memo::findOrFail($id);
        $memo_types = MemoType::all();
        $orgs = SupervisingOrg::all();
        $offices = Office::all();
        $memo_offices_ids = MemoOffice::where('MemoId', $id)->pluck('OfficeId')->toArray();
        return view('admin.memos.edit')
            ->with('memo', $memo)
            ->with('memo_types', $memo_types)
            ->with('orgs', $orgs)
            ->with('offices', $offices)
            ->with('memo_offices_ids', $memo_offices_ids);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMemo  $request
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemo $request, int $id)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();

        /**Start Transaction */
        DB::transaction(function () use ($validated, $request, $id) {
            $memo = Memo::findOrFail($id);
            $memo->update($validated);


            if (!empty($request->offices)) {
                MemoOffice::where('MemoId', $memo->Id)->delete();
                foreach ($request->offices as $office_id) {
                    (new MemoOffice)->create(['MemoId' => $memo->Id, 'OfficeId' => $office_id]);
                }
            }

            if (Input::file('PhotoId')) {
                File::where('File', $memo->PhotoId)->delete();
                $file = Input::file('PhotoId');
                $path = $file->getRealPath();
                $photo = file_get_contents($path);
                $base64 = base64_encode($photo);
                $file = (new File)->create(['File' => $base64]);
                $memo->PhotoId = $file->Id;
                $memo->save();
            }
        });
        /**End Transaction */

        toastr()->success(__('toastr.updated_successfully'));
        return redirect()->route('memos.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // $memo = Memo::findOFail($id);
        // $memo->delete();

        // toastr()->success(__('toastr.deleted_successfully'));
        // return redirect()->route('memos.index', app()->getLocale());
    }
}
