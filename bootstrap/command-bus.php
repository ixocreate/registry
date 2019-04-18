<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Registry;

use Ixocreate\Package\Registry\Command\UpdateCommand;

/** @var \Ixocreate\Package\CommandBus\Configurator $commandBus */
$commandBus->addCommand(UpdateCommand::class);
