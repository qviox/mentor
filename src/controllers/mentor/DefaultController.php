<?php

namespace qviox\mentor\controllers\mentor;


/**
 * Default controller for the `mentor` module
 */
class DefaultController extends RuleController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
