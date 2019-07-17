<?php

namespace Base\View\Helper;

use Base\Controller\BaseFunctions;
use User\Entity\User;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class GetFile extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    public function __invoke($controller,$campo,$id_entity = null) {
        if($id_entity == null){
            return false;
        }
        $helperPluginManager = $this->getServiceLocator();
        // the second one gives access to... other things.
        $serviceManager = $helperPluginManager->getServiceLocator();
        $this->setEm($serviceManager->get('Doctrine\ORM\EntityManager'));

        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();
        $controller = $functions->camel2dashed($controller);

        switch($controller){
            case 'user':
                $entity = $this->getEm()->getRepository('Register\Entity\User')->findOneById($id_entity);
                if(method_exists($entity,'getImage')){
                    $file = $entity->getImage();
                    $file = 'img/'.$controller.'/'.$file;
                }else if(method_exists($entity,'getFile')){
                    $file = $entity->getFile();
                    $file = 'file/'.$controller.'/'.$file;
                }else{
                    echo "PROBLEMA NO ARQUIVO GETFILE";
                    die;
                }
                break;
            case 'banner':
                $entity = $this->getEm()->getRepository('Banner\Entity\Banner')->findOneById($id_entity);
                if(method_exists($entity,'getImage')){
                    $file = $entity->getImage();
                    $file = 'img/'.$controller.'/'.$file;
                }else if(method_exists($entity,'getFile')){
                    $file = $entity->getFile();
                    $file = 'file/'.$controller.'/'.$file;
                }else{
                    echo "PROBLEMA NO ARQUIVO GETFILE";
                    die;
                }
                break;
            case 'testimony':
                $entity = $this->getEm()->getRepository('Site\Entity\Testimony')->findOneById($id_entity);
                if(method_exists($entity,'getImage')){
                    $file = $entity->getImage();
                    $file = 'img/'.$controller.'/'.$file;
                }else if(method_exists($entity,'getFile')){
                    $file = $entity->getFile();
                    $file = 'file/'.$controller.'/'.$file;
                }else{
                    echo "PROBLEMA NO ARQUIVO GETFILE";
                    die;
                }
                break;
            default:
                $entity = $this->getEm()->getRepository('Image\Entity\\'.$controller)->findOneById($id_entity);
                if(method_exists($entity,'getImage')){
                    $file = $entity->getImage();
                    $file = 'img/'.$controller.'/'.$file;
                }else if(method_exists($entity,'getFile')){
                    $file = $entity->getFile();
                    $file = 'file/'.$controller.'/'.$file;
                }else{
                    echo "PROBLEMA NO ARQUIVO GETFILE";
                    die;
                }
        }

        if (file_exists('public/' . $file)) {
            return '/' . $file;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}

?>
