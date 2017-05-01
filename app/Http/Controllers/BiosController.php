<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Bio;
use Illuminate\Http\Request;
use Session;

class BiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $bios = Bio::where('ig_username', 'LIKE', "%$keyword%")
				->orWhere('bio', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $bios = Bio::paginate($perPage);
        }

        return view('bios.index', compact('bios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('bios.create');
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
			'ig_username' => 'required'
		]);
        $requestData = $request->all();
        
        Bio::create($requestData);

        Session::flash('flash_message', 'Bio added!');

        return redirect('a/bios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bio = Bio::findOrFail($id);

        return view('bios.show', compact('bio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bio = Bio::findOrFail($id);

        return view('bios.edit', compact('bio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
			'ig_username' => 'required'
		]);
        $requestData = $request->all();
        
        $bio = Bio::findOrFail($id);
        $bio->update($requestData);

        Session::flash('flash_message', 'Bio updated!');

        return redirect('a/bios');
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
        Bio::destroy($id);

        Session::flash('flash_message', 'Bio deleted!');

        return redirect('a/bios');
    }
}
