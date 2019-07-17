<?php
namespace Image\Service;

use Base\Controller\BaseFunctions;
use Base\Mail\Mail;
use Base\Service\AbstractService;

use Image\Entity\CategoryImage;
use Image\Entity\ReferenceImage;
use Zend\Mail\Transport\Smtp as SmtpTransport;

class Image extends AbstractService{
    protected $em;
    protected $transport;
    protected $view;
    protected $configurationMail;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Image\Entity\Image';
        $this->setEm($em);
    }

    public function insert(array $data)
    {
        $em = $this->getEm();
        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();
        
        if(isset($data['user'])){
            $user = $em->getRepository('Register\Entity\User')->findOneById($data['user']);
            if($user)
            {
                $data['user'] = $user;
            }else{
                $data['user'] = null;
            }
        }

        if(isset($data['reference']) && $data['reference'] != '')
        {
            $reference = $em->getRepository('Image\Entity\ReferenceImage')->findOneByName($data['reference']);
            if(!$reference){
                $reference = new ReferenceImage();
                $reference->setChave($data['reference']);
                $reference->setName($data['reference']);

                $em->persist($reference);
                $em->flush();
            }

            $data['referenceImage'] = $reference;
        }else{
            $data['referenceImage'] = null;
        }

        if(isset($data['category']) && $data['category'] != -1 && is_numeric($data['category']))
        {
            $category = $em->getRepository('Image\Entity\CategoryImage')->findOneById($data['category']);

            $data['categoryImage'] = $category;
        }else if(isset($data['category']) && $data['category'] != -1){
            /**
             * @var CategoryImage $category
             */
            $name_category = json_decode($data['category'],true);
            if(!empty($name_category)){
                $name_category = $name_category['name'];
            }else{
                $name_category = $data['category'];
            }

            $category = $em->getRepository('Image\Entity\CategoryImage')->findOneByName($name_category);

            if(!$category)
            {
                $category = new CategoryImage();
                $category->setName($data['category']);
                $category->setChave($functions->strToFriendlyUrl($name_category));

                $em->persist($category);
                $em->flush();
            }

            $data['categoryImage'] = $category;
        }else{
            $data['categoryImage'] = null;
        }

        if($data['featured']){
            $obj_images = $em->getRepository('Image\Entity\Image')->findAll();
            if(!empty($obj_images))
            {
                foreach($obj_images as $obj_image){
                    $obj_image->setFeatured(0);
                    $em->persist($obj_image);
                    $em->flush();
                }
            }
        }

        $image = parent::insert($data);
        
        /**
         * @var \Register\Entity\Image[] $obj_images
         */
        $obj_images = $em->getRepository('Image\Entity\Image')->findAll();
        $images = array();
        if(!empty($obj_images))
        {
            foreach($obj_images as $obj_image){
                $images[] = $obj_image->getImage();
            }
        }

        $types = array( 'png', 'jpg', 'jpeg', 'gif', 'tmp' );
        $path = 'public/img/images/';
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            $ext = strtolower( $fileInfo->getExtension() );
            if(in_array( $ext, $types ))
            {
                if(!in_array($fileInfo->getFilename(),$images)){
                    unlink($path.$fileInfo->getFilename());
                }

            }
        }

        if($user) {
            $images = $em->getRepository('Image\Entity\Image')->findByUser($user);
            if(!empty($images))
            {
                foreach ($images as $image) {
                    if(!file_exists('public/img/images/'.$image->getImage())){
                        $em->remove($image);
                        $em->flush();
                    }
                }
            }
        }

        $categories = $em->getRepository('Image\Entity\CategoryImage')->findByUser($user);
        if(!empty($categories)){
            foreach($categories as $category){
                $images = $em->getRepository('Image\Entity\Image')->findByCategoryImage($category->getId());
                if(empty($images))
                {
                    $em->remove($category);
                    $em->flush();
                }
            }
        }

        return $image;
    }

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

}

?>
