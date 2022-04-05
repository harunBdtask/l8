<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Purchase\Entities\Requisition;
use Modules\Purchase\Entities\RequisitionDetails;
use \Yajra\Datatables\Datatables;

class RequisitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $data = [
            'count_Requisition' => Requisition::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'purchase::view_requisition',
            'title'      => 'Requisition List'
        ];
        //datatable
        if ($request->ajax()) {
            $q_user = Requisition::select('*')->orderByDesc('id');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editUser"><i class=" fi-rr-edit"></i></div>';
                        $btn .= ' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Details" class="btn btn-sm btn-icon btn-outline-info btn-circle mr-2 actionPreview"><i class="fi-rr-eye"></i></div>';
                        $btn .= ' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteUser"><i class="fi-rr-trash"></i></div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('layouts.v_template',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $result = Requisition::updateOrCreate(['id' => $request->id],
                [
                //  'voucher_no' => $request->voucher_no,
                 'voucher_no' => 2,
                 'created_at' => date('Y-m-d H:i:s'),
                 'updated_at' => date('Y-m-d H:i:s'),
                ]);
        $details = array(
            'parent_id' => $result->id,
            'item_id' => 1,
            'qty' => 2,
        );
        RequisitionDetails::create($details);
        return response()->json(['success'=>'Saved successfully! '.$result->id]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Requisition::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Requisition::find($id)->delete();

        return response()->json(['success'=>'Successfully deleted!']);
    }
}
