<?php
    require_once 'BaseModel.php';

class Image extends BaseModel {

    private $id;
    private $name;
    private $ownerId; // the owner of the image
    private $data;

    public $allImages = [];

    public function __construct() {
        parent::__construct();
    }
    /*
    **  Getters and setters
    */
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function getData() {
        return $this->data;
    }
    public function getOwnerId() {
        return $this->ownerId;
    }
    public function setOwnerId($ownerId) {
        $this->ownerId = $ownerId;
    }

    public function getPosts($fromIndex = 0, $elements = 5) {
        if ($fromIndex === $elements && $fromIndex === 0)
            $limit = "";
        else
            $limit = "LIMIT {$fromIndex}, {$elements}";
        $this->query("
        SELECT image.data, image.creation_date,
            image.id AS imageid, user.username AS owner
            FROM image
            INNER JOIN user
            ON image.user_id = user.id
            ORDER BY creation_date DESC {$limit};
        ");
        $this->allImages = $this->resultset();
        $posts = [];
        foreach ($this->allImages as $image) {
            $comments = $this->getImageComments($image->imageid);
            $likes = $this->getImageLikesCount($image->imageid);
            $isLiked = false;
            if (isAuthentified()) {
                $isLiked = $this->isLiked($image->imageid);
            }
            $posts[] = [
                'image' => $image,
                'comments' => $comments,
                'likes' => $likes,
                'liked' => $isLiked
            ];
        }
        return $posts;
    }

    public function isLiked($imageid) {
        $query = "SELECT * FROM `like` WHERE like.image_id=:imageid AND like.user_id=:userid";
        $this->query($query);
        $this->bind(":imageid", $imageid);
        $this->bind(":userid", $_SESSION["logged-in-user"]->id);
        return $this->rowCount();
    }

    public function saveImage() {
        $sql = 'INSERT INTO image (name, data, user_id) values (:name, :data, :user_id)';
        $this->query($sql);
        $this->bind(':name', $this->name);
        $this->bind(':data', $this->data);
        $this->bind(':user_id', $this->ownerId);
        return $this->execute();
    }

    public function deleteImage() {
        $sql = "DELETE FROM image WHERE image.id LIKE :imageid";
        $this->query($sql);
        $this->bind(":imageid", $this->id);
        $this->execute();
    }

    public function getUserImages($ownerid) {
        $sql = "SELECT data, creation_date FROM image WHERE user_id=:userid ORDER BY creation_date DESC";
        $this->query($sql);
        $this->bind(":userid", $ownerid);
        return $this->resultset();
    }

    public function getLatestImage() {
        $sql = "SELECT data, creation_date FROM image WHERE user_id=:userid ORDER BY creation_date DESC LIMIT 1";
        $this->query($sql);
        $this->bind(":userid", $this->ownerId);
        return $this->single();
    }

    public function getImageComments($imageId) {
        $comment = new Comment($imageId);
        return $comment->getComments();
    }

    public function getImageLikesCount($imageId) {
        $like = new Like($imageId);
        return $like->countLikes();
    }

    public function getImageOwnerNotify($imageid) {
        $sql = "SELECT user.notify, user.email, user.id as owner_id, image.user_id, image.id
            FROM image
            JOIN user ON user.id=image.user_id AND image.id=:imageid;
        ";
        $this->query($sql);
        $this->bind(":imageid", $imageid);
        return $this->single();
    }

}