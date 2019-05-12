<?php
/**
 * Created by PhpStorm.
 * User: Borja
 * Date: 31/12/2018
 * Time: 19:06
 */

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;

abstract class BaseController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * BaseController constructor.
     * @param EntityManagerInterface $em
     * @param AdapterInterface $cache
     */public function __construct(EntityManagerInterface $em, AdapterInterface $cache)
    {
        $this->em = $em;
        $this->cache = $cache;
    }

}