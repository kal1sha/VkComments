 
<?php
class ApiVK
{
    protected $appId, $secretKey, $accessToken, $accessSecret; 
 
    /**
     * @param int $groupId
     * @param int $appId
     * @param string $secretKey
     */
    public function __construct($appId, $secretKey)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
    } 
 
    /**
     * @param string $accessToken
     * @param string $accessSecret
     */
    public function setAccessData($accessToken, $accessSecret)
    {
        $this->accessToken = $accessToken;
        $this->accessSecret = $accessSecret;
    } 
 
    /**
     * Маленький Hack для генерации code
     */
    public function getAccessData()
    {
        echo "<!doctype html><html><head><meta charset='utf-8'></head>
            <body><a href='http://api.vkontakte.ru/oauth/authorize?" .
            "client_id={$this->appId}&scope=offline,wall,groups,pages,friends,nohttps&amp;" .
            "redirect_uri=http://api.vkontakte.ru/blank.html&amp;response_type=code'
                target='_blank'>Получить CODE</a><br>Ссылка для получения токена:<br>
                <b>https://api.vkontakte.ru/oauth/access_token?client_id={$this->appId}" .
            "&amp;client_secret={$this->secretKey}&amp;code=CODE</b></body></html>"; 
 
        exit;
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
     * @param mixed $parameters
     * @return mixed
     */
    public function callMethod($method, $parameters)
    {
        if (!$this->accessToken) return false;
        if (is_array($parameters)) $parameters = http_build_query($parameters);
        $queryString = "/method/$method?$parameters&access_token={$this->accessToken}";
        $querySig = md5($queryString . $this->accessSecret);
        return json_decode(file_get_contents(
            "http://api.vk.com{$queryString}&sig=$querySig"
        ));
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
       return $this->callMethod('board.getComments', array(
           'gid' => $gid,
           'tid' => $tid,
       ));
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
       return  $this->callMethod('photos.getComments', array(
           'owner_id' => $owner_id,
           'pid' => $pid
       ));
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
       return  $this->callMethod('photos.getComments', array(
           'owner_id' => -1 * $owner_id,
           'pid' => $pid
       ));
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
       return $this->callMethod('wall.getComments', array(
           'owner_id' => $owner_id,
           'post_id' => $post_id,
       ));
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
       return $this->callMethod('wall.getComments', array(
           'owner_id' => -1 * $owner_id,
           'post_id' => $post_id,
       ));
    } 

    /**
     * Права доступа
     *
     * @param int $uid
     * @return mixed
     */
    public function getUserSettings($uid) {
       return $this->callMethod('getUserSettings', array(
           'uid' => $uid,
       ));        
    }
}
?>