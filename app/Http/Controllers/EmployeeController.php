<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class EmployeeController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);
        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::attempt($credentials) == true) {
            return redirect()->route('dashboard')->with('message', 'You have Successfully loggedin');
        }
        return redirect()->back()->with('message', 'Oppes! You have entered invalid credentials');
    }

    public function dashboard()
    {
        return view('auth.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Logout successfully!');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = User::latest()->get();

            return FacadesDataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('employees.index');
    }

    public function store(Request $request)
    {
        User::updateOrCreate(
            [
                'id' => $request->employee_id
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email),
                'dob' => $request->dob,
                'gender' => $request->gender,
            ]
        );

        return response()->json(['success' => 'User saved successfully.']);
    }
   
    public function edit($id)
    {
        $product = User::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }
}
