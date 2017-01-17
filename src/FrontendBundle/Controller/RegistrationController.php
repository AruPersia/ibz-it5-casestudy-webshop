<?php
namespace FrontendBundle\Controller;

use CoreBundle\Message\Message;
use FrontendBundle\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class RegistrationController extends NavigatorController
{

    /**
     * @A\Route("/registration", name="frontendRegistrationShowForm")
     */
    public function showFormAction(Request $request)
    {

        $customer = $this->get('doctrine.orm.entity_manager')->getReference('CoreBundle:CustomerEntity', 1);

        $token = new UsernamePasswordToken($customer, $customer->getPassword(), 'public', $customer->getRoles());

        $this->get('security.token_storage')->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        return $this->redirectToRoute('frontendShowAllRootCategories');
        //return $this->renderRegistrationForm($this->getRegistrationForm());
    }

    /**
     * @A\Route("/registration/submit", name="frontendRegistrationSubmitForm")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function submitFormAction(Request $request)
    {
        $registrationForm = $this->getRegistrationForm()->handleRequest($request);
        if ($registrationForm->isValid()) {
            $this->getRegistrationService()->register($registrationForm->getData());
            $this->addMessage(Message::success('registration.successful', 'thanks.for.your.registration'));
            return $this->render('@Frontend/base.html.twig');
        }

        return $this->renderRegistrationForm($registrationForm);
    }

    private function getRegistrationForm()
    {
        return $this->createForm(RegistrationFormType::class);
    }

    /**
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderRegistrationForm(Form $form)
    {
        return $this->render('@Frontend/Registration/registration.form.html.twig', ['registrationForm' => $form->createView()]);
    }

}