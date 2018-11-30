{strip}
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1,width=device-width">

{* OpenGraph | http://ogp.me
Для подключения нужно использовать атрибут prefix="og: http://ogp.me/ns#" в теге html.

Шаблон: *}
<meta property="og:type" content="website" />
<meta property="og:url" content="http://tst.readonly.site/" />
<meta property="og:title" content="только для чтения" />
<meta property="og:description" content="описание" />
<meta property="og:image" content="http://tst.readonly.site/bg-main_t.jpg" />
<meta property="og:image:height" content="496" />
<meta property="og:image:width" content="232" />

<title>{$_meta.title}</title>

<meta name="description" content="{$_meta.description}">
<meta name="keywords" content="{$_meta.keywords}">

{* <meta http-equiv="refresh" content="5; URL=http://www.htmlbook.ru"> *}

<link rel="shortcut icon" href="/images/adminfavicon.ico" type="image/x-icon">
<link rel="icon" href="/images/adminfavicon.ico" type="image/x-icon">
{* <link rel="icon" href="" type="image/x-icon"> *}
{* <link rel="apple-touch-icon" href="" type="image/png"> *}

{* Apple iOS | https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html *}
{* <meta name="apple-mobile-web-app-capable" content="yes"> *}
{* <meta name="apple-mobile-web-app-status-bar-style" content="black"> *}

<!--[if lt IE 9]>
  {* https://ru.wikipedia.org/wiki/HTML5_Shiv *}
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  {* http://2web-master.ru/10-samyx-poleznyx-instrumentov-dlya-javascript-razrabotchikov.html *}
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

{* <!--Custom Windows Start Screen Tile | http://www.buildmypinnedsite.com--> *}

{* <link rel="canonical" href="http://site.com/dresses.html" /> *}
{/strip}