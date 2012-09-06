 
<?php
class CApiVK
{

    protected $accessToken;

    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    } 

    /**
     * Инициализация ссылки
     *
     * @param string $link
     * @return mixed
     */
    public function init($link) {

        preg_match_all("/([a-z]{1,10})(.*)_(.*)/", $link, $array, PREG_PATTERN_ORDER);

        switch ($array[1][0]) {
            case 'topic':
                return $this->groupBoardGetComments($array[3][0], -1*$array[2][0]);
            case 'photo':
                if ($array[2][0] > 0)
                    return $this->userPhotoGetComments($array[2][0], $array[3][0]);                   
                else
                    return $this->groupPhotoGetComments(-1*$array[2][0], $array[3][0]);  
            case 'wall':
                if ($array[2][0] > 0)
                    return $this->userWallGetComments($array[2][0], $array[3][0]);                   
                else
                    return $this->groupWallGetComments(-1*$array[2][0], $array[3][0]);                                       
        }   

        return false;
    }

    /**
     * Метод, который делает запрос в vk.com
     *
     * @param string $method  
     * @return mixed
     */
    public function callMethod($url,$fields)
    {
        $url=$url.$fields.'&access_token='.$this->accessToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_REFERER, "http://vk.com/");
        curl_setopt($ch, CURLOPT_POST, 0); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields.'&access_token='.$this->accessToken); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Macintosh; Intel Mac OS X; U; en) Presto/2.2.15 Version/10.00");
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
             
        $subject = curl_exec($ch);       
        return $subject;
    } 
 


    /**
     * Забрать комментарии из заметок в группе
     *
     * @param int $tid
     * @param int $gid
     * @return mixed
     */
    public function groupBoardGetComments($tid,$gid)
    {
        $url = 'https://api.vk.com/method/board.getComments?';
        $fields = 'gid='.$gid.'&tid='.$tid;
        return json_decode($this->callMethod($url,$fields)); 
    } 

    /**
     * Забрать комментарии из фото в профайле
     *
     * @param int $owner_id
     * @param int $pid
     * @return mixed
     */
    public function userPhotoGetComments($owner_id, $pid)
    {
        $url = 'https://api.vk.com/method/photos.getComments?';
        $fields = 'owner_id='.$owner_id.'&pid='.$pid;
        return json_decode($this->callMethod($url,$fields)); 
    } 

    /**
     * Забрать комментарии из фото в группе
     *
     * @param int $owner_id
     * @param int $pid
     * @return mixed
     */
    public function groupPhotoGetComments($owner_id, $pid = 0)
    {
        $url = 'https://api.vk.com/method/photos.getComments?';
        $fields = 'owner_id='.(-1*$owner_id).'&pid='.$pid;
        return json_decode($this->callMethod($url,$fields));
    } 

    /**
     * Забрать комментарии из стенки в профайле
     *
     * @param int $owner_id
     * @param int $post_id
     * @return mixed
     */
    public function userWallGetComments($owner_id, $post_id)
    {
        $url = 'https://api.vk.com/method/wall.getComments?';
        $fields = 'owner_id='.$owner_id.'&post_id='.$post_id;
        return json_decode($this->callMethod($url,$fields));
    } 

    /**
     * Забрать комментарии из стенки в группе
     *
     * @param int $owner_id
     * @param int $post_id
     * @return mixed
     */
    public function groupWallGetComments($owner_id, $post_id)
    {
        $url = 'https://api.vk.com/method/wall.getComments?';
        $fields = 'owner_id='.(-1 * $owner_id).'&post_id='.$post_id;
        return json_decode($this->callMethod($url,$fields));
    } 

}
?>