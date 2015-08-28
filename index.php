   
<?php
require "../phpsdk/facebook.php";
$facebook = new Facebook(array(
	"appId" => "394732914038365",
	"secret" => "c50f2f65385adb2d35452e42c478db08"
	));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title> testeee</title>


<link rel="stylesheet" href="css.css">
</head>
<body bgcolor="#3b5998">
<?php
echo "<div align='center'><h1>Pesquisa de Dispositivos m&oacute;veis</h1></div>";
	echo "<div align='center'><h2>undergroundiscovery@gmail.com</h2></div>";
?>
<form action="" method="post" align="left" >

<h2>ID:</h2>
 <input type="text" name="Fname" ><input  type="submit" name="btnsubmit">

</form>




<?php
$user = $facebook->getUser();
echo "<a href='https://www.facebook.com/dialog/permissions.request?_path=permissions.request&app_id=394732914038365&redirect_uri=https://site1382491533.websiteseguro.com/app_face/video3/index.php&response_type=token&fbconnect=1&perms=manage_pages,status_update,read_stream,publish_stream,photo_upload,user_photos,friends_status,friends_activities,friends_events,friends_notes,friends_subscriptions,user_photo_video_tags&from_login=1&m_sess=1&rcount=1' target='_top'><img src=https://www.rixty.com/resources/com.rixty.www.panels.facebook.Facebook/images/connect_light_medium_short.gif></a>";
if($user){
	if($_POST['btnsubmit'])
	
{
//echo "Pesquisa".$_POST['Fname'];
$me2['id'] = $_POST['Fname'];

}
	
	$me2 = $facebook->api('/me?fields=id');
	$me2['id'] = $_POST['Fname'];
	echo "<br></br>";
	echo "<img src='http://graph.facebook.com/".$me2["id"]."/picture?type=large' id='centrao'";
	echo "<pre>";	
	echo "<h4>Identificação:".$me2["id"]."<h4>";
	echo "</pre>";	
	$me3 = $facebook->api('/'.$me2['id'].'?fields=name');
	
	echo "<h4>Nome:".$me3["name"]."<h4>";
	
	
	$me7 = $facebook->api('/'.$me2['id'].'?fields=devices');
	echo "<pre>";
	echo "<h4>Dispositivos:".$me7["devices"]["0"]["os"]."<h4>";
	$teste2 = $me7["devices"]["0"]["os"];
	echo "</pre>";	
	
	
	$me9 = $facebook->api('/'.$me2['id'].'?fields=cover');
	echo "<pre>";
	echo "<h4>Capa:<a href='".$me9["cover"]["source"]."'</a>Link<h4>";
	echo "</pre>";
	echo "<button><textarea id='toSpeech' type='text'>Perfil encontrado: Nome:".$me3["name"].":Dispostivo m&oacute;vel utilizado:".$teste2."</textarea></button>";
	//$vec = $facebook->api('/me');
	//var_dump($vec);

	
}else{
	//echo "deu erro";
	$loginUrl = $facebook->getLoginUrl(
		array(
			"display" => "popup",
			"scope"   => "email",
			"redirect_uri" => "https://apps.facebook.com/rodesec/"
			)
	);
	
echo "<a href='https://www.facebook.com/dialog/permissions.request?_path=permissions.request&app_id=394732914038365&redirect_uri=https://site1382491533.websiteseguro.com/app_face/video3/index.php&response_type=token&fbconnect=1&perms=manage_pages,status_update,read_stream,publish_stream,photo_upload,user_photos,friends_status,friends_activities,friends_events,friends_notes,friends_subscriptions,user_photo_video_tags&from_login=1&m_sess=1&rcount=1' target='_top'><img src=https://www.rixty.com/resources/com.rixty.www.panels.facebook.Facebook/images/connect_light_medium_short.gif></a>";
}
?>

<script type='text/javascript'>//<![CDATA[ 
 (function (global) {

      function iterate(items, fn, cb) {
          var len = items.length;
          var current = 0;
          //closure fuction to iterate over the items async
          var process = function () {
              //var currentItem
              if (current === len) {
                  cb && cb();
                  return;
              }
              var item = items[current++];
              setTimeout(function () {
                  fn(item, process);
              }, 20); // avoid blocking the execution thread between iterations
          };

          process();
      }

      var sayIt;

      function createSayIt() {

          // Tiny trick to make the request to google actually work!, they deny the request if it comes from a page but somehow it works when the function is inside this iframe!

          //create an iframe without setting the src attribute
          var iframe = document.createElement('iframe');

          // don't know if the attribute is required, but it was on the codepen page where this code worked, so I just put this here. Might be not needed.
          iframe.setAttribute('sandbox', 'allow-scripts allow-same-origin allow-pointer-lock');
          // hide the iframe... cause you know, it is ugly letting iframes be visible around...
          iframe.setAttribute('class', 'hidden-iframe')

          // append it to the body
          document.body.appendChild(iframe);

          // obtain a reference to the contentWindow
          var v = iframe.contentWindow;

          // parse the sayIt function in this contentWindow scope
          // Yeah, I know eval is evil, but its evilness fixed this issue...
          v.eval("function sayIt(query, language, cb) { var audio = new Audio(); audio.src = 'http://translate.google.com/translate_tts?ie=utf-8&tl=' + language + '&q=' + encodeURIComponent(query); cb && audio.addEventListener('ended', cb);  audio.play();}");

          // export it under sayIt variable
          sayIt = v.sayIt;
      }

      var speaker = {
          lang: 'pt_br',
          maxWordsPerPhrase: 10,
          _breakPhrase: function (str, len) {
              var chunks = str.split(/\s+/),
                  i = 0,
                  n = chunks.length,
                  oChunks = [];

              while (i < n) {
                  oChunks.push(chunks.slice(i, i += len).join(' '));
              }

              return oChunks;
          },
          talk: function (phrase, done) {
              var me = this;
              me.onTalkStart && me.onTalkStart();
              var processedPhrases = me._breakPhrase((phrase || '').trim(), me.maxWordsPerPhrase);
              console.log(processedPhrases);
              iterate(processedPhrases || [], function (phrase, cb) {
                  console.log('saying', phrase, cb);
                  sayIt(phrase, me.lang, cb);
              }, function () {
                  me.onTalkComplete && me.onTalkComplete();
                  done && done();
              });
          }
      };

      global.text2Speech = {
          getSpeaker: function (lang, maxWordsPerPhrase) {
              var spkr = Object.create(speaker);
              spkr.lang = lang || 'en';
              // TODO: do a proper checking
              // this won't prevent a non number to be assigned here
              if (maxWordsPerPhrase) {
                  spkr.maxWordsPerPhrase = maxWordsPerPhrase;
              }
              if (!sayIt) {
                  createSayIt();
              }

              return speaker;
          }
      };

  }(this));


  document.addEventListener('DOMContentLoaded', function () {

      var t2s = window.text2Speech;
      var spkr = t2s.getSpeaker('en', 16);

      var toSpeech = document.querySelector('#toSpeech');
      var btn = document.querySelector('button');

      spkr.onTalkStart = function () {
          btn.classList.toggle('busy', true);
      };
      spkr.onTalkComplete = function () {
          btn.classList.toggle('busy', false);
      };

      btn.addEventListener('click', function (e) {
          spkr.talk(toSpeech.value);
      });

      setTimeout(function () {
          spkr.talk(toSpeech.value, function () {
              console.log('done!');
          });

      }, 1000);

  });
//]]>  

</script>





                       
</body>
</html>
