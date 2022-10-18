<?php

class PromoCodesController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post')) {
            switch ($this->request->post('action', 'string')):

                case 'add':

                    $code = trim($this->request->post('code'));
                    $percent = trim($this->request->post('percent'));

                    if (empty($code)) {
                        $this->json_output(array('error' => 'Укажите промокод'));
                    } elseif (empty($percent)) {
                        $this->json_output(array('error' => 'Укажите процент'));
                    } else {
                        $promo_code = array(
                            'code' => $code,
                            'percent' => $percent,
                        );
                        $id = $this->PromoCodes->add($promo_code);

                        $this->json_output(array(
                            'id' => $id,
                            'code' => $code,
                            'percent' => $percent,
                            'success' => 'Промокод добавлен'
                        ));
                    }

                    break;

                case 'update':

                    $id = $this->request->post('id', 'integer');
                    $code = trim($this->request->post('code'));
                    $percent = trim($this->request->post('percent'));

                    if (empty($code)) {
                        $this->json_output(array('error' => 'Укажите промокод'));
                    } elseif (empty($percent)) {
                        $this->json_output(array('error' => 'Укажите процент'));
                    } else {
                        $promo_code = array(
                            'code' => $code,
                            'percent' => $percent,
                        );
                        $this->PromoCodes->update($id, $promo_code);

                        $this->json_output(array(
                            'id' => $id,
                            'code' => $code,
                            'percent' => $percent,
                            'success' => 'Промокод обновлен'
                        ));
                    }

                    break;

                case 'delete':

                    $id = $this->request->post('id', 'integer');

                    $this->PromoCodes->delete($id);

                    $this->json_output(array(
                        'id' => $id,
                        'success' => 'Промокод удален'
                    ));

                    break;

            endswitch;
        }

        $promo_codes = $this->PromoCodes->get_codes();
        $this->design->assign('promo_codes', $promo_codes);

        return $this->design->fetch('promo_codes.tpl');
    }
}
