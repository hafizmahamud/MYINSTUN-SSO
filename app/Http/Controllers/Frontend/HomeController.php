<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {   $announcement_all = Announcements::all();
        return view ('frontend.index',compact('announcement_all'));
    }
    public function error()
    {   $announcement_all = Announcements::all();
        return view ('frontend.error');
    }

    public function getAnnounce(){
        $announcement_all = Announcements::all();
        return response($announcement_all);
    }
}
