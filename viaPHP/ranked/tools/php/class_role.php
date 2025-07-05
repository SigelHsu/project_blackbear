<?php
  class cls_withRole {
    private $p_roleListAry;
    private $p_inputAry;
    private $p_returnAry;

    public function __construct ($inputAry = array(), $settingAry = array()) {
      global $ary_setRoleList;											//print_r($ary_setRoleList);
      $this->p_roleListAry = $ary_setRoleList;
      $this->fun_setInputAry($inputAry);						//print_r($inputAry);
      $this->fun_setReturnAry($inputAry);
    }
    private function fun_setInputAry($inputAry = array()) {
      $tmp_Ary = array();

      $cls_tkAry = new cls_takeAryby;
      $cls_tkAry->fun_takeFromMultiAry($inputAry, "Role", array("isCountTotal" => 0, "isAddValueTag" => 0) );
      $tmp_Ary = $cls_tkAry->fun_returnValues();		//print_r($tmp_Ary);
      $this->p_inputAry = $tmp_Ary;
    }
    private function fun_updateInputAry($inputAry = array(), $outputTag = "") {
      if(!empty($outputTag)) {
        $this->p_inputAry[$outputTag] = $inputAry;
      }
      else {
        $this->p_inputAry = $inputAry;
      }
      $this->fun_setReturnAry($this->p_inputAry, $outputTag);
    }
    private function fun_setReturnAry($inputAry = array(), $outputTag = "") {
      if(!empty($outputTag)) {
        $this->p_returnAry[$outputTag]["Role"] = $inputAry;
      }
      else {
        $this->p_returnAry = $inputAry;
      }
    }

    //根據所輸入的 Role_Name，從 $ary_roleList中找到相對應的 Role_ID
    public function fun_getRoleTagIDFromName ($TagName = "") {
      foreach($this->p_roleListAry AS $Key => $Values) {
        if( in_array(strtolower($TagName), $Values["Title"]) ) {
          return $Key;
          break;
        }
      }
    }
    //根據所輸入的 Role_Name，從 $ary_roleList中找到相對應的 Role_ID
    public function fun_getAbilityTagIDFromName ($TagName = "") {
      foreach($this->p_roleListAry AS $Key => $Values) {
        if( in_array(strtolower($TagName), $Values["Ability"]) ) {
          return $Key;
          break;
        }
      }
    }
  }
?>