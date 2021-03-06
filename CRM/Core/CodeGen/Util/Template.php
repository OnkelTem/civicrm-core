<?php

/**
 * Class CRM_Core_CodeGen_Util_Template
 */
class CRM_Core_CodeGen_Util_Template {
  protected $filetype;

  protected $smarty;
  protected $beautifier;

  /**
   * @param string $filetype
   */
  public function __construct($filetype) {
    $this->filetype = $filetype;

    $this->smarty = CRM_Core_CodeGen_Util_Smarty::singleton()->getSmarty();

    $this->assign('generated', "DO NOT EDIT.  Generated by CRM_Core_CodeGen");

    // CRM-5308 / CRM-3507 - we need {localize} to work in the templates
    require_once 'CRM/Core/Smarty/plugins/block.localize.php';
    $this->smarty->register_block('localize', 'smarty_block_localize');

    if ($this->filetype === 'php') {
      require_once 'PHP/Beautifier.php';
      // create an instance
      $this->beautifier = new PHP_Beautifier();
      $this->beautifier->addFilter('ArrayNested');
      // add one or more filters
      $this->beautifier->addFilter('Pear');
      // add one or more filters
      $this->beautifier->addFilter('NewLines', array('after' => 'class, public, require, comment'));
      $this->beautifier->setIndentChar(' ');
      $this->beautifier->setIndentNumber(2);
      $this->beautifier->setNewLine("\n");
    }
  }

  /**
   * @param array $inputs
   *   Template filenames.
   * @param string $outpath
   *   Full path to the desired output file.
   */
  public function runConcat($inputs, $outpath) {
    if (file_exists($outpath)) {
      unlink($outpath);
    }
    foreach ($inputs as $infile) {
      // FIXME: does not beautify.  Document.
      file_put_contents($outpath, $this->smarty->fetch($infile)  . "\n", FILE_APPEND);
    }
  }

  /**
   * @param string $infile
   *   Filename of the template, without a path.
   * @param string $outpath
   *   Full path to the desired output file.
   */
  public function run($infile, $outpath) {
    $renderedContents = $this->smarty->fetch($infile);

    if ($this->filetype === 'php') {
      $this->beautifier->setInputString($renderedContents);
      $this->beautifier->setOutputFile($outpath);
      $this->beautifier->process();
      $this->beautifier->save();
    }
    else {
      file_put_contents($outpath, $renderedContents);
    }
  }

  /**
   * @param $key
   * @param $value
   */
  public function assign($key, $value) {
    $this->smarty->assign_by_ref($key, $value);
  }

  /**
   * Clear the smarty cache and assign default values
   * FIXME: unused cos we no longer do evil singleton magick
   */
  protected function reset() {
    $this->smarty->clear_all_assign();
    $this->smarty->clear_all_cache();
  }
}
