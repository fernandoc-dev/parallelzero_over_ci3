<?php
$result = $this->generic_model->get_a_record_by_id('articles', $id, FALSE);
$this->data['article'] = $result[0];

//Translation id-value of Category
$this->data['article']['category'] = $this->generic_model->get_the_value_of($this->data['categories'], $this->data['article']['category'], 'category');

//Translation id-value of Subcategories
$this->data['article']['subcategories'] = explode(",", $this->data['article']['subcategories']);
foreach ($this->data['article']['subcategories'] as $id) {
    $subcategories[] = $this->generic_model->get_the_value_of($this->data['subcategories'], $id, 'subcategory');
}
$this->data['article']['subcategories'] = $subcategories;

//Translation id-value of Tags
$this->data['article']['tags'] = explode(",", $this->data['article']['tags']);
foreach ($this->data['article']['tags'] as $id) {
    $tags[] = $this->generic_model->get_the_value_of($this->data['tags'], $id, 'tag');
}
$this->data['article']['tags'] = $tags;

$this->data['article']['created_at'] = date("Y-m-d\TH:i", strtotime($this->data['article']['created_at']));
$this->data['article']['release_at'] = date("Y-m-d\TH:i", strtotime($this->data['article']['release_at']));
$this->data['article']['expire_at'] = date("Y-m-d\TH:i", strtotime($this->data['article']['expire_at']));
$this->data['article']['modified_at'] = date("Y-m-d\TH:i", strtotime($this->data['article']['modified_at']));
