<?php

namespace common\widgets;

use yii\base\Widget;

class TreeComment extends Widget
{
    public $data;
    public $commentForm;

    private $tree = [];
    private $outerHtml;

    public function buildTree($data, $rootID = null)
    {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node['parent_id'] == $rootID) {
                unset($data[$id]);
                $node['childs'] = $this->buildTree($data, $node['id']);
                $tree[] = $node;
            }
        }
        return $tree;
    }

    private function renderTree($data, $level = 0)
    {
        foreach ($data as $node) {
            $nodeHtml = $this->render('tree/node', [
                'node' => $node,
                'level' => $level,
                'model' => $this->commentForm,
            ]);
            $this->outerHtml .= $nodeHtml;
            if (!empty($node['childs'])) {
                $this->renderTree($node['childs'], ($level + 1));
            }
        }
    }

    public function run()
    {
        $this->tree = $this->buildTree($this->data);
        $this->renderTree($this->tree);
        return $this->outerHtml;
    }
}