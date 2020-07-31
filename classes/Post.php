<?php

class Post implements JsonSerializable{
    private string $title;
    private string $author;
    private DateTime $date;
    private array $emojis = [
        ':-)' => '&#128512;',
        ';-)' => '&#128521;',
        ':-(' => '&#128543;'
    ];

    public function __construct(string $title, string $author, string $content)
    {
        $this->title = $title;
        $this->author = $author;
        $this->date = new DateTime();
        $this->content = $content;


    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
    private string $content;


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }


    public function getContent(): string
    {
        return $this->content;
    }


    public function jsonSerialize():array
    {
        return [
            'title'=>$this->title,
            'author'=>$this->author,
            'date' =>$this->date,
            'content'=> $this->content
        ];
    }

    public function displayPost():string{

        foreach ($this->emojis as $key => $emoji){
            $this->setContent(str_replace($key,$emoji,$this->content));
        }

        return "<div class='card col-3 mr-2 mb-2'>
                    <div class='card-body'>
                        <h4 class='card-title''>{$this->getTitle()}</h4>
                        <h6 class='card-subtitle mb-2 text-muted'>{$this->getAuthor()} on {$this->getDate()->format('D M d H:ia')}</h6>
                        <p class='card-text'>{$this->getContent()}</p>
                    </div>
                  </div>";
    }
}