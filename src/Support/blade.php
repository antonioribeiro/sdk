<?php

Blade::extend(function ($view)
{
	$view = preg_replace("/{{'([^<^>^\s]+)'}}/", '<?php echo t("$1"); ?>', $view);

	return $view;
});
