<?php if ($pg_nome == "login.php") { ?>
<style type="text/css">
.footer-inner {
	padding: 15px 0;
	font-size: 12px;
	background: none;
	color: #999;
}
.footer {
	margin-top:4em;
}
</style>
<?php } ?>
<div class="footer"> 
	
	<div class="footer-inner">
		
		<div class="container">
			
			<div class="row">
				
    			<div class="span12">
    				&copy; 2013 <a href="http://msm.dyndns.com/hosana.app/">Hosana.SiS</a>
                    (by <a href="http://www.webig.pro.br">WebiG</a>)
                    <span style='color: #BBB; font-size: .75em;'>
                        <?php
                            if(defined('VERSAO')) {
                               echo VERSAO;
                            }
                        ?>
                    </span>.
    			</div> <!-- /span12 -->
    			
    		</div> <!-- /row -->
    		
		</div> <!-- /container -->
		
	</div> <!-- /footer-inner -->
	
</div> <!-- /footer -->

<script src="./js/jquery-1.7.2.min.js"></script>
<script src="./js/bootstrap.js"></script>
<script src="./js/signin.js"></script>

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

</body>
</html>