<?php
/**
 * 非AMPフォーマットのheadタグのユーザー拡張部分
 *
 * ココに書いたタグが通常ページ（AMPではない）のhead内に出力されます
 * Google Fontsなどを追加したい時にご使用下さい
 *
 * ※AMPページにも同じタグを出力したい場合は user-custom-head-amp.php にも追記して下さい
 */

/* adobeフォント導入*/
?>
<script>
  (function(d) {
    var config = {
      kitId: 'nlk1mjd',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>