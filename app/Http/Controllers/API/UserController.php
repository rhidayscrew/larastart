<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     $this->middleware('auth:api'); // ini juga baru di tambhkan bareng dengan  : Consuming Your API With JavaScript
    // $this->middleware('api');  klo pake ini bisa di akses api nya "laraveltodoapparastart.test/api/user"
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);  // page klo udah 10 data
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  /// insert coyy :store
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:5'
        ]);

       // return $request ->all();
       return User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'type' => $request['type'],
        'bio' => $request['bio'],
        'photo' => $request['photo'],
        'password' => Hash::make ($request['password']),
       ///'password' => $request['password'],
       ]);


    }

  public function updateProfile(Request $request)  // tambahakan ini 4.4
    {
        $user =  auth('api')->user();

        return $request->photo;
       // return ['message' => "succeess"];

    }



    public function profile()
    {
        return auth('api')->user();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'Sometimes|min:5'

        ]);



        $user->update($request->all());

        return ['message' => 'udaptedet user infoe'];


       // $user->update($request->all());
       // return ['password' => Hash::make ($request['password']),
        //];  GAgal
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        //delete user
        $user->delete();

        return ['message' => 'user deleted'];




    }
}
