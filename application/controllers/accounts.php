<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Accounts extends CI_Controller {

  public $privileges;
  
  function __construct() {
    parent::__construct();
    $this->privileges = $this->MUser_privileges->get_by_ref_user($this->session->userdata('user_id'));
  }

  //Chart of Accounts Start ---------------
  
  function index() {
    $data['title'] = 'Sales Inventory System';
    $data['menu'] = 'accounts';
    $data['content'] = 'admin/ac/chart_list';
    $data['ac_chart_list'] = $this->MAc_charts->get_coa_list();
    $data['privileges'] = $this->privileges;
    $this->load->vars($data);
    $this->load->view('admin/dashboard');
  }

  function add_chart_ac() {
    if ($this->input->post('name')) {
      $this->MAc_charts->create();
      redirect('accounts', 'refresh');
    } else {
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/ac/chart_entry');
    }
  }

  function edit_chart_ac($id=0) {
    if ($this->input->post('name')) {
      $this->MAc_charts->update();
      redirect('accounts', 'refresh');
    } else {
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['ac_chart'] = $this->MAc_charts->get_by_id($id);
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/ac/chart_edit');
    }
  }

  function delete_chart_ac() {
    $this->MAc_charts->delete($this->input->post('id'));
    echo "<h1>Chart of A/C deleted.</h1>";
  }

  //Chart of Accounts End ---------------
  //
  //Journal Voucher Part Start ------------------
  
  function journal_voucher_list() {
    $data['title'] = 'Sales Inventory System';
    $data['menu'] = 'accounts';
    $data['content'] = 'admin/ac/journal_voucher_list';
    $data['journal_vouchers'] = $this->MAc_journal_voucher_master->get_all();
    $data['privileges'] = $this->privileges;
    $this->load->vars($data);
    $this->load->view('admin/dashboard');
  }

  function add_journal_voucher_master() {
    if ($this->input->post('voucher_no')) {
      $this->MAc_journal_voucher_master->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_journal_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/journal_voucher_master_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['voucher_no'] = $this->MAc_journal_voucher_master->get_voucher_number();
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function add_journal_voucher_details($voucher_no=NULL) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_journal_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_journal_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/journal_voucher_details_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['voucher_particulars'] = $this->MAc_journal_voucher_details->get_by_voucher_no($voucher_no);
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['voucher_no'] = $voucher_no;
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function journal_voucher_complete() {
    if ($this->input->post('debit') == $this->input->post('credit')) {
      //$this->MAc_journal_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/journal_voucher_list', 'refresh');
    } else {
      redirect('accounts/add_journal_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    }
  }

  function edit_journal_voucher_master($id=0) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_journal_voucher_master->update();
      //$this->session->set_flashdata('message', 'User updated');
      redirect('accounts/add_journal_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/journal_voucher_master_edit';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['journal_voucher'] = $this->MAc_journal_voucher_master->get_by_id($id);
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function delete_journal_voucher_item() {
    $this->MAc_journal_voucher_details->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  function delete_journal_voucher() {
    $voucher = $this->MAc_journal_voucher_master->get_by_id($this->input->post('id'));
    $this->MAc_journal_voucher_details->delete_by_voucher_no($voucher['voucher_no']);
    $this->MAc_journal_voucher_master->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  //Journal Voucher Part End ------------------
  //
  //Debit Voucher Part Start ------------------
  
  function debit_voucher_list() {
    $data['title'] = 'Sales Inventory System';
    $data['menu'] = 'accounts';
    $data['content'] = 'admin/ac/debit_voucher_list';
    $data['debit_vouchers'] = $this->MAc_debit_voucher_master->get_all();
    $data['privileges'] = $this->privileges;
    $this->load->vars($data);
    $this->load->view('admin/dashboard');
  }

  function add_debit_voucher_master() {
    if ($this->input->post('voucher_no')) {
      $this->MAc_debit_voucher_master->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_debit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/debit_voucher_master_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['voucher_no'] = $this->MAc_debit_voucher_master->get_voucher_number();
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function add_debit_voucher_details($voucher_no=NULL) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_debit_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_debit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/debit_voucher_details_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['voucher_particulars'] = $this->MAc_debit_voucher_details->get_by_voucher_no($voucher_no);
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['voucher_no'] = $voucher_no;
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function debit_voucher_complete() {
    if ($this->input->post('debit') == $this->input->post('credit')) {
      //$this->MAc_journal_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/journal_voucher_list', 'refresh');
    } else {
      redirect('accounts/add_journal_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    }
  }

  function edit_debit_voucher_master($id=0) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_debit_voucher_master->update();
      //$this->session->set_flashdata('message', 'User updated');
      redirect('accounts/add_debit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/debit_voucher_master_edit';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['debit_voucher'] = $this->MAc_debit_voucher_master->get_by_id($id);
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function delete_debit_voucher_item() {
    $this->MAc_journal_voucher_details->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  function delete_debit_voucher() {
    $this->MAc_vouchers->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  //Debit Voucher Part End ------------------
  //
  //Credit Voucher Part Start ------------------
  
  function credit_voucher_list() {
    $data['title'] = 'Sales Inventory System';
    $data['menu'] = 'accounts';
    $data['content'] = 'admin/ac/credit_voucher_list';
    $data['credit_vouchers'] = $this->MAc_credit_voucher_master->get_all();
    $data['privileges'] = $this->privileges;
    $this->load->vars($data);
    $this->load->view('admin/dashboard');
  }

  function add_credit_voucher_master() {
    if ($this->input->post('voucher_no')) {
      $this->MAc_credit_voucher_master->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_credit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/credit_voucher_master_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['voucher_no'] = $this->MAc_credit_voucher_master->get_voucher_number();
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function add_credit_voucher_details($voucher_no=NULL) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_credit_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/add_credit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/credit_voucher_details_entry';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['voucher_particulars'] = $this->MAc_credit_voucher_details->get_by_voucher_no($voucher_no);
      $data['ac_chart_tree'] = $this->MAc_charts->get_coa_tree();
      $data['voucher_no'] = $voucher_no;
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function credit_voucher_complete() {
    if ($this->input->post('debit') == $this->input->post('credit')) {
      //$this->MAc_journal_voucher_details->create();
      //$this->session->set_flashdata('message', 'Voucher Posted');
      redirect('accounts/credit_voucher_list', 'refresh');
    } else {
      redirect('accounts/add_credit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    }
  }

  function edit_credit_voucher_master($id=0) {
    if ($this->input->post('voucher_no')) {
      $this->MAc_credit_voucher_master->update();
      //$this->session->set_flashdata('message', 'User updated');
      redirect('accounts/add_credit_voucher_details/' . $this->input->post('voucher_no'), 'refresh');
    } else {
      $data['title'] = 'Sales Inventory System';
      $data['menu'] = 'accounts';
      $data['content'] = 'admin/ac/credit_voucher_master_edit';
      $data['ac_charts'] = $this->MAc_charts->get_all();
      $data['employees'] = $this->MEmp_info->get_all();
      $data['credit_voucher'] = $this->MAc_credit_voucher_master->get_by_id($id);
      $data['privileges'] = $this->privileges;
      $this->load->vars($data);
      $this->load->view('admin/dashboard');
    }
  }

  function delete_credit_voucher_item() {
    $this->MAc_credit_voucher_details->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  function delete_credit_voucher() {
    $this->MAc_vouchers->delete($this->input->post('id'));
    echo "<h1>Voucher deleted.</h1>";
  }

  //Credit Voucher Part End ------------------
  //
  
}