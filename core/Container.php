<?php 

namespace Core;

class Container 
{
    protected $bindings = [];
    protected $instances = [];

    // Đăng ký một dịch vụ mới
    public function bind($name, callable $resolver)
    {
        $this->bindings[$name] = $resolver;
    }

    // Đăng ký một singleton
    public function singleton($name, callable $resolver)
    {
        $this->bindings[$name] = $resolver;
        $this->instances[$name] = null;
    }

    // Giải quyết và lấy ra một dịch vụ
    public function make($name)
    {
        if(isset($this->instances[$name])) {
            if($this->instances[$name] === null) {
                // Tạo singleton instance nếu chưa tồn tại
                $this->instances[$name] = $this->bindings[$name]($this);
            }
            return $this->instances[$name];
        }

        // Kiểm tra xem dịch vụ có tồn tại trong container không
        if (isset($this->bindings[$name])) {
            return $this->bindings[$name]($this);
        }
    }

    protected function build($abstract)
    {
        return $this->bindings[$abstract]($this);
    }
}