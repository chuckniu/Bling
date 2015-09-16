<?php
function timeElapsed($time){
    $date=time()-$time;
    if($date < 60) return "$date seconds";
    if ($date < 3600) {
        $minutes = (int)($date/60);
        return "$minutes minute".($minutes > 1 ? "s" : "");
    }
    if ($date < 3600*24) {
        $hours = (int)($date/3600);
        return "$hours hour".($hours > 1 ? "s" : "");
    }
    $date = (int)($date/(3600*24));
    return "$date day".($date > 1 ? "s" : "");
}

function utf8entities($s) {
    return htmlentities($s,ENT_COMPAT,'UTF-8');
}

function showPost($id){
    $redis=Redis::connection();
    $post = $redis->hgetall("post:$id");
    if (empty($post)) return false;
    $userid = $post['user_id'];
    $username = DB::table('users')->where('id', $userid)->pluck('name');
    $elapsed = timeElapsed($post['time']);
    $userlink = "<a class=\"username\" href=\"profile?u=".urlencode($username)."\">".utf8entities($username)."</a>";
    echo('<div class="post">'.$userlink.' '.utf8entities($post['body'])."<br>");
    echo('<i>posted '.$elapsed.' ago </i></div>');
    return true;
}

function showUserPosts($userid,$start,$count) {
    $redis=Redis::connection();
    $key = ($userid == -1) ? "timeline" : "posts:$userid";
    $posts = $redis->lrange($key,$start,$start+$count);
    $counts = 0;
    foreach($posts as $p) {
        if (showPost($p)) $counts++;
        if ($counts == $count) break;
    }
    return count($posts) == $count+1;
}

function showUserPostsWithPagination($username,$userid,$start,$count) {
    $thispage = Request::path();
    $navlink = "";
    $next = $start+10;
    $prev = $start-10;
    $nextlink = $prevlink = false;
    if ($prev < 0) $prev = 0;
    $u = $username ? "&u=".urlencode($username) : "";
    if (showUserPosts($userid,$start,$count))
        $nextlink = "<a href=\"$thispage?start=$next".$u."\">Older posts &raquo;</a>";
    if ($start > 0) {
        $prevlink = "<a href=\"$thispage?start=$prev".$u."\">&laquo; Newer posts</a>".($nextlink ? " | " : "");
    }
    if ($nextlink || $prevlink)
        echo("<div class=\"rightlink\">$prevlink $nextlink</div>");
}


function showLastUsers() {
    $redis=Redis::connection();
    $users = $redis->zrevrange("users_by_time",0,9);
    echo("<div>");
    foreach($users as $u) {
        echo("<a class=\"username\" href=\"profile.php?u=".urlencode($u)."\">".utf8entities($u)."</a> ");
    }
    echo("</div><br>");
}

?>
