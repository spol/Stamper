<?php

class StamperTemplate
{
	private $filepath;
	private $twig;
	private $config = array();

	public function __construct($filepath)
	{
		$this->filepath = $filepath;
		$this->twig_init();
	}

	public function set_config($config_filepath)
	{
		$config = json_decode(file_get_contents($config_filepath));

		if (json_last_error() === JSON_ERROR_NONE)
		{
			$this->config = (array)$config->variables;
			return true;
		}
		else
		{
			return false;
		}
	}

	public function twig_init()
	{
		$loader = new Stamper_Twig_Loader();
		$this->twig = new Twig_Environment($loader);
	}

	public function render_and_write($output_filepath)
	{
		$output = $this->twig->render($this->filepath, $this->config);

		file_put_contents($output_filepath, $output);
	}
}