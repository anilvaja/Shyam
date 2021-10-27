<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
//use App\Http\Controllers\Session;

class BookingController extends Controller
{
   
    public function index()
    {
       return view('booking');
    }
    public function bookinglist()
    {
        $sid = session()->get('ADMIN_ID');
        $bookl['blist'] = Booking::where('User_Id','=', $sid)->get();
       return view('bookinglist',$bookl);
    }
    public function confirmSelection(request $r)
    {
    echo "shyam";

    }   

}
