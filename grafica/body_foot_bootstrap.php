<footer class="panel-footer">
    <p>Software rilasciato sotto licenza <a href="http://www.gnu.org/licenses/gpl.txt">GNU/GPL</a></p>
   <!-- <p>&copy; Maurizio Proietti 2015 - 	<a href="http://blog.maurizio.proietti.name">Credits</a> </p> -->
</footer>

<?php include_once($percorso_relativo."include/google_analytics.php") ?>

<!--------------------------------------------------------------------------------->


<script src="<?=$percorso_relativo?>libs/js/jquery/jquery.min.js"></script>
<script src="<?=$percorso_relativo?>libs/js/jquery/jquery-migrate.min.js"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=$percorso_relativo?>libs/js/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.it.js"></script>




<script type="text/javascript">

	jQuery.validator.setDefaults ({
		// debug: true,
		success: "valid"
	});

</script>

<!-------------------------------------------------------------------------------------------->



<script type='text/javascript'>
	$(document).ready(function(){
		$(".cancella").click(function(){
			if (!confirm("Sei sicuro di voler eseguire la cancellazione? L'OPERAZIONE È IRREVERSIBILE.?")){
				return false;
			}
		});
	});
</script>'


<!--
<script type="text/javascript">
    jQuery.validator.setDefaults({
        //	debug: true,
        success: "valid"
    });;
</script>
-->

</body>
</html>
