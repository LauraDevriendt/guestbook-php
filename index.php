<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require 'classes/PostLoader.php';
require 'classes/Post.php';

session_start();

$postLoader = new PostLoader();

if (isset($_POST['submit'])) {

    if (empty($_POST['authorName']) || empty($_POST['title']) || empty($_POST['message'])) {
        throw new Exception('not everything is filled in');
    }
    $post = new Post(htmlspecialchars($_POST['authorName']), htmlspecialchars($_POST['title']), htmlspecialchars($_POST['message']));
    $postLoader->addPosts($post);
    $postLoader->storeDataPosts();

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
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
          crossorigin="anonymous">
    <title>Guestbook</title>
</head>
<body>
<h1 class="my-5 text-center">GuestBook</h1>
<section id="createPost" class="container">
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
<section id="displayPosts">

    <div class="container">
        <form method="post" class="w-30 my-2">
            <div class="input-group">
                <input type="number" name="displayNumber" class="form-control" placeholder="" aria-label=""
                       aria-describedby="basic-addon1" value="<?php echo (isset($_POST['displayNumber'])) ? htmlspecialchars($_POST['displayNumber']) : "20";?>">
                <div class="input-group-append">
                    <button class="btn btn-success" name="displayNumberSubmit" type="button">set Display</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row mx-auto">
            <?php
         $displayNumber= (isset($_POST['displayNumber'])) ? htmlspecialchars($_POST['displayNumber']) : "20";
            if (!empty($postLoader->getPosts())) echo $postLoader->displayPosts((int)$displayNumber);

            ?>
        </div>
    </div>
</section>
</body>
</html>
