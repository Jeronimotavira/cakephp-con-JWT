<?php
declare(strict_types=1);

namespace App\Controller\Api;
use App\Controller\AppController;
use Firebase\JWT\JWT;
use Cake\View\JsonView;
use Cake\View\XmlView;

class TokenController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Json');
    
        
    }
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function index()
    {
       // $this->viewBuilder()->setClassName("Json");

        $user = 'hola mundo';

        $this->set('user', $user);
        $this->viewBuilder()->setOption('serialize', 'user');
    }

    public function login()
    {
         $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user = $result->getData();
            $payload = [
            //   'iss' => 'myapp',
                'sub' => $user->id,
                'exp' => time() + 60,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
                'data' => $result->getData(),
            ]; 
          // $json = $result->getData();
           // $json = $this->request->getData();
        } else {
            $this->response = $this->response->withStatus(401);
            $json = $this->request->getData();
        }
   
       // $this->viewBuilder()->setClassName("Json");
        $this->set('json', $json);
        $this->viewBuilder()->setOption('serialize', ['json']);
       
    }
    public function hey()
    {
       // $this->viewBuilder()->setClassName("Json");
       
        $user = 'hola mundo';

        $this->set('user', $user);
        $this->viewBuilder()->setOption('serialize', 'user');
    }

}
