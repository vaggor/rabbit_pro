<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;


class SettingsController extends AppController{

	public function packageItems(){
		$packageItemsTb = TableRegistry::get('PackageItems');
		$packagesTb = TableRegistry::get('Packages');
		$data = $packageItemsTb->getPackageItems();
		$list_packages = $packagesTb->listPackages();
		$this->set(compact('data','list_packages'));
	}


	public function addPackageItem()
    {
    	$packagesTb = TableRegistry::get('Packages');
    	$packageItemsTb = TableRegistry::get('PackageItems');
        $data = $packageItemsTb->newEntity();
        if ($this->request->is('post')) {
            $data = $packageItemsTb->patchEntity($data, $this->request->getData());
            if ($packageItemsTb->save($data)) {
                $this->Flash->success(__('Package Item has been saved.'));

                return $this->redirect(['action' => 'packageItems']);
            }
            $this->Flash->error(__('Package Item could not be saved. Please, try again.'));
        }
        $list_packages = $packagesTb->listPackages();
        $this->set(compact('list_packages','data'));
    }

    

    public function editPackageItem($id = null)
    {
    	$packagesTb = TableRegistry::get('Packages');
    	$packageItemsTb = TableRegistry::get('PackageItems');

        //$data = $packageItemsTb->get($id, ['contain' => [],]);

        if ($this->request->is(['patch', 'post', 'put'])) {
        	$data = $packageItemsTb->get($this->request->data['id'], ['contain' => [],]);
            $data = $packageItemsTb->patchEntity($data, $this->request->getData());
            //print_r($data);exit;
            if ($packageItemsTb->save($data)) {
                $this->Flash->success(__('Package List has been saved.'));

                return $this->redirect(['action' => 'packageItems']);
            }
            $this->Flash->error(__('Package List could not be saved. Please, try again.'));
        }
        $list_packages = $packagesTb->listPackages();
        $this->set(compact('data', 'list_packages'));
    }

   

    public function deletePackageItem($id = null)
    {
    	$packageItemsTb = TableRegistry::get('PackageItems');
        $this->request->allowMethod(['post', 'delete']);
        if ($packageItemsTb->deletePackageItem($id)) {
            $this->Flash->success(__('Package Item has been deleted.'));
        } else {
            $this->Flash->error(__('Package Item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'packageItems']);
    }
}

?>