<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\Form;

class InvalidFormException extends \Exception
{
    private $form;

    public function __construct(Form $form, \Exception $exception = null)
    {
        parent::__construct(sprintf('Form is invalid: %s', $form->getName()), 0, $exception);
        $this->form = $form;
    }

    /**
     * Returns invalid form.
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

}