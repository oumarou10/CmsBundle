<?php
/**
 * Created by PhpStorm.
 * User: oumarucho
 * Date: 23/07/2017
 * Time: 19:50
 */

namespace OC\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('OCCmsBundle:Cms:index.html.twig');
    }
}