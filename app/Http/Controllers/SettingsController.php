<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Setting;
use Illuminate\Http\Request;
use Session, DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $settings = DB::table('settings')->first();

        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'field' => 'required',
			'value' => 'required'
		]);
        $requestData = $request->all();
        
        Setting::create($requestData);

        Session::flash('flash_message', 'Setting added!');

        return redirect('a/settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $setting = DB::table('settings')->first();

        return view('settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // $setting = Setting::findOrFail($id);
        $setting = DB::table('settings')->first();
        // return $setting;
        return view('settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->validate($request, [
			'ig_username' => 'required',
			'ig_password' => 'required'
		]);
        $requestData = $request->all();
        // dd($requestData);
        $un = request('ig_username');
        $pw = request('ig_password');

        $setting = DB::update("update settings set ig_username='$un', ig_password='$pw'");
        // $setting->update($requestData);

        Session::flash('flash_message', 'Setting updated!');

        return redirect('a/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Setting::destroy($id);

        Session::flash('flash_message', 'Setting deleted!');

        return redirect('a/settings');
    }
}
