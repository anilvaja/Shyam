<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SignupController extends Controller
{
    
    public function index()
    {
        if(session()->has('ADMIN_LOGIN'))
        {
            return redirect('dashboard');
        }
        else
        {
            return view('login');
        }

    
    }
    
    public function signup()
    {
        $process['pname'] =DB::table('process')->get();
        return view('signup',$process);
    }

    
    public function authsign(Request $r, Signup $admin)
    {
        
        $admin1= new Signup;
		$admin1->User_Email_Id=$r->get('email');
        $admin1->Password=Hash::make($r->get('password'));
        $admin1->Process_Id= $r->get('process');
        $admin1->User_Name= $r->get('name');
        $admin1->User_Type="Editor";
        $admin1->User_Status="Active";
        $admin1->save();
        if($admin1)
        {
            $r->session()->flash('error','Sign up sucessfully, Please Login');
            return redirect('admin');        }
        else
        {
            return redirect('signup');  
            $r->session()->flash('error','Error in data');
        }

    }
	public function dashboard()
    {
      return view('admin.dashboard');
    }
   
   
    public function auth(Request $request)
    {
    //Retrive all the post data //return $request->post();
     $email = $request->post('email');
     $password = $request->post('password');
    
	// $result = Admin::where(['email'=>$email, 'password'=>$password])->get();
    $result = Signup::where(['User_Email_Id'=>$email])->first();
	 //if(isset($result['0']->id))
     if($result)
	 {
         if(Hash::check($request->post('password'),$result->Password))
         {
            $request->session()->put('ADMIN_LOGIN',true);
            $request->session()->put('ADMIN_ID',$result->User_Id); 
            $request->session()->put('ADMIN_Name',$result->User_Name); 
            //$request->session()->put('ADMIN_ID',$result->email);
            return redirect('booking');
        }
        else
         {
            $request->session()->flash('error','Please enter correct Password');
            return redirect('admin');
         }
         }
         
		 
	 else
	 {
		 $request->session()->flash('error','Please enter correct Email Id');
		 return redirect('admin');
	 }
	
    }

    

    public function changepassword()
    {
        return view('changepassword');
    }

    public function updatepassword(Request $a, Signup $admin)
    {
        $id = session()->has('ADMIN_ID');
        $oldpassword = $a->post('oldpassword');
        $newpassword = $a->post('newpassword');
       $result = Signup::where(['User_Id '=>$id])->first();
       if(Hash::check($oldpassword,$result->password))
       {
        $b=Signup::find($id);
        $b->Password=Hash::make($newpassword);
        $b->save();
        $a->session()->forget('ADMIN_ID');
        $a->session()->forget('ADMIN_LOGIN');
        $a->session()->flash('error','Password Update Sucessfully, Please Login again');
        return redirect('admin');
       }
       else
       {
        $a->session()->flash('error','Please enter correct old password');
        return redirect('changepassword');

       }
    
    }

    public function forgetpassword()
    {
       return view('forgetpassword');
    }
    public function forgetpassword_submit(Request $r)
    {
       $rs = $r->post('email');
       $result = Signup::where(['User_Email_Id'=>$rs])->get();
      
       if(isset($result[0]))
       {
        
        $r->session()->flash('error','Please check you email inbox');
        return view('forgetpassword');
       }
       else
       {
           $r->session()->flash('error','User Email id not found');
           return view('forgetpassword');
       }
    }

    
}
