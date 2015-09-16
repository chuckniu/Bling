@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">OneFlow</div>

				<div class="panel-body">
                                <h2>{{ Request::input('u') }}</h2>
                               <?php
                                $id=DB::table('users')->where('name', Request::input('u'))->pluck('id');
                                if (Auth::user()->id != $id) {
                                   $isfollowing = Redis::zscore("following:".(Auth::user()->id),$id);
                                   if (!$isfollowing) {
                                      echo("<a href=\"follow?uid=$id&f=1\" class=\"button\">Follow this user</a>");
                                      } else {
                                      echo("<a href=\"follow?uid=$id&f=0\" class=\"button\">Stop following</a>");
                                      }
                                    }                        
                                $start = Request::input('start');
                                $start = $start == false ? 0 : intval($start);
                                showUserPostsWithPagination(Request::input('u'),$id,$start,10);
                                ?> 

                                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
