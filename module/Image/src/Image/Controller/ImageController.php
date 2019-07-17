<?php
namespace Image\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Image\Entity\Image;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator;

class ImageController extends CrudController{
    public function __construct(){
        $this->title        = $this->translate("Galeria de Imagens");
        $this->table        = 'Image';
        $this->entity       = 'Image\Entity\\'.$this->table ;
        $this->service      = 'Image\Service\\'.$this->table ;
        $this->form         = 'Image\Form\\'.$this->table ;
        $this->controller   = "Image";
        $this->route        = "image/defaults";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-file-picture-o',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => false,
                        'authorize' => true,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit'
                    ),
                    'delete' => array(
                        'enable' => false,
                        'authorize' => false,
                        'class' => 'btn btn-danger decision',
                        'icon' => 'fa fa-trash'
                    ),
                    'view' => array(
                        'enable' => false,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-eye'
                    ),
                ),
            ),
            'fields' => array(
                'id'=>array(
                    'label' => $this->translate('Id'),
                    'list' => true,
                ),
                'title'=>array(
                    'label' => $this->translate('Título'),
                    'list' => true,
                ),
                'image'=>array(
                    'label' => $this->translate('Imagem'),
                    'list' => true,
                )
            ),
        );
    }

    function camel2dashed($className) {
        return strtolower(preg_replace('/([^A-Z-])([A-Z])/', '$1-$2', $className));
    }

    public function recortarAction(){
        $croppedImage = $_FILES['croppedImage'];
        $to_be_upload = $croppedImage['tmp_name'];
        $extension = explode('/',$croppedImage['type']);
        $extension = $extension[count($extension) -1];
        $bytes = openssl_random_pseudo_bytes(32);
        $random_name = str_replace('/','',base64_encode($bytes));
        $new_file = '/uploads/'.$random_name.'.'.$extension;
        $image_name = $random_name . '.' . $extension;
        move_uploaded_file($to_be_upload,'public'.$new_file);
        echo json_encode(array('image' => $new_file,'image_name' => $image_name));
        exit();
    }

    public function recortarGalleryAction(){
        $croppedImage = $_FILES['croppedImage'];
        $to_be_upload = $croppedImage['tmp_name'];
        $extension = explode('/',$croppedImage['type']);
        $extension = $extension[count($extension) -1];
        $time = date('Y-m-d-h-i-s');
        $new_file = '/img/images/cropped-image_'.$time.'.'.$extension;
        $image_name = 'cropped-image_'.$time.'.'.$extension;
        move_uploaded_file($to_be_upload,'public'.$new_file);
        echo json_encode(array('image' => $new_file,'image_name' => $image_name));
        exit();
    }

    public function newCustomAction(){

        $request = $this->getRequest();

        if($request->isPost()) {
            $post = $request->getPost()->toArray();
            $post['reference'] = $this->camel2dashed($post['reference']);

            /**
             * @var \Image\Service\Image $service
             */
            $service = $this->getServiceLocator()->get($this->service);
            $image = $service->insert($post);

            if($image instanceof Image){
                $this->flashMessenger()->addSuccessMessage("Imagem cadastrada com sucesso!");
            }else{
                $this->flashMessenger()->addErrorMessage("Houve um erro ao cadastrar a imagem!");
            }

            try{
                if($post['reference'] != 'image') {
                    $url = $this->redirect()->toRoute($post['reference'] . '/defaults', array(
                        'controller' => $post['reference'],
                        'action' => 'images',
                        'id' => $post['reference_id']
                    ));
                }else{
                    $url = $this->redirect()->toRoute('gallery');
                }
            }catch (\Exception $e)
            {
                try{
                    if($post['reference'] == 'image') {
                        $url = $this->redirect()->toRoute($post['reference'] . '/default', array(
                            'controller' => $post['reference'],
                            'action' => 'images',
                            'id' => $post['reference_id']
                        ));
                    }else{
                        $url = $this->redirect()->toRoute('gallery');
                    }
                }catch (\Exception $e) {
                    $url = $this->redirect()->toRoute('gallery');
                }
            }

            return $url;
        }
    }

    public function galleryAction()
    {
        $allowed = $this->isAllow('Captura de Tela','Visualizar');

        if($allowed){
            return new ViewModel(array(
                'em' => $this->getEm(),
                'controller' => 'image',
                'entity' => $this->entity
            ));
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }

    }

    public function imagesAction()
    {
        $url = $this->redirect()->toRoute('gallery');
    }

    public function deletarAction(){
        /**
         * @var BaseFunctions $functions
         */
        $functions = new BaseFunctions();
        $em = $this->getEm();
        $request = $this->getRequest();

        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            $findMethod = 'findOneBy' . $functions->toCamelCase($data['field'], true);
            $getMethod = 'get' . $functions->toCamelCase($data['field'], true);
            $setMethod = 'set' . $functions->toCamelCase($data['field'], true);

            $remove_result = unlink('public/img/uploads/' . $data['img']);
            if($remove_result) {

                $entity = $em->getRepository($data['entity'])->$findMethod($data['img']);

                if ($entity) {
                    $entity->$setMethod('');
                    $em->persist($entity);
                    $em->flush();
                }

                echo json_encode(array('result' => true));
                die;
            }else{
                echo json_encode(array('result' => false));
                die;
            }
        }
    }
}

?>
