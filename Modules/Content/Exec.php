<?php
/**
 * Description of content
 *
 * @author rbas
 */
class Modules_Content_Exec extends Lib_AbstractModule
{
    protected function defaultAction()
    {
        return 'Vitej v bobroid';
    }

    protected function showAction()
    {
        return $this->loadTemplate('template/default.phtml');
    }

    protected function newAction()
    {
        return $this->exampleForm() .'';
    }

    private function exampleForm()
    {
        $countries = array(
            'Select your country',
            'Europe' => array(
                'CZ' => 'Czech Republic',
                'FR' => 'France',
                'DE' => 'Germany',
                'GR' => 'Greece',
                'HU' => 'Hungary',
                'IE' => 'Ireland',
                'IT' => 'Italy',
                'NL' => 'Netherlands',
                'PL' => 'Poland',
                'SK' => 'Slovakia',
                'ES' => 'Spain',
                'CH' => 'Switzerland',
                'UA' => 'Ukraine',
                'GB' => 'United Kingdom',
            ),
            'AU' => 'Australia',
            'CA' => 'Canada',
            'EG' => 'Egypt',
            'JP' => 'Japan',
            'US' => 'United States',
            '?'  => 'other',
        );

        $sex = array(
            'm' => 'male',
            'f' => 'female',
        );



        // Step 1: Define form with validation rules
        $form = new Form;

        // group Personal data
        $form->addGroup('Personal data')
            ->setOption('description', 'We value your privacy and we ensure that the information you give to us will not be shared to other entities.');

        $form->addText('name', 'Your name:', 35)
            ->addRule(Form::FILLED, 'Enter your name');

        $form->addText('age', 'Your age:', 5)
            ->addRule(Form::FILLED, 'Enter your age')
            ->addRule(Form::INTEGER, 'Age must be numeric value')
            ->addRule(Form::RANGE, 'Age must be in range from %.2f to %.2f', array(9.9, 100));

        $form->addRadioList('gender', 'Your gender:', $sex);

        $form->addText('email', 'E-mail:', 35)
            ->setEmptyValue('@')
            ->addCondition(Form::FILLED) // conditional rule: if is email filled, ...
                ->addRule(Form::EMAIL, 'Incorrect E-mail Address'); // ... then check email


        // group Shipping address
        $form->addGroup('Shipping address')
            ->setOption('embedNext', TRUE);

        $form->addCheckbox('send', 'Ship to address')
            ->addCondition(Form::EQUAL, TRUE) // conditional rule: if is checkbox checked...
                ->toggle('sendBox'); // toggle div #sendBox


        // subgroup
        $form->addGroup()
            ->setOption('container', Html::el('div')->id('sendBox'));

        $form->addText('street', 'Street:', 35);

        $form->addText('city', 'City:', 35)
            ->addConditionOn($form['send'], Form::EQUAL, TRUE)
                ->addRule(Form::FILLED, 'Enter your shipping address');

        $form->addSelect('country', 'Country:', $countries)
            ->skipFirst()
            ->addConditionOn($form['send'], Form::EQUAL, TRUE)
                ->addRule(Form::FILLED, 'Select your country');


        // group Your account
        $form->addGroup('Your account');

        $form->addPassword('password', 'Choose password:', 20)
            ->addRule(Form::FILLED, 'Choose your password')
            ->addRule(Form::MIN_LENGTH, 'The password is too short: it must be at least %d characters', 3);

        $form->addPassword('password2', 'Reenter password:', 20)
            ->addConditionOn($form['password'], Form::VALID)
                ->addRule(Form::FILLED, 'Reenter your password')
                ->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);

        $form->addFile('avatar', 'Picture:')
            ->addCondition(Form::FILLED)
                ->addRule(Form::MIME_TYPE, 'Uploaded file is not image', 'image/*');

        $form->addHidden('userid');

        $form->addTextArea('note', 'Comment:', 30, 5);


        // group for buttons
        $form->addGroup();

        $form->addSubmit('submit1', 'Send');






        // Step 2: Check if form was submitted?
        if ($form->isSubmitted()) {

            // Step 2c: Check if form is valid
            if ($form->isValid()) {
                echo '<h2>Form was submitted and successfully validated</h2>';

                $values = $form->getValues();
                Debug::dump($values);

                // this is the end, my friend :-)
                if (empty($disableExit)) exit;
            }

        } else {
            // not submitted, define default values
            $defaults = array(
                'name'    => 'John Doe',
                'userid'  => 231,
                'country' => 'CZ', // Czech Republic
            );

            $form->setDefaults($defaults);
        }

        return $form;
    }
}