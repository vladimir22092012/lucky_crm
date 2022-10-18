<?php

class LoginController extends Controller
{

	function fetch()
	{
		// Выход
		if($this->request->get('action') == 'logout')
		{
			unset($_SESSION['manager_id']);
			unset($_SESSION['manager_ip']);
			unset($_SESSION['offline_point_id']);
            setcookie('mid', null, time() -1, '/', $this->config->root_url);
            setcookie('ah', null, time() -1, '/', $this->config->root_url);
			header('Location: '.$this->config->root_url);
			exit();
		}
		elseif($this->request->method('post') && $this->request->post('offline_form'))
        {
            if (empty($this->manager->id))
            {
                $this->design->assign('error', 'UNDEFINED MANAGER');
            }
            else
            {
                if ($offline_point_id = $this->request->post('offline_point_id', 'integer'))
                {
                    $_SESSION['offline_point_id'] = $offline_point_id;

    				$back = $this->request->get('back');
                    header('Location: '.$this->config->root_url.$back);
    			    exit;
                }
                else
                {
                    $this->design->assign('error', 'Выберите оффлайн отделение');
                }
                $this->design->assign('select_offline_point', 1);
            }
        }
		// Вход
		elseif($this->request->method('post') && $this->request->post('login'))
		{
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($_POST);echo '</pre><hr />';
			$login			= $this->request->post('login');
			$password		= $this->request->post('password');

			$this->design->assign('login', $login);

			if($manager_id = $this->managers->check_password($login, $password))
			{
                $update = array();

				if ($this->request->post('remember'))
                {
                    $salt = md5(mt_rand().microtime());

                    $hash = md5(sha1($_SERVER['REMOTE_ADDR'].$manager_id).$salt);

                    setcookie('mid', $manager_id, time() + 7*86400, '/', $this->config->root_url);
                    setcookie('ah', $hash, time() + 7*86400, '/', $this->config->root_url);

                    $update['salt'] = $salt;
                }

                $update['last_ip'] = $_SERVER['REMOTE_ADDR'];

                $this->managers->update_manager($manager_id, $update);

                $manager = $this->managers->get_manager($manager_id);
				$_SESSION['manager_id'] = $manager->id;
				$_SESSION['manager_ip'] = $_SERVER['REMOTE_ADDR'];
                
                if ($worktime = $this->managers->get_date_worktime($manager_id, date('Y-m-d')))
                {
                    $this->managers->update_worktime($worktime->id, array(
                        'last_active' => date('Y-m-d H:i:s'),
                        'last_ip' => $_SERVER['REMOTE_ADDR']
                    ));
                }
                else
                {
                    $this->managers->add_worktime(array(
                        'manager_id' => $manager_id,
                        'workdate' => date('Y-m-d'),
                        'login_time' => date('Y-m-d H:i:s'),
                        'last_active' => date('Y-m-d H:i:s'),
                        'last_ip' => $_SERVER['REMOTE_ADDR']
                    ));
                }
                
                if ($manager->role == 'cs_pc')
                {
                    $this->design->assign('select_offline_point', 1);
                }
                else
                {
    				$back = $this->request->get('back');
                    header('Location: '.$this->config->root_url.$back);
    			    exit;
			    }
            }
			else
			{
				$this->design->assign('error', 'login_incorrect');
			}
		}

        $cities = array();
        $offline_points = array();
        foreach ($this->offline->get_points() as $p)
        {
            $offline_points[$p->id] = $p;
            $cities[] = $p->city;
        }
        $this->design->assign('offline_points', $offline_points);
        $cities = array_unique($cities);
        sort($cities);
        $this->design->assign('cities', $cities);
//echo __FILE__.' '.__LINE__.'<br /><pre>';var_dump($offline_points);echo '</pre><hr />';

        return $this->design->fetch('login.tpl');
	}
}
