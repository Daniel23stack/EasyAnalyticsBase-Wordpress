<?php

namespace EasyAnalytics;
use EasyAnalytics\Factory;


class ExTables
{

  private $tableNames = array('page_view_log', 'page_analytics', 'user_interactions');

  public function __construct()
  {
  }



  /**
   * Initialization of the tables for this example.
   * @return void
   */
  function initDashboard()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'page_view_log';


    if (!$this->checkTable($table_name)) {
      $sql = "CREATE TABLE wp_page_view_log (
        id INT PRIMARY KEY AUTO_INCREMENT,
        page_id INT NOT NULL,
        view_count INT DEFAULT 0,
        last_viewed DATE
      )";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }

    $table_name = $wpdb->prefix . 'page_analytics';

    if (!$this->checkTable($table_name)) {
      $sql = "CREATE TABLE $table_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        page_id INT NOT NULL,
        time_on_page FLOAT NOT NULL,
        bounce_rate DECIMAL(5,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }

    $table_name = $wpdb->prefix . 'user_interactions';

    if (!$this->checkTable($table_name)) {
      $sql = "CREATE TABLE $table_name (
        id INT PRIMARY KEY AUTO_INCREMENT,
        page_id INT NOT NULL,
        user_action VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
    }

  }

  /**
   * Remove the tables if the plugin is deleted. Normally a 
   * .env would be used here if the user would like to keep the data.
   * @return void
   */
  function destroyDashboard()
  {
    error_log('Activate destroyDashboard');
    global $wpdb;

    $table_name = $wpdb->prefix . 'page_view_log';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . 'page_analytics';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . 'user_interactions';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
  }


  /**
   * Will display a user dashboard that allows for different graphs to be shown based on the data. 
   * @return void
   */
  function dashboard()
  {
    ?>
    <div class="wrap">
      <h1>This dashboard is still in development. Please check out the other dashboards linked below.</h1>
      <h2>If you don't see any data available <a
          href="<?php echo esc_url(admin_url('admin.php?page=generateSampleData')); ?>" class="button-primary">Generate
          Sample Data</a>
      </h2>
      <p><a href="<?php echo esc_url(admin_url('admin.php?page=pageAnalytics')); ?>" class="button-primary">Page
          Analytics</a></p>
      <p><a href="<?php echo esc_url(admin_url('admin.php?page=showPageView')); ?>" class="button-primary">Page View
          Logs</a></p>
      <p><a href="<?php echo esc_url(admin_url('admin.php?page=showUserInteractions')); ?>" class="button-primary">User
          Interactions</a></p>
    </div>
    <?php
  }
  function showUserInteractions()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_interactions';

    $logs = $wpdb->get_results("SELECT * FROM $table_name");

    if ($logs) {
      echo '<br/><br/>
      <input type="text" id="searchInput" placeholder="Search by Page ID">
      <div class="wrap">
          <h2>User Interactions</h2>
          <table class="widefat striped" id="dataTable">
          <thead>
          <tr>
          <th>ID</th>
          <th>Page ID</th>
          <th>Action</th>
          <th>Created At</th>
          </tr>
          </thead>
          <tbody>';

      foreach ($logs as $log) {
        echo '<tr>' . '<td>' . esc_html($log->id) . '</td>' .
          '<td>' . esc_html($log->page_id) . '</td>' .
          '<td>' . esc_html($log->user_action) . '</td>' .
          '<td>' . esc_html($log->created_at) . '</td>'
          . '</tr>';
      }

      echo '</tbody>' . '</table>' . '</div>';
    } else {
      echo '<div class="notice notice-warning">' . '<p>No user interactions found.</p>' . '</div>';
    }
  }

  function pageAnalytics()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'page_analytics';

    $logs = $wpdb->get_results("SELECT * FROM $table_name");

    if ($logs) {
      echo '<br/><br/>
      <input type="text" id="searchInput" placeholder="Search by Page ID">
      <div class="wrap">
        <h2>Page Analytics</h2>
        <table class="widefat striped" id="dataTable" >
        <thead>
        <tr>
        <th>ID</th>
        <th>Page ID</th>
        <th>Time on Page</th>
        <th>Bounce Rate</th>
        <th>Created At</th>
        </tr>
        </thead>
        <tbody>';

      foreach ($logs as $log) {
        echo '<tr>' . '<td>' . esc_html($log->id) . '</td>' .
          '<td>' . esc_html($log->page_id) . '</td>' .
          '<td>' . esc_html($log->time_on_page) . '</td>' .
          '<td>' . esc_html($log->bounce_rate) . '</td>' .
          '<td>' . esc_html($log->created_at) . '</td>'
          . '</tr>';
      }

      echo '</tbody>' . '</table>' . '</div>';
    } else {
      echo '<div class="notice notice-warning">' . '<p>No page analytics found.</p>' . '</div>';
    }
  }


  function pageViewLogs()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . 'page_view_log';

    $logs = $wpdb->get_results("SELECT * FROM $table_name");

    if ($logs) {
      echo '<br/><br/>
      <input type="text" id="searchInput" placeholder="Search by Page ID">
      <div class="wrap">
          <h2>Page View Logs</h2>
          <table class="widefat striped" id="dataTable">
          <thead>
          <tr>
          <th>ID</th>
          <th>Page ID</th>
          <th>View Count</th>
          <th>View Date</th>
          </tr>
          </thead>
          <tbody>';

      foreach ($logs as $log) {
        echo '<tr>' . '<td>' . esc_html($log->id) . '</td>' .
          '<td>' . esc_html($log->page_id) . '</td>' .
          '<td>' . esc_html($log->view_count) . '</td>' .
          '<td>' . esc_html($log->last_viewed) . '</td>'
          . '</tr>';
      }

      echo '</tbody>' . '</table>' . '</div>';
    } else {
      echo '<div class="notice notice-warning">' . '<p>No page view found.</p>' . '</div>';
    }
  }


  function checkTable($tableName)
  {
    global $wpdb;
    $t = $wpdb->prefix . $tableName;
    $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($t));
    if ($wpdb->get_var($query) == $t) {
      return true;
    } else {
      return false;
    }
  }

  function generateSampleData()
  {
    $tablesExist = 'no';
    if ($this->checkTable('page_view_log') && $this->checkTable('page_analytics') && $this->checkTable('user_interactions')) {
      $tablesExist = 'yes';
    }

    ?>
    <div class="wrap">
      <h1><?php esc_html_e('My Plugin', 'example_plugin'); ?></h1>
      <p><?php esc_html_e('Install Table Sample Data', 'example_plugin'); ?></p>
      <p>Write Access: <?php echo esc_html($tablesExist); ?></p>
      <?php if ($tablesExist === 'no'): ?>
        <div class="notice notice-error">
          <p><?php esc_html_e('The tables are not yet available for Sample data.', 'example_plugin'); ?></p>
        </div>
      <?php endif; ?>
      <a href="<?php echo esc_url(admin_url('admin.php?page=sampleData&sampleData=true')); ?>"
        class="button-primary"><?php esc_html_e('Install Sample Data', 'example_plugin'); ?></a>
    </div>
    <?php
  }



  function sampleData()
  {
    global $wpdb;
    $factory = new Factory();
    $tables = $this->tableNames;
    for ($i = 0; $i < 20; $i++) {
      $t = $factory->generateFakePageView();
      $wpdb->insert($wpdb->prefix . $tables[0], $t, array('%d', '%d', '%s'));

      $t = $factory->generateFakePageAnalytics();
      $wpdb->insert($wpdb->prefix . $tables[1], $t, array('%d', '%f', '%f'));

      $t = $factory->generateFakeUserInteraction();
      $wpdb->insert($wpdb->prefix . $tables[2], $t, array('%d', '%s'));
    }
    echo 'Completed Sample Data';
  }


  function insertPageView($data)
  {
    global $wpdb;
    $tables = $this->tableNames;
    $table = $wpdb->prefix . $tables[0];
    $query = $wpdb->prepare("SELECT view_count FROM $table WHERE page_id = %d", $data['page_id']);
    $viewCount = $wpdb->get_var($query);

    $dataFormat = [
      'page_id' => $data['page_id'],
      'view_count' => 1,
      'last_view' => date('Y-m-d')
    ];

    if ($viewCount === null) {
      wpdb->insert($table, $dataFormat, array('%d', '%d', '%s'));
    } else {
      $dataFormat['view_count'] = intval($viewCount) + 1;
      wpdb->insert($table, $dataFormat, array('%d', '%d', '%s'));
    }

  }

  function insertPageAnalytics($data)
  {
    global $wpdb;
    $tables = $this->tableNames;
    $table = $table = $wpdb->prefix . $tables[1];

    $dataFormat = [
      'page_id' => $data['page_id'],
      'time_on_page' => $data['time_on_page'],
      'bounce_rate' => $data['bounce_rate']
    ];
    $wpdb->insert($table, $dataFormat, array('%d', '%f', '%f'));
  }

  function insertUserInteractions($data)
  {
    global $wpdb;
    $tables = $this->tableNames;
    $table = $table = $wpdb->prefix . $tables[2];

    $dataFormat = [
      'page_id' => $data['page_id'],
      'user_action' => $data['user_action']
    ];

    $wpdb->insert($table, $dataFormat, array('%d', '%s'));

  }



}






