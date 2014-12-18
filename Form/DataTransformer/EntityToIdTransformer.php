<?php

namespace Zebba\Bundle\FormBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var string
     */
    private $class;

    /**
     * @param ObjectManager $objectManager
     * @param $class
     */
    public function __construct(ObjectManager $objectManager, $class)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
    }

    /**
     * @param $entity
     * @return null
     */
    public function transform($entity)
    {
        if (null === $entity) { return null; }

        return $entity->getId();
    }

    /**
     * @param $id
     * @return null|object
     */
    public function reverseTransform($id)
    {
        if (! $id) { return null; }

        $entity = $this->objectManager
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) { throw new TransformationFailedException(); }

        return $entity;
    }
}