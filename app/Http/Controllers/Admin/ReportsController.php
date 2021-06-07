<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportVote;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::all();

        return view('admin.reports.index', compact('reports'));
    }

    public function datatable(Request $request)
    {
        $status = strval($request->status);
        $order = $request->order;
        $name = $request->name;

        $reports = Report::withCount('votes');
        if($status != null)
        {
            $reports->where('status', $status);
        }

        if($name != null)
        {
            $reports->where('name', 'like', '%'.$name.'%');
        }
        
        if($order != null)
        {
            $reports->orderBy('votes_count', $order);
        }

        return view('admin.reports.table', ['reports' => $reports->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::with('votes', 'votes.user', 'images', 'province', 'regency', 'district', 'village')->find($id);

        return view('admin.reports.detail', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = Report::find($id);
        $edit->status = $request->status;
        $edit->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Report::destroy($id);
        ReportVote::where('report_id', $id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
