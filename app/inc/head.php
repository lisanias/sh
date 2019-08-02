<!DOCTYPE html>
<html lang="pt">
  <head>
<meta charset="utf-8" />
<title><?=$pg_titulo?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />

<link rel="icon" href="./img/favicon.png">
<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="./css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="./css/font-awesome.min.css" rel="stylesheet" />

<link href="./css/reports.css" rel="stylesheet" />

<!-- <link href="./css/font-awesome.css" rel="stylesheet" /> -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" />
    
<link href="./css/base-admin.css" rel="stylesheet" type="text/css" />
<link href="./css/pages/signin.css" rel="stylesheet" type="text/css" />



<!-- Maracara de entrada para campos -->
<script src="./js/jquery.mask.min.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(function($){
      $("#data_pg").mask("99/99/9999");
      $("#inputTres").mask("(99) 9999-9999");
      $("#inputCPF").mask("999.999.999-99", {placeholder:" "});
      $("#inputCEP").mask("99999-999");

      var SaoPauloCelphoneMask = function(phone, e, currentField, options){
          return phone.match(/^(\(?11\)? ?9(5[0-9]|6[0-9]|7[01234569]|8[0-9]|9[0-9])[0-9]{1})/g) ? '(00) 00000-0000' : '(00) 0000-0000';
      };

      $("#inputTcel").mask(SaoPauloCelphoneMask, { onKeyPress: function(phone, e, currentField, options){
          $(currentField).mask(SaoPauloCelphoneMask(phone), options);
      }});

      $('pre').each(function(i, e) {hljs.highlightBlock(e)});
  });
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>