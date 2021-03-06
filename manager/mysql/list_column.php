<?php

    use Librarys\App\AppAlert;
    use Librarys\App\AppDirectory;
    use Librarys\App\AppParameter;
    use Librarys\App\Config\AppConfig;
    use Librarys\App\Mysql\AppMysqlConfig;
    use Librarys\File\FileInfo;

    define('LOADED',               1);
    define('MYSQL_LIST_COLUMN',    1);
    define('DATABASE_CHECK_MYSQL', 1);
    define('TABLE_CHECK_MYSQL',    1);

    require_once('global.php');

    $appParameter = new AppParameter();
    $appParameter->add(PARAMETER_DATABASE_URL, AppDirectory::rawEncode($appMysqlConnect->getName()));
    $appParameter->add(PARAMETER_TABLE_URL,    AppDirectory::rawEncode($appMysqlConnect->getTableCurrent()));

    $title  = lng('mysql.list_column.title_page');
    AppAlert::setID(ALERT_MYSQL_LIST_COLUMN);
    require_once(ROOT . 'incfiles' . SP . 'header.php');

    $mysqlStr   = 'SHOW COLUMNS FROM `' . addslashes($appMysqlConnect->getTableCurrent()) . '`';
    $mysqlQuery = $appMysqlConnect->query($mysqlStr);
    $mysqlNums  = $appMysqlConnect->numRows($mysqlQuery);
?>

    <?php echo AppAlert::display(); ?>

    <div class="mysql-query-string">
        <span><?php echo $appMysqlConnect->getMysqlQueryExecStringCurrent(); ?></span>
    </div>

    <ul class="list<?php if (AppConfig::getInstance()->get('enable_disable.list_database_double') == false) { ?> not-double<?php } ?>">
        <li class="database back">
            <a href="info_table.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-table"></span>
            </a>
            <a href="list_table.php?<?php echo PARAMETER_DATABASE_URL; ?>=<?php echo AppDirectory::rawEncode($appMysqlConnect->getName()); ?>&<?php echo PARAMETER_TABLE_URL; ?>=<?php echo AppDirectory::rawEncode($appMysqlConnect->getTableCurrent()); ?>">
                <span><?php echo $appMysqlConnect->getTableCurrent(); ?></span>
            </a>
        </li>
        <?php if ($mysqlNums <= 0) { ?>
            <li class="has-first-not-entry empty">
                <span class="icomoon icon-column"></span>
                <span><?php echo lng('mysql.list_column.alert.empty_list_column'); ?></span>
            </li>
        <?php } else { ?>
            <?php while ($mysqlAssoc = $appMysqlConnect->fetchAssoc($mysqlQuery)) { ?>
                <li class="has-first-not-entry column">
                    <a href="#">
                        <span class="icomoon icon-column"></span>
                    </a>
                    <a href="#">
                        <span><?php echo $mysqlAssoc['Field']; ?></span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>

    <ul class="menu-action">
        <li>
            <a href="info_table.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-about"></span>
                <span><?php echo lng('mysql.list_table.menu_action.info_table'); ?></span>
            </a>
        </li>
        <li>
            <a href="create_column.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-plus"></span>
                <span><?php echo lng('mysql.list_table.menu_action.create_column'); ?></span>
            </a>
        </li>
        <li>
            <a href="create_data.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-plus"></span>
                <span><?php echo lng('mysql.list_table.menu_action.create_data'); ?></span>
            </a>
        </li>
        <li>
            <a href="truncate_data.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-trash"></span>
                <span><?php echo lng('mysql.list_table.menu_action.truncate_data'); ?></span>
            </a>
        </li>
        <li>
            <a href="rename_table.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-edit"></span>
                <span><?php echo lng('mysql.list_table.menu_action.rename_table'); ?></span>
            </a>
        </li>
        <li>
            <a href="delete_table.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-trash"></span>
                <span><?php echo lng('mysql.list_table.menu_action.delete_table'); ?></span>
            </a>
        </li>
        <li>
            <a href="list_data.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-storage"></span>
                <span><?php echo lng('mysql.list_table.menu_action.list_data'); ?></span>
            </a>
        </li>
        <li>
            <a href="list_table.php<?php echo $appParameter->toString(); ?>">
                <span class="icomoon icon-table"></span>
                <span><?php echo lng('mysql.list_table.menu_action.list_table'); ?></span>
            </a>
        </li>

        <?php if ($appMysqlConnect->isDatabaseNameCustom()) { ?>
            <li>
                <a href="list_database.php">
                    <span class="icomoon icon-mysql"></span>
                    <span><?php echo lng('mysql.list_table.menu_action.list_database'); ?></span>
                </a>
            </li>
        <?php } ?>
    </ul>

<?php require_once(ROOT . 'incfiles' . SP . 'footer.php'); ?>