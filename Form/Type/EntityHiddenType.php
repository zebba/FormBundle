<?php

namespace Zebba\Bundle\FormBundle\Form\Type;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Zebba\Bundle\FormBundle\Form\DataTransformer\EntityToIdTransformer;

class EntityHiddenType extends AbstractType
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $om = $this->registry->getManagerForClass($options['class']);

        if (! $om) { throw new \InvalidArgumentException(sprintf('Unable to retrieve ObjectManager instance for class \'%s\'', $options['class'])); }

        $transformer = new EntityToIdTransformer($om, $options['class']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array('class'))
            ->setDefaults(array(
                'invalid_message' => 'The entity does not exist.',
            ))
        ;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'entity_hidden';
    }
}