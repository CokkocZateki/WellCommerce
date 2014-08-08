<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CompanyBundle\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class CompanyController
 *
 * @package WellCommerce\Bundle\CompanyBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class CompanyController extends AbstractAdminController
{
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('company.datagrid'))
        ];
    }

    public function addAction()
    {
        $entity = new Company();
        $entity->setName(11111);
        $this->em->persist($entity);
        $this->em->flush();

        return [];
    }

    /**
     * @ParamConverter("company", class="WellCommerceCompanyBundle:Company")
     */
    public function editAction(Company $company)
    {
    }
}
