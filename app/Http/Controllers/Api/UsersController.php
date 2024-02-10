<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=User::all();
        $userList=[];
        foreach($list as $li)
        {
            $userList[]=array(
                'id'=>Crypt::encryptString($li->id),
                'name'=>$li->name,
                'course'=>$li->course,
                'email'=>$li->email,
                'phone'=>$li->phone,
                'created_at'=>date('d-M-Y h:i a',strtotime($li->created_at))
            );
        }
        return $userList;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // Validate incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'course' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ]);

    // Create a new user record with the validated data
    $user = User::create($validatedData);

    // Return the newly created user along with a status code of 201 (Created)
    return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $userDetails=array(
            'name'=>$user->name,
            'course'=>$user->course,
            'email'=>$user->email,
            'phone'=>$user->phone
        );
        return response()->json($userDetails);
        // return $userDetails;

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
         $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email' ,
        'course' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ]);

    $id = Crypt::decryptString($id);
    $user = User::find($id);
    $user->fill($validatedData);
    $user->save();
    return response()->json(['message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decryptString($id);
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);

    }
}
