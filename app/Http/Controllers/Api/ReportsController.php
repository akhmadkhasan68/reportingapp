<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportImage;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::with('votes', 'votes.user', 'images', 'province', 'regency', 'district', 'village')->get();

        return response()->json([
            'success' => true,
            'data' => $reports
        ], 200);
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
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'province_id' => [
                'required',
            ],
            'regency_id' => [
                'required',
            ],
            'district_id' => [
                'required',
            ],
            'village_id' => [
                'required',
            ],
            'address' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        $insert = Report::create([
            'user_id' => Auth::guard('api')->user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'address' => $request->address
        ]);

        for($i = 0; $i <= 2; $i++){
            ReportImage::create([
                'report_id' => $insert->id,
                'photo' => 'photo.jpg'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success add data'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $reports = Report::with('votes', 'votes.user', 'images', 'province', 'regency', 'district', 'village')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $reports
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 404);
        }
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
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
            ],
            'description' => [
                'required',
            ],
            'province_id' => [
                'required',
            ],
            'regency_id' => [
                'required',
            ],
            'district_id' => [
                'required',
            ],
            'village_id' => [
                'required',
            ],
            'address' => [
                'required',
            ],
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json(['success' => false, 'message' => $errors]);
        }

        try{
            $update = Report::findOrFail($id);
            $update->name = $request->name;
            $update->description = $request->description;
            $update->province_id = $request->province_id;
            $update->regency_id = $request->regency_id;
            $update->district_id = $request->district_id;
            $update->village_id = $request->village_id;
            $update->address = $request->address;
            $update->save();

        }catch(Exception $ex)
        {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Success edit data'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->delete();
            return response()->json([
                'success' => true,
                'message' => 'Success deleted data'
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ], 404);
        }
    }

    public function count_reports($status)
    {
        $reports = [
            'all' => Report::all(),
            'accept' => Report::where('status', '1')->get(),
            'decline' => Report::where('status', '2')->get(),
        ];

        $data = [
            'success' => true,
            'data' => [
                'total_data' => $reports[$status]->count()
            ]
        ];

        return response()->json($data, 200);
    }
}
