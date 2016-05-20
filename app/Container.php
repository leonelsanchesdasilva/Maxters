<?php

namespace Maxters;

/**
 * 
 * @author Wallace de Souza Vizerra
 * 
 * */
class Container implements \ArrayAccess
{
	protected $container = [
		'debug' => false,
	];

	public function offsetGet($key)
	{
		if (! isset($this->container[$key]))
		{
			throw new \InvalidArgumentException("Item '{$key}' not found in container");
		}

		return $this->container[$key];
	}

	public function offsetSet($key, $value)
	{
		$this->bind($key, $value);
	}

	public function offsetExists($key)
	{
		return isset($this->container[$key]);
	}

	public function offsetUnset($key)
	{
		unset($this->container[$key]);
	}

	public function bind($key, $value)
	{
		$this->container[$key] = $value;

		return $this;
	}

	public function singleton($key, $value, array $params = [])
	{
		// No singleton, se a instância passada for uma closure
		// Deve ser invocada imediatamente, para resolver as dependências

		if ($value instanceof \Closure)
		{
			$value = call_user_func_array($value, $params);
		}

		$this->container[$key] = $value;
	}

	public function resolver($key, array $arguments = [])
	{
		if (! isset($this->container[$key]))
		{
			throw new \InvalidArgumentException("value {$key} does'nt exists in container");
		}

		$value = $this->container[$key];

		// Quando o valor passado para o container (não o singleton) for uma closure
		// As dependências devem ser resolvidas em "runtime"

		if ($value instanceof \Closure)
		{
			$value = call_user_func_array($value, $arguments);

		} elseif (count($arguments) > 0) {

			throw new \RunTimeException(
				'Cannot pass arguments in non-closure dependency'
			);
		}

		return $value;
	}
}