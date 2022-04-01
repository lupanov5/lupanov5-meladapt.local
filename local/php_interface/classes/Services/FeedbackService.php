<?php
namespace dnext\Services;


use Bitrix\Main\Mail\Event;
use CEventLog;
use CFile;
use CModule;
use CIBlockElement;
use Bitrix\Main\Context;
use Bitrix\Main\Type\DateTime;
use dnext\Exceptions\DnextValidationException;
use dnext\Exceptions\FeedbackException;
use dnext\Models\Feedback\Questions;
use dnext\Models\Feedback\ServiceRequest;
use dnext\Services\Validator;


class FeedbackService
{
    private $modelList = [
        'question'  => 'dnext\Models\Feedback\Questions',
    ];

    /**
     * @var ServiceRequest|Questions
     */
    private $model;

    private $fields = [];

    private $files = [];

    private $errors = [];

    private $element;

    private $date;

    /**
     * Уровень событий, сохраняемых в логе
     * @var string[]
     */
    private $logTypes = [
        0 => 'DEBUG',
        1 => 'INFO',
        2 => 'WARNING',
        3 => 'ERROR',
        4 => 'SECURITY',
    ];

    /**
     * какие уровни событий сохраняем в базе
     *      0 - 'DEBUG',
                'INFO',
                'WARNING',
                'ERROR',
                'SECURITY',
     *      3 - 'ERROR',
                'SECURITY',
     *      4 - SECURITY,
     * @var int
     */
    private $logLevel = 0;

    public function __construct($modelName)
    {
        $this->logTypes = array_slice($this->logTypes, 4);

        if(key_exists($modelName, $this->modelList)
            && is_callable($this->modelList[$modelName], true, $callable_name)
            && method_exists($this->modelList[$modelName], 'hasTrait')) {
            CModule::IncludeModule("iblock");

            $this->model = new $this->modelList[$modelName];

            $this->fields = $this->model->getFormFields();
            $this->date = new DateTime();
        } else {
            throw new FeedbackException('Нет такого класса или необходимых методов');
        }

        return $this->errors;
    }

    public function run()
    {
        if(empty($this->model)) {
            throw new FeedbackException('Нет такой модели');
        }

        $this->prepare();

        if(empty($this->errors)) {
            $this->model->setFormFields($this->fields);
            $this->add();
        }

        return $this->errors;
    }

    private function prepare()
    {
        $request = Context::getCurrent()->getRequest();

        foreach ($this->fields as $name => $field) {
            if($field['rules'] == 'file') {
                $this->prepareFiles();
                $this->fields[$name]['value']  = $this->files;
                continue;
            }
            $this->fields[$name]['value']  = $request->get($name);
            $this->validate($name);
        }
    }

    private function prepareFiles()
    {
        $files = [];

        if(empty($this->files)) $this->makeFileArray();

        foreach ($this->files as $key => $file) {
//            $fileData = file_get_contents($file['tmp_name']);
            $files[$key] = [
                'VALUE'=> $file
//                    [
//                        0 => $file['name'],
//                        1 => base64_encode($fileData)
//                    ]
            ];
        }

        $this->files = $files;
    }

    private function makeFileArray()
    {
        if (empty($this->files)) {
            $files = [];

            if (!empty($_POST['files'])) {
                $n = 0;
                foreach ($_POST['files'] as $key => $file) {
                    $files['n' . $n] = $this->saveFile($file);
                    $n++;
                }
            }
            $this->files = $files;
        }
    }

    private function saveFile($fileBase64)
    {
        // так как иногда с фронта прихоят файлы то с именем в base64, то без имени, ведем себя по разному

        $arr = explode(';data:', $fileBase64);

        if(!empty($arr[1])) {
            if(!empty($arr[0])) {
                $name = $arr[0];
            } else {
                $name = 'file_' .uniqid() . rand(11, 99);
            }

            $fileBase64 = 'data:' . $arr[1];
            //$ext = $this->getFileExtention($fileBase64);
        } else {
            $name = 'file_' .uniqid() . rand(11, 99);
            $ext = $this->getFileExtention($arr[0]);
            $name .= '.' . $ext;
        }

        $outputFile = $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/' . $name;
        $f = file_put_contents($outputFile, file_get_contents($fileBase64));

        $fileArray = CFile::MakeFileArray($outputFile);

        return $fileArray;
    }

    private function getFileExtention($fileBase64)
    {
        // пример входящего файла в base64:
        // data:application/pdf;base64,тутсамфайл

        $fileMimeType = null;
        $fileMimeTypeArr = explode(';base64,', $fileBase64);
        if (!empty($fileMimeTypeArr[0])) {
            $fileMimeType = explode('data:', $fileMimeTypeArr[0]);
        }

        if(!empty($fileMimeType[1])) {
            return $this->getExtByMimeType($fileMimeType[1]);
        }
//        $fileMimeType2 = explode('/', mime_content_type($fileBase64))[1];
//
//        $encodedData = str_replace(' ','+', $fileBase64);
//        $decodedData = base64_decode($encodedData);
//        $a=1;
        return 'pdf';
    }

    /**
     * Получаем расширение по mimetype
     *
     * @param $mimeType
     * @return false|string
     */
    private function getExtByMimeType($mimeType)
    {
        $extension = \dnext\Helpers\FilesHelper::getExtensionByMime($mimeType);
        if (in_array($extension, ['docx', 'doc', 'pdf'])) {
            return $extension;
        } else {
            return false;
        }
    }

    public function validate($name)
    {
        $validator = new Validator($this->fields[$name]);
        $result = $validator->run();
        if(!empty($result)) {
            $this->errors[$name] = $result;
        }
    }

    private function add()
    {
        /**
         * @var $APPLICATION object
         */
        $storeFields = $this->model->getMainFieldsForStore();
        $storeFields['PROPERTY_VALUES'] = $this->model->getPropertiesForStore();

        $this->element = new CIBlockElement;

        $elementId = $this->element->Add($storeFields, false, false, false);
        $this->deleteTempFiles();
        // если отзыв добавлен - отправим письмо
        if(!empty($elementId)) {
            $this->model->afterAdd();
            $this->sendMail($elementId);

        } else {
            dnd('Ошибка при добавлении');
            dnd($this->element->LAST_ERROR);
            dnd($storeFields);
        }
    }

    private function checkEvent()
    {
        $className = get_class($this->model);
        $className .= '::' . 'EVENT_NAME';

        return defined($className);
    }

    private function sendMail($elementId)
    {
        if(!$this->checkEvent()) return;

        $fields = $this->model->getMailFields($elementId);
        if(empty($fields)) return;

        $result = Event::send($fields);

        if(!$result->isSuccess()) {
            $this->log($result->getErrorMessages(), 'WARNING', $this->model::EVENT_NAME);
        }
    }

    /**
     * Подчищаем за собой, удаляя файлы
     * @param $files
     */
    private function deleteTempFiles()
    {
        foreach ($this->files as $file) {
            try {

                unlink($file['VALUE']['tmp_name']);
                $this->log('Deleted: ' . $file['VALUE']['tmp_name'], 'INFO');
            } catch (\Exception $exception)
            {
                // do something
                $this->log($exception->getMessage(), 'WARNING', 'FEEDBACK_FILE_DELETE');
            }
        }
    }

    /**
     * @param $message
     * @param string $severity
     * @param string $type
     */
    private function log($message, $severity = 'INFO', $type = 'FEEDBACK')
    {
        if(in_array($severity, $this->logTypes)) {
            CEventLog::Add(array(
                    'SEVERITY' => $severity,
                    'AUDIT_TYPE_ID' => $type,
                    'MODULE_ID' => 'main',
                    'DESCRIPTION' => $message,
                )
            );
        }
    }
}