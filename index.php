<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//require 'classes/PostLoader.php';
require 'classes/Post.php';
session_start();


try {
    $postData=json_decode(file_get_contents('resources/posts.json'), true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    throw new JsonException('failed to get content');
}
$postLoader=new PostLoader();
if ($postData!=="") {
    $postLoader->setPosts($postData);
}

if(isset($_POST['submit'])){

if (empty($_POST['authorName']) || empty($_POST['title']) || empty($_POST['message'])) {
    throw new Exception('not everything is filled in');
}
$post = new Post(htmlspecialchars($_POST['authorName']), htmlspecialchars($_POST['title']), htmlspecialchars($_POST['message']));
$postLoader->addPosts($post);
    try {
        file_put_contents('resources/posts.json', json_encode($postLoader->getPosts(), JSON_THROW_ON_ERROR));
    } catch (JsonException $e) {
        throw new JsonException('failed to put in content');
    }

}






?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Guestbook</title>
</head>
<body>
<h1 class="my-5 text-center">GuestBook</h1>
<section class="container">
    <form method="post">
        <div class="form-group">
            <label class="" for="authorName">Name: </label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="authorName" id="authorName"
                   placeholder="Type here...">
        </div>
        <div class="form-group">
            <label class="" for="title">Title: </label>
            <input type="text" class="form-control mb-2 mr-sm-2" name="title" id="title" placeholder="Type here...">
        </div>
        <div class="form-group">
            <label for="message">Message: </label>
            <textarea class="form-control" name="message" id="message" rows="3"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </form>
</section>

</body>
</html>
