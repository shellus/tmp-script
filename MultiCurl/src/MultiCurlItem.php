<?php

/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/11/22
 * Time: 17:04
 */
class MultiCurlItem implements ArrayAccess
{
    private $url;
    private $data = [];
    private $master;
    private $handle;
    private $closure;

    /**
     * MultiCurlItem constructor.
     * @param string $url
     * @param \Closure $closure
     * @param array $data
     */
    public function __construct($url, $closure, $data = [])
    {
        $this->url = $url;
        $this->closure = $closure;
        $this->data = $data;
    }

    public function getContent()
    {
        return curl_multi_getcontent($this->handle);
    }

    public function callClosure()
    {
        // TODO hack
        $closure = $this->closure;
        return $closure($this);
    }

    /**
     * @param mixed $closure
     */
    public function setClosure($closure)
    {
        $this->closure = $closure;
    }

    /**
     * @param mixed $master
     */
    public function setMaster($master)
    {
        $this->master = $master;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return key_exists($offset, $this->data);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }


}