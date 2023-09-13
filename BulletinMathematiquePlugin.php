<?php
namespace APP\plugins\generic\bulletinMathematique;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

use APP\components\forms\submission\StartSubmission;
use PKP\components\forms\publication\TitleAbstractForm;
use PKP\components\forms\publication\Details;
use APP\facades\Repo;

use PKP\components\forms\FieldText;

class BulletinMathematiquePlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = NULL)
    {
        // Register the plugin even when it is not enabled
        $success = parent::register($category, $path);

        if ($success && $this->getEnabled()) {
            // Hook into the forms system
	    Hook::add('Form::config::before', [$this, 'formConfigBeforeCallback']);
            
            // formConfigBeforeCallback = public method; will be defined below
        }

        return $success;
    }

    /**
     * Provide a name for this plugin
     *
     * The name will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     */
    public function getDisplayName()
    {
        return 'Bulletin Mathematique';
    }

    /**
     * Provide a description for this plugin
     *
     * The description will appear in the Plugin Gallery where editors can
     * install, enable and disable plugins.
     */
    public function getDescription()
    {
        return 'This plugin was created for the mathematical journal of Faculty of Mathematics and Computer Science, University of Bucharest.';
    }

    public function formConfigBeforeCallback($hookName, $params) {
        $form = &$params;

	// Remove submission requirements checklist
        if ($form instanceof StartSubmission) {
            $form->removeField('submissionRequirements');
        }
        
        // Remove 'Keywords' field from submission form
        if ($form instanceof Details) {
            $form->removeField('keywords');
        }
        
        // Remove 'Abstract' field from submission form
        if($form instanceof Details) {
           $form->removeField('abstract');
        }
        
        return Hook::CONTINUE;
    }
    
}
