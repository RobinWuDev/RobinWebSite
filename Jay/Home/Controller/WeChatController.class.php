<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\Wechat;
class WeChatController extends Controller {
    protected $wechat;
    protected $data;

    public function _initialize() {
        $configs = array(
            'token'  => C("wechat_token"),
            'encodingaeskey'=>C("wechat_encodingaeskey"),
            'appid'  => C("wechat_appid"),
            'secret'  => C("wechat_secret")
        );
        $this->wechat = new Wechat($configs);
        $this->wechat->valid();
    }

    public function indexAction() {
        if($this->wechat->getRev()->getRevType()) {
            $this->route();
        } else {
            $this->wechat->text("error")->reply();
        }
        
    }

    private function route() {
        $msgtype = $this->wechat->getRev()->getRevType();        
        switch ($msgtype) {
            case Wechat::MSGTYPE_TEXT: {
                $ret = $this->wechat->getRev()->getRevContent();
                if ($ret == "0") {
                    $this->showMenu();
                } else if($ret == "1") {
                    $this->showSong();
                } else if($ret == "2") {
                    $this->showMingYan();
                }else {
                    $this->showMenu();
                }
                break;
            }
            default:
                $this->showMenu();
                break;
        }
    }

    private function showMenu() {
        $menuText = "1. 听\n2. 言";
        $this->wechat->text($menuText)->reply();
    }

    private function showSong() {
        $Music = D("Music");
        $Album = D("Album");
        $musics = $Music->select();
        $count = count($musics);
        $rand = rand(0,$count-1);
        $music = $musics[$rand];
        $album = $Album->find($music['album_id']);

        $url = "http://music.444dish.com/Public/Uploads/music/";
        $url .= $music['album_id'];
        $url .= "_";
        $url .= $music['id'];
        $url .= ".mp3";

        $this->wechat->music($music['name'], $album['name'], $url, $url)->reply();
    }

    private function showMingYan() {
        $MingYan = D("Mingyan");
        $mingyans = $MingYan->select();
        $count = count($mingyans);
        $rand = rand(0,$count-1);
        $mingyan = $mingyans[$rand];
        $content = "".$mingyan['content']."\n--".$mingyan['author'];

        $this->wechat->text($content)->reply();
    }
}

