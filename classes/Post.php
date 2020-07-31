<?php
class PostLoader{
    private array $posts=[];


    public function setPosts(array $posts): void
    {
        $this->posts = $posts;
    }

    public function addPosts(Post $post){
        $this->posts[]=$post;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }
}
class Post implements JsonSerializable{
    private string $title;
    private string $author;
    private DateTime $date;
    private string $content;


    public function __construct(string $title, string $author, string $content)
    {
        $this->title = $title;
        $this->author = $author;
        $this->date = new DateTime();
        $this->content = $content;


    }


   /* public function __unserialize(array $data): void
    {
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->date = $data['date'];
        $this->content = $data['content'];

        // @todo check this on manual $this->connect();
    }*/


    public function jsonSerialize():array
    {
        return [
            'title'=>$this->title,
            'author'=>$this->author,
            'date' =>$this->date,
            'content'=> $this->content
        ];
    }
}