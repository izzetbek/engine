<?php

namespace core\repositories\Site;

use core\repositories\NotFoundException;
use core\entities\Site\HRTemplate\Template;

class HRTemplateRepository
{
    public function get($id)
    {
        if (!$template = Template::findOne($id)) {
            throw new NotFoundException('template is not found!');
        }

        return $template;
    }

    public function save(Template $template)
    {
        if (!$template->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Template $template)
    {
        if (!$template->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

    }
}