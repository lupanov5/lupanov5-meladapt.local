<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use dnext\Services\FeedbackService;

        if($model = new FeedbackService('question')) {
            $response = $model->run();
        }
            else {
        $response = ['error' => 'Отсутствуют необходимые параметры'];
            }

echo json_encode($response);

