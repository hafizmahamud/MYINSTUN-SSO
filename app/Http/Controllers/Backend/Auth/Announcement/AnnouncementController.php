<?php

namespace App\Http\Controllers\Backend\Auth\Announcement;

use App\Models\Announcements;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class AnnouncementController
 */
class AnnouncementController extends Controller
{
    public function index()
    {
        $announcement_all = Announcements::get();
        
        return view('backend.auth.announcements.index', compact('announcement_all'));
    }

    public function storePage()
    {
        return view('backend.auth.announcements.create');
    }

    public function store(Request $request)
    {
        $announcements = new Announcements;
        
        $announcements->title = $request->input('title');
        $announcements->content = $request->input('content');

        $announcements->save();
        return redirect()->route('admin.auth.announcements.index')->withFlashSuccess(__('alerts.backend.announcements.created'));
    }

    public function updatePage($id)
    {
        $announcement = Announcements::find($id);
        return view('backend.auth.announcements.update',compact('announcement'));
    }
    public function update(Request $request)
    {
        $id = $request['id'];
        $announcement = Announcements::find($id);
        $announcement->update($request->all());
        return redirect()->route('admin.auth.announcements.index')->withFlashSuccess(__('alerts.backend.announcements.updated'));
    }

    public function destroy($id)
    {
        $delAnnouncement = Announcements::find($id);
        $delAnnouncement->delete();
        return redirect()->route('admin.auth.announcements.index')->withFlashSuccess(__('alerts.backend.announcements.deleted'));
    }

    public function landingPage($id)
    {
        $announcement = Announcements::find($id)->get();
        return view('frontend.user.index');
    }
}
