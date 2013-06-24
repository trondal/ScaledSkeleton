<?php
namespace Application\Controller;

use Doctrine\ORM\Tools\SchemaTool;

interface SchemaToolAware {

    public function setSchemaTool(SchemaTool $tool);

}