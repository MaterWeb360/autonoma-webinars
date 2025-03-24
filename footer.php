<?php

/**
 * Caja de HTML 
 * div#page
 * main#main
 */

?>
<?php
get_template_part(TEMA_P_FOOTER, "bar", []);
get_template_part(TEMA_P_FOOTER, "float", []);
get_template_part(TEMA_P_FOOTER, "general", []);

?>
</main>
</div>

<?php
$script_footer = globalCampo('g_script_footer');
echo $script_footer;

wp_footer();

get_template_part(TEMA_P_FOOTER, 'scripts', []);
?>
</body>

</html>