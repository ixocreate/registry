<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Registry\Command;

use Doctrine\ORM\EntityManagerInterface;
use Ixocreate\CommandBus\Command\AbstractCommand;
use Ixocreate\CommandBus\CommandInterface;
use Ixocreate\Entity\Type\Type;
use Ixocreate\Registry\Entity\Registry;
use Ixocreate\Registry\RegistrySubManager;
use Ixocreate\Registry\Repository\RegistryRepository;
use Ixocreate\Schema\Builder;
use Ixocreate\Type\Entity\SchemaType;

final class UpdateCommand extends AbstractCommand implements CommandInterface
{
    /**
     * @var RegistryRepository
     */
    private $registryRepository;

    /**
     * @var RegistrySubManager
     */
    private $registrySubManager;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ChangeAttributesCommand constructor.
     *
     * @param RegistryRepository $registryRepository
     * @param RegistrySubManager $registrySubManager
     * @param Builder $builder
     * @param EntityManagerInterface $master
     */
    public function __construct(
        RegistryRepository $registryRepository,
        RegistrySubManager $registrySubManager,
        Builder $builder,
        EntityManagerInterface $master
    ) {
        $this->registryRepository = $registryRepository;
        $this->registrySubManager = $registrySubManager;
        $this->builder = $builder;
        $this->entityManager = $master;
    }

    /**
     * @return string
     */
    public static function serviceName(): string
    {
        return 'admin.registry-update';
    }

    public function execute(): bool
    {
        $data = $this->data();
        $id = $data['id'];

        /** @var SchemaType $type */
        $type = Type::create($data['data'], SchemaType::class, [
            'provider' => ['class' => RegistrySubManager::class, 'name' => $id],
        ]);

        $entity = new Registry([
            'id' => $id,
            'value' => $type,
            'createdAt' => new \DateTime(),
            'updatedAt' => new \DateTime(),
        ]);

        /** @var Registry $registry */
        $registry = $this->registryRepository->find($id);

        if ($registry !== null) {
            $entity = $registry->with('value', $type);
            $entity = $entity->with('updatedAt', new \DateTime());
        }

        $this->registryRepository->save($entity);

        return true;
    }
}