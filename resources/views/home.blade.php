@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">OwnZone</div>

				<div class="panel-body">
				<form method="POST" action="post">
                                {{ Auth::user()->name }}, what do you wanna tell the world?<br>
                                <table>
                                <tr><td><textarea cols="80" rows="4" name="status"></textarea></td></tr>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <tr><td align="right"><input type="submit" name="postmsg" value="Submit" style="border-radius:15px;"></td></tr>
                                </table>
                                </form>
                                <div id="homeinfobox">
                                {{ Redis::zcard("followers:".(Auth::user()->id)) }} followers<br>
                                {{ Redis::zcard("following:".(Auth::user()->id)) }} following<br>
                                </div>
                                <?php
                                $start = Request::input('start');
                                $start = $start == false ? 0 : intval($start);
                                showUserPostsWithPagination(false,Auth::user()->id,$start,10);
                                ?> 
                                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
