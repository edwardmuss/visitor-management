<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Visitor;
use App\Models\Department;

use DataTables;
use DB;

use Illuminate\Support\Facades\Auth;
use App\DataTables\ExportDataTable;
use App\Exports\VisitorsExport;
use Maatwebsite\Excel\Facades\Excel;

class VisitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ExportDataTable $dataTable)
    {
     return $dataTable->render('visitor');
    }

    public function export() 
    {
    return Excel::download(new VisitorsExport, 'vistors-'.date('Y-m-d H:i:s').'.xlsx');
    }


    function fetch_all(Request $request)
    {
        if($request->ajax())
        {
            $query = Visitor::join('users', 'users.id', '=', 'visitors.visitor_enter_by');

            if(Auth::user()->type == 'User')
            {
                $query->where('visitors.visitor_enter_by', '=', Auth::user()->id);
            }

            if($request->filter =='today')
            {
                $query->whereDate('visitor_enter_time', '=', now()->today());
            }
            elseif($request->filter =='yesterday')
            {
                $query->whereDate('visitor_enter_time', '=', now()->subDays(1));
            }
            elseif($request->filter =='week')
            {
                $query->whereDate('visitor_enter_time', '>', now()->subWeek());
            }
            elseif($request->filter =='month')
            {
                $query->whereDate('visitor_enter_time', '>=', now()->subMonth());
            }
            elseif($request->filter =='year')
            {
                $query->whereDate('visitor_enter_time', '>=', now()->subYear());
            }

            if(!empty($request->from_date))
            {
                $query->whereBetween('visitor_enter_time', array($request->from_date.' 00:00:00', $request->to_date.' 23:59:59'));
            }

            $query->orderBy('visitors.visitor_enter_time','DESC');

            $data = $query->select(['visitors.visitor_id', 'visitors.visitor_name', 'visitors.visitor_meet_person_name', 'visitors.visitor_department', 'visitors.visitor_enter_time', 'visitors.visitor_out_time', 'visitors.visitor_status', 'users.name as name', 'visitors.id']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('visitor_enter_time', function($row){
                    return date('D d M, Y H:i', strtotime($row->visitor_enter_time));
                })
                ->editColumn('visitor_out_time', function($row){
                    if($row->visitor_out_time != '')
                    {
                        return date('D d M, Y H:i', strtotime($row->visitor_out_time));
                    }
                })
                ->editColumn('visitor_status', function($row){
                    if($row->visitor_status == 'In')
                    {
                        return '<span class="badge bg-success">In</span>';
                    }
                    else
                    {
                        return '<span class="badge bg-danger">Out</span>';
                    }
                })
                ->escapeColumns('visitor_status')
                ->addColumn('action', function($row){
                    if($row->visitor_status == 'In')
                    {
                        return '<a href="'.route('visitor.view', $row->id ).'" class="btn btn-info btn-sm">View</a>&nbsp;<a href="'.route('visitor.edit', $row->id ).'" class="btn btn-primary btn-sm">Edit</a>&nbsp;<button type="button" class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">Delete</button>
                        ';
                    }
                    else
                    {
                        return '<a href="'.route('visitor.view', $row->id ).'" class="btn btn-info btn-sm">View</a>&nbsp;<button type="button" class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">Delete</button>';
                    }
                })
                // ->filter(function ($instance) use ($request) {

                //     if ($request->get('filter') == 'today') {

                //         $instance->where('visitor_enter_time', '=', now()->today());

                //     }

                // })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    function add()
    {
        $departments = Department::all();
        return view('add_visitor', compact('departments'));
    }
    public function getContactPerson(Request $request)
    {
        $contact_person = Department::where('department_name','=',$request->department_name)->first();
        return response()->json(explode(", ", $contact_person->contact_person));

    }

    function add_validation(Request $request)
    {
        $request->validate([
            'visitor_name'       =>  'required',
            'visitor_id'      =>  'required',
            'visitor_email'      =>  'required|email',
            'visitor_mobile_no'      =>  'required',
            'visitor_department'      =>  'required',
        ]);
       
        $data = $request->all();
        // dd($data['visitor_id']);

        Visitor::create([
            'visitor_name'       =>  $data['visitor_name'],
            'visitor_id'       =>  $data['visitor_id'],
            'visitor_email'      =>  $data['visitor_email'],
            'visitor_mobile_no'  =>  $data['visitor_mobile_no'],
            'visitor_address'    =>  $data['visitor_address'],
            'visitor_department' =>  $data['visitor_department'],
            'visitor_meet_person_name' =>  $data['visitor_meet_person_name'],
            'visitor_reason_to_meet' =>  $data['visitor_reason_to_meet'],
            'visitor_enter_time' =>  date('Y-m-d H:i:s'),
            'visitor_enter_by' =>  Auth::user()->id,
        ]);

        return redirect(route('visitor'))->with('success', 'New Visitor Added');
    }

    public function edit($id)
    {
        $data = Visitor::findOrFail($id);
        $departments = Department::all();

        return view('edit_visitor', compact('data', 'departments'));
    }

    function edit_validation(Request $request)
    {
        $request->validate([
            'visitor_name'       =>  'required',
            'visitor_id'      =>  'required',
            'visitor_email'      =>  'required|email',
            'visitor_mobile_no'      =>  'required',
            'visitor_department'      =>  'required',
        ]);

        $data = $request->all();

        $form_data = array(
            'visitor_name'       =>  $data['visitor_name'],
            'visitor_id'       =>  $data['visitor_id'],
            'visitor_email'      =>  $data['visitor_email'],
            'visitor_mobile_no'  =>  $data['visitor_mobile_no'],
            'visitor_address'    =>  $data['visitor_address'],
            'visitor_department' =>  $data['visitor_department'],
            'visitor_meet_person_name' =>  $data['visitor_meet_person_name'],
            'visitor_reason_to_meet' =>  $data['visitor_reason_to_meet'],
        );

        Visitor::whereId($data['hidden_id'])->update($form_data);

        return redirect(route('visitor'))->with('success', 'Visitor Data Updated');
    }

    public function view($id)
    {
        $data = Visitor::findOrFail($id);
        $departments = Department::all();

        return view('view_visitor', compact('data', 'departments'));
    }

    function view_validation(Request $request)
    {
    
        $request->validate([
            'visitor_outing_remark'    =>  'required',
        ]);

        $data = $request->all();

        $form_data = array(
            'visitor_out_time'       =>  date('Y-m-d H:i:s'),
            'visitor_outing_remark'       =>  $data['visitor_outing_remark'],
            'visitor_status'       =>  'Out',
        );

        Visitor::whereId($data['hidden_id'])->update($form_data);

        return redirect(route('visitor'))->with('success', 'Visitor Out Remarks Updated');
    }

    function delete($id)
    {
        $data = Visitor::findOrFail($id);

        $data->delete();

        return redirect('visitor')->with('success', 'Visitor Data Removed');
    }
}
