<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'address' => 'required|string',
                'nation' => 'required',
                'city' => 'required',
                'zip_code' => 'required|integer',
            ]);
            //code...
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'data' =>  isset($e->validator) ? [
                    'validator' => $e->validator->errors(),
                ] : $e->getMessage(),
            ], 400);
        }


        try {

            $user = Auth::user();
            $address = new Address();
            $address->user_id = $user->id;
            $address->address = $request->address;
            $address->nation = $request->nation;
            $address->city = $request->city;
            $address->zip_code = $request->zip_code;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Create Address Success',
                'data' => ''
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Create Address Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'address' => 'required|string',
                'nation' => 'required',
                'city' => 'required',
                'zip_code' => 'required|integer',
            ]);
            //code...
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'data' =>  isset($e->validator) ? [
                    'validator' => $e->validator->errors(),
                ] : $e->getMessage(),
            ], 400);
        }


        try {

            $address = Address::find($id);
            $address->address = $request->address;
            $address->nation = $request->nation;
            $address->city = $request->city;
            $address->zip_code = $request->zip_code;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Update Address Success',
                'data' => ''
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update Address Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
    public function delete(Request $request, $id)
    {

        try {

            $address = Address::find($id);
            $address->delete();

            return response()->json([
                'success' => true,
                'message' => 'Delete Address Success',
                'data' => ''
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete Address Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
    public function list(Request $request)
    {
        try {

            $user = Auth::user();
            $address = Address::where('user_id', $user->id)->get();
            return response()->json([
                'success' => true,
                'message' => 'List Address Success',
                'data' => [
                    'address' => $address
                ]
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'List Address Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }

    public function detail(Request $request, $id)
    {
        try {
            $address = Address::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'List Address Success',
                'data' => [
                    'address' => $address
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'List Address Failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }
}
