<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\NetUtil;
class IndexController extends Controller {
    public function index(){
        $result = NetUtil::http("http://robinwu.com:8080/album/list");
        $musicId = I('id');
        $jsonObj = json_decode($result,true);
        $result = array();
    	if ($jsonObj["code"] == 0) {
            $albums = $jsonObj["data"];
    		foreach ($albums as $value) {
                $musicResponse = NetUtil::http("http://robinwu.com:8080/music/list?albumId=".$value['id']);
                $musicJsonObj = json_decode($musicResponse,true);
                if($musicJsonObj["code"] == 0) {
                    $album = array();
                    $album['id'] = $value['id'];
                    $album['name'] = $value['name'];
                    $album['year'] = $value['year'];
                    $arrMusics = array();
                    $musics = $musicJsonObj['data'];
                    foreach ($musics as $music) {
                        $tempMusic = array();
                        $tempMusic['id'] = $music['id'];
                        $tempMusic['name'] = $music['name'];
                        array_push($arrMusics,$tempMusic);
                    }
                    $album['musics'] = $arrMusics;
                    array_push($result,$album);
                }                
            }
    	}
        if (!empty($musicId)) {
            $musicResponse = NetUtil::http("http://robinwu.com:8080/music/getMusic?id=".$musicId);
            $musicJsonObj = json_decode($musicResponse,true);
            $currentMusic = $musicJsonObj["data"];
            $outMusic = array();
            $outMusic['id'] = $currentMusic['id'];
            $outMusic['name'] = $currentMusic['name'];
            $outMusic['album'] = $currentMusic['albumId'];
            $this->outMusic = $outMusic;
        }
        $this->albums = $result;
        $this->display();
    }
}