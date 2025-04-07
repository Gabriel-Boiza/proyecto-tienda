<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * Show the general dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the editor dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function editorDashboard()
    {
        return view('editor.dashboard');
    }
}
