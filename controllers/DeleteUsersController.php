<?php

class DeleteUsersController extends Controller
{
    public function fetch()
    {
        if ($this->request->method('post')) {
            if ($this->request->post('action', 'string')) {
                $methodName = 'action_' . $this->request->post('action', 'string');
                if (method_exists($this, $methodName)) {
                    $this->$methodName();
                }
            }
        }


        return $this->design->fetch('delete_users.tpl');
    }

    private function action_delete_user()
    {
        $phone = $this->request->post('phone');

        if (strlen($phone) > 11 || strlen($phone) < 11) {
            echo json_encode(['error' => 'Проверьте правильность номера, не соответствует кол-во цифр']);
            exit;
        }

        $user = UsersORM::where('phone_mobile', $phone)->first();

        if (empty($user)) {
            echo json_encode(['error' => 'Такого юзера нет']);
            exit;
        }

        OrdersORM::where('user_id', $user->id)->delete();
        UsersORM::where('id', $user->id)->delete();

        echo json_encode(['success' => 1]);
        exit;
    }
}