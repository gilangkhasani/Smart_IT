<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function human_date($tgl)
{
	$d = date("l, j F Y",strtotime($tgl));
	return $d;
}

function checkLogin()
{
	$myci = & get_instance();
	if($myci->session->userdata('logged_in') != TRUE){
		redirect('Sb_login');
	}
}

function checkAdmin()
{
	$myci = & get_instance();
	if($myci->session->userdata('usertype') != 'Admin'){
		redirect('blog');
	} 
}

function checkExim()
{
	$myci = & get_instance();
	//if($myci->session->userdata('usertype') != 'Admin' || $myci->session->userdata('usertype') != 'Exim'){
	if($myci->session->userdata('usertype') != 'Admin'){
		redirect('blog');
	} 
}

function checkProduction()
{
	$myci = & get_instance();
	//if($myci->session->userdata('usertype') != 'Admin' || $myci->session->userdata('usertype') != 'Production'){
	if($myci->session->userdata('usertype') != 'Admin'){
		redirect('blog');
	} 
}

function checkInventory()
{
	$myci = & get_instance();
	//if($myci->session->userdata('usertype') != 'Admin' || $myci->session->userdata('usertype') != 'Inventory'){
	if($myci->session->userdata('usertype') != 'Admin'){
		redirect('blog');
	} 
}