<?php



namespace EasyAnalytics;
use EasyAnalytics\ExTables;
/**
 * Handles custom REST API requests.
 */
class Api
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes()
    {
        register_rest_route('easyanalytics/v1', '/addPageView', [
            'methods' => 'POST',
            'callback' => [$this, 'addPageView']
        ]);
        register_rest_route('easyanalytics/v1', '/addPageAnalytics', [
            'methods' => 'POST',
            'callback' => [$this, 'addPageAnalytics']
        ]);
        register_rest_route('easyanalytics/v1', '/addUserInteraction', [
            'methods' => 'POST',
            'callback' => [$this, 'addUserInteraction']
        ]);
    }

    public function addPageView($request)
    {
        $data = $request->get_params();


        $errors = [];

        if (empty($data['page_id']) || !is_numeric($data['page_id'])) {
            $errors[] = 'page_id is required and must be an integer.';
        }

        if (!empty($errors)) {
            return new WP_Error('invalid_data', implode(' ', $errors), ['status' => 400]);
        }

        $exTables = new ExTables();
        $exTables->insertPageView($data);

        $response_data = [
            'message' => 'Data validated and inserted successfully!',
            'data' => $data,
        ];
        return rest_ensure_response($response_data);
    }

    public function addPageAnalytics($request)
    {
        $data = $request->get_params();

        $errors = [];

        if (empty($data['page_id']) || !is_numeric($data['page_id'])) {
            $errors[] = 'page_id is required and must be an integer.';
        }

        if (!is_numeric($data['time_on_page'])) {
            $errors[] = 'time_on_page is required and must be an float.';
        }

        if (!is_numeric($data['bounce_rate'])) {
            $errors[] = 'bounce_rate is required and must be a numeric.';
        }

        if (!empty($errors)) {
            return new WP_Error('invalid_data', implode(' ', $errors), ['status' => 400]);
        }

        $exTables = new ExTables();
        $exTables->insertPageAnalytics($data);
        $response_data = [
            'message' => 'Data validated and inserted successfully!',
            'data' => $data,
        ];

        return rest_ensure_response($response_data);
    }

    public function addUserInteraction($request)
    {
        $data = $request->get_params();

        $errors = [];


        if (empty($data['page_id']) || !is_numeric($data['page_id'])) {
            $errors[] = 'page_id is required and must be an integer.';
        }

        if (empty($data['user_action'])) {
            $errors[] = 'user_action is required.';
        }

        if (!empty($errors)) {
            return new WP_Error('invalid_data', implode(' ', $errors), ['status' => 400]);
        }

        $exTables = new ExTables();
        $exTables->insertUserInteractions($data);
        $response_data = [
            'message' => 'Data validated and inserted successfully!',
            'data' => $data,
        ];

        return rest_ensure_response($response_data);
    }
}



