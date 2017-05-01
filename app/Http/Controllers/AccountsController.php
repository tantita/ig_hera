<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Account;
use Illuminate\Http\Request;
use Session, DB;
use InstagramAPI\Instagram;
use App\Bio;

class AccountsController extends Controller
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
            $accounts = Account::where('ig_username', 'LIKE', "%$keyword%")
				->orWhere('followers', 'LIKE', "%$keyword%")
				->orWhere('followings', 'LIKE', "%$keyword%")
				
                ->paginate($perPage);
        } else {
            $accounts = Account::paginate($perPage);
        }

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('accounts.create');
    }


    protected function process($ig_usernames){
        ini_set('max_execution_time', 0);

        
        $creds = DB::table('settings')->first();

        $ig = new Instagram();
        $ig->setUser($creds->ig_username, $creds->ig_password);

        if(!$ig->isLoggedIn){
            $ig->login();
        }

        foreach ($ig_usernames as $ig_username) {
            $account = Account::where('ig_username', $ig_username)->first();

            if(!$account){        
                $account = new Account();
                $account->ig_username = $ig_username;
                $account->ig_usernameid = $ig->getUsernameId($ig_username);            
            }

            $bio = $ig->getUsernameInfo($account->ig_usernameid)->user->biography;
            

            // for each account
            //      get username ID
            //      get followers
            //      get followings
            //      then compare both        

            $followers = [];
            $followings = [];
            $followers_next_max_id = null;
            $followings_next_max_id = null;

            do{
                $data = $ig->getUserFollowers($account->ig_usernameid, $followers_next_max_id);  
                $followers_next_max_id = $data->next_max_id;
                // dd($data);          
                foreach ($data->users as $user) {
                    $followers[] = ['ig_username'=>$user->username, 'ig_usernameid'=>strval($user->pk), 'bio'=>''];
                }
                
            }
            while($followers_next_max_id);
            // return $followers;

            do{
                $data = $ig->getUserFollowings($account->ig_usernameid, $followings_next_max_id);
                $followings_next_max_id = $data->next_max_id;
                foreach ($data->users as $user) {
                    $followings[] = ['ig_username'=>$user->username, 'ig_usernameid'=>strval($user->pk), 'bio'=>''];
                }
            }
            while($followings_next_max_id);


            $account->followers = $followers;
            $account->followings = $followings;
            $account->bio = $bio;

            $account->save();

            // $temp = [];
            // foreach ($account->followers as $user) {
            //     $bio = $ig->getUsernameInfo($user['ig_usernameid'])->user->biography;
            //     $temp[] = ['ig_username'=>$user['ig_username'], 'ig_usernameid'=>$user['ig_usernameid'], 'bio'=>$bio];
            // }
            // $account->followers = $temp;
            // $account->save();

            foreach ($account->followers as $follower) {
                $bio_db = Bio::where('ig_username',$follower['ig_username'])->first();
                if($bio_db){                    
                }
                else{
                    Bio::create(['ig_username'=>$follower['ig_username'], 'ig_usernameid'=>$follower['ig_usernameid']]);
                }
            }

            foreach ($account->followings as $following) {
                $bio_db = Bio::where('ig_username',$following['ig_username'])->first();
                if($bio_db){                    
                }
                else{
                    Bio::create(['ig_username'=>$following['ig_username'], 'ig_usernameid'=>$following['ig_usernameid']]);
                }
            }

            foreach ($account->withoutduplicates as $user) {
                $bio_db = Bio::where('ig_username',$user)->first();   
                $bio = $ig->getUsernameInfo($bio_db->ig_usernameid)->user->biography;

                $bio_db->bio = $bio;
                $bio_db->save();
               
            }

            
        }

        


        Session::flash('flash_message', 'Account(s) added!');

        return redirect('a/accounts');
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
        ini_set('max_execution_time', 0);

        $this->validate($request, [
			'ig_usernames' => 'required'
		]);
        $requestData = $request->all();
        
        return $this->process($requestData['ig_usernames']);
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
        $account = Account::findOrFail($id);

        return view('accounts.show', compact('account'));
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
        $account = Account::findOrFail($id);

        return view('accounts.edit', compact('account'));
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
        
        $account = Account::findOrFail($id);
        $account->update($requestData);

        Session::flash('flash_message', 'Account updated!');

        return redirect('a/accounts');
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
        Account::destroy($id);

        Session::flash('flash_message', 'Account deleted!');

        return redirect('a/accounts');
    }


    public function download($id){
        $account = Account::findOrFail($id);
        // $withoutduplicates = implode("\n", $account->withoutduplicates);       

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=$account->ig_username.txt");
        // print $account->bio;
        // print "\n\n\n";
        // print $withoutduplicates;
        foreach ($account->withoutduplicates as $acc) {
            $bio = Bio::where('ig_username',$acc)->first();   
            print $acc . ' - ' . $bio->bio . "\n";
        }
    }

    public function upload(Request $request){
        $f = $request->file('accounts_file');

        $ig_usernames = file($f, FILE_IGNORE_NEW_LINES);

        return $this->process($ig_usernames);        
    }
}
