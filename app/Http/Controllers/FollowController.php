<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redis;
class FollowController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
               $redis = Redis::connection();
               $name=DB::table('users')->where('id', $request->input('uid'))->pluck('name');
               $follow=intval($request->input('f'));
               $uid=intval($request->input('uid'));
               if(!$request->input('uid')||$request->input('f')===false||!$name){
                  return redirect('/');
               } 
               if($uid!=Auth::user()->id){
                 if ($follow) {
                     $redis->zadd("followers:".$uid,time(),Auth::user()->id);
                     $redis->zadd("following:".Auth::user()->id,time(),$uid);
                 } else {
                     $redis->zrem("followers:".$uid,Auth::user()->id);
                     $redis->zrem("following:".Auth::user()->id,$uid);
                 }
               }
               return redirect("/profile?u=".urlencode($name));
        }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
