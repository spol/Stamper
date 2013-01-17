<?php

class Stamper_Twig_Loader implements Twig_LoaderInterface
{
	private $path;

	public function getSource($name)
	{
		if (dirname($name) !== '.')
		{
			$this->path = dirname($name);
		}
		else
		{
			$name = $this->path . '/' . $name;
		}

		// if ($name != '/Users/scp/Projects/Stamper/templates/email.twig') var_dump($name);

		return file_get_contents($name);

	}

	public function getCacheKey($name)
	{
		return $name;
	}

	public function isFresh($name, $time)
	{
		return false;
	}
}