<?php

namespace App\Form\Filter;

use App\Entity\Product;
use App\Entity\Sales;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\FilterType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Persisters\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ProductFilterType extends FilterType
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $productRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->productRepository = $entityManager->getRepository(Product::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $products = $this->productRepository->findAll();

        foreach ($products as $prod) {
            $result[] = array($prod->getProductname() => $prod->getProductname());
        }

        $resolver->setDefaults([
            'choices' => $result,
        ]);
    }

    /**
     * @return string|null
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @param QueryBuilder $queryBuilder The list QueryBuilder instance
     * @param FormInterface $form The form filter instance
     * @param array $metadata The configured filter options
     *
     * @return void|false Returns false if the filter wasn't applied
     */
    public function filter(QueryBuilder $queryBuilder, FormInterface $form, array $metadata)
    {
        if (null !== $form->getData()) {
            // use $metadata['property'] to make this query generic
            $queryBuilder->andWhere('entity.product = :product')
                ->setParameter('product', $form->getData());
        }
    }
}