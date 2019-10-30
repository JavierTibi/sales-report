<?php

namespace App\Controller;

use App\Form\Filter\ProductFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Form\FormInterface;

class SalesController extends EasyAdminController
{

    /**
     * @param string $entityName
     * @return FormInterface
     */
    protected function createFiltersForm(string $entityName): FormInterface
    {
        $form = parent::createFiltersForm($entityName);
        $form->add('product', ProductFilterType::class, []);

        return $form;
    }
}