<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Registry\Package\Template;

use Ixocreate\Registry\Package\RegistryInterface;
use Ixocreate\Template\Package\ExtensionInterface;
use Ixocreate\Registry\Package\Registry;

final class RegistryExtension implements ExtensionInterface
{
    /**
     * @var Registry
     */
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'registry';
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __invoke($name)
    {
        if ($this->registry->has($name)) {
            return $this->registry->get($name);
        }
        return null;
    }
}
