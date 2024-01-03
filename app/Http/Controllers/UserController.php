<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\EditUser;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{



    public function users(){

        $users = User::where('role', '!=', '0')->paginate(20);

        return view("Admin.employees" ,compact('users'));

    }
    
    


   public function userInfo($id){

        $user = User::find($id);
        
        $activities = Activity::where('user_id', $id)
       ->orderBy('created_at', 'desc')
       ->get();
        
        $prevoius_data = EditUser::where('user_id', $id)->orderBy('id', 'desc')->get();
        
        return view("auth.profile" ,compact('user' , 'activities' , 'prevoius_data' ));
        
        // return view("Admin.single_user" ,compact('user' , 'activities'));
    }
    
    

    public function UserDelete($id){
        try {

            User::destroy($id); // Find the report by its ID
            
              $this->ActivityFunction(auth::user()->id, "User delete the Employee record $id");
              
            return response()->json(['message' => 'Report deleted successfully']);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
            return response()->json(['error' => 'Failed to delete report'], 500);
        }
    }



    public function ChangeUserStatus($id){
        try {
 
            $user = User::findOrFail($id);
            $user->status = ($user->status === 'Activate') ? 'Deactivate' : 'Activate';
            $user->save();


  $this->ActivityFunction(auth::user()->id, "User Change the Employee Status ");
  
            return response()->json(['message' => 'Report deleted successfully']);
        } catch (\Exception $e) {
            // Handle exceptions, e.g., report or log the error
            return response()->json(['error' => 'Failed to delete report'], 500);
        }
    }

    public function UserEdit($id){
     $user = User::findOrFail($id);
     return view("auth.add_edit_user" ,compact('user'));
    }
    
    public function UserCreate(){

        return view("auth.add_edit_user");

    }
    


 public function UserProfile(){
$id = auth::user()->id;
$user = User::find($id);
return view("auth.profile" ,compact('user'));

}



        

// public function UpdateProfile(Request $request , $id){

// $nameParts = explode(' ', $request->name);

// $firstName = isset($nameParts[0]) ? $nameParts[0] : '';
// $lastName = end($nameParts);

// $user = User::find($id);

//         $user->first_name=$firstName;
//         $user->last_name=$lastName;
//         $user->username=$request->username;
//         $user->email= $request->email;
//         $user->update();
        
//          $this->ActivityFunction(auth::user()->id, "User Update the Profile Information");
         
//         return redirect('/user-profile');

//     }

    
    public function user_password_update(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
        ]);
    
        $user = Auth::user();

       $new_set_password = $request->input('password');
      $new_confirm_password = $request->input('password_confirmation');

if ($new_set_password == $new_confirm_password ) {
  

  if (!Hash::check($request->input('old_password'), $user->password)) {
    return redirect()->back();
}

// Update the user's password
$user->password = Hash::make($request->input('password'));
$user->save();

  $this->ActivityFunction(auth::user()->id, "User Update the Password");
  
return redirect('/dashboard')->with('success', 'Password updated successfully.');

}else{

  
return redirect('/user-profile');

}
    }


 



    public function user_information(Request $request)
    {
        $nameParts = explode(' ', $request->name);
        $firstName = isset($nameParts[0]) ? $nameParts[0] : '';
        $lastName =isset($nameParts[1]) ? $nameParts[1] : '';
    
        if (isset($request->id)) {
            
             $this->ActivityFunction(auth::user()->id, "User Update the Employee record $request->id");
              
            $user = User::find($request->id);
            
            //save the edited record
            $previous_user=json_encode($user ,true);
            $previous_user_info= new EditUser();
            $previous_user_info->creator_id= auth::user()->id;
              $previous_user_info->user_id= $request->id;
            $previous_user_info->detail= $previous_user;
            $previous_user_info->save();
            
        } else {
            $user = new User();
            
             $this->ActivityFunction(auth::user()->id, "User Create the Employee record $request->name");
        }
    
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->username = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
    
        $user->save();
        return redirect('/users');
    }
    
    
    
    
    

    
       public function update_user_profile(Request $request)
    {
        
             $nameParts = explode(' ', $request->name);
        $firstName = isset($nameParts[0]) ? $nameParts[0] : '';
        $lastName =isset($nameParts[1]) ? $nameParts[1] : '';
        
        $id = $request->id;
        
        
        // dd($id, $lastName, $firstName, $nameParts, $request->all() );
        
          $this->ActivityFunction(auth::user()->id, "User Update the pofile Information of User with $id ");
        
          $user = User::find($id);
            
            //save the edited record
            $previous_user=json_encode($user ,true);
            $previous_user_info= new EditUser();
                $previous_user_info->creator_id= auth::user()->id;
              $previous_user_info->user_id=$id;
            $previous_user_info->detail= $previous_user;
            $previous_user_info->save();
        
        
        //Update theRecord
       $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->username = $request->name;
          $user->country = $request->country;
             $user->address = $request->address;
                $user->number = $request->number;
                   $user->twitter = $request->twitter; 
                   $user->facebook = $request->facebook;
                      $user->instagram = $request->instagram;
                         $user->linkedin = $request->linkedin; 
          $user->update();
        
        
         return redirect()->back();
        
    }
    
    
    
    
    

 public function LOGIN(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $this->ActivityFunction(auth::user()->id, "User Login into the account");
        return redirect()->route('dashboard'); // Laravel will handle the redirect if login is successful
    }

    return back();
}






    public function logout()
    {
           $this->ActivityFunction(auth::user()->id, "User Logout From account");
        Auth::logout();
        return redirect('/'); // You can redirect to any page after logout
    }


 public function ActivityFunction($id , $activityText)
    {
        // dd($activity);
         $activity  = new Activity();
        
          $activity->user_id= $id;
          $activity->activity= $activityText;
         $activity->save();
        
        }
    
}
