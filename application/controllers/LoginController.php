<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class LoginController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Login_Model']);
        if (!empty($this->session->userdata("fullname"))) {
            redirect(base_url("ims/dashboards/analytics"));
        }
    }


    private function generateCaptcha()
    {
        $config = [
            'img_path'      => FCPATH . 'captcha_images/', // Server path
            'img_url'       => base_url('captcha_images/'),
            'font_path'     => BASEPATH . 'fonts/texb.ttf', // Server path
            'img_width'     => 150,
            'img_height'    => 38,
            'expiration'    => 7200,
            'word_length'   => 5,
            'font_size'     => 20,
            'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'        => [
                'background' => [255, 255, 255],
                'border'     => [255, 255, 255],
                'text'       => [0, 0, 0],
                'grid'       => [255, 40, 40]
            ]
        ];

        $captcha = create_captcha($config);
        if ($captcha === FALSE) {
            log_message('error', 'Captcha generation failed. Check font path and directory permissions.');
            return FALSE;
        }

        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);

        return $captcha;
    }

    public function index()
    {
        $captcha = $this->generateCaptcha();

        if ($captcha === FALSE) {
            // Load view with default or error placeholder
            $data = [
                'captchaImg' => '<p style="color:red;">CAPTCHA failed to generate</p>',
                'token'      => $this->security->get_csrf_hash(),
                'main'       => 'auth/login_view'
            ];
        } else {
            $data = [
                'captchaImg' => $captcha['image'],
                'token'      => $this->security->get_csrf_hash(),
                'main'       => 'auth/login_view'
            ];
        }

        $this->load->view('login_view', $data);
    }






    function SubmitLogin()
    {
        $uname = $this->input->post("IMS_USERS_UNAME");
        $pword = $this->input->post("IMS_USERS_PWORD");
        if ($this->input->post("captcha_id") === $this->session->userdata("captchaCode")) {
            $this->Login_Model->SubmitLogin($uname, $pword);
        } else {
            $this->session->set_flashdata('error', "Captcha code does not match, please try again.");
            redirect(base_url() . 'login');
        }
    }
}
