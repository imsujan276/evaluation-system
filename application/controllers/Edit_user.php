<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_user extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
        }

        public function index()
        {
                $user_id = NULL;
                if (!$user_id = $this->input->get('user-id'))
                {
                        show_error('Missing parameter');
                }
                $this->data['title'] = $this->lang->line('edit_user_heading');



                $user = $this->ion_auth->user($user_id)->row();
                if (!$user)
                {
                        show_error('Invalid request.');
                }
                $this->data['user_id'] = $user_id;
                $groups                = $this->ion_auth->groups()->result_array();
                $currentGroups         = $this->ion_auth->get_users_groups($user_id)->result();

                //just 
                // validate form input
                $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|human_name');
                $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|human_name');
                $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), '');
                $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), '');

                if (isset($_POST) && !empty($_POST))
                {
                        // do we have a valid request?
                        if ($this->_valid_csrf_nonce() === FALSE || $user_id != $this->input->post('id'))
                        {
                                show_error($this->lang->line('error_csrf'));
                        }

                        // update the password if it was posted
                        if ($this->input->post('password'))
                        {
                                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]|no_space|password_level[3]');
                                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
                        }

                        if ($this->form_validation->run() === TRUE)
                        {
                                $data = array(
                                    'first_name' => $this->input->post('first_name'),
                                    'last_name'  => $this->input->post('last_name'),
                                    'company'    => $this->input->post('company'),
                                    'phone'      => $this->input->post('phone'),
                                );

                                // update the password if it was posted
                                if ($this->input->post('password'))
                                {
                                        $data['password'] = $this->input->post('password');
                                }



                                // Only allow updating groups if user is admin
                                if ($this->ion_auth->is_admin())
                                {
                                        //Update the groups user belongs to
                                        $groupData = $this->input->post('groups');

                                        if (isset($groupData) && !empty($groupData))
                                        {

                                                $this->ion_auth->remove_from_group('', $user_id);

                                                foreach ($groupData as $grp)
                                                {
                                                        $this->ion_auth->add_to_group($grp, $user_id);
                                                }
                                        }
                                }

                                // check to see if we are updating the user
                                if ($this->ion_auth->update($user->id, $data))
                                {
                                        // redirect them back to the admin page if admin, or to the base url if non admin
                                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                                        if ($this->ion_auth->is_admin())
                                        {
                                                redirect(base_url('edit-user/?user-id=' . $user_id), 'refresh');
                                        }
                                        else
                                        {
                                                redirect('/', 'refresh');
                                        }
                                }
                                else
                                {
                                        // redirect them back to the admin page if admin, or to the base url if non admin
                                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                                        if ($this->ion_auth->is_admin())
                                        {
                                                redirect('auth', 'refresh');
                                        }
                                        else
                                        {
                                                redirect('/', 'refresh');
                                        }
                                }
                        }
                }

                // display the edit user form
                $this->data['csrf'] = $this->_get_csrf_nonce();

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                // pass the user to the view
                $this->data['user']          = $user;
                $this->data['groups']        = $groups;
                $this->data['currentGroups'] = $currentGroups;

                $this->data['first_name']       = array(
                    'name'  => 'first_name',
                    'id'    => 'first_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('first_name', $user->first_name),
                );
                $this->data['last_name']        = array(
                    'name'  => 'last_name',
                    'id'    => 'last_name',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('last_name', $user->last_name),
                );
                $this->data['company']          = array(
                    'name'  => 'company',
                    'id'    => 'company',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('company', $user->company),
                );
                $this->data['phone']            = array(
                    'name'  => 'phone',
                    'id'    => 'phone',
                    'type'  => 'text',
                    'value' => $this->form_validation->set_value('phone', $user->phone),
                );
                $this->data['password']         = array(
                    'name' => 'password',
                    'id'   => 'password',
                    'type' => 'password'
                );
                $this->data['password_confirm'] = array(
                    'name' => 'password_confirm',
                    'id'   => 'password_confirm',
                    'type' => 'password'
                );

                $this->header_view();
                $this->_render_page('admin/edit_user', $this->data);
                $this->_render_page('admin/footer');
        }

}
