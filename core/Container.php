<?php

namespace Core;

class Container 
{
    protected $bindings = [];
    protected $instances = [];

    // Đăng ký một dịch vụ mới
    public function bind($name, callable $resolver)
    {
        echo '1';
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
        // Kiểm tra nếu instance đã tồn tại
        if (isset($this->instances[$name])) {
            if ($this->instances[$name] === null) {
                // Tạo singleton instance nếu chưa tồn tại
                $this->instances[$name] = $this->bindings[$name]($this);
            }
            return $this->instances[$name];
        }

        // Kiểm tra xem dịch vụ có tồn tại trong container không
        if (isset($this->bindings[$name])) {
            return $this->bindings[$name]($this);
        }

        // Nếu không có binding, cố gắng khởi tạo lớp
        return $this->build($name);
    }

    // Tự động khởi tạo các đối tượng và phụ thuộc của nó
    protected function build($class)
    {
        // Kiểm tra class có tồn tại không
        if (!class_exists($class)) {
            throw new \Exception("Class {$class} does not exist");
        }

        $reflector = new \ReflectionClass($class);

        // Kiểm tra class có thể khởi tạo được không
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        // Nếu không có constructor, khởi tạo đối tượng bình thường
        if (is_null($constructor)) {
            return new $class;
        }

        // Nếu có constructor, lấy các dependencies của nó
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependencyClass = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? $parameter->getType()->getName()
                : null;

            if ($dependencyClass) {
                $dependencies[] = $this->make($dependencyClass);
            } else {
                // Nếu không có class hoặc là scalar value, thêm null (hoặc giá trị mặc định nếu có)
                $dependencies[] = $parameter->isDefaultValueAvailable()
                    ? $parameter->getDefaultValue()
                    : null;
            }
        }


        // Khởi tạo class với các dependencies
        return $reflector->newInstanceArgs($dependencies);
    }
}
