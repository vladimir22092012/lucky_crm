<?php

class RfmController extends Controller
{
    public $import_files_dir = 'files/import/';
    public $import_file = 'rfmlist.xml';

    public function fetch()
    {
        ini_set('memory_limit', '1024M');
        $this->design->assign('import_files_dir', $this->import_files_dir);

        if (!is_writable($this->import_files_dir))
            $this->design->assign('message_error', 'no_permission');

        if ($this->request->post('run')) {
            ini_set('max_execution_time', 0);
            $import_file = $this->request->files("import_file");
            $ext = strtolower(pathinfo($import_file['name'], PATHINFO_EXTENSION));

            if (empty($import_file)) {
                $this->design->assign('error', 'Загрузите файл');
            } elseif (!in_array($ext, array('xml'))) {
                $this->design->assign('error', 'Принимаются файлы в формате xml');
            } else {

                $uploaded_name = $this->request->files("import_file", "tmp_name");

                $xml = simplexml_load_file($uploaded_name, 'SimpleXMLElement', LIBXML_NOCDATA);
                $json = json_encode($xml);
                $xml = json_decode($json, true);

                $success = true;

                if(isset($xml['АктуальныйПеречень']['Субъект'])){
                    foreach ($xml['АктуальныйПеречень']['Субъект'] as $value) {
                        if(!array_key_exists('ФЛ', $value)){
                            continue;
                        }
                        $prepare_item['fio'] = $value['ФЛ']['ФИО'];
                        $result = $this->Rfmlist->add_person($prepare_item);
    
                        if(!$result)
                            $success = false;
                    }
                }
                else{
                    foreach ($xml['TERRORISTS'] as $value) {
    
                        $string = str_replace(['<![CDATA[', ']]', '*', '>'], '', (string) $value['TERRORISTS_NAME']);
    
                        $prepare_item['fio'] = mb_strtolower($string);
    
                        $result = $this->Rfmlist->add_person($prepare_item);
    
                        if(!$result)
                            $success = false;
                    }
                }


                $this->design->assign('success', $success);

            }
        }
        return $this->design->fetch('rfm.tpl');
    }
}