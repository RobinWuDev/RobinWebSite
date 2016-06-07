<?php
namespace Home\Controller;
use Think\Controller;
use Common\Common\Wechat;
use Common\Common\NetUtil;
class WeChatController extends Controller {
    protected $wechat;
    protected $data;

    public function _initialize() {
        // $configs = array(
        //     'token'  => C("wechat_token"),
        //     'encodingaeskey'=>C("wechat_encodingaeskey"),
        //     'appid'  => C("wechat_appid"),
        //     'secret'  => C("wechat_secret")
        // );
        $configs = array(
            'token'  => 'giveyou3seconds',
            'encodingaeskey'=>'SSPFCNdygBF66ZY47epMI6Q9yKAhpf0CuyDEUReiroi',
            'appid'  => 'wx74d6978ff4743503',
            'secret'  => '1d7aacbc1fa9d70c0b52c3ec1821b17f'
        );
        $this->wechat = new Wechat($configs);
        $this->wechat->valid();
    }

    public function index() {
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
        error_log('你要输出的信息', 3, '/tmp/log.txt');
        $menuText = "1. 听\n2. 言";
        $this->wechat->text($menuText)->reply();
    }

    private function showSong() {
        $result = NetUtil::http("http://127.0.0.1:8080/index/randMusic");
        $jsonObj = json_decode($result,true);
        $music = $jsonObj["data"];

        $url = "http://music.robinwu.com/Public/Uploads/music/";
        $url .= $music['albumId'];
        $url .= "_";
        $url .= $music['id'];
        $url .= ".mp3";

        $this->wechat->music($music['name'], $music['albumName'], $url, $url)->reply();
    }

    private function showMingYan() {
        $result = NetUtil::http("http://127.0.0.1:8080/index/randMingYan");
        $jsonObj = json_decode($result,true);
        $mingYan = $jsonObj["data"];
        $content = "".$mingYan['content']."\n--".$mingYan['author'];
        $this->wechat->text($content)->reply();
    }
}

