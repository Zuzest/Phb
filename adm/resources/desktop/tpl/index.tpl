<!DOCTYPE html>
<html>
<head>
  {include file="meta.tpl"}
  {include file="bootstrap.tpl"}
</head>
<body>

sdfdsfsdf
{$ttt}
<br>
{* {Tpl::gggetTitle()} *}
{F::transliterate('фиговинка')}
{* {$Tpl->getTitle()} *}
{* {$_meta|vdump} *}
{* {CFG::getSelf()|vdump} *}

</body>
  {assets->getCss}
{* {assets::getCss()} *}
</html>