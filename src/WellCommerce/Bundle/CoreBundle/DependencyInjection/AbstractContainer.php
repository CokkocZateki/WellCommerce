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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AbstractContainer
 *
 * @package WellCommerce\Bundle\CoreBundle\DependencyInjection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractContainer extends ContainerAware
{
    /**
     * Returns true if the service id is defined.
     *
     * @param string $id The service id
     *
     * @return bool true if the service id is defined, false otherwise
     */
    final protected function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Gets a service by id.
     *
     * @param string $id The service id
     *
     * @return object Service
     */
    final protected function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * Returns translation service
     *
     * @return \Symfony\Component\Translation\Translator
     */
    public function getTranslator()
    {
        return $this->container->get('translator.default');
    }

    /**
     * Translates a string using the translation service
     *
     * @param string $id Message to translate
     *
     * @return string The message
     */
    protected function trans($id, $params = [], $domain = 'admin')
    {
        return $this->getTranslator()->trans($id, $params, $domain);
    }

    /**
     * Shortcut to return the session service
     *
     * @return object Session service
     */
    final protected function getSession()
    {
        return $this->container->get('session');
    }

    /**
     * Shortcut to return the session flashbag
     *
     * @return object FlashBag from session service
     */
    final protected function getFlashBag()
    {
        return $this->container->get('session')->getFlashBag();
    }

    /**
     * Shortcut to return the router service
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    final protected function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * Shortcut to return the request service
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    final protected function getRequest()
    {
        return $this->get('request_stack')->getCurrentRequest();
    }

    /**
     * Shortcut to return event dispatcher service
     *
     * @return object Event dispatcher service
     */
    final protected function getDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * Shortcut to get param from current route
     *
     * @param string $index
     *
     * @return mixed
     */
    final protected function getParam($index)
    {
        return $this->container->get('request')->attributes->get($index);
    }

    /**
     * Shortcut to get Helper service
     *
     * @return object Helper
     */
    final protected function getHelper()
    {
        return $this->container->get('helper');
    }

    /**
     * Shortcut to get PropertyAccessor
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    final protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * Shortcut to get LayoutManager service
     *
     * @return object LayoutManager
     */
    final public function getLayoutManager()
    {
        return $this->container->get('layout_manager');
    }

    /**
     * Shortcut to get LayoutRenderer service
     *
     * @return object LayoutRenderer
     */
    final public function getLayoutRenderer()
    {
        return $this->container->get('layout_renderer');
    }

    /**
     * Shortcut to get Cache service
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    final protected function getCache()
    {
        return $this->container->get('cache');
    }

    /**
     * Shortcut to get Uploader service
     *
     * @return object
     */
    final protected function getUploader()
    {
        return $this->container->get('media.uploader');
    }

    /**
     * Shortcut to get ImageGallery service
     *
     * @return \WellCommerce\FileManager\Uploader\ImageGallery
     */
    final protected function getImageGallery()
    {
        return $this->container->get('file_manager.gallery.image');
    }

    /**
     * Generates relative or absolute url based on given route and parameters
     *
     * @param string $route
     * @param array  $parameters
     * @param string $referenceType
     *
     * @return string Generated url
     */
    public function generateUrl($route, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     */
    public function getDoctrine()
    {
        return $this->get('doctrine');
    }

    /**
     * Shortcut for getting default entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    /**
     * Returns current locale
     *
     * @return mixed
     */
    public function getCurrentLocale()
    {
        $request = $this->get('request');

        return $request->getLocale();
    }

    /**
     * Returns validator object
     *
     * @return \Symfony\Component\Validator\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->container->get('validator');
    }

    /**
     * Returns themes directory path
     * If theme folder name is passed, full directory path pointing to it will be returned
     *
     * @param string $themeFolder
     *
     * @return string
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    final protected function getThemeDir($themeFolder = '')
    {
        $kernelDir = $this->get('kernel')->getRootDir();
        $webDir    = $kernelDir . '/../web';

        if (strlen($themeFolder)) {
            $dir = $webDir . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $themeFolder;
        } else {
            $dir = $webDir . DIRECTORY_SEPARATOR . 'themes';
        }

        if (!is_dir($dir)) {
            throw new FileException(sprintf('Directory "%s" not found.', $dir));
        }

        return $dir;
    }

}