<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File; // use for delete file or image
use Illuminate\Support\Facades\Hash; //for hash password in secure
use Illuminate\Http\Request;
use App\Models\user;

class loginController extends Controller
{
    //to show register form
    function registForm(){
        return view('register');
    }
    //to save data to DB
    function saveUser(Request $req){
        $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users', // unique:table name (this is to check dubplicate email)
            'pass' => 'required|min:6|same:re_pass',
            're_pass' => 'required|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'name.required' => 'សូមបំពេញឈ្មោះ',
            'email.required' => 'សូមបំពេញអីមែល',
            'email.unique' => 'អីមែលនេះត្រូវបានចុះឈ្មោះរួចហើយ',
            'pass.required' => 'សូមបំពេញលេខសម្ងាត់',
            'pass.min' => 'លេខសម្ងាត់ត្រូវតែ៦តួ',
            're_pass.min' => 'លេខសម្ងាត់ត្រូវតែ៦តួ',
            're_pass.required' => 'សូមបំពេញលេខសម្ងាត់',
            'pass.same' => 'លេខសម្ងាត់ផ្ទៀងផ្ទាត់មិនត្រូវគ្នា',
            'image.required' => 'សូមជ្រើសរើសរូបភាព',
            'image.image' => 'សូមជ្រើសរើសរូបភាពជាប្រភេទ:jpeg,png,jpg,gif ឬ​ svg',
            'image.max' => 'សូមជ្រើសរើសរូបភាពមានទំហំធំបំផុត 2048 គីឡូបាយត៏​'
        ]);
        // for file secure
        if($req->hasFile('image')){
            $image = $req->file('image');
            $desitate_path = 'public/images';
            $imageName = time().'.'.$req->image->getClientOriginalName(); // to get image name and convert to number;            $img_resize->move($desitate_path,$imageName); //to store image
            $image->move($desitate_path,$imageName);
        }else{
            $imageName = 'default_img/default_user.png';  //if we dont use img validate the input file can be blank so the default image is user.png
        }

        $data = new user;
        $data->name = $req->name;
        $data->email = $req->email;   //if u want to check duplicate email when create acc $check = user::where('email', $req->email)->get(); if(count($check)>0){make session to tell duplicate email..}
        $data->password = Hash::make($req->pass); //to hash password
        $data->image = $imageName; // $data->image will be store file name in database as string
        $create = $data->save();
        // to check if data has been saved!
        if($create){
            return redirect()->back()->with('success','User has been added!');
        } else{
            return redirect()->back()->with('fail','there is something wrong!');
        }
        
    }
    
    //to show users
    function users(){
        $data = user::orderBy('id','asc')->paginate(6); //use::all() if dun use paginate  //or use qureyBuilder $data = DB::table('')->get();
        return view('users',['data'=>$data]);
    }
    //to update user
    function userUpdate($id){
        $data = user::find($id);
        return view('update',['data'=>$data]);
    }
    //to save update to database
    function saveUpdate(Request $req){
        $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$req->id, // unique:table name (this is to check dubplicate email)
            'pass' => 'required|min:6|same:re_pass',
            're_pass' => 'required|min:6',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'name.required' => 'សូមបំពេញឈ្មោះ',
            'email.required' => 'សូមបំពេញអីមែល',
            'email.unique' => 'អីមែលនេះត្រូវបានចុះឈ្មោះរួចហើយ',
            'pass.required' => 'សូមបំពេញលេខសម្ងាត់',
            'pass.min' => 'លេខសម្ងាត់ត្រូវតែ៦តួ',
            'pass.same' => 'លេខសម្ងាត់ផ្ទៀងផ្ទាត់មិនត្រូវគ្នា',
            're_pass.min' => 'លេខសម្ងាត់ត្រូវតែ៦តួ',
            're_pass.required' => 'សូមបំពេញលេខសម្ងាត់',
            'image.required' => 'សូមជ្រើសរើសរូបភាព',
            'image.image' => 'សូមជ្រើសរើសរូបភាពជាប្រភេទ:jpeg,png,jpg,gif ឬ​ svg',
            'image.max' => 'សូមជ្រើសរើសរូបភាពមានទំហំធំបំផុត 2048 គីឡូបាយត៏​'
        ]);
        // for file secure
        $data = user::find($req->id);
        if($req->hasFile('image')){
            // to delete old image before update
            $image_path = public_path("\public\images\\").$data->image;
            if(File::exists($image_path)){
                File::delete($image_path);
                //one way: unlink($image_path);
            }
            $image = $req->file('image');
            $desitate_path = 'public/images';
            $NewimageName = time().'.'.$req->image->getClientOriginalName(); // to get image name and convert to number;
            $image->move($desitate_path,$NewimageName); //to store image
        }else{
            $NewimageName = $data->image;  //if we dont use img validate the input file can be blank so the default image is old image
        }

        $data->name = $req->name;
        $data->email = $req->email;   //if u want to check duplicate email when create acc $check = user::where('email', $req->email)->get(); if(count($check)>0){make session to tell duplicate email..}
        $data->password = Hash::make($req->pass); //to hash password
        $data->image = $NewimageName; // $data->image will be store file name in database as string
        $create = $data->save();
        // to check if data has been saved!
        if($create){
            return redirect()->back()->with('update-success','Successfully!');
        } else{
            return redirect()->back()->with('update-fail','there is something wrong!');
        }

    }

    //to delete user
    function userDelete($id){
        $data = user::find($id);
        $image_path = public_path("\public\images\\").$data->image;
        // check and delete file in directory
        if(File::exists($image_path)){
            File::delete($image_path);
            //u can use this
            // unlink($image_path);
        }
        // delete data from database
        $delete = $data->delete();
        if($delete){
            return redirect()->back()->with('delete-success','A Record has been deleted!');
        }else{
            return redirect()->back()->with('delete-fail','There is something wrong!');
        }
    }
    //delete selected
    function useDeleteAll(Request $req){
        $user = user::whereIn('id',$req->ids); //we have to use whereIn(...)
        $user->delete();
        return response()->json('Delete selected Success');
    }
    // to show login form
    function logIn(){
        return view('login');
    }
    //to login by user
    function uerLogin(Request $req){
        
        $req->validate([
            'email' => 'required|exists:users,email', //check if there is no this input email in users table
            'pass' => 'required'
        ],[
            'email.required' => 'សូមបំពេញអីមែល',
            'email.exists'=> '​Email មិនត្រឺមត្រូវ',
            'pass.required' => 'សូមបំពេញលេខសម្ងាត់'
        ]);
        $email = $req->email;
        $pass = $req->pass;
        $user = user::where('email',$email)->first();
        $passHash = Hash::check($pass,$user->password); // to check pass input and pass in database match or not with hash password
        
        if($user && $passHash){
            // to store value in session
            $req->session()->put('user_id',$user->id);
            $req->session()->put('user_name',$user->name);
            // to get value form session
            $id = $req->session()->get('user_id');
            $username = $req->session()->get('user_name');
            if($id =="" || $username ==""){
                return redirect()->route('login')->with('nullIDorName','You can not Login at this moment please check yuor acc!');
            }else{
                return view('loginSuccess',['user'=>$user]);
            }
        }else{
            //if there is no this user
            return redirect()->route('login')->with('fail_login','​Email ឬ Password មិនត្រឺមត្រូវ!');
        }



        // $email = $req->email;
        // $pass = $req->pass;
        // //to check wheather or not has this user email and password
        // $check = user::where('email',$email)->where('password',$pass)->get(); //this is an array data
        // if(count($check)>0){
        //     // to store value in session
        //     $req->session()->put('user_id',$check[0]->id);
        //     $req->session()->put('user_name',$check[0]->name);
        //     // to get value form session
        //     $id = $req->session()->get('user_id');
        //     $username = $req->session()->get('user_name');
        //     //to prevent null id or name
        //     if($id =="" || $username ==""){
        //         return redirect()->route('login')->with('nullIDorName','You can not Login at this moment please check yuor acc!');
        //     }else{
        //         return view('loginSuccess',['user'=>$username]);
        //     }
            
        // }else{
        //     //if there is no this user
        //     return redirect()->route('login')->with('fail-login','Incorrect Email or Password!');
        // }
    }
    // for logout
    function uerLogout(Request $req){
        $req->session()->forget('user_id');
        $req->session()->forget('user_name');
        return redirect()->route('login');       
    }
}
