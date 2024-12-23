<?php
namespace EasyAnalytics;
use EasyAnalytics\ExTables;
class HooksHandler
{

    public function __construct()
    {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'registerAdminPage'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScriptsAndStyles'));
    }

    public function init()
    {
    }

    public function registerAdminPage()
    {
        add_menu_page(
            'Example Dashboard',
            'Example Dashboard',
            'manage_options',
            'exampleDashboard',
            array($this, 'dashboard')
        );

        add_submenu_page(
            'exampleDashboard',
            'Page Analytics',
            'Page Analytics',
            'manage_options',
            'pageAnalytics',
            array($this, 'pageAnalytics')
        );

        add_submenu_page(
            'exampleDashboard',
            'Page Views',
            'Page Views',
            'manage_options',
            'showPageView',
            array($this, 'showPageView')
        );

        add_submenu_page(
            'exampleDashboard',
            'User Interactions',
            'User Interactions',
            'manage_options',
            'showUserInteractions',
            array($this, 'showUserInteractions')
        );

        add_submenu_page(
            'exampleDashboard',
            'Generate Sample Data',
            'Generate Sample Data',
            'manage_options',
            'generateSampleData',
            array($this, 'generateSampleData')
        );
        add_submenu_page(
            '',
            'sampleData',
            'sampleData',
            'manage_options',
            'sampleData',
            array($this, 'sampleData')
        );

    }


    static function activate()
    {
        $exTables = new ExTables();
        $exTables->initDashboard();
    }

    static function deactivate()
    {
        $exTables = new ExTables();
        $exTables->destroyDashboard();
    }

    function dashboard()
    {
        $exTables = new ExTables();
        $exTables->dashboard();
    }
    function pageAnalytics()
    {
        $exTables = new ExTables();
        $exTables->pageAnalytics();
    }
    function showPageView()
    {
        $exTables = new ExTables();
        $exTables->pageViewLogs();
    }

    function showUserInteractions()
    {
        $exTables = new ExTables();
        $exTables->showUserInteractions();
    }

    function generateSampleData()
    {
        $exTables = new ExTables();
        $exTables->generateSampleData();
    }

    function sampleData()
    {
        $exTables = new ExTables();
        $exTables->sampleData();
    }

    public function enqueueScriptsAndStyles()
    {
        wp_register_script('dashboardjs', plugins_url('js/admin.js', dirname(__FILE__)), array('jquery'), '', true);
        wp_enqueue_script('dashboardjs');
        wp_register_style('dashboardstyle', plugins_url('css/main.css', dirname(__FILE__)), array(), '1.0', 'all');
        wp_enqueue_style('dashboardstyle');
    }
}