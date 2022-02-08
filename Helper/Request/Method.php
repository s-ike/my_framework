<?php
namespace FW\Helper\Request;

class Method
{
    /**
     * $this->methodsのいずれかの値
     *
     * @var string
     */
    private $method;

    /**
     * HTTP methods
     *
     * @var array
     */
    private $methods = array(
        'GET'       => 'GET',
        'POST'      => 'POST',
        'PUT'       => 'PUT',
        'DELETE'    => 'DELETE',
    );

    /**
     * コンストラクタ
     *
     * @param string $method 'GET', 'POST', 'PUT' , 'DELETE'
     */
    public function __construct($method)
    {
        if (! isset($this->methods[$method])) {
            // 500エラー
            return header('Content-Type: text/plain; charset=UTF-8', true, 500);
            // 例外を返す場合:
            // throw new \InvalidArgumentException('Method class construct is common HTTP methods. Input was: '.$method);
        }
        $this->method = $this->methods[$method];
    }

    /**
     * $this->methodのgetter
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
