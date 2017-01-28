<?php
namespace FrontendBundle\Controller;

use CoreBundle\Message\Message;
use FrontendBundle\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as A;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends NavigatorController
{

    /**
     * @A\Route("/registration", name="frontendRegistrationShowForm")
     */
    public function showFormAction(Request $request)
    {
        return $this->renderRegistrationForm($this->getRegistrationForm());
    }

    /**
     * @param Form $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderRegistrationForm(Form $form)
    {
        return $this->render('@Frontend/Registration/registration.form.html.twig', ['registrationForm' => $form->createView()]);
    }

    private function getRegistrationForm()
    {
        return $this->createForm(RegistrationFormType::class);
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

}