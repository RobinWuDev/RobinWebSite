<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\NetUtil;
class IndexController extends Controller {
    public function index(){
        $result = NetUtil::http("http://127.0.0.1:8080/index/musicList");
        $musicId = I('id');
        $jsonObj = json_decode($result,true);
        $result = array();
        if ($jsonObj["code"] == 0) {
            $albums = $jsonObj["data"];
            foreach ($albums as $value) {
                    $album = array();
                    $album['id'] = $value['id'];
                    $album['name'] = $value['name'];
                    $album['year'] = $value['year'];
                    $arrMusics = array();
                    $musics = $value['musics'];
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
        if (!empty($musicId)) {
            $musicResponse = NetUtil::http("http://127.0.0.1:8080/music/getMusic?id=".$musicId);
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