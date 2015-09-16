@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">FeedFlow</div>

				<div class="panel-body">
                                <p> Lastest 100 Messages:</p>
                               <?php
                                 showUserPosts(-1,0,50);
                               ?> 

                                </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
