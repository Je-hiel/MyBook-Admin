<?php 

	// Gets all the group posts a specific user can see -- ie. group posts from all other members in the group
	include('conn.php');

	$user_id = $_GET['user_id'];
	$group_id = $_GET['group_id'];

	$query = "SELECT post.post_id, user.first_name, user.last_name, user.username, post.title, post.content, post.created_at FROM post JOIN group_post JOIN group_member JOIN user ON post.post_id = group_post.post_id AND group_post.group_id = group_member.group_id AND group_member.user_id = user.user_id WHERE user.user_id = :user_id AND group_post.group_id = :group_id ORDER BY 7 DESC LIMIT 300";

	$stmt = $db->prepare($query);
	$stmt->execute(['user_id' => $user_id, 'group_id' => $group_id]);
	$posts = $stmt->fetchAll();
	
	echo json_encode($posts, JSON_NUMERIC_CHECK);

?>