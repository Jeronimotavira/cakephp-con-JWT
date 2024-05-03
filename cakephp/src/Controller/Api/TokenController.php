<?php
declare(strict_types=1);

namespace App\Controller\Api;
use App\Controller\AppController;
use Firebase\JWT\JWT;

class TokenController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event){
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function index()
    {
        $result = $this->Authentication->getResult();
        if($result->isValid()){
            $user = $result->getData();
        }else{
            $this->response = $this->response->withStatus(401);
            $user = [
                'message' => 'invalid user'
            ];
        }

        $this->set('user', $user);
        $this->viewBuilder()->setClassName("Json");
        $this->viewBuilder()->setOption('serialize', 'users');
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
            ];
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
        }
   
        $this->viewBuilder()->setClassName("Json");
        $this->set('json', $json);
        $this->viewBuilder()->setOption('serialize', ['json']);
       
    }

}
