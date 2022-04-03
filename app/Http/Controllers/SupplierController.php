<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $data = [
            'count_Supplier' => Supplier::latest()->count(),
            'menu'       => 'menu.v_menu_admin',
            'content'    => 'supplier.view_item_supplier',
            'title'    => 'Supplier List'
        ];
        //datatable
        if ($request->ajax()) {
            $q_user = Supplier::select('*')->orderByDesc('id');
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
        Supplier::updateOrCreate(['id' => $request->id],
                [
                 'title' => $request->title,
                 'created_at' => date('Y-m-d H:i:s'),
                 'updated_at' => date('Y-m-d H:i:s'),
                ]);
        return response()->json(['success'=>'Saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Supplier::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();

        return response()->json(['success'=>'Successfully deleted!']);
    }
}
