<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Redis;
use Auth;
class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	public function store(Request $request)
	{
               if(!$request->input('status')){ return redirect('/');}
               $redis = Redis::connection();
               $postid = $redis->incr("next_post_id");
               $status = str_replace("\n"," ",$request->input('status'));
               $redis->hmset("post:$postid","user_id",Auth::user()->id,"time",time(),"body",$status);
               $followers = $redis->zrange("followers:".(Auth::user()->id),0,-1);
               $followers[] = Auth::user()->id;

               foreach($followers as $fid) {
                  $redis->lpush("posts:$fid",$postid);
               }

               $redis->lpush("timeline",$postid);
               $redis->ltrim("timeline",0,1000);
               return redirect('home');
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
