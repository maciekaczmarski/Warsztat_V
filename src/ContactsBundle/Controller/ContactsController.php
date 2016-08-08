<?php

namespace ContactsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ContactsBundle\Entity\Person;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ContactsBundle\Entity\Address;
use ContactsBundle\Entity\Email;
use ContactsBundle\Entity\Phone;
use ContactsBundle\Entity\Groups;

class ContactsController extends Controller
{
 

    /**
     * @Route("/find")
     * @Template("ContactsBundle:Contacts:showFound.html.twig")
     * @Method({"POST"})
     */
    
    public function FindPersonByNameAction(Request $req){

        $form = $this->createFindForm();
        $form->handleRequest($req);
        $name = $form['name']->getData();
//        var_dump($name);
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $persons = $repo->findPersonByName($name);
                
        return ["allPersons" => $persons];
    }
    
     /**
     * @Route("/find")
     * @Template("ContactsBundle:Contacts:findForm.html.twig")
     * @Method ({"GET"})
     */
    public function findPersonAction(){
    
        $form = $this->createFindForm();
        return array("form" => $form->createView()); 
    }

    
    /**
     * @Route("/modifyPhone/{id}/{phoneId}")
     * @Template ("ContactsBundle:Contacts:addPhone.html.twig")
     * @Method({"GET"})
     */
    
    public function editPhoneAction($id, $phoneId) {
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Phone");
        $phone = $repository->find($phoneId);
        $form = $this->createPhoneForm($phone);
        
        return ["form" => $form->createView()];
    }
    
    /**
     * @Route("/modifyPhone/{id}/{phoneId}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function getEditedPhoneDataAction(Request $req, $id, $phoneId){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Phone");
        $phone = $repo->find($phoneId);
        $form = $this->createPhoneForm($phone);
        $form->handleRequest($req);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return ["person" => $person];
    }
    
    /**
     * @Route("/deletePhone/{id}/{phoneId}")
     */
    
    public function deletePhoneAction($id, $phoneId){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Phone");
        $phone = $repo->find($phoneId);
        
        $person->removePhone($phone);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();
        
        return $this->redirectToRoute('contacts_contacts_showperson', ["id" => $id]);
    }
    
    /**
     * @Route ("/modifyEmail/{id}/{emailId}")
     * @Template("ContactsBundle:Contacts:addEmail.html.twig")
     * @Method({"GET"})
     */
    
    public function editEmailAction($id, $emailId){
    
            $repository = $this->getDoctrine()->getRepository("ContactsBundle:Email");
            $email = $repository->find($emailId);
            $form = $this->createEmailForm($email);
            
            return ["form" => $form->createView()];
    
    }
    
    /**
     * @Route("/modifyEmail/{id}/{emailId}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function getEditedEmailDAtaAction(Request $req, $id, $emailId){
    
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repo->find($id);
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Email");
        $email = $repository->find($emailId);
        $form = $this->createEmailForm($email);
        $form->handleRequest($req);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return ["person" => $person];
    }
    
    /**
     * @Route("/deleteEmail/{id}/{emailId}")
     */
    
    public function deleteEmailAction($id, $emailId){
        
        $repostory = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repostory->find($id);
        
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Email");
        $email = $repo->find($emailId);
        
        $person->removeEmail($email);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        
        return $this->redirectToRoute('contacts_contacts_showperson', ["id" => $id]);
    }
    
    /**
     * @Route("/modifyAddress/{id}/{addressId}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function getEditedAddressDataAction(Request $req, $addressId, $id){
        
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repo->find($id);
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Address");
        $address = $repository->find($addressId);
        $form = $this->createAddressForm($address);
        $form->handleRequest($req);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return ["person" => $person];
    }
    
    /**
     * 
     * @Route ("/modifyAddress/{id}/{addressId}")
     * @Template("ContactsBundle:Contacts:addAddress.html.twig")
     * @Method({"GET"})
     * 
     */
    
    public function editAddressAction($addressId){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Address");
        $address = $repository->find($addressId);
        $form = $this->createAddressForm($address);
        
        return ["form" => $form->createView()];

    }
    
    
    /**
     * @Route("/deleteAddress/{id}/{addressId}")
     * 
     */
    
    public function deleteAddressAction($id, $addressId){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        $repo = $this->getDoctrine()->getRepository("ContactsBundle:Address");
        $address = $repo->find($addressId);
                  
        $person->removeAddress($address);
        
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($address);
        $em->flush();

        
        return $this->redirectToRoute('contacts_contacts_showperson', ["id" => $id]);  
    }
    
    /**
     * @Route("/addPhone/{id}")
     * @Method({"GET"})
     * @Template("ContactsBundle:Contacts:addPhone.html.twig")
     */
    
    public function addPhoneAction($id){
        
        $newPhone = new Phone();
        $form = $this->createPhoneForm($newPhone);
        
        return ["form" => $form->createView()];
    }
    
    /**
     * @Route ("/addPhone/{id}")
     * @Method ({"POST"})
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     */
    
    public function getNewPhoneDataAction($id, Request $req){
        
        $newPhone = new Phone();
        $form = $this->createPhoneForm($newPhone);
        $form->handleRequest($req);
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        $newPhone->setPerson($person);
        $person->addPhone($newPhone);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newPhone);
        $em->flush();
        
        return ["person" => $person];
    }
    
    /**
     * @Route("/addEmail/{id}")
     * @Method({"GET"})
     * @Template("ContactsBundle:Contacts:addEmail.html.twig")
     */
    
    public function addEmialAction($id){
        
        $newEmail = new Email();
        $form = $this->createEmailForm($newEmail);
        
        return ["form" => $form->createView()];
    }
    
    /**
     * @Route("/addEmail/{id}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function  getNewEmailDataAction(Request $req, $id){
        
        $newEmail = new Email();
        $form = $this->createEmailForm($newEmail);
        $form->handleRequest($req);
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        $newEmail->setPerson($person);
        $person->addEmail($newEmail);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newEmail);
        $em->flush();
        
        return ["person" => $person];
    }    
    /**
     * @Route("addAddress/{id}")
     * @Method({"GET"})
     * @Template("ContactsBundle:Contacts:addAddress.html.twig")
     */
    
    public function addAddressAction(){
    
        $newAddress = new Address();
        $form = $this->createAddressForm($newAddress);
        
        return ["form" => $form->createView()];
    }
    
     /**
     * @Route("addAddress/{id}")
     * @Method({"POST"})
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     */
    

    public function getNewAddressDataAction($id, Request $req){
        
        $newAddress = new Address();
        $form = $this->createAddressForm($newAddress);
        $form->handleRequest($req);
        
        //
        $repostitory = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repostitory->find($id);
        
        $newAddress->setPerson($person);
        $person->addAddress($newAddress);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newAddress);
        $em->flush();
           
        return ["person" => $person];
    }
    
    
    
    /**
     * @Route("show/{id}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     */
    public function showPersonAction($id){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        return ["person" => $person];
    }
    
    
    /**
     * @Route("/showAll")
     * @Template("ContactsBundle:Contacts:showAll.html.twig")
     */
    
    public function showAllAction(){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $allPersons = $repository->findAllByName();
        
        return ['allPersons' => $allPersons];
    }
    
    /**
     * @Route("delete/{id}")
     * 
     */
    
    public function deletePersonAction($id){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();
        
        return $this->redirectToRoute('contacts_contacts_showall');
     
    }
   
    /**
     * @Route("/modify/{id}")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function getEditedDataAction(Request $req, $id){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        $form = $this->createPersonForm($person);
        $form->handleRequest($req);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        
        return ["person" => $person];
    }
    
    /**
     * 
     * @Route ("/modify/{id}")
     * @Template("ContactsBundle:Contacts:newPerson.html.twig")
     * @Method({"GET"})
     * 
     */
    
    public function editPersonAction($id){
        
        $repository = $this->getDoctrine()->getRepository("ContactsBundle:Person");
        $person = $repository->find($id);
        $form = $this->createPersonForm($person);
        
        return ["form" => $form->createView()];

    }
    
    
    /**
     * @Route ("/new")
     * @Template("ContactsBundle:Contacts:showPerson.html.twig")
     * @Method({"POST"})
     */
    
    public function receivedPersonDataAction(Request $req){
        
        $newPerson = new Person();
        $form = $this->createPersonForm($newPerson);
        $form->handleRequest($req);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newPerson);
        $em->flush();
           
        return ["person" => $newPerson];
        
    }
    
    /**
     * @Route ("/new")
     * @Template("ContactsBundle:Contacts:newPerson.html.twig")
     * @Method ({"GET"})
     */
    
    public function newPersonAction(){
        
        $newPerson = new Person();
        $form = $this->createPersonForm($newPerson);
        
        return ["form" => $form->createView()];
        
    }
    
    private function createPersonForm(Person $person){
        return $this->createFormBuilder($person)
                ->add("name", "text", ["required" => true, "label" => "Name: "])
                ->add("surname", "text", ["label" => "Surname: "])
                ->add("description", "text", ["label" => "Description: "])
                ->add("send", "submit")
                ->getForm();
    }
    
    private function createAddressForm(Address $address){
        return $this->createFormBuilder($address)
                ->add("city", "text")
                ->add("street", "text")
                ->add("str_number", "integer")
                ->add("house_number", "integer", ["required" => false])
                ->add("send", "submit")
                ->getForm();
    }
    
    private function createEmailForm(Email $email){
        return $this->createFormBuilder($email)
                ->add("main_email","text", ["required" => false])
                ->add("work_email","text", ["required" => false])                
                ->add("second_email","text", ["required" => false])    
                ->add("send", "submit")
                ->getForm();
                
    }
    
    private function createPhoneForm (Phone $phone){
        return $this->createFormBuilder($phone)
                ->add("home", "text", ["required" => false, "label" => "home number: "])
                ->add("mobile", "text", ["required" => false, "label" => "mobile number: "])
                ->add("work", "text", ["required" => false, "label" => "work number: "])
                ->add("send", "submit")
                ->getForm();
    }
    
    private function createFindForm() {
        return $this->createFormBuilder()
                ->add("name", "text", ["label"=> "Name: "])
                ->add("find", "submit")
                ->getForm();
    }
}
