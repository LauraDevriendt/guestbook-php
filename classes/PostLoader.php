<?php
class PostLoader{
    private array $badWords=['shit','fuck'];
    const RESOURCES_POSTS_JSON = 'resources/posts.json';

    /**
     * @var Post[]
     */
    private array $posts=[];

    /**
     * PostLoader constructor.
     * @param Post[] $posts
     */
    public function __construct()
    {
        try {
            $postData = json_decode(file_get_contents(self::RESOURCES_POSTS_JSON), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $postData="";
        }
        if (!empty($postData)) {
            $this->setPosts($postData);
        }

    }


    public function setPosts(array $postData): void
    {
        foreach ($postData as $post){
            $postFromFile=new Post( $post['title'],$post['author'],$post['content']);
            $date= new DateTime($post['date']['date']);
            $postFromFile->setDate($date);
            $this->posts[]= $postFromFile;
        }


    }

    public function addPosts(Post $post){
        foreach ($this->badWords as $word){
            if(strpos($post->getContent(),$word)!==false){
                throw new Exception("Following word '{$word}' is not allowed! Your post will not be included");
            }
        }

        $this->posts[]=$post;
    }


    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    public function storeDataPosts(){
        try {
            file_put_contents(self::RESOURCES_POSTS_JSON, json_encode($this->getPosts(), JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            throw new JsonException('failed to put in content');
        }

    }

    public function displayPosts($numberOfPosts=20):string{
        /**
         * @var Post[] $posts
         */
        $posts=array_slice(array_reverse($this->posts),0,$numberOfPosts);
        $display="";
        foreach ($posts as $post){
            $display.=$post->displayPost();
        }
        return $display;
    }



}