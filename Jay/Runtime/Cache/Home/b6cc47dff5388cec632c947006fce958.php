<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jay的音乐网站</title>
    <link href="/Public/Default/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Default/css/index.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container">
    <button type="button" class="btn btn-default navbar-btn" id="song-play-btn">
        <span class="glyphicon glyphicon-play" aria-hidden="true" id="song-play-icon"></span>
    </button>
    <?php if($outMusic['id'] > 0 ): ?><p class="navbar-brand" id="song-name"><?php echo ($outMusic["name"]); ?></p>
    <?php else: ?>
        <p class="navbar-brand" id="song-name">Jay的音乐网站</p><?php endif; ?>
  </div>
  <div>
  </div>
</nav>
    <div class="container-fluid">
        	<?php if(is_array($albums)): $i = 0; $__LIST__ = $albums;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$album): $mod = ($i % 2 );++$i;?><div class="panel panel-primary">
                    <div class="panel-heading"><?php echo ($album["name"]); ?>-<?php echo ($album["year"]); ?></div>
                    <table class="table">
                        <?php if(is_array($album['musics'])): $i = 0; $__LIST__ = $album['musics'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$music): $mod = ($i % 2 );++$i;?><tr>
                                <td class="music" onclick="window.location.href='/index.php/Home/Index?id=<?php echo ($music["id"]); ?>'"><?php echo ($music["name"]); ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="/Public/Default/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/Default/js/player.js"></script>
    <script type="text/javascript">
    var host = window.location.host;
    var url = "http://" + host + "/Public/Uploads/music/<?php echo ($outMusic["album"]); ?>_<?php echo ($outMusic["id"]); ?>.mp3";
    play(url);
    </script>
  </body>
</html>