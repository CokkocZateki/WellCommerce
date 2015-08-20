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

namespace WellCommerce\Bundle\ProductBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShowcaseBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductStatusManager
     */
    protected $manager;
    
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $provider          = $this->manager->getProvider('product');
        $collectionBuilder = $provider->getCollectionBuilder();
        $requestHelper     = $this->manager->getRequestHelper();

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => $requestHelper->getQueryAttribute('limit', 1),
            'order_by'   => $requestHelper->getQueryAttribute('order_by', 'name'),
            'order_dir'  => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions' => $this->manager->getStatusConditions($boxSettings->getParam('status')),
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $dataset
        ]);
    }
}
